<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Profile extends BaseController 
{
	protected $adminModel;
    protected $userModel;
    protected $friendsModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
		$this->friendsModel = new Friends_m();
	}

	public function index($user = null)
	{

		$data = [
			'getSession' => session()->get('loggedUser'),
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getUserData' => $this->userModel->where('user', $user)->first(),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
			$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
			$data['getFriends'] = $this->friendsModel->getFriendsProfile($data['getUserData']['id']);
			$data['getFriendsMe'] = $this->friendsModel->getFriends($data['userInfo']['id']);
		}
		
		$data['pag'] = 'Perfil de '.$data['getUserData']['user'];
		$data['box_left'] = view('template/box_left', $data);

		// Si hay mantenimiento y no tienes un rango te redirige a la página de mantenimiento.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) < 0){ return redirect()->to('/maintenance'); }

		if(!$data['getUserData'])
		{
			return redirect()->to(base_url());

		}else{

			$statusFightMe = $this->adminModel->statusFight($data['userInfo']['id']);
			$statusFightEnemy = $this->adminModel->statusFight($data['getUserData']['id']);

			$statusArenaMe = $this->adminModel->statusArena($data['userInfo']['id']);
			$statusArenaEnemy = $this->adminModel->statusArena($data['getUserData']['id']);


			if(isset($data['getSession']['userSession']))
			{
				// Si el usuario rival soy yo mismo, no mostrar botón de atacar.
				if($data['getUserData']['id'] == $data['userInfo']['id'])
				{
					$data['buttonAction'] = null;
				}
				// Si ya estás en un combate contra un mob o un duelo contra otro usuario sin finalizar, no podrás atacar.
				elseif($statusArenaMe or $statusFightMe)
				{
					$data['buttonAction'] = '
									<button type="submit" disabled class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Ya estás en un combate</button>
									<br/><hr/>';
				}
				// Si no tienes salud, no podrás atacar.
				elseif($data['userInfo']['health'] <= 10)
				{
					$data['buttonAction'] = '<script> function restringir(){ alert("No tienes Salud suficiente para poder combatir."); }</script>
									<button type="submit" onclick="restringir()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
									<br/><hr/>';
				}
				// Si no tienes energía, no podrás atacar.
				elseif($data['userInfo']['energy'] < 5)
				{
					$data['buttonAction'] = '<script> function restringir(){ alert("No tienes Energía para poder combatir."); }
									</script><button type="submit" onclick="restringir()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
									<br/><hr/>';
				}
				// Si el usuario rival no tiene salud ,no puede ser atacado.
				elseif($data['getUserData']['health'] <= 10)
				{
					$data['buttonAction'] = '<script> function restringir(){ alert("Este usuario no dispone de salud suficiente para combatir."); }</script>
											  	<button type="submit" onclick="restringir()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
											  	<br/><hr/>';
				}
				// Si el usuario rival no tiene energía, no puede ser atacado.
				elseif($data['getUserData']['energy'] < 5)
				{
					$data['buttonAction'] = '<script> function restringir(){ alert("Este usuario no dispone de energía suficiente para combatir."); }</script>
											  	<button type="submit" onclick="restringir()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
											  	<br/><hr/>';
				}
				// Si tienes una ventaja de más niveles que el establecido en la configuración del sitio, no se podrá atacar.
				elseif($data['userInfo']['level'] - $data['getUserData']['level'] > $data['siteInfo']['intervalLvl'])
				{
					$data['buttonAction'] = '<script> function restringir(){ alert("Hay una diferencia de '.$data['siteInfo']['intervalLvl'].' o más niveles. No puedes combatir."); }</script>
											  	<button type="submit" onclick="restringir()" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-alert"></span> &nbsp;&nbsp;Atacar Usuario</button>
											  	<br/><hr/>';
				}else{

					$data['buttonAction'] = '<form method="post" action="'.current_url().'">
										  		<input type="submit" name="createArena" class="btn btn-danger btn-sm" value="Atacar Usuario"></form>
										  		<hr/>';
					
					// Se crea una arena donde combates contra el usuario seleccionado con las estadísticas que tenía en el momento de atacarlo.
					if($this->request->getPost('createArena'))
					{
						$subtractEnergy = $data['userInfo']['energy'] - 5;

						$this->userModel->updateParameterUser('energy', $subtractEnergy, $data['userInfo']['id']);

						$dataPost = [
							'idUser1' => $data['userInfo']['id'],
							'idUser2' => $data['getUserData']['id'],
							'atkEnemyArena' => $data['getUserData']['attack'],
							'healthEnemyArena' => $data['getUserData']['health'],
							'maxHealthEnemyArena' => $data['getUserData']['maxHealth'],
							'energyEnemyArena' => $data['getUserData']['energy'],
							'maxEnergyEnemyArena' => $data['getUserData']['maxEnergy'],
						];

						$this->adminModel->insertArena($dataPost);

						return redirect()->to(base_url('/duel'));
					}

				}

				if($this->request->getPost('sendRequest'))
				{
					$dataRequest = [
						'idAuthorRequest' => $data['userInfo']['id'],
						'idReceiverRequest' => $data['getUserData']['id'],
						'dateRequest' => date('Y-m-d H:i')
					];

					$query = $this->friendsModel->insertRequest($dataRequest);

					if(!$query)
					{
						return redirect()->to(current_url());
					}else{
						return redirect()->to(current_url());
					}
				}

				if($data['getUserData']['id'] === $data['userInfo']['id'])
				{
					echo null;

				}elseif(count($data['getFriendsMe']) >= $data['siteInfo']['maxFriends']){

					$data['buttonRequest'] = '<center><button disabled class="btn btn-primary btn-xs">Límite de amigos alcanzado</button></center>';

				}elseif($this->friendsModel->checkFriends($data['userInfo']['id'], $data['getUserData']['id']) == TRUE){

					$data['buttonRequest'] = '<center><button disabled name="sendRequest" class="btn btn-primary btn-xs">Ya sois amigos</button></center>';

				}elseif($this->friendsModel->checkRequests($data['userInfo']['id'], $data['getUserData']['id']) == TRUE){

					$data['buttonRequest'] = '<center><button disabled class="btn btn-secondary btn-xs">Pendiente...</button></center>';

				}else{
					
					$data['buttonRequest'] = '<center><form method="post" action="'.current_url().'">
										<input type="submit" name="sendRequest" class="btn btn-success btn-xs" value="Añadir a amigos">
											</form></center>';
				}
			}
		}

		// Imprimir vistas de la página.
		return view('template/header', $data).view('profile_v', $data).view('template/footer');
	}
}
