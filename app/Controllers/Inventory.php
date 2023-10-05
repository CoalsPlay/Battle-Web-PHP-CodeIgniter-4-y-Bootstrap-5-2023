<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Inventory_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Inventory extends BaseController {

	protected $adminModel;
    protected $userModel;
    protected $inventoryModel;
    protected $friendsModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
		$this->inventoryModel = new Inventory_m();
		$this->friendsModel = new Friends_m();
	}

	public function index()
	{

		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Inventario',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),
		];

		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/inventory');
		$segment = $uri->getTotalSegments() + 1;

		$paginateData = $this->inventoryModel->where('idUserInv', $data['userInfo']['id'])
											 ->orderBy('idInventory', 'DESC')
											 ->join('shop_db', 'shop_db.idItem = inventories_db.idItemInv')
											 ->paginate(15, 'itemsList', null, $segment);
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Si un usuario tiene un combate activo no puede acceder a esta area.
		$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
		$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
		if($data['statusFight'] == true or $data['statusArena'] == true){ return redirect()->to(base_url()); }

		$data['getItems'] = $paginateData;
		$data['pager'] = $this->inventoryModel->pager;

		$data['dataInv'] = $this->inventoryModel->getItemsInv($data['userInfo']['id']);

		$data['box_left'] = view('template/box_left', $data);


		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && $data['userInfo']['rank'] == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('useItem'))
		{
			$dataPost = [
				'idInventory' => $this->request->getPost('idInventory'),
				'idUser' => $data['userInfo']['id'],
			];

			$getData = $this->inventoryModel->getItemInv($dataPost['idInventory']);

			foreach($getData as $row)
			{

				if($row['actionItem'] == 'hp')
				{
					if($data['userInfo']['health'] >= $data['userInfo']['maxHealth'])
					{
						return redirect()->to(current_url())->with('fail', 'La salud ya está al máximo, no puedes usar este objeto.');

					}else{

						// Si la salud actual del usuario + la curación que se aplica excede la vida máxima del usuario, se llena al máximo.
						if(($data['userInfo']['health'] + $row['amountActionItem']) > $data['userInfo']['maxHealth'])
						{
							$query1 = $this->userModel->updateParameterUser('health', $data['userInfo']['maxHealth'], $data['userInfo']['id']);
							$query2 = $this->inventoryModel->deleteItemInv($row['idInventory']);

							if(!$query1 or !$query2)
							{
								return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
							}else{
								return redirect()->to(current_url())->with('success', 'Has rellenado la salud al máximo.');
							}	

						}else{

							$operation = $data['userInfo']['health'] + $row['amountActionItem'];
							$query1 = $this->userModel->updateParameterUser('health', $operation, $data['userInfo']['id']);
							$query2 = $this->inventoryModel->deleteItemInv($row['idInventory']);

							if(!$query1 or !$query2)
							{
								return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
							}else{
								return redirect()->to(current_url())->with('success', 'Has rellenado la salud en <b>'.$row['amountActionItem'].'</b> puntos.');
							}	
						}
					}

				}elseif($row['actionItem'] == 'sp'){
								  		
					if($data['userInfo']['energy'] == $data['userInfo']['maxEnergy'])
					{
						return redirect()->to(current_url())->with('fail', 'La energía ya está al máximo, no puedes usar este objeto.');

					}else{

						if(($data['userInfo']['energy'] + $row['amountActionItem']) > $data['userInfo']['maxEnergy'])
						{
							$query1 = $this->userModel->updateParameterUser('energy', $data['userInfo']['maxEnergy'], $data['userInfo']['id']);
							$query2 = $this->inventoryModel->deleteItemInv($row['idInventory']);

							if(!$query1 or !$query2)
							{
								return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
							}else{
								return redirect()->to(current_url())->with('success', 'Has rellenado la energía al máximo.');
							}	

						}else{
							$operation = $data['userInfo']['energy'] + $row['amountActionItem'];
							$query1 = $this->userModel->updateParameterUser('energy', $operation, $data['userInfo']['id']);
							$query2 = $this->inventoryModel->deleteItemInv($row['idInventory']);

							if(!$query1 or !$query2)
							{
								return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
							}else{
								return redirect()->to(current_url())->with('success', 'Has rellenado la energía en <b>'.$row['amountActionItem'].'</b> puntos.');
							}
						}
					}

				}elseif($row['actionItem'] == 'def'){

					$operation = $data['userInfo']['defense'] + $row['amountActionItem'];
					$query1 = $this->userModel->updateParameterUser('defense', $operation, $data['userInfo']['id']);
					$query2 = $this->inventoryModel->deleteItemInv($row['idInventory']);

					if(!$query1 or !$query2)
					{
						return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
					}else{
						return redirect()->to(current_url())->with('success', 'Has aumentado la defensa en <b>'.$row['amountActionItem'].'</b> puntos.');
					}

				}elseif($row['actionItem'] == 'atk'){

					$operation = $data['userInfo']['attack'] + $row['amountActionItem'];
					$query1 = $this->userModel->updateParameterUser('attack', $operation, $data['userInfo']['id']);
					$query2 = $this->inventoryModel->deleteItemInv($row['idInventory']);

					if(!$query1 or !$query2)
					{
						return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
					}else{
						return redirect()->to(current_url())->with('success', 'Has aumentado el ataque en <b>'.$row['amountActionItem'].'</b> puntos.');
					}
				}

			} // End foreach

		} // End If Post

		if($this->request->getPost('deleteItem'))
		{
			$dataPost = [
				'idInventory' => $this->request->getPost('idInventory'),
				'nameItemInv' => $this->request->getPost('nameIteminv'),
				'idUser' => $data['userInfo']['id'],
			];

			$query = $this->inventoryModel->deleteItemInv($dataPost['idInventory']);

			if(!$query)
			{
				return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
			}else{
				return redirect()->to(current_url())->with('success', 'Has desechado este objeto.');
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('inventory_v', $data).view('template/footer');
	}

}
