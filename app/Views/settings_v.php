
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_config; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/cog.png'); ?>"> Opciones y Configuraciones</div>
				  <div class="card-body">
					<ul class="list-group">
					  <li class="list-group-item">
					    <span class="text-primary">Usuario:</span>&nbsp;&nbsp; <b><?= $userInfo['user']; ?></b>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Email:</span>&nbsp;&nbsp; <b><?= $userInfo['email']; ?></b>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Fecha de registro:</span>&nbsp;&nbsp; <b><?= $userInfo['registrationDate']; ?></b>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Rango:</span>&nbsp;&nbsp; 
							<?php 
								if($userInfo['rank'] == 1){
									echo '<span class="badge bg-danger">Administrador</span>'; 
								}elseif($userInfo['rank'] == 2){
									echo ' <span class="badge bg-success">Moderador</span>';
								}elseif($userInfo['rank'] == 3){
									echo ' <span class="badge bg-primary">Colaborador</span>';
								}elseif($userInfo['rank'] == 0){
									echo ' <span class="badge bg-secondary">Normal</span>';
								}
							?>
					  </li>
					  <li class="list-group-item">
					    <span class="text-primary">Estado de la cuenta:</span>&nbsp;&nbsp; <b><?php if($userInfo['accountStatus'] == 1){ echo '<span class="badge bg-success">OK</span>'; } ?></b>
					  </li>
					</ul>
				  </div>
				</div>
				
			</div>
			
		</div>
