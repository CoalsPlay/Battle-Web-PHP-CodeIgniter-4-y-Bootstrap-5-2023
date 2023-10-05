<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Libraries\Hash;

class Auth extends BaseController 
{

	protected $adminModel;
    protected $userModel;

    public function __construct()
    {
        $this->adminModel = new Admin_m();
        $this->userModel = new Users_m();
    }

	public function login()
	{

        // Información principal de página ///////////////////////////////////////////////////

        $data = [
            'pag' => 'Login',
            'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
            'countUsers' => $this->userModel->countUsers(),
            'siteInfo' => $this->adminModel->getInfoSite(),
        ];

        if(isset($data['getSession'])){ $data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']); }

		$data['box_left'] = view('template/box_left', $data);

        //////////////////////////////////////////////////////////////////////////////////////

        // Imprimir vistas de la página.
		return view('template/header', $data).view('login_v', $data).view('template/footer');

	}

    public function check()
    {
        // Información principal de página ///////////////////////////////////////////////////

        $data = [
            'pag' => 'Comprobando credenciales',
            'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
            'countUsers' => $this->userModel->countUsers(),
            'siteInfo' => $this->adminModel->getInfoSite(),
        ];

        $data['box_left'] = view('template/box_left', $data);

        //////////////////////////////////////////////////////////////////////////////////////

        $validation = $this->validate([
            'username' => [
                'rules'  => 'required|is_not_unique[users_db.user]|alpha_dash|htmlspecialchars',
                'errors' => [
                    'required' => 'Debe escribir un nombre de usuario.<br/>',
                    'is_not_unique' => 'Este usuario no existe.<br/>',
                    'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
                ],
            ],
            'password' => [
                'rules'  => 'required|alpha_dash|min_length[6]|max_length[40]|htmlspecialchars',
                'errors' => [
                    'required' => 'Debe escribir una contraseña.<br/>',
                    'min_length' => 'La contraseña debe contener más de 6 carácteres.<br/>',
                    'max_length' => 'La contraseña es demasiado larga',
                    'alpha_dash' => 'No está permitido carácteres especiales.',
                ],
            ],
        ]);

        if(!$validation){

            // Imprimir vistas de la página.
            return view('template/header', $data).view('login_v', $data, ['validation'=>$this->validator]).view('template/footer');

        }else{
            
            //Obtenemos el valor de los campos de texto
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            $user_info = $this->userModel->where('user', $username)->first();

            $check_password = Hash::check($password, $user_info['passw']);

            if(!$check_password){

                return  redirect()->to('/login')->with('fail', 'Usuario o contraseña incorrectos.')->withInput();
                
            }else{

                $session_data = ['userSession' => $user_info];
                session()->set('loggedUser', $session_data);
                return  redirect()->to('/');
            }
        }
    }

	public function register()
	{

        // Información principal de página ///////////////////////////////////////////////////

        $data = [
            'pag' => 'Registro',
            'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
            'countUsers' => $this->userModel->countUsers(),
            'siteInfo' => $this->adminModel->getInfoSite(),
        ];

		$data['box_left'] = view('template/box_left', $data);

        // Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
        if($data['siteInfo']['maintenance'] == 1){ return redirect()->to('/maintenance'); }

        //////////////////////////////////////////////////////////////////////////////////////

        // Imprimir vistas de la página.
		return view('template/header', $data).view('register_v', $data).view('template/footer');
	}

	public function save()
	{

        // Información principal de página ///////////////////////////////////////////////////

        $data = [
            'pag' => 'Comprobación de registro',
            'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
            'countUsers' => $this->userModel->countUsers(),
            'siteInfo' => $this->adminModel->getInfoSite(),
        ];

        $data['box_left'] = view('template/box_left', $data); 

        // Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
        if($data['siteInfo']['maintenance'] == 1){ return redirect()->to('/maintenance'); }

        //////////////////////////////////////////////////////////////////////////////////////

        $validation = $this->validate([
            'usernameR' => [
                'rules'  => 'required|is_unique[users_db.user]|alpha_dash|htmlspecialchars',
                'errors' => [
                	'is_unique' => 'Este nombre de usuario ya está en uso.<br/>',
                    'required' => 'Debes escribir un nombre de usuario.<br/>',
                    'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                    'htmlspecialchars' => 'No se permiten carácteres especiales.<br/>',
                ],
            ],
            'emailR' => [
                'rules'  => 'required|valid_email|is_unique[users_db.email]|htmlspecialchars',
                'errors' => [
                    'required' => 'Escriba un correo electrónico.<br/>',
                    'valid_email' => 'Correo electrónico incorrecto.<br/>',
                    'is_unique' => 'Este correo electrónico ya está en uso.<br/>',
                ],
            ],
            'passwordR' => [
                'rules'  => 'required|min_length[6]|alpha_dash|max_length[20]|htmlspecialchars',
                'errors' => [
                    'required' => 'Escriba una contraseña.<br/>',
                    'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                    'min_length' => 'La contraseña debe tener más de 6 carácteres.<br/>',
                ],
            ],
            'password2' => [
                'rules'  => 'required|alpha_dash|matches[passwordR]|htmlspecialchars',
                'errors' => [
                    'required' => 'Confirme la contraseña.<br/>',
                    'matches' => 'Las contraseñas no coinciden.<br/>',
                    'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                ],
            ],
        ]);

        if(!$validation){
          
            return view('template/header', $data).view('register_v', $data, ['validation'=>$this->validator]).view('template/footer');

        }else{
            
            //Obtenemos el valor de los campos de texto
            $username = $this->request->getPost('usernameR');
            $email = $this->request->getPost('emailR');
            $password = $this->request->getPost('passwordR');
            $ip = $this->request->getPost('ip');
 
            $values = [
               'usernameR' => $username,
               'emailR' => $email,
               'passwordR' => Hash::make($password),
               'ip'=>$ip
            ];

            $query = $this->userModel->registerUser($values);

            if(!$query){

                return  redirect()->to('/register')->with('fail', 'Ha habido un error en el registro.');

            }else{

                return  redirect()->to('/register')->with('success', 'Te has registrado corréctamente.');
            }
        }

	}

    public function logout()
    {
        if(session()->has('loggedUser'))
        {
            session()->remove('loggedUser');
            return redirect()->to('/login')->with('success', 'Te has desconectado correctamente.');
        }
    }

    public function forgot_password()
    {

        // Información principal de página ///////////////////////////////////////////////////

        $data = [
            'userInfo' => session()->get('loggedUser'),
            'pag' => 'Contraseña olvidada',
            'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
            'countUsers' => $this->userModel->countUsers(),
            'siteInfo' => $this->adminModel->getInfoSite(),
        ];

        $data['box_left'] = view('template/box_left', $data);

        // Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
        if($data['siteInfo']['maintenance'] == 1){ return redirect()->to('/maintenance'); }

        //////////////////////////////////////////////////////////////////////////////////////

        if($this->request->getPost('sendEmail'))
        {

            $validation = $this->validate([
                'email' => [
                    'rules'  => 'trim|required|valid_email|is_not_unique[users_db.email]|htmlspecialchars',
                    'errors' => [
                        'required' => 'Debe escribir un correo electrónico.<br/>',
                        'valid_email' => 'Este correo electrónico no es correcto.<br/>',
                        'is_not_unique' => 'No hay ninguna cuenta asociada a este correo electrónico.<br/>',
                    ],
                ],
            ]);

            if(!$validation)
            {
                return view('template/header', $data).view('forgot_password_v', $data, ['validation'=>$this->validator]).view('template/footer');

            }else{

                $email = $this->request->getPost('email');

                $token = bin2hex(openssl_random_pseudo_bytes(64));

                $query = $this->userModel->where('email', $email)->first();

                $values = [
                    'tokenPassword' => $token,
                ];

                $query2 = $this->userModel->updateToken($query['id'], $values);

                if(!$query2)
                {
                    return redirect()->to(current_url())->with('fail', 'Ha habido un error.');

                }else{
                    $to = $email;
                    $subject = 'Restaurar contraseña';
                    $token_no = $token;
                    $message = 
                    '<h4 class="card-title">'.$data['siteInfo']['siteName'].' - Cambio de contraseña</h4>

                            <p class="card-text text-secondary">Hola <b>'.$query['user'].'</b>, vemos que ha solicitado un cambio de contraseña, para llevar a cabo este cambio debes acceder a la URL que te proporcionamos a continuación.<br/>

                            Pulsa en el siguiente link para proceder con el cambio de contraseña.</p>

                            <a href="'.base_url().'/auth/password_update/'.$token_no.'">Click aquí para cambiar la contraseña.</a><br/>

                            <p class="card-text text-secondary">De lo contrario si no ha sido usted quien ha solicitado el cambio de contraseña, haz caso omiso a este correo.<br/><br/>

                            <i>Esto es un Email automático enviado por '.$data['siteInfo']['siteName'].' por lo que no se moleste en responderlo. Gracias!</i></span>
                            </p>';

                    $sendEmail = \Config\Services::email();
                    $sendEmail->setTo($to);
                    $sendEmail->setFrom($data['siteInfo']['siteEmail'], $data['siteInfo']['siteName']);
                    $sendEmail->setSubject($subject);
                    $sendEmail->setMessage($message);
                    
                    if(!$sendEmail->send())
                    {
                        $msg = $sendEmail->printDebugger(['headers']);
                        print_r($msg);

                    }else{

                        return redirect()->to(current_url())->with('successPw', 'Hemos enviado un correo a <b>'.$email.'</b> con los pasos a seguir para cambiar su contraseña.');
                    }          
                }

                return $this->response->redirect(current_url());

            }

        }

        // Imprimir vistas de la página.
        return view('template/header', $data).view('forgot_password_v', $data).view('template/footer');         
    }

    public function password_update($token)
    {

        // Información principal de página //////////////////////////////////////////////////

        $data = [
            'userInfo' => session()->get('loggedUser'),
            'pag' => 'Cambiar contraseña',
            'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
            'countUsers' => $this->userModel->countUsers(),
            'siteInfo' => $this->adminModel->getInfoSite(),
            'token' => $token,
        ];

        $data['box_left'] = view('template/box_left', $data);

        // Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
        if($data['siteInfo']['maintenance'] == 1 && $data['userInfo']['rank'] == 0){ return redirect()->to('/maintenance'); }

        $query = $this->userModel->where('tokenPassword', $token)->first();

        /////////////////////////////////////////////////////////////////////////////////////

        // Si el token no existe, redirecciona a inicio. Si existe, procesar toda la información.
        if(!$query or $token == 0)
        { 
            return redirect()->to(base_url()); 

        }else{

            if($this->request->getPost('confirmedUp'))
            {

            $validation = $this->validate([
                'email' => [
                    'rules'  => 'trim|required|valid_email|is_not_unique[users_db.email]|htmlspecialchars',
                    'errors' => [
                        'required' => 'Debe escribir un correo electrónico.<br/>',
                        'valid_email' => 'Este correo electrónico no es correcto.<br/>',
                        'is_not_unique' => 'No hay ninguna cuenta asociada a este correo electrónico.<br/>',
                    ],
                ],
                'usernameR' => [
                    'rules'  => 'trim|required|min_length[4]|alpha_dash|is_not_unique[users_db.user]|htmlspecialchars',
                    'errors' => [
                        'required' => 'Debe escribir el nombre de usuario de la cuenta a recuperar.<br/>',
                        'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                        'min_length' => 'El nombre de usuario debe cotener mínimo 4 carácteres.<br/>',
                        'is_not_unique' => 'Este usuario no existe.<br/>',
                    ],
                ],
                'passwordR' => [
                    'rules'  => 'trim|required|alpha_dash|min_length[6]|max_length[100]|htmlspecialchars',
                    'errors' => [
                        'required' => 'Debe escribir una contraseña.<br/>',
                        'min_length' => 'La contraseña debe tener más de 6 carácteres.<br/>',
                        'max_length' => 'La contraseña es demasiado larga.<br/>',
                        'alpha_dash' => 'No está permitido carácteres especiales.<br/>',
                    ],
                ],
                'cpassword' => [
                    'rules'  => 'trim|required|alpha_dash|min_length[6]|matches[passwordR]|max_length[100]|htmlspecialchars',
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
                return view('template/header', $data).view('password_reset_v', $data, ['validation'=>$this->validator]).view('template/footer');

            }else{

                $email = $this->request->getPost('email');
                $username = $this->request->getPost('usernameR');
                $password = $this->request->getPost('passwordR');

                $valuesWH = [
                    'email' => $email,
                    'user' => $username,
                ];

                $valuesUP = [
                    'tokenPassword' => 0,
                    'passw' => Hash::make($password),
                ];

                $sql = $this->userModel->whereEmail($email, $username);

                if(!$sql)
                {

                    return redirect()->to('/auth/password_update/'.$token)->with('failR', 'El correo o el usuario no coinciden.');

                }else{

                    $update = $this->userModel->updatePassword($valuesWH, $valuesUP);

                    if(!$update)
                    {
                        return redirect()->to('/auth/password_update/'.$token)->with('failR', 'No ha podido cambiarse la contraseña. Inténtelo más tarde.');

                    }else{

                        return redirect()->to('/login')->with('success', 'Su contraseña ha sido cambiada correctamente. Ya puede iniciar sesión con su nueva contraseña.');
                    }
                }
            }

            }else{

                // Imprimir vistas de la página.
                return view('template/header', $data).view('password_reset_v', $data).view('template/footer');
            }

        }

    }

}
