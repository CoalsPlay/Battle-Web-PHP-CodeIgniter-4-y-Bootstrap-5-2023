
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">
				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/page_user.gif'); ?>"> Perfil de <?= $getUserData['user']; ?> <?php if($userInfo['rank'] == 1){ ?><small class="float-end"><a class="btn btn-primary btn-sm" href="<?= base_url('/admin/user/edit/'.$getUserData['id']); ?>">Editar</a></small><?php } ?></div>
				  <div class="card-body">
						<div class="row">

							<div class="col-md-3 text-break" style="margin-bottom:20px;">
								<ul class="list-group">
								  <li class="list-group-item"><h3 class="text-center"><?= $getUserData['user']; ?></h3></li>
								  <li class="list-group-item"><center><img class="img-fluid img-thumbnail" width="200" height="200" src="<?= base_url('/assets/img/avatars/'.$getUserData['avatar']); ?>" alt=""></center>

								  	<?php if(isset($buttonRequest)){ echo '<br/>'.$buttonRequest; } ?>
								  </li>
								  <li class="list-group-item">
									<span style="font-size:14pt;"><u>Sobre mi</u></span><br/>
									<span>
									<?php 
										if(!$getUserData['aboutMe']){

											echo '<span class="text-muted">No especificado.</span>';

										}else{

											echo htmlspecialchars($getUserData['aboutMe']);
											
										}
									?>
									</span>
								  </li>
								  <li class="list-group-item">
									<span style="font-size:14pt;"><u>Género</u></span><br/>
									<span>
									<?php 
										if($getUserData['gender'] == 0){

											echo '<span class="text-muted">No especificado.</span>';

										}elseif($getUserData['gender'] == 1){

											echo '<img src="'.base_url('/assets/img/iconos/male.png').'"> Hombre';

										}elseif($getUserData['gender'] == 2){

											echo '<img src="'.base_url('/assets/img/iconos/female.png').'"> Mujer';
										} 
									?>	
									</span>
								  </li>
								  <li class="list-group-item">
									 <span style="font-size:14pt;"><u>Redes sociales</u></span><br/>

									 <?php

									 if(!$getUserData['twitter'] && !$getUserData['facebook'] && !$getUserData['youtube']){

									 	echo '<span class="text-muted">No especificado.</span>';

									 }else{


									 	if($getUserData['twitter']){
									 		echo '<a href="https://twitter.com/'.$getUserData['twitter'].'" target="_blank"><img src="'.base_url('/assets/img/redsocial/tw.png').'"></a> ';
									 	}

									 	if($getUserData['facebook']){
									 		echo '<a href="https://facebook.com/'.$getUserData['facebook'].'" target="_blank"><img src="'.base_url('/assets/img/redsocial/fb.png').'"></a> ';
									 	}

									 	if($getUserData['youtube']){
									 		echo '<a href="https://youtube.com/user/'.$getUserData['youtube'].'" target="_blank"><img src="'.base_url('/assets/img/redsocial/yt.png').'"></a> ';
									 	}
									 }

									 ?>
								  </li>
								</ul>
								
							</div>
							<div class="col-md-9">
								<div class="card">
								  <div class="card-body">

								  	<!-- Button Action -->
								  	<?php if(isset($buttonAction)){ echo $buttonAction; } ?>

									<ul class="nav nav-tabs">
									  <li class="nav-item" role="presentation">
										<button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" aria-controls="info" aria-selected="true">Información</button>
									  </li>
									  <li class="nav-item">
									  	<button class="nav-link" id="friends-tab" data-bs-toggle="tab" data-bs-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false">Amigos (<b><?= count($getFriends); ?></b>)</button>
									  </li>
									  <li class="nav-item">
									  	<button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="false">Estadísticas</button>
									</ul>

									<div id="myTabContent" class="tab-content">

									  <!-- INFO PANEL -->
									  <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
									  		<br/>
											<ul class="list-group">
											  <li class="list-group-item">
												<img src="<?= base_url('/assets/img/iconos/user_red.png'); ?>"> Rango:&nbsp;
												<?php
													if($getUserData['rank'] == 0){
														echo '<span class="badge badge-secondary">Sin rango</span>';
													}elseif($getUserData['rank'] == 1){
														echo '<span class="badge badge-danger">Administrador</span>';
													}elseif($getUserData['rank'] == 2){
														echo '<span class="badge badge-success">Moderador</span>';
													}elseif($getUserData['rank'] == 3){
														echo '<span class="badge badge-primary">Colaborador</span>';
													} 
												?>
											  </li>
											  <li class="list-group-item">
											   <img src="<?= base_url('/assets/img/iconos/rosette.png'); ?>"> Nivel <b><?= $getUserData['level']; ?></b>
											  </li>
											  <li class="list-group-item">
											    <img src="<?= base_url('/assets/img/iconos/coins.png'); ?>"> <?= $siteInfo['moneyName']; ?>: <b><?= $getUserData['gold']; ?></b>
											  </li>	  
											  <li class="list-group-item">
											    <img src="<?= base_url('/assets/img/iconos/exp.png'); ?>"> Experiencia: <b><?= $getUserData['exp']; ?></b>
											  </li>
											  <li class="list-group-item">
											    <img src="<?= base_url('/assets/img/iconos/attack.png'); ?>"> Ataque: <b><?= $getUserData['attack']; ?></b>
											  </li>
											</ul>
									  </div>

									  <!-- FRIENDS LIST PANEL -->
									  <div class="tab-pane fade" id="friends" role="tabpanel" aria-labelledby="friends-tab">
									  	<br/>
									  	<ul class="list-group">
									  		<?php if(count($getFriends)){ ?>
									  		<?php foreach($getFriends as $row2){ ?>
											  <li class="list-group-item">
											  	<a href="<?= base_url('/profile/'.$row2['user']); ?>">
											  	<img style="margin-right:10px;" width="30" height="30" class="media-object img-thumbnail pull-left" src="<?= base_url('/assets/img/avatars/'.$row2['avatar']); ?>" alt="...">
												<?= $row2['user']; ?></a>
											  </li>
											<?php } ?>
											<?php }else{ ?>
												<li class="list-group-item text-center">
													<h5>
														<span class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> Este usuario no tiene amigos actualmente.</span>
													</h5>
												</li>
											<?php } ?>
										</ul>

									  </div>

									  <!-- STATS PANEL -->
									  <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab">
									  	<br/>
										<ul class="list-group">
										  <li class="list-group-item">
										    <img src="<?= base_url('/assets/img/iconos/objetive.png'); ?>"> Mobs o usuarios asesinados: <b><?= $getUserData['kills']; ?></b>
										  </li>
										  <li class="list-group-item">
										    <img src="<?= base_url('assets/img/iconos/muerte.png'); ?>"> Veces muerto: <b><?= $getUserData['deaths']; ?></b>
										  </li>
										</ul>
									  </div>
									</div>

								  </div>
								</div>
							</div>
						</div>

				  </div>
				</div>
				
			</div>
			
		</div>
