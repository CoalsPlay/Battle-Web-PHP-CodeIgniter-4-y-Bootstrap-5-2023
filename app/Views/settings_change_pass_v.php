
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/textfield_key.png'); ?>"> Cambio de contraseña</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.base_url('/settings/change_password')); ?>
	               <?php endif ?>

					<form method="post" action="<?= base_url('/settings/change_password'); ?>" class="form-horizontal">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<h3 class="text-secondary">Cambio de contraseña</h3>
						<hr/>
						
						<label for="oldPass">Contraseña actual</label>
						<input type="password" class="form-control" name="oldPass" id="inputEmail" placeholder="Contraseña actual">
						<span class="text-danger"><?= $validation->getError('oldPass'); ?></span><br/>

						<label for="newPass">Nueva contraseña</label>
						<input type="password" class="form-control" name="newPass" id="inputEmail" placeholder="Contraseña nueva">
						<span class="text-danger"><?= $validation->getError('newPass'); ?></span><br/>

						<label for="repeatNewPass">Repetir nueva contraseña</label>
						<input type="password" class="form-control" name="cNewPass" id="inputEmail" placeholder="Repetir contraseña nueva">
						<span class="text-danger"><?= $validation->getError('cNewPass'); ?></span><br/>

						<input type="submit" name="changePass" class="btn btn-primary" value="Guardar cambios">
					</form>
				  </div>
				</div>
				

			</div>
			
		</div>
