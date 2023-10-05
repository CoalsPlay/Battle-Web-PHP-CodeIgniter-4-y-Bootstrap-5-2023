<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Inventory_m;
use App\Models\Shop_m;
use App\Models\News_m;
use App\Models\Mobs_m;
use App\Models\Comments_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Administration extends BaseController {

	protected $adminModel;
    protected $userModel;
	protected $inventoryModel;
	protected $shopModel;
	protected $newsModel;
	protected $mobsModel;
	protected $commentsModel;
	protected $friendsModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
        $this->inventoryModel = new Inventory_m();
        $this->shopModel = new Shop_m();
        $this->newsModel = new News_m();
        $this->mobsModel = new Mobs_m();
        $this->commentsModel = new Comments_m();
        $this->friendsModel = new Friends_m();
	}

	public function index()
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Panel',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'numMobs' => $this->mobsModel->numMobs(),
			'numNews' => $this->newsModel->numNews(),
			'numComments' => $this->commentsModel->numComments(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);
		$data['box_changelog'] = view('template/box_changelog', $data);

		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/panel_v', $data).view('template/footer');

	}

	public function configuration()
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Configuración del sitio',
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

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] != 1){ return redirect()->to(base_url()); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('saveConfiguration'))
		{
			$dataPost = [
				'siteName' => $this->request->getPost('siteName'),
				'siteDescript' => $this->request->getPost('siteDescript'),
				'maintenance' => $this->request->getPost('maintenance'),
				'titleMaintenance' => $this->request->getPost('titleMaintenance'),
				'descriptMaintenance' => $this->request->getPost('descriptMaintenance'),
				'emailName' => $this->request->getPost('emailName'),
				'siteEmail' => $this->request->getPost('siteEmail'),
				'userTwitter' => $this->request->getPost('userTwitter'),
			];

	        $validation = $this->validate([
	            'siteName' => [
	                'rules'  => 'required|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe escribir un nombre para su sitio.<br/>',
	                ],
	            ],
	            'siteDescript' => [
	                'rules'  => 'required|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe escribir una descripción para su sitio.<br/>',
	                ],
	            ],
	            'titleMaintenance' => [
	                'rules'  => 'required|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe escribir un título para el modo mantenimiento.<br/>',
	                ],
	            ],
	            'descriptMaintenance' => [
	                'rules'  => 'required|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe escribir una descripción para el modo mantenimiento.<br/>',
	                ],
	            ],
	            'emailName' => [
	                'rules'  => 'trim|required|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe asignar un título para el correo electrónico de su sitio.<br/>',
	                ],
	            ],
	            'siteEmail' => [
	                'rules'  => 'trim|required|valid_email|htmlspecialchars',
	                'errors' => [
	                	'valid_email' => 'El formato del correo electrónico es incorrecto.',
	                    'required' => 'Debe asignar un correo electrónico para su sitio.<br/>',
	                ],
	            ],
	            'userTwitter' => [
	                'rules'  => 'trim|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                ],
	            ],
	        ]);

			if(!$validation)
			{
				return view('template/header', $data).view('admin/configuration_v', $data, ['validation'=>$this->validator]).view('template/footer');

			}else{

				$this->adminModel->updateInfoSite($dataPost);
				return redirect()->to(current_url())->with('success', 'Se han guardado los cambios correctamente.');
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/configuration_v', $data).view('template/footer');
	}

	public function game_options()
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Opciones del juego',
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

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] != 1){ return redirect()->to(base_url()); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('saveConfiguration'))
		{
			$dataPost = [
				'maxLvl' => $this->request->getPost('maxLvl'),
				'attributePointsPerLvl' => $this->request->getPost('attributePointsPerLvl'),
				'intervalExp' => $this->request->getPost('intervalExp'),
				'intervalLvl' => $this->request->getPost('intervalLvl'),
				'maxTop' => $this->request->getPost('maxTop'),
				'maxItemsInventory' => $this->request->getPost('maxItemsInventory'),
				'maxFriends' => $this->request->getPost('maxFriends'),
				'moneyName' => $this->request->getPost('moneyName'),
			];

	        $validation = $this->validate([
	            'maxLvl' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe especificar el máximo nivel alcanzable para su juego.<br/>',
	                    'integer' => 'El valor solo puede ser numérico.<br/>',
	                ],
	            ],
	            'attributePointsPerLvl' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe especificar puntos de atributos por nivel subido para su juego.<br/>',
	                    'integer' => 'El valor solo puede ser numérico.<br/>',
	                ],
	            ],
	            'intervalExp' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe escribir un intervalo de experiencia para su juego.<br/>',
	                    'integer' => 'El valor solo puede ser numérico.<br/>',
	                ],
	            ],
	            'intervalLvl' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe especificar un intervalo de nivel para su juego.<br/>',
	                    'integer' => 'El valor solo puede ser numérico.<br/>',
	                ],
	            ],
	            'maxTop' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe especificar el número máximo a mostrar en los TOPs.<br/>',
	                    'integer' => 'El valor solo puede ser numérico.<br/>',
	                ],
	            ],
	            'maxItemsInventory' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                	'integer' => 'El valor solo puede ser numérico.<br/>',
	                    'required' => 'Debe asignar el número máximo de huecos en inventario su juego.<br/>',
	                ],
	            ],
	            'maxFriends' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'integer' => 'El valor solo puede ser numérico.<br/>',
	                ],
	            ],
	            'moneyName' => [
	                'rules'  => 'required|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('admin/game_options_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

	        	$query = $this->adminModel->updateGameOptions($dataPost);

	        	if(!$query)
	        	{
	        		return redirect()->to(current_url())->with('fail', 'No se han guardado los cambios. Hubo un error.');
	        	}else{
	        		return redirect()->to(current_url())->with('success', 'Se han guardado los cambios correctamente.');
	        	}
	        }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/game_options_v', $data).view('template/footer');
	}

	public function feedback()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Centro de soporte',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'data_bug' => $this->adminModel->getBugs(),
			'data_sugg' => $this->adminModel->getSuggestions(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección al inicio.
		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		/////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/feedback_v', $data).view('template/footer');
	}

	public function news_manager()
	{
		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/admin/news_manager');
		$segment = $uri->getTotalSegments() + 1;

		$paginateData = $this->newsModel->table('news_db')
										 ->join('users_db', 'news_db.authorNews = users_db.id')
										 ->orderBy('idNews', 'DESC')
										 ->paginate(10, 'newsList', null, $segment);
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Gestión de noticias',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getNews' => $paginateData,
			'pager' => $this->newsModel->pager,
			'numNews' => $this->newsModel->numNews(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección al inicio.
		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		/////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('saveNews'))
		{
			$dataPost = [
				'titleNews' => $this->request->getPost('titleNews'),
				'textNews' => $this->request->getPost('textNews'),
				'dateNews' => date("Y-m-d H:i"),
				'authorNews' => $data['userInfo']['id'],
			];

		    $validation = $this->validate([
		        'titleNews' => [
		            'rules'  => 'required|min_length[5]|htmlspecialchars',
		            'errors' => [
		                'required' => 'Debe escribir un título para la noticia.<br/>',
		                'min_length' => 'Debe contener como mínimo 5 carácteres.<br/>',
		            ],
		        ],
		        'textNews' => [
		            'rules'  => 'required|min_length[10]|htmlspecialchars',
		            'errors' => [
		                'required' => 'Debe escribir el contenido de la noticia.<br/>',
		                'min_length' => 'Debe contener como mínimo 10 carácteres.<br/>',
		            ],
		        ],
		    ]);

		    if(!$validation)
		    {
		    	return view('template/header', $data).view('admin/news_v', $data, ['validation'=>$this->validator]).view('template/footer');

		    }else{

		    	$query = $this->newsModel->insertNews($dataPost);

		    	if(!$query)
		    	{
		    		return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
		    	}else{
		    		return redirect()->to(current_url())->with('success', 'La noticia ha sido creada correctamente.');
		    	}
		    }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/news_v', $data).view('template/footer');
	}

	public function edit_news($idNews = null)
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Gestión de noticias',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getNews' => $this->newsModel->getNews($idNews),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección al inicio.
		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		/////////////////////////////////////////////////////////////////////////////////////

		if(!$data['getNews'])
		{
			return redirect()->to(base_url());

		}else{

			if($this->request->getPost('editNews'))
			{
				$dataPost = [
					'idNews' => $this->request->getPost('idNews'),
					'titleNews' => $this->request->getPost('titleNews'),
					'textNews' => $this->request->getPost('textNews')
				];

			    $validation = $this->validate([
			        'titleNews' => [
			            'rules'  => 'required|min_length[5]|htmlspecialchars',
			            'errors' => [
			                'required' => 'Debe escribir un título para la noticia.<br/>',
			                'min_length' => 'Debe contener como mínimo 5 carácteres.<br/>',
			            ],
			        ],
			        'textNews' => [
			            'rules'  => 'required|min_length[10]|htmlspecialchars',
			            'errors' => [
			                'required' => 'Debe escribir el contenido de la noticia.<br/>',
			                'min_length' => 'Debe contener como mínimo 10 carácteres.<br/>',
			            ],
			        ],
			    ]);

			    if(!$validation)
			    {
			    	return view('template/header', $data).view('admin/news_v', $data, ['validation'=>$this->validator]).view('template/footer');

			    }else{

			    	$query = $this->newsModel->updateNews($idNews, $dataPost);

			    	if(!$query)
			    	{
			    		return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
			    	}else{
			    		return redirect()->to(base_url('/admin/news_manager'))->with('success', 'La noticia ha sido editada correctamente.');
			    	}
			    }		
			}

			if($this->request->getPost('deleteNews'))
			{
				$query = $this->newsModel->deleteNews($idNews);

			    if(!$query)
			    {
			    	return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
			    }else{
			    	return redirect()->to(base_url('/admin/news_manager'))->with('success', 'La noticia ha sido eliminada correctamente.');
			    }
			}

		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/edit_news_v', $data).view('template/footer');	
	}

	public function ranks()
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Lista de usuarios',
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
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] != 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('update_rank'))
		{
			$dataPost = [
				'user' => $this->request->getPost('user'),
				'rank' => $this->request->getPost('rankValue')
			];

	        $validation = $this->validate([
	            'user' => [
	                'rules'  => 'trim|required|alpha_dash|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe especificar el usuario.<br/>',
	                    'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
	                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('admin/ranks_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

				$getUserRank = $this->userModel->where('user', $dataPost['user'])->first();

				if(!$getUserRank){

					return redirect()->to(current_url())->with('fail', 'Este usuario no existe.');

				}elseif($getUserRank['rank'] == $dataPost['rank']){

					return redirect()->to(current_url())->with('fail', 'El usuario que especifica ya tiene este rango.');

				}else{

					$query = $this->userModel->updateRank($getUserRank['id'], $dataPost);

					if(!$query)
					{
						return redirect()->to(current_url())->with('fail', 'El usuario que especifica ya tiene este rango.');
					}else{
						return redirect()->to(current_url())->with('success', 'El rango de este usuario ha sido actualizado.');
					}
				}
	        }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/ranks_v', $data).view('template/footer');	
	}

	public function shop()
	{

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/admin/shop');
		$segment = $uri->getTotalSegments() + 1;

		$searchData = $this->request->getGet();
		$per_page = 15;

        $validation = $this->validate([
            'search' => [
                'rules'  => 'trim|required|htmlspecialchars',
                'errors' => [
                    'required' => 'Debes escribir un nombre de usuario.<br/>',
                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
                ],
            ],
        ]);

		$search = "";
		if(isset($searchData) && isset($searchData['search'])) {
			$search = $searchData['search'];
		}

		if($search == '')
		{
			$paginateData = $this->shopModel->paginate($per_page, 'itemsList', null, $segment);

		} else {
			$paginateData = $this->shopModel->select('*')
											 ->orLike('nameItem', $search)   			
											 ->paginate($per_page, 'itemsList', null, $segment);
		}
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Gestión de tienda',
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
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/shop_v', $data).view('template/footer');		
	}

	public function item_add()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Gestión de tienda - Añadir producto',
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

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('addItem'))
		{
			$dataPost = [
				'nameItem' => $this->request->getPost('nameItem'),
				'priceItem' => $this->request->getPost('priceItem'),
				'actionItem' => $this->request->getPost('actionItem'),
				'amountActionItem' => $this->request->getPost('amountActionItem'),
				'descriptionItem' => $this->request->getPost('descriptionItem'),
				'imgItem' => $this->request->getPost('imgItem'),
			];

		    $validation = $this->validate([
		        'nameItem' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		            	'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		        'priceItem' => [
		            'rules'  => 'required|integer|htmlspecialchars',
		            'errors' => [
		                'required' => 'Debe rellenar este campo.<br/>',
		                'integer' => 'Solo se permite valores númericos.<br/>',
		            ],
		        ],
		        'actionItem' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		        'amountActionItem' => [
		            'rules'  => 'required|integer|htmlspecialchars',
		            'errors' => [
		                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                'required' => 'Debe rellenar este campo.<br/>',
		                'integer' => 'Solo se permite valores númericos.<br/>',
		            ],
		        ],
		        'descriptionItem' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		        'imgItem' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		             	'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		    ]);

		    if(!$validation)
		    {
		    	return view('template/header', $data).view('admin/item_add_v', $data, ['validation'=>$this->validator]).view('template/footer');
		    }else{

		    	$query = $this->shopModel->insertItem($dataPost);

		    	if(!$query)
		    	{
		        	return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
		    	}else{
		        	return redirect()->to(current_url())->with('success', 'El producto ha sido agregado correctamente.');
		    	}
		    }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/item_add_v', $data).view('template/footer');	
	}

	public function item_edit($idItem = null)
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Gestión de tienda - Editar producto',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getItem' => $this->shopModel->getItem($idItem),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($data['getItem'])
		{

			if($this->request->getPost('updateItem'))
			{
				$dataPost = [
					'nameItem' => $this->request->getPost('nameItem'),
					'priceItem' => $this->request->getPost('priceItem'),
					'actionItem' => $this->request->getPost('actionItem'),
					'amountActionItem' => $this->request->getPost('amountActionItem'),
					'descriptionItem' => $this->request->getPost('descriptionItem'),
					'imgItem' => $this->request->getPost('imgItem'),
				];

			    $validation = $this->validate([
			        'nameItem' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			            	'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			        'priceItem' => [
			            'rules'  => 'required|integer|htmlspecialchars',
			            'errors' => [
			                'required' => 'Debe rellenar este campo.<br/>',
			                'integer' => 'Solo se permite valores númericos.<br/>',
			            ],
			        ],
			        'actionItem' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			                'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			        'amountActionItem' => [
			            'rules'  => 'required|integer|htmlspecialchars',
			            'errors' => [
			                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			                'required' => 'Debe rellenar este campo.<br/>',
			                'integer' => 'Solo se permite valores númericos.<br/>',
			            ],
			        ],
			        'descriptionItem' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			                'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			        'imgItem' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			             	'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			    ]);

			    if(!$validation)
			    {
			    	return view('template/header', $data).view('admin/item_edit_v', $data, ['validation'=>$this->validator]).view('template/footer');
			    }else{

			    	$query = $this->shopModel->updateItem($idItem, $dataPost);

			    	if(!$query)
			    	{
			        	return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
			    	}else{
			        	return redirect()->to(current_url())->with('success', 'El producto ha sido editado correctamente.');
			    	}
			    }
			}

		}else{

			return redirect()->to('/');
		}

		if($this->request->getPost('deleteItem'))
		{
			$query = $this->shopModel->deleteItem($idItem);

			if(!$query)
			{
				return redirect()->to(base_url('/admin/shop'))->with('fail', 'Hubo un error al ejecutar la función.');	
			}else{
				return redirect()->to(base_url('/admin/shop'))->with('success', 'El producto ha sido borrado correctamente.');	

			}				
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/item_edit_v', $data).view('template/footer');			
	}

	public function mobs_manager()
	{

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/admin/mobs_manager');
		$segment = $uri->getTotalSegments() + 1;

		$searchData = $this->request->getGet();

        $validation = $this->validate([
            'search' => [
                'rules'  => 'trim|required|alpha_dash|htmlspecialchars',
                'errors' => [
                    'required' => 'Debes escribir un nombre de usuario.<br/>',
                    'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
                ],
            ],
        ]);

		$search = "";
		if(isset($searchData) && isset($searchData['search'])) {
			$search = $searchData['search'];
		}

		if($search == '')
		{
			$paginateData = $this->mobsModel->join('maps_db', 'mobs_db.idMapMob = maps_db.idMap')
											->orderBy('idMob', 'DESC')
											->paginate(10, 'mobsList', null, $segment);

		} else {
			$paginateData = $this->mobsModel->join('maps_db', 'mobs_db.idMapMob = maps_db.idMap')
											->orLike('nameMob', $search)
											->orderBy('idMob', 'DESC')
											->paginate(10, 'mobsList', null, $segment);
		}
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Gestión de enemigos',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getMobs' => $paginateData,
			'pager' => $this->mobsModel->pager,
			'search' => $search
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/mobs_v', $data).view('template/footer');			
	}

	public function mob_add()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Agregar enemigo',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getMaps' => $this->adminModel->getMaps(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('addMob'))
		{
			$dataPost = [
				'nameMob' => $this->request->getPost('nameMob'),
				'atkMob' => $this->request->getPost('atkMob'),
				'healthMob' => $this->request->getPost('maxHealthMob'),
				'maxHealthMob' => $this->request->getPost('maxHealthMob'),
				'expMob' => $this->request->getPost('expMob'),
				'goldMob' => $this->request->getPost('goldMob'),
				'reputationMob' => $this->request->getPost('reputationMob'),
				'descriptMob' => $this->request->getPost('descriptMob'),
				'imgMob' => $this->request->getPost('imgMob'),
				'idMapMob' => $this->request->getPost('idMapMob')
			];

		    $validation = $this->validate([
		        'nameMob' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		            	'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		        'atkMob' => [
		            'rules'  => 'required|integer|htmlspecialchars',
		            'errors' => [
		                'required' => 'Debe rellenar este campo.<br/>',
		                'integer' => 'Solo se permite valores númericos.<br/>',
		            ],
		        ],
		        'maxHealthMob' => [
		            'rules'  => 'required|integer|htmlspecialchars',
		            'errors' => [
		                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                'required' => 'Debe rellenar este campo.<br/>',
		                'integer' => 'Solo se permite valores númericos.<br/>',
		            ],
		        ],
		        'expMob' => [
		            'rules'  => 'required|numeric|htmlspecialchars',
		            'errors' => [
		                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                'required' => 'Debe rellenar este campo.<br/>',
		                'numeric' => 'Solo se permite valores númericos.<br/>',
		            ],
		        ],
		        'goldMob' => [
		            'rules'  => 'required|integer|htmlspecialchars',
		            'errors' => [
		                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                'required' => 'Debe rellenar este campo.<br/>',
		                'integer' => 'Solo se permite valores númericos.<br/>',
		            ],
		        ],
		        'reputationMob' => [
		            'rules'  => 'required|numeric|htmlspecialchars',
		            'errors' => [
		            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		             	'required' => 'Debe rellenar este campo.<br/>',
		             	'numeric' => 'Solo se permite valores númericos.<br/>',
		            ],
		        ],
		        'descriptMob' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		             	'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		        'imgMob' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		             	'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		        'descriptMob' => [
		            'rules'  => 'required|htmlspecialchars',
		            'errors' => [
		            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		             	'required' => 'Debe rellenar este campo.<br/>',
		            ],
		        ],
		    ]);

		    if(!$validation)
		    {
		    	return view('template/header', $data).view('admin/mob_add_v', $data, ['validation'=>$this->validator]).view('template/footer');
		    }else{

		    	$query = $this->mobsModel->insertMob($dataPost);

		    	if(!$query)
		    	{
		        	return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
		    	}else{
		        	return redirect()->to(current_url())->with('success', 'El enemigo ha sido agregado correctamente.');
		    	}
		    }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/mob_add_v', $data).view('template/footer');		
	}

	public function mob_edit($idMob = null)
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Editar enemigo',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getMob' => $this->mobsModel->getMob($idMob),
			'getMaps' => $this->adminModel->getMaps(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if(!$data['getMob']){

			return redirect()->to('/');
		}else{

			if($this->request->getPost('editMob'))
			{
				$dataPost = [
					'nameMob' => $this->request->getPost('nameMob'),
					'atkMob' => $this->request->getPost('atkMob'),
					'healthMob' => $this->request->getPost('maxHealthMob'),
					'maxHealthMob' => $this->request->getPost('maxHealthMob'),
					'expMob' => $this->request->getPost('expMob'),
					'goldMob' => $this->request->getPost('goldMob'),
					'reputationMob' => $this->request->getPost('reputationMob'),
					'descriptMob' => $this->request->getPost('descriptMob'),
					'imgMob' => $this->request->getPost('imgMob'),
					'idMapMob' => $this->request->getPost('idMapMob')
				];

			    $validation = $this->validate([
			        'nameMob' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			            	'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			        'atkMob' => [
			            'rules'  => 'required|integer|htmlspecialchars',
			            'errors' => [
			                'required' => 'Debe rellenar este campo.<br/>',
			                'integer' => 'Solo se permite valores númericos.<br/>',
			            ],
			        ],
			        'maxHealthMob' => [
			            'rules'  => 'required|integer|htmlspecialchars',
			            'errors' => [
			                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			                'required' => 'Debe rellenar este campo.<br/>',
			                'integer' => 'Solo se permite valores númericos.<br/>',
			            ],
			        ],
			        'expMob' => [
			            'rules'  => 'required|numeric|htmlspecialchars',
			            'errors' => [
			                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			                'required' => 'Debe rellenar este campo.<br/>',
			                'numeric' => 'Solo se permite valores númericos.<br/>',
			            ],
			        ],
			        'goldMob' => [
			            'rules'  => 'required|integer|htmlspecialchars',
			            'errors' => [
			                'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			                'required' => 'Debe rellenar este campo.<br/>',
			                'integer' => 'Solo se permite valores númericos.<br/>',
			            ],
			        ],
			        'reputationMob' => [
			            'rules'  => 'required|numeric|htmlspecialchars',
			            'errors' => [
			            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			             	'required' => 'Debe rellenar este campo.<br/>',
			             	'numeric' => 'Solo se permite valores númericos.<br/>',
			            ],
			        ],
			        'descriptMob' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			             	'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			        'imgMob' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			             	'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			        'descriptMob' => [
			            'rules'  => 'required|htmlspecialchars',
			            'errors' => [
			            	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
			             	'required' => 'Debe rellenar este campo.<br/>',
			            ],
			        ],
			    ]);

			    if(!$validation)
			    {
			    	return view('template/header', $data).view('admin/mob_edit_v', $data, ['validation'=>$this->validator]).view('template/footer');
			    }else{

			    	$query = $this->mobsModel->updateMob($idMob, $dataPost);

			    	if(!$query)
			    	{
			        	return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
			    	}else{
			        	return redirect()->to(current_url())->with('success', 'Los cambios se han guardado correctamente.');
			    	}
			    }
			}
		} 

		if($this->request->getPost('deleteMob'))
		{
			$query = $this->mobsModel->deleteMob($idMob);

			if(!$query)
			{
				return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
			}else{
			    return redirect()->to('/admin/mobs_manager')->with('success', 'El enemigo ha sido eliminado.');
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/mob_edit_v', $data).view('template/footer');			
	}

	public function users()
	{

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/admin/users');
		$segment = $uri->getTotalSegments() + 1;

		$searchData = $this->request->getGet();

		$search = "";
		if (isset($searchData) && isset($searchData['search'])) {
			$search = $searchData['search'];
		}

		if ($search == '') {
			$paginateData = $this->userModel->paginate(10, 'usersList', null, $segment);
		} else {
			$paginateData = $this->userModel->select('*')
				->orLike('user', $search)   			
				->paginate(10, 'usersList', null, $segment);
		}

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Lista de usuarios',
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
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] != 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('searchUser'))
		{
			$dataSearch = $this->request->getPost('textSearch');	

			$rules = array(
						array(
							'field' => 'textSearch',
							'rules' => 'required|htmlspecialchars'
						)
			);

			$this->form_validation->set_rules($rules);

			if($this->form_validation->run() != FALSE){

				$data['userSearch'] = $this->usuarios_m->getUsersSearch($dataSearch);
			}

		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/users_v', $data).view('template/footer');	
	}

	public function user_edit($idUser = null)
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Editar usuario',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'userData' => $this->userModel->where('id', $idUser)->first(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario que no tenga rango o no sea de un rango específico hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] != 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if(!$data['userData'])
		{
			return redirect()->to('/admin/users');

		}else{

			if($this->request->getPost('updateUser'))
			{
				$dataPost = [
					'user' => $this->request->getPost('user'),
					'email' => $this->request->getPost('email'),
					'aboutMe' => $this->request->getPost('aboutMe'),
					'twitter' => $this->request->getPost('twitter'),
					'facebook' => $this->request->getPost('facebook'),
					'youtube' => $this->request->getPost('youtube'),
					'level' => $this->request->getPost('level'),
					'gold' => $this->request->getPost('money'),
					'kills' => $this->request->getPost('kills'),
					'reputation' => $this->request->getPost('reputation'),
					'energy' => $this->request->getPost('energy'),
					'maxEnergy' => $this->request->getPost('maxEnergy'),
					'attack' => $this->request->getPost('attack'),
					'health' => $this->request->getPost('health'),
					'maxHealth' => $this->request->getPost('maxHealth')
				];

		        $validation = $this->validate([
		            'user' => [
		                'rules'  => 'required|alpha_dash|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe especificar el máximo nivel alcanzable para su juego.<br/>',
		                    'alpha_dash' => 'No se permite carácteres especiales.<br/>',
		                ],
		            ],
		            'email' => [
		                'rules'  => 'required|valid_email|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe especificar puntos de atributos por nivel subido para su juego.<br/>',
		                    'valid_email' => 'El formato del correo electrónico no es correcto.<br/>',
		                ],
		            ],
		            'aboutMe' => [
		                'rules'  => 'htmlspecialchars',
		                'errors' => [
		                    'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                ],
		            ],
		            'twitter' => [
		                'rules'  => 'htmlspecialchars',
		                'errors' => [
		                    'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                ],
		            ],
		            'facebook' => [
		                'rules'  => 'htmlspecialchars',
		                'errors' => [
		                    'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                ],
		            ],
		            'youtube' => [
		                'rules'  => 'htmlspecialchars',
		                'errors' => [
		                	'htmlspecialchars' => 'Se limpiará de carácteres especiales.<br/>',
		                ],
		            ],
		            'level' => [
		                'rules'  => 'required|integer|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'integer' => 'El valor solo puede ser numérico.<br/>',
		                ],
		            ],
		            'money' => [
		                'rules'  => 'required|numeric|htmlspecialchars',
		                'errors' => [
		                	'numeric' => 'Solo puede ser un valor numérico.',
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		            'kills' => [
		                'rules'  => 'required|integer|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'integer' => 'El valor solo puede ser numérico.<br/>',
		                ],
		            ],
		            'reputation' => [
		                'rules'  => 'required|numeric|htmlspecialchars',
		                'errors' => [
		                	'numeric' => 'Solo puede ser un valor numérico.',
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		            'energy' => [
		                'rules'  => 'required|numeric|htmlspecialchars',
		                'errors' => [
		                	'numeric' => 'Solo puede ser un valor numérico.',
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		            'maxEnergy' => [
		                'rules'  => 'required|numeric|htmlspecialchars',
		                'errors' => [
		                	'numeric' => 'Solo puede ser un valor numérico.',
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		            'attack' => [
		                'rules'  => 'required|numeric|htmlspecialchars',
		                'errors' => [
		                	'numeric' => 'Solo puede ser un valor numérico.',
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		            'health' => [
		                'rules'  => 'required|numeric|htmlspecialchars',
		                'errors' => [
		                	'numeric' => 'Solo puede ser un valor numérico.',
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		            'maxHealth' => [
		                'rules'  => 'required|numeric|htmlspecialchars',
		                'errors' => [
		                	'numeric' => 'Solo puede ser un valor numérico.',
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		        ]);

				if(!$validation)
				{
					// Imprimir vistas de la página con los errores.
					return view('template/header', $data).view('admin/user_edit_v', $data, ['validation'=>$this->validator]).view('template/footer');

				}else{

					$query = $this->userModel->updateUserAll($idUser ,$dataPost);

					if(!$query)
					{
						return redirect()->to(current_url())->with('fail', 'Hubo un error en la edición de datos de usuario.');

					}elseif($idUser == $data['userInfo']['id']){

							$user_info = $this->userModel->where('id', $idUser)->first();
			                $session_data = ['userSession' => $user_info];
			                session()->set('loggedUser', $session_data);
			                return redirect()->to(current_url())->with('success', 'Se han guardado los cambios correctamente.');
					}else{

						return redirect()->to(current_url())->with('success', 'Se han guardado los cambios correctamente.');
					}	
				}
			}

			if($this->request->getPost('deleteUser'))
			{
				$query = $this->userModel->deleteUser($idUser);

				if(!$query)
				{
					return redirect()->to(current_url())->with('fail', 'Hubo un error en la ejecución de la función.');
				}else{

					$this->newsModel->deleteNews($idUser);
					$this->commentsModel->deleteComment($idUser);
					return redirect()->to(base_url('/admin/users'));
				}
				
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/user_edit_v', $data).view('template/footer');			
	}

	public function faq_center()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Editar usuario',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getFaq' => $this->adminModel->getFaqs(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección a inicio.
		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		// Actualizar el texto superior de la sección FAQ.
		if($this->request->getPost('editTextFaq'))
		{
			$dataPost = [
				'helpFaq' => $this->request->getPost('helpFaq'),
			];

			$query = $this->adminModel->updateHelpFaq($dataPost);

			if(!$query)
	        {
	        	return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
	        }else{
	        	return redirect()->to(current_url())->with('success', 'El texto ha sido actualizado correctamente.');
	        }			
		}

		// Borrar un FAQ específico si se ha pulsado el botón.
		if($this->request->getMethod() === 'post')
		{
			$idFaq = $this->request->getPost('idFaq');

			$query = $this->adminModel->deleteFaq($idFaq);

	        if(!$query)
	        {
	        	return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
	        }else{
	        	return redirect()->to(current_url())->with('success', 'Se ha eliminado correctamente.');
	        }			
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/faq_center_v', $data).view('template/footer');		
	}

	public function faq_add()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Editar usuario',
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

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección a inicio.
		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('sendFaq'))
		{
			$dataPost = [
				'titleFaq' => $this->request->getPost('titleFaq'),
				'descriptFaq' => $this->request->getPost('descriptFaq')
			];

	        $validation = $this->validate([
	            'titleFaq' => [
	                'rules'  => 'required|min_length[10]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'min_length' => 'Debe contener como mínimo 10 carácteres.<br/>',
	                ],
	            ],
	            'descriptFaq' => [
	                'rules'  => 'required|min_length[10]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'min_length' => 'Debe contener como mínimo 10 carácteres.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('admin/faq_add_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

	        	$query = $this->adminModel->insertFaq($dataPost);

	        	if(!$query)
	        	{
	        		return redirect()->to(current_url())->with('fail', 'Hubo un error al ingresar los datos.');
	        	}else{
	        		return redirect()->to(current_url())->with('success', 'Se ha agregado correctamente.');
	        	}
	        }
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/faq_add_v', $data).view('template/footer');			
	}

	public function faq_edit($idFaq = null)
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Editar usuario',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getFaq' => $this->adminModel->getFaqId($idFaq),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección a inicio.
		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if(!$data['getFaq'])
		{
			return redirect()->to(base_url());

		}else{

			if($this->request->getPost('editFaq'))
			{
				$dataPost = [
					'titleFaq' => $this->request->getPost('titleFaq'),
					'descriptFaq' => $this->request->getPost('descriptFaq'),
				];

		        $validation = $this->validate([
		            'titleFaq' => [
		                'rules'  => 'required|min_length[10]|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'min_length' => 'Debe contener como mínimo 10 carácteres.<br/>',
		                ],
		            ],
		            'descriptFaq' => [
		                'rules'  => 'required|min_length[10]|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'min_length' => 'Debe contener como mínimo 10 carácteres.<br/>',
		                ],
		            ],
		        ]);

		        if(!$validation)
		        {
		        	return view('template/header', $data).view('admin/faq_add_v', $data, ['validation'=>$this->validator]).view('template/footer');

		        }else{

		        	$query = $this->adminModel->updateFaq($idFaq, $dataPost);

		        	if(!$query)
		        	{
		        		return redirect()->to(current_url())->with('fail', 'Hubo un error al editar los datos.');
		        	}else{
		        		return redirect()->to(current_url())->with('success', 'Se han guardado los cambios correctamente.');
		        	}
		        }
			}

		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/faq_edit_v', $data).view('template/footer');		
	}

	public function categories_and_maps()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Categorías y mapas',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getCategories' => $this->adminModel->getCategories(),
			'getMaps' => $this->adminModel->getMaps(),
			'db1' => new Admin_m(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('addCategory'))
		{
			$dataPost = [
				'nameCategory' => $this->request->getPost('nameCategory'),
				'descriptCategory' => $this->request->getPost('descriptCategory')
			];

	        $validation = $this->validate([
	            'nameCategory' => [
	                'rules'  => 'required|min_length[1]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'min_length' => 'Debe contener como mínimo 1 caracter.<br/>',
	                ],
	            ],
	            'descriptCategory' => [
	                'rules'  => 'required|min_length[5]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'min_length' => 'Debe contener como mínimo 5 carácteres.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('admin/categories_and_maps_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

	        	$query = $this->adminModel->insertCategory($dataPost);

	        	if(!$query)
	        	{
	        		return redirect()->to(current_url())->with('fail', 'Hubo un error al ingresar los datos.');
	        	}else{
	        		return redirect()->to(current_url())->with('success', 'La categoría se ha agregado correctamente.');
	        	}
	        }
		}

		if($this->request->getPost('deleteCategory'))
		{
			$dataPost = [
				'idCategory' => $this->request->getPost('idCategory'),
			];

			$query = $this->adminModel->deleteCategoryAndMaps($dataPost);

			if(!$query)
			{
				return redirect()->to(current_url())->with('fail', 'Hubo un error al ingresar los datos.');
			}else{
				return redirect()->to(current_url())->with('success', 'La categoría se ha eliminada correctamente.');
			}
		}

		if($this->request->getPost('deleteMap'))
		{
			$idMap = $this->request->getPost('idMap');

			$query = $this->adminModel->deleteMap($idMap);

			if(!$query)
			{
				return redirect()->to(current_url())->with('fail', 'Hubo algún error.');
			}else{
				return redirect()->to(current_url())->with('success', 'El mapa se ha eliminada correctamente.');
			}
		}		

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/categories_and_maps_v', $data).view('template/footer');			
	}

	public function add_map()
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Agregar mapa',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getCategory' => $this->adminModel->getCategories(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección a inicio.
		if($data['userInfo']['rank'] < 1){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('addMap'))
		{
			$dataPost = [
				'nameMap' => $this->request->getPost('nameMap'),
				'descriptMap' => $this->request->getPost('descriptMap'),
				'lvlMap' => $this->request->getPost('lvlMap'),
				'idCategoryMap' => $this->request->getPost('categoryMap'),
				'imageMap' => $this->request->getPost('imageMap')
			];

	        $validation = $this->validate([
	            'nameMap' => [
	                'rules'  => 'required|min_length[1]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'min_length' => 'Debe contener como mínimo 1 caracter.<br/>',
	                ],
	            ],
	            'descriptMap' => [
	                'rules'  => 'required|min_length[5]|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'min_length' => 'Debe contener como mínimo 5 carácteres.<br/>',
	                ],
	            ],
	            'lvlMap' => [
	                'rules'  => 'required|integer|htmlspecialchars',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                    'integer' => 'Solo se admite valores numéricos.<br/>',
	                ],
	            ],
	            'categoryMap' => [
	                'rules'  => 'required',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                ],
	            ],
	            'imageMap' => [
	                'rules'  => 'required',
	                'errors' => [
	                    'required' => 'Debe rellenar este campo.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('admin/add_map_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

	        	$query = $this->adminModel->insertMap($dataPost);

	        	if(!$query)
	        	{
	        		return redirect()->to(current_url())->with('fail', 'Hubo un error al ingresar los datos.');
	        	}else{
	        		return redirect()->to(current_url())->with('success', 'El mapa se ha agregado correctamente.');
	        	}
	        }
		}		

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/add_map_v', $data).view('template/footer');	
	}

	public function edit_category($idCategory = null)
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Editar categoría',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getCategory' => $this->adminModel->getCategoryId($idCategory),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if(!$data['getCategory'])
		{
			return redirect()->to('/');
		}else{

			if($this->request->getPost('editCategory'))
			{
				$dataPost = [
					'nameCategory' => $this->request->getPost('nameCategory'),
					'descriptCategory' => $this->request->getPost('descriptCategory')
				];

		        $validation = $this->validate([
		            'nameCategory' => [
		                'rules'  => 'required|min_length[1]|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'min_length' => 'Debe contener como mínimo 1 caracter.<br/>',
		                ],
		            ],
		            'descriptCategory' => [
		                'rules'  => 'required|min_length[5]|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'min_length' => 'Debe contener como mínimo 5 carácteres.<br/>',
		                ],
		            ],
		        ]);

		        if(!$validation)
		        {
		        	return view('template/header', $data).view('admin/categories_and_maps_v', $data, ['validation'=>$this->validator]).view('template/footer');

		        }else{

		        	$query = $this->adminModel->updateCategory($idCategory, $dataPost);

		        	if(!$query)
		        	{
		        		return redirect()->to(current_url())->with('fail', 'Hubo un error al ingresar los datos.');
		        	}else{
		        		return redirect()->to(current_url())->with('success', 'La categoría se ha agregado correctamente.');
		        	}
		        }
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/edit_category_v', $data).view('template/footer');			
	}

	public function edit_map($idMap = null)
	{

		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Administración - Editar mapa',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getMap' => $this->adminModel->getMapId($idMap),
			'getCategory' => $this->adminModel->getCategories(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		$data['box_left'] = view('admin/template/box_left', $data);

		// Si un usuario no tiene cierto rango, hará redirección a inicio.
		if($data['userInfo']['rank'] < 1 or $data['userInfo']['rank'] == 3){ return redirect()->to(base_url()); }

		//////////////////////////////////////////////////////////////////////////////////////

		if(!$data['getMap'])
		{
			return redirect()->to('/');
		}else{

			if($this->request->getPost('editMap'))
			{
				$dataPost = [
					'nameMap' => $this->request->getPost('nameMap'),
					'descriptMap' => $this->request->getPost('descriptMap'),
					'lvlMap' => $this->request->getPost('lvlMap'),
					'idCategoryMap' => $this->request->getPost('idCategoryMap'),
					'imageMap' => $this->request->getPost('imageMap')
				];

		        $validation = $this->validate([
		            'nameMap' => [
		                'rules'  => 'required|min_length[1]|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'min_length' => 'Debe contener como mínimo 1 caracter.<br/>',
		                ],
		            ],
		            'descriptMap' => [
		                'rules'  => 'required|min_length[5]|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'min_length' => 'Debe contener como mínimo 5 carácteres.<br/>',
		                ],
		            ],
		            'lvlMap' => [
		                'rules'  => 'required|integer|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'integer' => 'Solo se admite valores numéricos.<br/>',
		                ],
		            ],
		            'idCategoryMap' => [
		                'rules'  => 'required',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		            'imageMap' => [
		                'rules'  => 'required',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                ],
		            ],
		        ]);

		        if(!$validation)
		        {
		        	return view('template/header', $data).view('admin/add_map_v', $data, ['validation'=>$this->validator]).view('template/footer');

		        }else{

		        	$query = $this->adminModel->updateMap($idMap, $dataPost);

		        	if(!$query)
		        	{
		        		return redirect()->to(current_url())->with('fail', 'Hubo un error al ingresar los datos.');
		        	}else{
		        		return redirect()->to(current_url())->with('success', 'Se han guardado los cambios correctamente.');
		        	}
		        }
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('admin/edit_map_v', $data).view('template/footer');		
	}

}
