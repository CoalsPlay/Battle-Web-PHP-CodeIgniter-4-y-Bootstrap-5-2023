<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/posts.gif'); ?>"> Registro </div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.base_url()); ?>
	               <?php endif ?>

					<form class="form-horizontal" method="post" action="<?= base_url('/auth/save'); ?>" autocomplete="off">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<input type="text" name="usernameR" value="<?= set_value('usernameR') ?>" class="form-control" placeholder="Usuario">
						<span class="text-danger"><?= $validation->getError('usernameR'); ?></span><br/>

						<input type="email" name="emailR" value="<?= set_value('emailR') ?>" class="form-control"  placeholder="Email">
						<span class="text-danger"><?= $validation->getError('emailR'); ?></span><br/>

						<input type="password" name="passwordR" value="<?= set_value('passwordR') ?>" class="form-control" placeholder="Contraseña">
						<span class="text-danger"><?= $validation->getError('passwordR'); ?></span><br/>

						<input type="password" name="password2" value="<?= set_value('password2') ?>" class="form-control" placeholder="Repetir contraseña">
						<span class="text-danger"><?= $validation->getError('password2'); ?></span><br/>

						<input type="hidden" name="ip" value="<?= $_SERVER['REMOTE_ADDR']; ?>">

						<input type="submit" class="btn btn-primary" value="Registrar">
					</form>
					<br/>
					<a href="<?= base_url('/login'); ?>">¿Ya estás registrado?¡conéctate!.</a>

				  </div>
				</div>
				
			</div>
			
		</div>
