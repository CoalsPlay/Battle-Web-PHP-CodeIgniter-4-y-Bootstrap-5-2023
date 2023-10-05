
<!-- ========================================================================= -->
<!-- Login and User Panel -->
<!-- ========================================================================= -->


				   		<?php if(isset($getSession['userSession'])) { ?>

						<div class="card">
						   <div class="card-header text-center">
						   	<i class="bi bi-person-fill"></i> ¡Bienvenido <b><a href="<?= base_url('/profile/'.$userInfo['user']); ?>"><?= $userInfo['user'] ?></a></b>¡
						   	</div>
						   <div class="card-body">
						   <?php
						   		if(isset($statusFight) && $statusFight == true)
						   		{
						   			echo '<div class="alert alert-dismissible alert-info">
											  <button type="button" class="btn-close" data-dismiss="alert"></button>
											  <strong>Recordatorio</strong> Tienes un combate en proceso, puedes volver dando<br/> <b><a href="'.base_url('/map/fight').'">Clic aquí</a></b>.
											</div>';
						   		}
								
						   		if(isset($statusArena) && $statusArena == true)
						   		{
						   			echo '<div class="alert alert-dismissible alert-info">
											  <button type="button" class="btn-close" data-dismiss="alert"></button>
											  <strong>Recordatorio</strong> Tienes un duelo en proceso, puede volver dando<br/> <b><a href="'.base_url('/duel').'">Clic aquí</a></b>.
											</div>';
						   		}
								
						  		if($friends == 1){
						  			echo '<div class="alert alert-info">
											<img src="'.base_url('/assets/img/iconos/user_add.png').'"> Tienes <b><span class="text-primary"> <a href="'.base_url('/friends').'"> '.$friends.'</a></span></b> petición de amistad pendiente.
											</div>';
						  		}elseif($friends > 1){
								  	echo '<div class="alert alert-info">
											<img src="'.base_url('/assets/img/iconos/user_add.png').'"> Tienes <b><span class="text-primary">
											<a href="'.base_url('/friends').'">'.$friends.'</a></span></b> peticiones de amistad pendiente.
										  </div>';				  				
						  		}

						  		if($db->unreadMsg($userInfo['id']) > 0)
						  		{
								  	echo '<div class="alert alert-info">
												  <img src="'.base_url('/assets/img/iconos/email.png').'"> Tienes <b><span class="text-info"><a href="'.base_url('/inbox').'">'.$db->unreadMsg($userInfo['id']).'</a></span></b> mensaje(s) privado(s) sin leer.
												</div>';
						  		}
						  	?>

							  <ul class="list-group list-group-flush">
								  <li class="list-group-item">

								    <img src="<?= base_url('/assets/img/iconos/upgrade.png'); ?>">
								    <a href="<?= base_url('/attributes'); ?>">Pts. de atributos (<b><?= $userInfo['ptsAttributes']; ?></b>)</a>
								  	<?php
								  		if($userInfo['ptsAttributes'] > 0){
								  			echo '<span class="badge badge-success">
												  	  '.$userInfo['ptsAttributes'].'</span>';
								  		}else{
								  			echo '<span class="badge badge-danger">
												  	  '.$userInfo['ptsAttributes'].'</span>';		
								  		}
								  	?>
									
								  </li>

								  <li class="list-group-item">
									<img src="<?= base_url('assets/img/iconos/rosette.png'); ?>"> Nivel: 
									<span class="label label-danger"><b><?= $userInfo['level']; ?></b></span>		 	 
								  	<?php if($userInfo['level']  == $siteInfo['maxLvl']){ echo '<span class="badge badge-warning">MÁX</span>'; } ?>
								  </li>

								  <li class="list-group-item">
									<?php 
										if($userInfo['reputation']  >= 0 and $userInfo['reputation']  < 10000){ 
											echo '<img src="'.base_url('/assets/img/iconos/medal.png').'"> Bronce';
										}elseif($userInfo['reputation']  > 10000 and $userInfo['reputation']  < 20000){ 
											echo '<img src="'.base_url('/assets/img/iconos/medal_silver_1.png').'"> Plata'; 
										}elseif($userInfo['reputation']  > 20000){
											echo '<img src="'.base_url('/assets/img/iconos/medal_gold_1.png').'"> Oro'; 
										}

										echo ' - <b>'.$userInfo['reputation'] .'</b>';
									?> 
								  </li>

								  <li class="list-group-item">
									<img src="<?= base_url('/assets/img/iconos/coins.png'); ?>"> <?= $siteInfo['moneyName']; ?>: <b><?= $userInfo['gold']; ?></b>
								  </li>


									<?php if($userInfo['level']  == $siteInfo['maxLvl']){ ?>

								    <li class="list-group-item">
										<img src="<?= base_url('/assets/img/iconos/exp.png'); ?>"> Exp: <b><span class="text-success">MAX</span></b><br/>

										<div class="progress">
										  <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" aria-valuenow="<?= round(($userInfo['exp']  / $userInfo['maxExp'] ) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="MAX" style="width:100%; max-width:100%;">
										  	<b>MAX</b>
										  </div>
										</div>
									</li>								

									<?php }else{ ?>

								    <li class="list-group-item">
										<img src="<?= base_url('/assets/img/iconos/exp.png'); ?>"> Exp: <b><span class="text-success"><?= $userInfo['exp']; ?></span></b>/<b> <span class="text-success"><?= $userInfo['maxExp']; ?></span></b><br/>

										<div class="progress">
										  <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width: <?= round(($userInfo['exp'] / $userInfo['maxExp']) * 100); ?>%" aria-valuenow="<?= round(($userInfo['exp'] / $userInfo['maxExp']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $userInfo['exp']; ?>/<?= $userInfo['maxExp']; ?> Exp" style="width:<?= round(($userInfo['exp'] / $userInfo['maxExp']) * 100); ?>%; max-width:100%;">
										  	<b><?= round(($userInfo['exp'] / $userInfo['maxExp']) * 100); ?>%</b>
										  </div>
										</div>
 								    </li>

									<?php } ?>
	 
								 
							    <li class="list-group-item">
							    	
								    <img src="<?= base_url('/assets/img/iconos/heart.png'); ?>"> Salud: <b><span class="text-danger"><?= $userInfo['health']; ?></span></b>/<b><span class="text-danger"><?= $userInfo['maxHealth']; ?></span></b> HP

									<div class="progress" style="height:28px;">
									  <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>%" aria-valuenow="<?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $userInfo['health']; ?>/<?= $userInfo['maxHealth']; ?> HP" style="width:<?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>%; max-width:100%;">
									  	<b><?= $userInfo['health']; ?>/<?= $userInfo['maxHealth']; ?> HP</b>
									  </div>
									</div>

							    </li>
							    <li class="list-group-item">
							    	
								    <img src="<?= base_url('/assets/img/iconos/energia.png'); ?>"> Energía: <b><span class="text-info"><?= $userInfo['energy']; ?></span></b>/<b><span class="text-info"><?= $userInfo['maxEnergy']; ?></span></b>

									<div class="progress" style="height:28px;">
									  <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: <?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>%" aria-valuenow="<?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $userInfo['energy']; ?>/<?= $userInfo['maxEnergy']; ?> de energía" style="width:<?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>%; max-width:100%;">
									  	<b><?= $userInfo['energy']; ?>/<?= $userInfo['maxEnergy']; ?></b>
									  </div>
									</div>

							    </li>
							    <li class="list-group-item"><img src="<?= base_url('/assets/img/iconos/attack.png'); ?>"> Fuerza: <span class="label label-default"><b><?= $userInfo['attack']; ?></b></span></li>

							  </ul>
							</div>
						</div>
						<br/>

				   		<?php }else{ ?>


				<!-- ========================================================================= -->
				<!-- Login -->
				<!-- ========================================================================= -->
					<?php if($pag == 'Login' or $pag == 'Registro' or $pag == 'Comprobando credenciales'){ 
							echo '';
						}else{
					?>
						<div class="card">
						  <div class="card-header text-center"><i class="bi bi-box-arrow-in-right"></i> ¡Conéctate!</div>
						  <div class="card-body">
						  	
			               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
			                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
			               <?php endif ?>

			               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
			                   <div class="alert alert-success"><?= session()->getFlashdata('sucess'); ?></div>
			               <?php endif ?>

							 <form method="post" action="<?= base_url('/auth/check'); ?>" class="form-horizontal">
							 	<?php $validation = \Config\Services::validation(); ?>
								<?= csrf_field(); ?>

								<div class="form-floating mb-3">
								  <input type="text" class="form-control" name="username" value="<?= set_value('username') ?>" id="floatingInput" placeholder="Usuario">
								  <label for="floatingInput">Usuario</label>
								</div>
								<span class="text-danger"><?= $validation->getError('username'); ?></span>
								
								<div class="form-floating mb-3">
								  <input type="password" class="form-control" name="password" value="<?= set_value('password') ?>" id="floatingInput" placeholder="Contraseña">
								  <label for="floatingInput">Contraseña</label>
								</div>
								<span class="text-danger"><?= $validation->getError('password'); ?></span>

								<hr/>
								<input type="submit" class="btn btn-primary btn-block" value="Conectar" style="width:100%;" >
							</form>

							<br/>
							<a href="<?= base_url('/register'); ?>">¡Registrate!</a><br/>
							<a href="<?= base_url('/forgot_password'); ?>">¿Contraseña perdida?</a>

						  </div>
						</div>
						<br/>
						<?php } ?>

						<?php } ?>

				<!-- ========================================================================= -->
				<!-- Stats -->
				<!-- ========================================================================= -->

				<div class="card d-none d-sm-block">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/chart_bar.png'); ?>"> Estadísticas</div>
				  <div class="card-body">
					<ul class="list-group list-group-flush">
					  <li class="list-group-item">
						<center>Último usuario
						<hr/>
						<b>

						<?php if($ultUser == TRUE){ ?>

						<a href="<?= base_url('/profile/'.$ultUser['user']); ?>"><?= $ultUser['user']; ?></a>

						<?php }else{ ?>

						<span class="text-secondary">No hay usuarios.</span>

						<?php } ?>

						</b>

						</center>
					  </li>
					  <li class="list-group-item d-flex justify-content-between align-items-center">
					    Usuarios registrados:
					    <span class="badge rounded-pill bg-primary"><?= $countUsers; ?></span>
					  </li>
					  <li class="list-group-item">
					    Mantenimiento:
					    
					    <?php if($siteInfo['maintenance'] == 0){ ?>

					    	<span class="badge bg-danger">No</span>

					   	<?php }elseif($siteInfo['maintenance'] == 1){ ?>

					    	<span class="badge bg-success">Sí</span>

					    <?php } ?>
					    
					  </li>
					</ul>
				  </div>
				</div>


				<!-- ========================================================================= -->
				<!-- Social -->
				<!-- ========================================================================= -->

				<?php if($siteInfo['userTwitter']){ ?>

				<br/>
				<div class="card d-none d-sm-block d-xs-block">
				  <div class="card-header">Tweets del sitio</div>
				  <div class="card-body">
				    <a class="twitter-timeline" href="https://twitter.com/<?= $siteInfo['userTwitter']; ?>" data-widget-id="461511161393840128">Tweets por <?= $siteInfo['userTwitter']; ?>.</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				  </div>
				</div>
				<br/>

				<?php } ?>
