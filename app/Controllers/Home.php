<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\News_m;
use App\Models\Comments_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Home extends BaseController 
{
	protected $adminModel;
    protected $userModel;
    protected $newsModel;
    protected $commentsModel;
    protected $friendsModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
		$this->newsModel = new News_m();
		$this->commentsModel = new Comments_m();
		$this->friendsModel = new Friends_m();
	}

	public function index()
	{

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url());
		$segment = $uri->getTotalSegments() + 1;

		$paginateData = $this->newsModel->join('users_db', 'news_db.authorNews = users_db.id')
										->orderBy('idNews', 'DESC')
										->paginate(10, 'newsList', null, $segment);
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página ///////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Inicio',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getNews' => $paginateData,
			'pager' => $this->newsModel->pager,
		];

		// Establecer variables si existe una sesión activa.
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
		return view('template/header', $data).view('home_v', $data).view('template/footer');
	}

	public function staff()
	{

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Staff',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'foreach_adm' => $this->userModel->getRank(1),
			'foreach_mod' => $this->userModel->getRank(2),
			'foreach_col' => $this->userModel->getRank(3),
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

		// Imprimir vistas de la página.
		return view('template/header', $data).view('staff_v', $data).view('template/footer');	
	}

	public function top()
	{

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'TOP',
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

		$data['topGold'] = $this->userModel->getUserMax('gold', $data['siteInfo']['maxTop']);
		$data['topRep'] = $this->userModel->getUserMax('reputation', $data['siteInfo']['maxTop']);
		$data['topKills'] = $this->userModel->getUserMax('kills', $data['siteInfo']['maxTop']);
		$data['topLvl'] = $this->userModel->getUserMax('level', $data['siteInfo']['maxTop']);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		// Imprimir vistas de la página.
		return view('template/header', $data).view('top_v', $data).view('template/footer');
		
	}

	public function users_list()
	{
		
		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/users_list');
		$segment = $uri->getTotalSegments() + 1;

		$searchData = $this->request->getGet();

		$search = "";
		if(isset($searchData) && isset($searchData['search'])) {
			$search = $searchData['search'];
		}

		if($search == '')
		{
			$paginateData = $this->userModel->paginate(10, 'usersList', null, $segment);

		} else {
			$paginateData = $this->userModel->select('*')
				->orLike('user', $search)   			
				->paginate(10, 'usersList', null, $segment);
		}

		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Lista de usuarios',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'usersPag' => $paginateData,
			'pager' => $this->userModel->pager,
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

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('users_list_v', $data).view('template/footer');
	}

	public function faq()
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'FAQ',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getFaq' => $this->adminModel->getFaqs(),
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

		//////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('faq_v', $data).view('template/footer');

	}

	public function maintenance()
	{
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Mantenimiento',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('template/box_left', $data);

		if($data['siteInfo']['maintenance'] == 0 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		return view('template/header', $data).view('maintenance_v', $data).view('template/footer');
	}

}
