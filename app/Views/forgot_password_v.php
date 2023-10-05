
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/lock_break.png'); ?>"> Recuperar contraseña</div>
				  <div class="card-body">
				  		<span class="text-secondary">
				  			Introduce el email asociado a tu cuenta para que podamos enviarte un correo con los pasos a seguir para restaurar la contraseña.
				  		</span>
				  		<br/><br/>

		               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('fail'); ?></div>
		               <?php endif ?>

		               <?php if( !empty( session()->getFlashdata('successPw') ) ) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('successPw'); ?></div>
		               <?php endif ?>

						<form method="post" action="<?= current_url(); ?>" class="form-horizontal">
							<?php $validation = \Config\Services::validation(); ?>
							<?= csrf_field(); ?>
							
							<input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control" id="inputEmail" placeholder="Email">
							<span class="text-danger"><?= $validation->getError('email'); ?></span><br/>

							<input type="submit" name="sendEmail" class="btn btn-primary" value="Aceptar">

						</form>
				  </div>
				</div>
				
			</div>
			
		</div>
