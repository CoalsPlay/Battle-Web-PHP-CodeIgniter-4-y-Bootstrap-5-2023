<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\News_m;
use App\Models\Comments_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class News extends BaseController {

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

	public function index($idNews = null)
	{

		// Paginación ////////////////////////////////////////////////////////////////////////

		$pager = \Config\Services::pager();
		$uri = new \CodeIgniter\HTTP\URI(base_url().'/news/'.$idNews);
		$segment = $uri->getTotalSegments() + 1;

		$paginateData = $this->commentsModel->where('idNewsComment', $idNews)
											->join('users_db', 'comments_db.authorComment = users_db.id', 'inner')
											->orderBy('idComment', 'DESC')
											->paginate(1, 'commentsList', null, $segment);
		
		//////////////////////////////////////////////////////////////////////////////////////

		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Noticia',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getNews' => $this->newsModel->getNews($idNews),
			'getComments' => $paginateData,
			'numComments' => $this->commentsModel->where('idNewsComment', $idNews)->countAllResults(),
			'pager' => $this->commentsModel->pager,
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

		if(!$data['getNews'])
		{
			return redirect()->to(base_url());
		}else{

			if($this->request->getPost('sendComment'))
			{
				$dataPost = [
					'textComment' => $this->request->getPost('textComment'),
					'authorComment' => $data['userInfo']['id'],
					'dateComment' => date("Y-m-d H:i"),
					'idNewsComment' => $this->request->getPost('idNewsComment')
				];

		        $validation = $this->validate([
		            'textComment' => [
		                'rules'  => 'trim|required|min_length[10]|htmlspecialchars',
		                'errors' => [
		                    'required' => 'Debe rellenar este campo.<br/>',
		                    'min_length' => 'El comentario debe tener mínimo 10 carácteres.<br/>',
		                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
		                ],
		            ],
		        ]);

		        if(!$validation)
		        {
		        	return view('template/header', $data).view('news_v', $data, ['validation'=>$this->validator]).view('template/footer');

		        }else{

		        	foreach($data['getNews'] as $row)
		        	{
			        	$sumComment = $row['commentsNews'] + 1;
		        	}

			        $set = [
			        	'commentsNews' => $sumComment,
			        ];

		        	$query1 = $this->commentsModel->insertComment($dataPost);
		        	$query2 = $this->newsModel->updateCommentsNews($idNews, $set);

		        	if(!$query1 && !$query2)
		        	{
		        		return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
		        	}else{
		        		return redirect()->to(current_url())->with('success', 'El comentario ha sido escrito correctamente.');
		        	}
		        }
			}

			if($this->request->getPost('deleteComment'))
			{
				$idComment = $this->request->getPost('idComment');

		        foreach($data['getNews'] as $row)
		        {
			        $restComment = $row['commentsNews'] - 1;
		        }

			   	$set = [
			    	'commentsNews' => $restComment,
			   	];

				$query1 = $this->commentsModel->deleteComment($idComment);
				$query2 = $this->newsModel->updateCommentsNews($idNews, $set);

				if(!$query1 && !$query2)
				{
					return redirect()->to(current_url())->with('fail', 'Hubo un error al ejecutar la función.');
				}else{
					return redirect()->to(current_url())->with('success', 'El comentario ha sido eliminado correctamente.');
				}
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('news_v', $data).view('template/footer');
	}
}
