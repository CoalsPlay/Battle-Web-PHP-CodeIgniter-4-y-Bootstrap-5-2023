<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/posts.gif'); ?>"> Login </div>
				  <div class="card-body">
		               <?php if(!empty( session()->getFlashdata('fail'))) : ?>
		                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
		               <?php endif ?>

		               <?php if(!empty( session()->getFlashdata('success'))) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
		               <?php endif ?>

					  	<form method="post" action="<?= base_url('/auth/check'); ?>" class="form-horizontal">
					  		<?php $validation = \Config\Services::validation(); ?>
							<?= csrf_field(); ?>

							<input type="text" name="username" class="form-control" value="<?= set_value('username') ?>" placeholder="Usuario">
							<span class="text-danger"><?= $validation->getError('username'); ?></span><br/>

							<input type="password" name="password" class="form-control" placeholder="Contraseña">
							<span class="text-danger"><?= $validation->getError('password'); ?></span><br/>
							
							<a href="<?= base_url('/forgot_password'); ?>">¿Contraseña perdida?</a><br/><br/>
							<input type="submit" class="btn btn-primary" value="Conectar">
						</form>

				  </div>
				</div>
				
			</div>
			
		</div>
