
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/lock_break.png'); ?>"> Cambiar contraseña</div>
				  <div class="card-body">
				  		<span class="text-secondary">
				  			Por motivos de seguridad debe escribir el email y el nombre de usuario asociado a la cuenta a recuperar, acto seguido podrá introducir una nueva contraseña con la que acceder a su cuenta.
				  		</span>
				  		<br/><br/>

		               <?php if(!empty(session()->getFlashdata('successR'))) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('successR'); ?></div>
		                   <?php header('Refresh:2; url='.base_url('/login')) ?>
		               <?php endif ?>

		               <?php if(!empty(session()->getFlashdata('failR'))) : ?>
		                   <div class="alert alert-danger"><?= session()->getFlashdata('failR'); ?></div>
		               <?php endif ?>

						<form method="post" action="<?= base_url('/auth/password_update/'.$token); ?>" class="form-horizontal">
							<?php $validation = \Config\Services::validation(); ?>
							<?= csrf_field(); ?>

							<input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control" id="inputEmail" placeholder="Email">
							<span class="text-danger"><?= $validation->getError('email'); ?></span><br/>

							<input type="text" name="usernameR" value="<?= set_value('usernameR'); ?>" class="form-control" id="inputEmail" placeholder="Nombre de usuario">
							<span class="text-danger"><?= $validation->getError('usernameR'); ?></span><br/>

							<input type="password" name="passwordR" value="<?= set_value('passwordR'); ?>" class="form-control" id="inputEmail" placeholder="Nueva contraseña">
							<span class="text-danger"><?= $validation->getError('passwordR'); ?></span><br/>

							<input type="password" name="cpassword" value="<?= set_value('cpassword'); ?>" class="form-control" id="inputEmail" placeholder="Confirmar nueva contraseña">
							<span class="text-danger"><?= $validation->getError('cpassword'); ?></span><br/>

							<input type="submit" name="confirmedUp"  class="btn btn-primary" value="Cambiar contraseña">

						</form>
				  </div>
				</div>
				
			</div>
			
		</div>
