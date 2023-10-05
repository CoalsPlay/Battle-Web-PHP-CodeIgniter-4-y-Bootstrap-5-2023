
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">
				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/add_sug.png'); ?>"> Enviar Sugerencia</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	               <?php endif ?>

					<form method="post" action="<?= current_url(); ?>" class="form-horizontal">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<textarea class="form-control" style="max-width:100%;" name="textSuggestion" rows="3" id="textArea" placeholder="Explicación de la sugerencia"></textarea>
						<span class="text-danger"><?= $validation->getError('textSuggestion'); ?></span><br/>
						<span class="help-block">Se agradece que este sistema se use con el fin con el que ha sido implementado. ¡Gracias por su interés!</span><br/>

						<hr>
						<input type="submit" name="sendSugg" class="btn btn-primary" value="Enviar Sugerencia">
					</form>
				  </div>
				</div>
				
			</div>
			
		</div>
