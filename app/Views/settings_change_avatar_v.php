
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">


				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/cog.png'); ?>"> Opciones y Configuraciones</div>
				  <div class="card-body">

					<div class="row">
					<div class="col-md-3">

				  		<img width="200px" height="200px" class="img-thumbnail float-right" src="<?= base_url('/assets/img/avatars/'.$userInfo['avatar']); ?>">

				  	</div>

				  	<div class="col-md-9">

		               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
		                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
		               <?php endif ?>

		               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
		                   <?php header('Refresh:1; url= '.base_url('/settings/change_avatar')); ?>
		               <?php endif ?>

						<form method="post" action="<?= current_url(); ?>" class="form-horizontal" enctype="multipart/form-data">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<span class="text-danger"><?= $validation->getError('avatar'); ?></span><br/>
						
					    <div class="mb-3">
						  <label for="formFile" class="form-label">Solo compatible con formatos .jpg, .png y .gif.</label>
						  <input class="form-control" name="avatar" type="file" id="fileHelp">
						</div>

							<hr/>
							<input type="submit" name="uploadAvatar" class="btn btn-primary" value="Subir avatar">
						</form>

					</div>

					</div>


				  </div>
				</div>
				
			</div>
			
		</div>
