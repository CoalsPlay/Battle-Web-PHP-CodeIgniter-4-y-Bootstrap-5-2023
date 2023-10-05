<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Inbox extends BaseController {

	protected $adminModel;
    protected $userModel;
    protected $messagesModel;
    protected $friendsModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
		$this->messagesModel = new Messages_m();
		$this->friendsModel = new Friends_m();
	}

	public function index()
	{
		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Bandeja de entrada',
			'siteInfo' => $this->adminModel->getInfoSite(),

			'db' => new Messages_m(),
		];

		if(isset($data['getSession'])){ $data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']); }

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/inbox');
		$segment = $uri->getTotalSegments() + 1;

		$paginateData = $this->messagesModel->join('users_db', 'messages_db.idAuthorMsg = users_db.id')
											->where('idReceiverMsg', $data['userInfo']['id'])
											->orderBy('idMsg', 'DESC')
											->paginate(10, 'msgList', null, $segment);

		//////////////////////////////////////////////////////////////////////////////////////


		$data['getMsg'] = $paginateData;
		$data['pager'] = $this->messagesModel->pager;
		$data['unreadMsg'] = $this->messagesModel->unreadMsg($data['userInfo']['id']);
		$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('markRead'))
		{
			$idMsg = $this->request->getPost('idMsg');

			$query = $this->messagesModel->updateStatusId($idMsg);

			if(!$query)
			{
				return redirect()->to(current_url());
			}else{
				return redirect()->to(current_url());
			}
		}

		if($this->request->getPost('markAllRead'))
		{
			$query = $this->messagesModel->updateStatusMsg($data['userInfo']['id']);

			if(!$query)
			{
				return redirect()->to(current_url());
			}else{
				return redirect()->to(current_url());
			}
		}	

		// Imprimir vistas de la página.
		return view('template/header', $data).view('inbox_v', $data).view('template/footer');
	}

	public function send_msg()
	{
		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Enviar mensaje',
			'siteInfo' => $this->adminModel->getInfoSite(),

			'db' => new Messages_m(),
		];

		if(isset($data['getSession'])){
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
			$data['unreadMsg'] = $this->messagesModel->unreadMsg($data['userInfo']['id']);
		}

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('sendMsg'))
		{
			$dataPost = [
				'idAuthorMsg' => $data['userInfo']['id'],
				'toMsg' => $this->request->getPost('toMsg'),
				'titleMsg' => $this->request->getPost('titleMsg'),
				'textMsg' => $this->request->getPost('textMsg'),
			];

		    $validation = $this->validate([
		        'toMsg' => [
		            'rules'  => 'required|is_not_unique[users_db.user]|htmlspecialchars',
		            'errors' => [
		                'required' => 'Debe rellenar este campo.',
		                'is_not_unique' => 'Este usuario no existe.',
		            ],
		        ],
		        'titleMsg' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		                'required' => 'Debe rellenar este campo.',
		            ],
		        ],
		        'textMsg' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		                'required' => 'Debe rellenar este campo.',
		            ],
		        ],
		    ]);

		    if(!$validation)
		    {
		    	return view('template/header', $data).view('send_msg_v', $data, ['validation'=>$this->validator]).view('template/footer');
		    }else{

		    	$to = $this->userModel->getUser($dataPost['toMsg']);
		    	$query = $this->messagesModel->insertMsg($dataPost, $to['id']);

		    	if(!$query)
		    	{
					return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
		    	}else{
		    		return redirect()->to(current_url())->with('success', 'Mensaje enviado a <b>'.$dataPost['toMsg'].'</b> correctamente.');
		    	}
		    }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('send_msg_v', $data).view('template/footer');
	}

	public function sent_msg()
	{
		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Mensajes enviados',
			'siteInfo' => $this->adminModel->getInfoSite(),

			'db' => new Messages_m(),
		];

		if(isset($data['getSession'])){
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
			$data['unreadMsg'] = $this->messagesModel->unreadMsg($data['userInfo']['id']);
		}

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/sent_msg');
		$segment = $uri->getTotalSegments() + 1;

		$paginateData = $this->messagesModel->join('users_db', 'messages_db.idAuthorMsg = users_db.id')
											->where('idAuthorMsg', $data['userInfo']['id'])
											->orderBy('idMsg', 'DESC')
											->paginate(10, 'msgList', null, $segment);

		//////////////////////////////////////////////////////////////////////////////////////

		$data['getMsg'] = $paginateData;
		$data['pager'] = $this->messagesModel->pager;

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		/////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('sent_msg_v', $data).view('template/footer');
	}

}
