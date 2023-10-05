<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/cart_edit.png'); ?>"> Administración - Configuración</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.current_url()); ?>
	               <?php endif ?>

				  	<form class="form-horizontal" action="<?= current_url(); ?>" method="post">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<h3 class="text-muted">Información del sitio</h3>
						<hr/>

				  		<label class="control-label" for="focusedInput">Nombre del sitio</label>
				  		<input type="text" name="siteName" value="<?= $siteInfo['siteName']; ?>" class="form-control" id="inputEmail" placeholder="Nombre del sitio">
						<span class="text-danger"><?= $validation->getError('siteName'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del sitio</label>
						<textarea class="form-control" style="max-width:100%;" name="siteDescript" rows="3" id="textArea" placeholder="Descripción del sitio..."><?= $siteInfo['siteDescript']; ?></textarea>
						<span class="text-danger"><?= $validation->getError('siteDescript'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Url del sitio</label>
				  		<input type="text" name="siteUrl" value="<?= base_url(); ?>" class="form-control" id="inputEmail" disabled placeholder="Url del sitio">La URL debe modificarse en el archivo <b class="text-muted">app/Config/App.php</b> en la línea 25.
						<span class="text-danger"><?= $validation->getError('siteUrl'); ?></span><br/>

						<h3 style="margin-top:50px;" class="text-muted">Widget de Twitter</h3>
						<hr/>

				  		<label class="control-label" for="focusedInput">Twitter del sitio</label>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text" id="basic-addon1">@</span>
							</div>
						<input type="text" class="form-control" value="<?= $siteInfo['userTwitter']; ?>"  placeholder="Usuario de Twitter" name="userTwitter" aria-label="Username" aria-describedby="basic-addon1">
				   		</div><span class="text-danger"><?= $validation->getError('userTwitter'); ?></span><br/>

						<h3 style="margin-top:20px;" class="text-muted">Mantenimiento</h3>
						<hr/>
				        
				        <label class="control-label" for="maintenance">Modo mantenimiento</label>
						<select  class="form-control" name="maintenance">
						  <option <?php if($siteInfo['maintenance'] == 1){ echo 'selected'; } ?> value="1">Si</option>
						  <option <?php if($siteInfo['maintenance'] == 0){ echo 'selected'; } ?> value="0">No</option>
						</select>

						<span class="text-danger"><?= $validation->getError('maintenance'); ?></span><br/>


				  		<label class="control-label" for="focusedInput">Título del mantenimiento</label>
				  		<input type="text" name="titleMaintenance" value="<?= $siteInfo['titleMaintenance']; ?>" class="form-control" id="inputEmail" placeholder="Título del mantenimiento">
						<span class="text-danger"><?= $validation->getError('titleMaintenance'); ?></span><br/>
						

				  		<label class="control-label" for="focusedInput">Descripción del mantenimiento</label>
						<textarea class="form-control" style="max-width:100%;" name="descriptMaintenance" rows="3" id="textArea" placeholder="Descripción del mantenimiento..."><?= $siteInfo['descriptMaintenance']; ?></textarea>
						<span class="text-danger"><?= $validation->getError('descriptMaintenance'); ?></span><br/>

						<h3 style="margin-top:20px;" class="text-muted">Ajustes del correo electrónico</h3>
						<hr/>

				  		<label class="control-label" for="focusedInput">Nombre abreviado del sitio</label>
				  		<input type="text" name="emailName" value="<?= $siteInfo['emailName']; ?>" class="form-control" id="inputEmail" placeholder="Nombre abreviado del sitio">
						<span class="text-danger"><?= $validation->getError('emailName'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Correo electrónico del sitio</label>
				  		<input type="email" name="siteEmail" value="<?= $siteInfo['siteEmail']; ?>" class="form-control" id="inputEmail" placeholder="Correo del sitio">
						<span class="text-danger"><?= $validation->getError('descriptMaintenance'); ?></span><br/>
				        
						<hr>
						<input type="submit" name="saveConfiguration" class="btn btn-primary" value="Guardar cambios">
				  	</form>
				  </div>
				</div>
					
			</div>
			
		</div>
