<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Attributes extends BaseController {

	protected $adminModel;
    protected $userModel;
    protected $friendsModel;

	public function __construct()
	{
        $this->adminModel = new Admin_m();
        $this->userModel = new Users_m();
        $this->friendsModel = new Friends_m();
	}

	public function index()
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Atributos',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),
		];

		if(isset($data['getSession'])){
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']); 
			$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
			$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		// Si el usuario tiene un duelo o combate en proceso, le avisa un recordatorio en el bloque izquierdo
		

		$data['box_left'] = view('template/box_left', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('attack')){

			$ptsAttributes = $data['userInfo']['ptsAttributes'];

			if($ptsAttributes > 0){

				$rest_atr = $ptsAttributes - 1;
				$sum_atk = $data['userInfo']['attack'] + 3;

				$values = [
					'attack' => $sum_atk,
					'ptsAttributes' => $rest_atr,
				];

				$query = $this->userModel->updateAtr($data['userInfo']['user'], $values);

				if($query)
				{
					return redirect()->to(current_url())->with('successAtk', '+3 de ataque');
				}else{
					return redirect()->to(current_url())->with('failAtk', 'No pudo actualizarse los atributos.');
				}
				
			}
		}elseif($this->request->getPost('maxHealth')){

			$ptsAttributes = $data['userInfo']['ptsAttributes'];

			if($ptsAttributes > 0){

				$rest_atr = $ptsAttributes - 1;
				$sum_hp = $data['userInfo']['maxHealth'] + 10;

				$values = [
					'maxHealth' => $sum_hp,
					'ptsAttributes' => $rest_atr,
				];

				$query = $this->userModel->updateAtr($data['userInfo']['user'], $values);

				if($query)
				{
					return redirect()->to(current_url())->with('successHp', '+10 de salud máxima');
				}else{
					return redirect()->to(current_url())->with('failHp', 'No pudo actualizarse los atributos.');
				}
				
			}
		}elseif($this->request->getPost('maxEnergy')){

			$ptsAttributes = $data['userInfo']['ptsAttributes'];

			if($ptsAttributes > 0){

				$rest_atr = $ptsAttributes - 1;
				$sum_sp = $data['userInfo']['maxEnergy'] + 5;

				$values = [
					'maxEnergy' => $sum_sp,
					'ptsAttributes' => $rest_atr,
				];

				$query = $this->userModel->updateAtr($data['userInfo']['user'], $values);

				if($query)
				{
					return redirect()->to(current_url())->with('successSp', '+5 de energía máxima');
				}else{
					return redirect()->to(current_url())->with('failSp', 'No pudo actualizarse los atributos.');
				}	
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('attributes_v', $data).view('template/footer');
	}

}
