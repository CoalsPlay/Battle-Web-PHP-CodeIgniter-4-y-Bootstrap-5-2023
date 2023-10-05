<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Settings extends BaseController {

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
			'pag' => 'Configuración',
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

		$data['box_config'] = view('template/box_config', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		// Imprimir vistas de la página.
		return view('template/header', $data).view('settings_v', $data).view('template/footer');
	}

	public function change_information()
	{
		// Información principal de página //////////////////////////////////////////////////
		
		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Configuración - Cambio de información',
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

		$data['box_left'] = view('template/box_config', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('saveInfo'))
		{
			$dataPost = [
				'idUser' => $data['userInfo']['id'],
				'aboutMe' => $this->request->getPost('aboutMe'),
				'gender' => $this->request->getPost('gender'),
				'theme' => $this->request->getPost('theme'),
				'twitter' => $this->request->getPost('twitter'),
				'facebook' => $this->request->getPost('facebook'),
				'youtube' => $this->request->getPost('youtube'),
			];

            $validation = $this->validate([
                'aboutMe' => [
                    'rules'  => 'trim|htmlspecialchars',
                    'errors' => [
                        'alpha_numeric_space' => 'No está permitido carácteres especiales.<br/>',
                    ],
                ],
                'twitter' => [
                    'rules'  => 'trim|htmlspecialchars',
                    'errors' => [
                        'alpha_numeric_space' => 'No está permitido carácteres especiales.',
                    ],
                ],
                'facebook' => [
                    'rules'  => 'trim|htmlspecialchars',
                    'errors' => [
                        'alpha_numeric_space' => 'No está permitido carácteres especiales.',
                    ],
                ],
                'youtube' => [
                    'rules'  => 'trim|htmlspecialchars',
                    'errors' => [
                        'alpha_numeric_space' => 'No está permitido carácteres especiales.',
                    ],
                ],
            ]);

			if(!$validation)
			{
				return view('template/header', $data).view('settings_info_v', $data, ['validation'=>$this->validator]).view('template/footer');

			}else{

				$query = $this->userModel->updateUserConfig($dataPost);
				return redirect()->to(current_url())->with('success', 'Los ajustes se han guardado correctamente.');

				if(!$query)
				{
					return redirect()->to(current_url())->with('fail', 'Los ajustes no se han guardado correctamente.');
				}else{
					return redirect()->to(current_url())->with('success', 'Los ajustes se han guardado correctamente.');
				}
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('settings_info_v', $data).view('template/footer');		
	}

	public function change_password()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Configuración - Cambio de contraseña',
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

		$data['box_left'] = view('template/box_config', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('changePass'))
		{

			$dataPost = [
				'idUser' => $data['userInfo']['id'],
				'oldPass' => $this->request->getPost('oldPass'),
				'newPass' => Hash::make($this->request->getPost('newPass')),
			];

            $validation = $this->validate([
                'oldPass' => [
                    'rules'  => 'trim|required|alpha_dash|min_length[6]|max_length[100]|htmlspecialchars',
                    'errors' => [
                        'required' => 'Debe escribir una contraseña.<br/>',
                        'min_length' => 'La contraseña debe tener más de 6 carácteres.<br/>',
                        'max_length' => 'La contraseña es demasiado larga.<br/>',
                        'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                    ],
                ],
                'newPass' => [
                    'rules'  => 'trim|required|alpha_dash|min_length[6]|max_length[100]|htmlspecialchars',
                    'errors' => [
                        'required' => 'Debe confirmar la contraseña.<br/>',
                        'min_length' => 'La contraseña debe tener más de 6 carácteres.<br/>',
                        'max_length' => 'La contraseña es demasiado larga.<br/>',
                        'alpha_dash' => 'No está permitido carácteres especiales.',
                    ],
                ],
                'cNewPass' => [
                    'rules'  => 'trim|required|alpha_dash|min_length[6]|matches[newPass]|max_length[100]|htmlspecialchars',
                    'errors' => [
                        'required' => 'Debe confirmar la contraseña.<br/>',
                        'min_length' => 'La contraseña debe tener más de 6 carácteres.<br/>',
                        'max_length' => 'La contraseña es demasiado larga.<br/>',
                        'matches' => 'La contraseña no coincide.<br/>',
                        'alpha_dash' => 'No está permitido carácteres especiales.',
                    ],
                ],
            ]);

         

			if(!$validation)
			{
				return view('template/header', $data).view('settings_change_pass_v', $data, ['validation'=>$this->validator]).view('template/footer');

			}else{

				$check_password = Hash::check($dataPost['oldPass'], $data['userInfo']['passw']);

				if(!$check_password)
				{
					return redirect()->to(current_url())->with('fail', 'La contraseña antigua es incorrecta.');

				}else{

					$this->userModel->changeUserPass($dataPost);
					return redirect()->to(current_url())->with('success', 'La contraseña ha sido cambiada correctamente.');				
				}


			}
						

		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('settings_change_pass_v', $data).view('template/footer');		
	}

	public function change_avatar()
	{
		// Información principal de página //////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Configuración - Cambio de avatar',
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

		$data['box_left'] = view('template/box_config', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		if($this->request->getPost('uploadAvatar'))
		{

			$file = $this->request->getFile('avatar');

	        $validation = $this->validate([
	            'avatar' => [
	                'rules'  => 'uploaded[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/gif,image/png,image/webp]|max_size[avatar,400]|is_image[avatar]',
	                'errors' => [
	                    'uploaded' => 'Debes seleccionar una imagen.<br/>',
	                    'mime_in' => 'Este formato es incompatible.<br/>',
	                    'max_size' => 'El tamaño máximo es de 200kb.<br/>',
	                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
	                ],
	            ],
	        ]);

	        if(!$validation)
	        {
	        	return view('template/header', $data).view('settings_change_avatar_v', $data, ['validation'=>$this->validator]).view('template/footer');

	        }else{

				$nameFile = $file->getRandomName();


				if($file->isValid() && ! $file->hasMoved())
				{
					$file->move('assets/img/avatars/', $nameFile);
					$this->userModel->uploadAvatar($nameFile, $data['userInfo']['id']);
					return redirect()->to(current_url())->with('success', 'Se ha subido su avatar correctamente.');

				}else{

					return redirect()->to(current_url())->with('fail', 'No pudo subirse la imagen.');
				}

	        }

		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('settings_change_avatar_v', $data).view('template/footer');		
	}

}
