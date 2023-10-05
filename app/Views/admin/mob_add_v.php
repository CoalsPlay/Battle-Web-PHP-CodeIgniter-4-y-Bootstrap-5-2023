<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/bomb.png'); ?>"> Administración - Agregar Mob</div>
				  <div class="card-body">

					<nav aria-label="breadcrumb" style="margin-bottom:30px;">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url('/admin/mobs_manager'); ?>">Gestor de enemigos</a></li>
						    <li class="breadcrumb-item active" aria-current="page">Agregar nuevo enemigo</li>
						</ol>
					</nav>

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.base_url('/admin/mobs_manager')); ?>
	               <?php endif ?>

				  	<form class="form-horizontal" action="<?= current_url(); ?>" method="post">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

				  		<label class="control-label" for="focusedInput">Nombre del enemigo</label>
				  		<input type="text" name="nameMob" class="form-control" id="inputEmail" placeholder="Nombre del enemigo">
						<span class="text-danger"><?= $validation->getError('nameMob'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Ataque del enemigo</label>
				  		<input type="number" name="atkMob" class="form-control" id="inputEmail" placeholder="Ataque del enemigo">
						<span class="text-danger"><?= $validation->getError('atkMob'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Salud máxima del enemigo</label>
				  		<input type="number" name="maxHealthMob" class="form-control" id="inputEmail" placeholder="Máxima salud del enemigo">
						<span class="text-danger"><?= $validation->getError('maxHealthMob'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Experiencia drop</label>
				  		<input type="number" name="expMob" class="form-control" id="inputEmail" placeholder="Experiencia que da el enemigo">
						<span class="text-danger"><?= $validation->getError('expMob'); ?></span><br/>

				  		<label class="control-label" for="focusedInput"><?= $siteInfo['moneyName']; ?> drop</label>
				  		<input type="number" name="goldMob" class="form-control" id="inputEmail" placeholder="<?= $siteInfo['moneyName']; ?> drop">
						<span class="text-danger"><?= $validation->getError('goldMob'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Reputación drop</label>
				  		<input type="number" name="reputationMob" class="form-control" id="inputEmail" placeholder="Reputación que da el enemigo">
						<span class="text-danger"><?= $validation->getError('reputationMob'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del enemigo</label>
				  		<textarea class="form-control" style="max-width:100%;" name="descriptMob" rows="2" id="textArea" placeholder="Descripción del enemigo"></textarea>
						<span class="text-danger"><?= $validation->getError('descriptMob'); ?></span><br/>
						
				  		<label class="control-label" for="focusedInput">Imagen del enemigo</label>
						<select class="form-control" name="imgMob">
							<option>Imagen</option>
						<?php 
							$dir = opendir("assets/img/mobs/"); 
							while($listar_d = readdir($dir)){ 
								if ($listar_d[0] != "." && $listar_d[0] != ".." ){ 
									echo "<option value=\"$listar_d\">$listar_d</option>"; 
								} 
							} 
							echo '</select>';
							closedir($dir);
						?>
						<span class="text-danger"><?= $validation->getError('imgMob'); ?></span><br/>

						<label for="select" class="control-label">Mapa</label>
						<select class="form-control" id="select" name="idMapMob" >
							<?php 
								if(count($getMaps)){
									foreach ($getMaps as $row2){ 
							?>

							<option value="<?= $row2['idMap']; ?>"><?= $row2['nameMap']; ?></option>

							<?php
									}
								}else{
									echo '<option disabled>No hay mapas para asignar.</option>';
								}
							?>
						</select>
						<span class="text-danger"><?= $validation->getError('idMapMob'); ?></span><br/>

						<hr>
						<input type="submit" name="addMob" class="btn btn-primary" value="Agregar enemigo">
				  	</form>
				  </div>
				</div>			

			</div>
			
		</div>
