<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Mobs_m;
use App\Models\Comments_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Mobs extends BaseController {

	protected $adminModel;
    protected $userModel;
    protected $mobsModel;
    protected $friendsModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
		$this->mobsModel = new Mobs_m();
		$this->friendsModel = new Friends_m();
	}

	public function mobs_list()
	{

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/mobs_list');
		$segment = $uri->getTotalSegments() + 1;

		$searchData = $this->request->getGet();

		$search = "";
		if(isset($searchData) && isset($searchData['search'])) {
			$search = $searchData['search'];
		}

		if($search == '')
		{
			$paginateData = $this->mobsModel->join('maps_db', 'mobs_db.idMapMob = maps_db.idMap')
											->orderBy('idMob', 'DESC')
											->paginate(9, 'mobsList', null, $segment);

		} else {
			$paginateData = $this->mobsModel->join('maps_db', 'mobs_db.idMapMob = maps_db.idMap')
											->orLike('nameMob', $search)
											->orderBy('idMob', 'DESC')
											->paginate(9, 'mobsList', null, $segment);
		}
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Lista de enemigos',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getMobs' => $paginateData,
			'pager' => $this->mobsModel->pager,
			'search' => $search,
		];

		if(isset($data['getSession'])){
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']); 
			$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
			$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('template/box_left', $data);
		$data['box_changelog'] = view('template/box_changelog', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		/////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('mobs_v', $data).view('template/footer');

	}

}
