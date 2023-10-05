<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Inventory_m;
use App\Models\Shop_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Shop extends BaseController {

	protected $adminModel;
    protected $userModel;
	protected $inventoryModel;
	protected $shopModel;
	protected $friendsModel;

	public function __construct()
	{
        $this->adminModel = new Admin_m();
        $this->userModel = new Users_m();
        $this->inventoryModel = new Inventory_m();
        $this->shopModel = new Shop_m();
        $this->friendsModel = new Friends_m();
	}

	public function index()
	{

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/shop');
		$segment = $uri->getTotalSegments() + 1;

		$searchData = $this->request->getGet();
		$perPage = 12;

		$search = "";
		if(isset($searchData) && isset($searchData['search'])) {
			$search = $searchData['search'];
		}

		if($search == '')
		{
			$paginateData = $this->shopModel->paginate($perPage, 'itemsList', null, $segment);

		} else {
			$paginateData = $this->shopModel->select('*')
											 ->orLike('nameItem', $search)   			
											 ->paginate($perPage, 'itemsList', null, $segment);
		}
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página ///////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Tienda',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getItem' => $paginateData,
			'pager' => $this->shopModel->pager,
			'search' => $search,
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
			$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('template/box_left', $data);

		// Si un usuario tiene un combate activo no puede acceder a esta area.
		if($data['statusFight'] == true or $data['statusArena'] == true){ return redirect()->to(base_url()); }

		$getSlots = $this->inventoryModel->numItemsUser($data['userInfo']['id']);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('buyItem'))
		{

			if($getSlots < $data['siteInfo']['maxItemsInventory'])
			{

				$dataItem = [
					'idUserInv' => $data['userInfo']['id'],
					'idItemInv' => $this->request->getPost('idItemInv'),
					'nameItemInv' => $this->request->getPost('nameItemInv'),
				];

				$getItem = $this->shopModel->getItem($dataItem['idItemInv']);

				foreach($getItem as $row){

					if($data['userInfo']['gold'] < $row['priceItem'])
					{
						return redirect()->to(current_url())->with('fail', 'No tienes suficiente '.$data['siteInfo']['moneyName'].' para realizar la compra.');

					}else{

						$operation = $data['userInfo']['gold'] - $row['priceItem'];
						$query1 = $this->userModel->updateParameterUser('gold', $operation, $data['userInfo']['id']);
						$query2 = $this->inventoryModel->insertInventory($dataItem);

						if(!$query1 or !$query2)
						{
							return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar el código.');
						}else{
							return redirect()->to(current_url())->with('success', 'Ha realizado la compra correctamente: <b>-'.$row['priceItem'].' '.$data['siteInfo']['moneyName'].'.</b>');
						}	
					}
				} // End Foreach

			}else{

				return redirect()->to(current_url())->with('fail', 'No tienes más huecos en el inventario.');
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('shop_v', $data).view('template/footer');
	}

}
