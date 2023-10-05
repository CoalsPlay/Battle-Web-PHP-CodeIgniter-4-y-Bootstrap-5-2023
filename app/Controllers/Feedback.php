<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Feedback extends BaseController {

	protected $adminModel;
    protected $userModel;
    protected $friendsModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
		$this->friendsModel = new Friends_m();
	}

	public function report_bug()
	{
		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Centro de reporte de bugs',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
			$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}


		$data['box_left'] = view('template/box_left', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('reportBug'))
		{
			$dataPost = [
				'textBug' => $this->request->getPost('textBug'),
				'authorBug' => $data['userInfo']['id'],
			];

	        $validation = $this->validate([
	            'textBug' => [
	                'rules'  => 'required|min_length[20]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debes describir el bug que quiere reportar.<br/>',
	                    'min_length' => 'El reporte debe contener como mínimo 20 carácteres.<br/>',
	                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('bugs_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

	        	$query = $this->adminModel->insertBug($dataPost);

	        	if(!$query)
	        	{
	        		return redirect()->to(current_url())->with('fail', 'Hubo un error en el reporte. Inténtelo más tarde.');
	        	}else{
	        		return redirect()->to(current_url())->with('success', 'El reporte ha sido enviado correctamente. Lo revisaremos cuanto antes.');
	        	}
	        }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('bugs_v', $data).view('template/footer');

	}

	public function suggestion()
	{

		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Centro de sugerencias',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
			$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('template/box_left', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('sendSugg'))
		{
			$dataPost = [
				'textSuggestion' => $this->request->getPost('textSuggestion'),
				'authorSuggestion' => $data['userInfo']['id'],
			];

	        $validation = $this->validate([
	            'textSuggestion' => [
	                'rules'  => 'required|min_length[10]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debes especificar la sugerencia que quiere enviar.<br/>',
	                    'min_length' => 'La sugerencia debe contener como mínimo 10 carácteres.<br/>',
	                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('suggestion_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

	        	$query = $this->adminModel->insertSuggestion($dataPost);

	        	if(!$query)
	        	{
	        		return redirect()->to(current_url())->with('fail', 'Hubo un error en el envío. Inténtelo más tarde.');
	        	}else{
	        		return redirect()->to(current_url())->with('success', 'La sugerencia ha sido enviado correctamente. La revisaremos cuanto antes.');
	        	}
	        }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('suggestion_v', $data).view('template/footer');

	}

}
