<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Friends extends BaseController{

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
			'pag' => 'Lista de amigos y peticiones',
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

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/friends');
		$segment = $uri->getTotalSegments() + 1;
		
		$paginateData = $this->friendsModel->join('users_db', 'friends_db.idFriend2 = users_db.id')
										   ->where('idFriend1', $data['userInfo']['id'])
										   ->orderBy('idFriends', 'DESC')
										   ->paginate(15, 'friendsList', null, $segment);
		
		//////////////////////////////////////////////////////////////////////////////////////

		$data['getRequests'] = $this->friendsModel->getRequestsId($data['userInfo']['id']);
		$data['numFriends'] = $this->friendsModel->numFriendId($data['userInfo']['id']);
		$data['getFriends'] = $paginateData;
		$data['pager'] = $this->friendsModel->pager;

		$data['box_left'] = view('template/box_left', $data);
		$data['box_changelog'] = view('template/box_changelog', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('acceptRequest'))
		{
			if($data['numFriends'] < $data['siteInfo']['maxFriends'])
			{
				$idAuthorRequest = $this->request->getPost('idAuthorRequest');

				$query1 = $this->friendsModel->checkRequests($idAuthorRequest, $data['userInfo']['id']);
				$query2 = $this->friendsModel->checkRequests($data['userInfo']['id'], $idAuthorRequest);

				if($query1 && $query2)
				{
					$query3 = $this->friendsModel->deleteRequest($idAuthorRequest, $data['userInfo']['id']);
					$query4 = $this->friendsModel->deleteRequest($data['userInfo']['id'], $idAuthorRequest);
					$query5 = $this->friendsModel->insertFriend($idAuthorRequest, $data['userInfo']['id']);
					$query6 = $this->friendsModel->insertFriend($data['userInfo']['id'], $idAuthorRequest);

					if(!$query3 && !$query4 && !$query5 && !$query6)
					{
						return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
					}else{	
						return redirect()->to(current_url())->with('success', 'Ha sido agregado a tu lista de amigos.');
					}

				}elseif($query1 or $query2){

					$query3 = $this->friendsModel->deleteRequest($idAuthorRequest, $data['userInfo']['id']);
					$query4 = $this->friendsModel->insertFriend($idAuthorRequest, $data['userInfo']['id']);
					$query5 = $this->friendsModel->insertFriend($data['userInfo']['id'], $idAuthorRequest);

					if(!$query3 && !$query4 && !$query5)
					{
						return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
					}else{	
						return redirect()->to(current_url())->with('success', 'Ha sido agregado a tu lista de amigos.');
					}
				}
					
			}else{

				return redirect()->to(current_url())->with('fail', 'Has alcanzado la capacidad máxima de amigos agregados.');
			}
		}

		if($this->request->getPost('deleteRequest'))
		{
			$idAuthorRequest = $this->request->getPost('idAuthorRequest');

			$query = $this->friendsModel->deleteRequest($idAuthorRequest, $data['userInfo']['id']);

			if(!$query)
			{
				return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
			}else{
				return redirect()->to(current_url());
			}
		}

		if($this->request->getPost('deleteFriend'))
		{
			$idFriend = $this->request->getPost('idFriend2');

			$query1 = $this->friendsModel->deleteFriend($data['userInfo']['id'], $idFriend);
			$query2 = $this->friendsModel->deleteFriend($idFriend, $data['userInfo']['id']);
			$query3 = $this->friendsModel->deleteRequestFriend($data['userInfo']['id'], $idFriend);

			if(!$query1 && !$query2 && !$query3)
			{
				return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
			}else{
				return redirect()->to(current_url());
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('friends_v', $data).view('template/footer');
	}
}
