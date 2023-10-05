<?php

namespace App\Controllers;

use App\Models\Users_m;
use App\Models\Admin_m;
use App\Models\Mobs_m;
use App\Models\Messages_m;
use App\Models\Friends_m;
use App\Libraries\Hash;

class Map extends BaseController {

	protected $adminModel;
	protected $userModel;
	protected $mobsModel;
	protected $friendsModel;
	protected $messagesModel;

	public function __construct()
	{
		$this->adminModel = new Admin_m();
		$this->userModel = new Users_m();
		$this->mobsModel = new Mobs_m();
		$this->messagesModel = new Messages_m();
		$this->friendsModel = new Friends_m();
	}

	public function map()
	{

		// Información principal de página ///////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Mapa',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getCategories' => $this->adminModel->getCategories(),
			'db1' => new Admin_m(),
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
		return view('template/header', $data).view('map_v', $data).view('template/footer');
	}

	public function explore($idMap = null)
	{

		// Información principal de página ///////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Explorando...',
			'ultUser' => $this->userModel->orderBy('id', 'DESC')->first(),
			'countUsers' => $this->userModel->countUsers(),
			'siteInfo' => $this->adminModel->getInfoSite(),
			'db' => new Messages_m(),

			'getRandomMob' => $this->mobsModel->randomMob($idMap),
			'getMap' => $this->adminModel->getMapId($idMap),
		];

		// Establecer variables si existe una sesión activa.
		if(isset($data['getSession'])){ 
			$data['userInfo'] = $this->userModel->getUser($data['getSession']['userSession']['user']);
			$data['statusFight'] = $this->adminModel->statusFight($data['userInfo']['id']); 
			$data['statusArena'] = $this->adminModel->statusArena($data['userInfo']['id']);
			$data['friends'] = $this->friendsModel->numRequestsId($data['userInfo']['id']);
		}

		// Si un usuario tiene un combate activo no puede acceder a esta area.
		if($data['statusFight'] == true){ return redirect()->to('/map/fight'); }
		if($data['statusArena'] == true){ return redirect()->to('/map')->with('fail', 'Tienes un duelo en proceso. Finalízalo antes de entrar en otro combate.'); }

		if(!$data['getRandomMob']){ return redirect()->to('/map')->with('fail', 'No hay enemigos asignados a este mapa.'); }

		$data['box_left'] = view('template/box_left', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		// Si un usuario intenta entrar mediante URL a un mapa restringido por nivel, lo redirecciona al apartado Mapas
		foreach($data['getMap'] as $row){ if($data['userInfo']['level'] < $row['lvlMap']){ return redirect()->to('/map'); } }

		//////////////////////////////////////////////////////////////////////////////////////


		if($data['userInfo']['health'] == 0 && $data['userInfo']['energy'] < 5){
			echo '<script> function restringir(){ alert("No tienes salud ni energía para poder combatir."); }</script>';
		}elseif($data['userInfo']['health'] == 0){
			echo '<script> function restringir(){ alert("No tienes salud para poder combatir."); }</script>';
		}elseif($data['userInfo']['energy'] < 5){
			echo '<script> function restringir(){ alert("No tienes energía suficiente para poder combatir."); }</script>';
		}else{

			if($this->request->getPost('fight')){

				$dataPost = [
					'idUser' => $data['userInfo']['id'],
					'idMob' => $this->request->getPost('idMob'),
					'healthMob' => $this->request->getPost('healthMob'),
					'maxHealthMob' => $this->request->getPost('maxHealthMob'),
					'atkMob' => $this->request->getPost('atkMob'),
				];
				
				$subtractEnergy = $data['userInfo']['energy'] - 5;

				$query1 = $this->userModel->updateParameterUser('energy', $subtractEnergy, $data['userInfo']['id']);
				$query2 = $this->adminModel->insertFight($dataPost);

				if(!$query1 && !$query2)
				{
					return redirect()->to('/map');
				}else{
					return redirect()->to('/map/fight');
				}
			}						  			
		} 

		// Imprimir vistas de la página.
		return view('template/header', $data).view('explore_v', $data).view('template/footer');	
	}

	public function fight()
	{

		// Información principal de página ///////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'En combate',
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


		// Si no hay combate se redirecciona al apartado Mapas.
		$data['checkFight'] = $this->adminModel->checkFight($data['userInfo']['id']);
		if(!$data['checkFight']){ return redirect()->to('/map'); }
		if($data['statusArena']){ return redirect()->to(base_url()); }

		// Si ya hay previamente un combate activo, se redirige al apartado Mapas.
		if($this->adminModel->checkFightActive($data['userInfo']['id']) == TRUE){ return redirect()->to('/map'); }

		$data['box_left'] = view('template/box_left', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		foreach($data['checkFight'] as $row):

		if($data['userInfo']['health'] == 0 && $row['healthEnemyFight'] == 0)
		{
			$data['msg'] = '<center><b>¡Ha acabado en empate!</b></center>
							<center>Más suerte para la próxima vez...</center><br/>
							<center>No has perdido nada, pero tampoco has ganado ninguna recompensa.</center><br/>
							<form method="post" action="'.current_url().'">
								<input name="sameFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
							</form>';

		}elseif($row['healthEnemyFight'] == 0){

			if($data['userInfo']['level'] == $data['siteInfo']['maxLvl']){

				$data['msg'] = '<center><b>¡Has ganado el combate!<br/>¡Felicidades!</b></center><br/>
							    	<center>Recompensa<br/>
									<img src="'.base_url('/assets/img/iconos/coins.png').'"> &nbsp;<b>+'.$row['goldMob'].'</b> '.$data['siteInfo']['moneyName'].'<br/>
									<img src="'.base_url('/assets/img/iconos/bullet_orange.png').'"> &nbsp;<b>+'.$row['reputationMob'].'</b> Pts. de Reputación</center>
									<br/>
									<form method="post" action="'.current_url().'">
							    		<input name="victoryFinish" type="submit" style="width:100%;" class="btn btn-success" value="Finalizar combate">
							    	</form>';
			}else{

				$data['msg'] = '<center><b>¡Has ganado el combate!<br/>¡Felicidades!</b></center><br/>
							    	<center>Recompensa<br/>
									 <img src="'.base_url('/assets/img/iconos/exp.png').'"> &nbsp;<b class="text-success">+'.$row['expMob'].'</b> de Experiencia<br/>
									<img src="'.base_url('/assets/img/iconos/coins.png').'"> &nbsp;<b class="text-success">+'.$row['goldMob'].'</b> '.$data['siteInfo']['moneyName'].'<br/>
									<img src="'.base_url('/assets/img/iconos/bullet_orange.png').'"> &nbsp;<b class="text-success">+'.$row['reputationMob'].'</b> Pts. de Reputación</center>
									<br/>
									<form method="post" action="'.current_url().'">
							    		<input name="victoryFinish" type="submit" style="width:100%;" class="btn btn-success" value="Finalizar combate">
							    	</form>';
			}

		}elseif($data['userInfo']['health'] == 0){

			$data['msg'] = '<center><b>¡Has perdido!</b></center>
							<center>Más suerte la próxima vez...</center><br/>
							<center>Has perdido:<br/>
							<img src="'.base_url('/assets/img/iconos/coins.png').'"> &nbsp;<b><span class="text-danger">-'.$row['goldMob'].'</span></b> '.$data['siteInfo']['moneyName'].'<br/>
							<img src="'.base_url('/assets/img/iconos/bullet_orange.png').'"> &nbsp;<b><span class="text-danger">-'.$row['reputationMob'].'</span></b> Pts. de Reputación</center>
							<br/>
							<form method="post" action="'.current_url().'">
								<input name="loserFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
					 		</form>';

		}elseif($data['userInfo']['energy'] < 5){

			$data['msg'] = '<center><b>¡Has perdido por falta de energía!</b></center>
							<center>Más suerte la próxima vez...</center><br/>
							<center>Has perdido:<br/>
							<img src="'.base_url('/assets/img/iconos/coins.png').'"> &nbsp;<b><span class="text-danger">-'.$row['goldMob'].'</span></b> '.$data['siteInfo']['moneyName'].'<br/>
							<img src="'.base_url('/assets/img/iconos/bullet_orange.png').'"> &nbsp;<b><span class="text-danger">-'.$row['reputationMob'].'</span></b> Pts. de Reputación</center>
							<br/>
							<form method="post" action="'.current_url().'">
								<input name="loserFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
					 		</form>';
		}

		if($this->request->getPost('sameFinish'))
		{
			$query1 = $this->userModel->updateParameterUser('health', '10', $data['userInfo']['id']);

			if($data['userInfo']['energy'] < 5) {
				$query1 = $this->userModel->updateParameterUser('energy', '10', $data['userInfo']['id']);
			}

			$query2 = $this->adminModel->deleteFight($row['idFight']);

			if($query1 && $query2){
				return redirect()->to('/map');
			}
		}

		if($this->request->getPost('victoryFinish'))
		{
				$increaseGold = $data['userInfo']['gold'] + $row['goldMob'];
				$increaseReputation = $data['userInfo']['reputation'] + $row['reputationMob'];
				$increaseKills = $data['userInfo']['kills'] + 1;

				$this->userModel->updateParameterUser('gold', $increaseGold, $data['userInfo']['id']);
				$this->userModel->updateParameterUser('reputation', $increaseReputation, $data['userInfo']['id']);
				$this->userModel->updateParameterUser('kills', $increaseKills, $data['userInfo']['id']);

			if($data['userInfo']['level'] < $data['siteInfo']['maxLvl'])
			{
				$increaseExp = $data['userInfo']['exp'] + $row['expMob'];
				$this->userModel->updateParameterUser('exp', $increaseExp, $data['userInfo']['id']);

				// Experiencia actual del usuario más la obtenida por el combate.
				$exp_earned = $data['userInfo']['exp'] + $row['expMob'];

				if($exp_earned >= $data['userInfo']['maxExp'])
				{
					$increaseLvl = $data['userInfo']['level'] + 1;
					$this->userModel->updateParameterUser('level', $increaseLvl, $data['userInfo']['id']);

					$this->userModel->updateParameterUser('exp', '0', $data['userInfo']['id']);

					$increaseMaxExp = $data['userInfo']['maxExp'] + $data['siteInfo']['intervalExp'];
					$this->userModel->updateParameterUser('maxExp', $increaseMaxExp, $data['userInfo']['id']);

					$increaseAtributesPoints = $data['userInfo']['ptsAttributes'] + $data['siteInfo']['attributePointsPerLvl'];
					$this->userModel->updateParameterUser('ptsAttributes', $increaseAtributesPoints, $data['userInfo']['id']);
				}
			}

				$this->adminModel->deleteFight($row['idFight']);
				return redirect()->to('/map');

		}

		if($this->request->getPost('loserFinish'))
		{
			$subtractReputation = $data['userInfo']['reputation'] - $row['reputationMob'];
			$subtractGold = $data['userInfo']['gold'] - $row['goldMob'];
			$increaseKill = $data['userInfo']['deaths'] + 1;

			$this->userModel->updateParameterUser('health', '10', $data['userInfo']['id']);
			$this->userModel->updateParameterUser('reputation', $subtractReputation, $data['userInfo']['id']);
			$this->userModel->updateParameterUser('gold', $subtractGold, $data['userInfo']['id']);
			$this->userModel->updateParameterUser('deaths', $increaseKill, $data['userInfo']['id']);

			if($data['userInfo']['energy'] < 5) {
				$query1 = $this->userModel->updateParameterUser('energy', '10', $data['userInfo']['id']);
			}

			$this->adminModel->deleteFight($row['idFight']);

			return redirect()->to('/map');
		} 

		if($this->request->getPost('attack'))
		{

			$subtractHealth = $data['userInfo']['health'] - $row['atkEnemyFight'];
			$subtractEnergy = $data['userInfo']['energy'] - 5;
			$subtractHealthEnemy = $row['healthEnemyFight'] - $data['userInfo']['attack'];

			$this->userModel->updateParameterUser('health', $subtractHealth, $data['userInfo']['id']);
			$this->userModel->updateParameterUser('energy', $subtractEnergy, $data['userInfo']['id']);
			$this->adminModel->updateFight('healthEnemyFight', $subtractHealthEnemy, $row['idFight']);

			$data['msg'] = '<b>'.$data['userInfo']['user'].'</b> infligió <b>'.$data['userInfo']['attack'].'</b> de daño.<br/>
								<hr/>
								<b><span class="text-danger">'.$row['nameMob'].'</span></b> infligió <b>'.$row['atkEnemyFight'].'</b> de daño.	';
			echo '<meta http-equiv="refresh" content="0.5;'.current_url().'">';
		}

		if($this->request->getPost('surrender'))
		{
			$this->userModel->updateParameterUser('health', '0', $data['userInfo']['id']);

			return redirect()->to(current_url());
		}
		
		endforeach;

		// Imprimir vistas de la página.
		return view('template/header', $data).view('fight_v', $data).view('template/footer');		
	}

	public function duel()
	{
		// Información principal de página ///////////////////////////////////////////////////

		$data = [
			'getSession' => session()->get('loggedUser'),
			'pag' => 'Duelo',
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

		// Si no hay combate se redirecciona al apartado Mapas.
		$data['checkFight'] = $this->adminModel->statusFight($data['userInfo']['id']);
		if($data['checkFight']){ return redirect()->to(base_url('/map/fight')); }

		$data['box_left'] = view('template/box_left', $data);

		// Si hay mantenimiento, te muestra una vista, si no lo hay, la vista normal.
		if($data['siteInfo']['maintenance'] == 1 && isset($data['userInfo']['rank']) == 0){ return redirect()->to('/maintenance'); }

		//////////////////////////////////////////////////////////////////////////////////////

		$data['checkArena'] = $this->adminModel->checkArena($data['userInfo']['id']);

		if(!$data['checkArena']){ return redirect()->to(base_url()); }

		foreach($data['checkArena'] as $row):

		if($data['userInfo']['health'] == 0 && $row['healthEnemyArena'] == 0)
		{
			$data['msg'] = '<center><b>¡Ha acabado en empate!</b></center>
							<center>Más suerte para la próxima vez...</center><br/>
							<center>No has perdido nada, pero tampoco has ganado ninguna recompensa.</center><br/>
							<form method="post" action="'.current_url().'">
								<input name="sameFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
							</form>';
		}elseif($data['userInfo']['energy'] < 5 && $row['energyEnemyArena'] < 5){

			$data['msg'] = '<center><b>¡Ha acabado en empate, porque ambos os habéis quedado sin energía.!</b></center>
							<center>Más suerte para la próxima vez...</center><br/>
							<center>No has perdido nada, pero tampoco has ganado ninguna recompensa.</center><br/>
							<form method="post" action="'.current_url().'">
								<input name="sameFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
							</form>';

		}elseif($row['healthEnemyArena'] == 0){

			$data['msg'] = '<center><b>¡Has ganado el combate a <a href="'.base_url('/profile/'.$row['user']).'">'.$row['user'].'</a>!<br/>¡Felicidades!</b></center><br/>

								<br/>
								<form method="post" action="">
						    		<input name="victoryFinish" type="submit" style="width:100%;" class="btn btn-success" value="Finalizar combate">
						    	</form>';

		}elseif($data['userInfo']['health'] == 0){

			$data['msg'] = '<center><b>¡Has perdido!</b></center>
							<center>Más suerte para la próxima vez...</center><br/>
							
							<form method="post" action="'.current_url().'">
								<input name="loserFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
					 		</form>';
		}elseif($data['userInfo']['energy'] < 5){

			$data['msg'] = '<center><b>¡Has perdido por falta de energía!</b></center>
							<center>Más suerte para la próxima vez...</center><br/>
							
							<form method="post" action="'.current_url().'">
								<input name="loserFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Finalizar combate">
					 		</form>';
	    }elseif($row['energyEnemyArena'] < 5){

			$data['msg'] = '<center><b>¡Has ganado el combate a <a href="'.base_url('/profile/'.$row['user']).'">'.$row['user'].'</a> porque se ha quedado sin energía!<br/>¡Felicidades!</b></center><br/>

								<br/>
								<form method="post" action="">
						    		<input name="victoryFinish" type="submit" style="width:100%;" class="btn btn-success" value="Finalizar combate">
						    	</form>';

		}else{
			$data['msg'] = '<center><b>Esperando acción...</b></center>';
		}

		// Si ambos empatan vuelven a inicio con 50 puntos de salud y se envía una notificación al rival.
		if($this->request->getPost('sameFinish'))
		{
			$this->userModel->updateParameterUser('health', '50', $data['userInfo']['id']);
			$this->userModel->updateParameterUser('health', '50', $row['id']);

			$this->adminModel->deleteArena($row['idArena']);

			$dataPost = [
				'idAuthorMsg' => $data['userInfo']['id'],
				'toMsg' => $row['id'],
				'titleMsg' => 'Notificación automática',
				'textMsg' => '¡Has quedado en empate con '.$data['userInfo']['user'].' en un duelo!',
			];

			$this->messagesModel->insertMsg($dataPost, $row['id']);

			echo '<meta http-equiv="refresh" content="1.5;'.base_url().'">';
		}

		// Si obtienes la victoria, te suman 1 baja y a tu rival una derrota y se le envía una notificación con el resultado.
		if($this->request->getPost('victoryFinish'))
		{
			$increaseKills = $data['userInfo']['kills'] + 1;
			$increaseDeaths = $row['deaths'] + 1;

			$this->userModel->updateParameterUser('health', '10', $row['id']);
			$this->userModel->updateParameterUser('kills', $increaseKills, $data['userInfo']['id']);
			$this->userModel->updateParameterUser('deaths', $increaseDeaths, $row['id']);

			$dataPost = [
				'idAuthorMsg' => $data['userInfo']['id'],
				'toMsg' => $row['user'],
				'titleMsg' => 'Notificación automática',
				'textMsg' => '¡Has sido derrotado por '.$data['userInfo']['user'].' en un duelo!',
			];

			$this->messagesModel->insertMsg($dataPost, $row['id']);

			$this->adminModel->deleteArena($row['idArena']);

			return redirect()->to(base_url());
		}

		// Si pierdes te suma una derrota, al rival una baja y vuelves a inicio con 10 puntos de vida
		if($this->request->getPost('loserFinish'))
		{
			$increaseDeaths = $data['userInfo']['deaths'] + 1;
			$increaseKills = $row['kills'] + 1;

			$this->userModel->updateParameterUser('health', '10', $data['userInfo']['id']);
			$this->userModel->updateParameterUser('deaths', $increaseDeaths, $data['userInfo']['id']);
			$this->userModel->updateParameterUser('kills', $increaseKills, $row['id']);

			if($data['userInfo']['energy'] < 5)
			{
				$this->userModel->updateParameterUser('energy', '10', $data['userInfo']['id']);
			}

			$dataPost = [
				'idAuthorMsg' => $data['userInfo']['id'],
				'toMsg' => $row['user'],
				'titleMsg' => 'Notificación automática',
				'textMsg' => '¡Has derrotado a '.$data['userInfo']['user'].' en un duelo iniciado por este usuario!',
			];

			$this->messagesModel->insertMsg($dataPost, $row['id']);

			$this->adminModel->deleteArena($row['idArena']);

			return redirect()->to(base_url());
		}

		// Si atacas le descuentas al rival los puntos de salud correspondiente a tu ataque, y tu salud correspondiente al rival
		if($this->request->getPost('attack'))
		{

			$subtractHealth = $data['userInfo']['health'] - $row['atkEnemyArena'];
			$subtractEnergy = $data['userInfo']['energy'] - 5;
			$subtractHealthEnemy = $row['healthEnemyArena'] - $data['userInfo']['attack'];
			$subtractEnergyEnemy = $row['energyEnemyArena'] - 5;

			$this->userModel->updateParameterUser('health', $subtractHealth, $data['userInfo']['id']);
			$this->userModel->updateParameterUser('energy', $subtractEnergy, $data['userInfo']['id']);
			$this->adminModel->updateArena('healthEnemyArena', $subtractHealthEnemy, $row['idArena']);
			$this->adminModel->updateArena('energyEnemyArena', $subtractEnergyEnemy, $row['idArena']);

			echo '<meta http-equiv="refresh" content="1;'.current_url().'">';

			$data['msg'] = '<b>'.$data['userInfo']['user'].'</b> infligió <b>'.$data['userInfo']['attack'].'</b> de daño.<br/>
								<b><span class="text-danger">'.$row['user'].'</span></b> infligió <b>'.$row['atkEnemyArena'].'</b> de daño.';

		}

		// Si te rindes, te suman una derrota y vuelves a inicio con 10 puntos de vida.
		if($this->request->getPost('surrender'))
		{
			$increaseDeaths = $data['userInfo']['deaths'] + 1;

			$this->userModel->updateParameterUser('deaths', $increaseDeaths, $data['userInfo']['id']);
			$this->userModel->updateParameterUser('health', '10', $data['userInfo']['id']);

			$data['msg'] = '<center><b>¡Te has rendido!</b></center>
							<center>Más suerte para la próxima vez...</center><br/>
							
							<form method="post" action="'.base_url().'">
								<input name="loserFinish" type="submit" style="width:100%;" class="btn btn-danger" value="Volver a inicio">
					 		</form>';

			$this->adminModel->deleteArena($row['idArena']);
		}

		endforeach;

		// Imprimir vistas de la página.
		return view('template/header', $data).view('arena_v', $data).view('template/footer');			
	}
}
