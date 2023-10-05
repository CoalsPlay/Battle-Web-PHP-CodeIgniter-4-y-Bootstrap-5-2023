<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">

					<div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/book_open.png'); ?>"> Administración - Centro FAQ - Agregar pregunta y respuesta.</div>

					<div class="card-body">

						<?php foreach($getFaq as $row){ ?>
							
						<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
						  <ol class="breadcrumb">
						    <li class="breadcrumb-item"><a href="<?= base_url('/admin/faq_center'); ?>">Centro FAQ</a></li>
						    <li class="breadcrumb-item active" aria-current="page"><?= $row['titleFaq']; ?></li>
						  </ol>
						</nav>
						<hr/>

		               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
		                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
		               <?php endif ?>

		               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
		                   <?php header('Refresh:1; url= '.current_url()); ?>
		               <?php endif ?>

						<form method="post" action="<?= current_url(); ?>" class="form-horizontal">
							<?php $validation = \Config\Services::validation(); ?>
							<?= csrf_field(); ?>

					  		<label class="control-label" for="focusedInput">Pregunta</label>
							<input type="text" class="form-control" id="inputEmail" name="titleFaq" placeholder="Pregunta" value="<?= $row['titleFaq']; ?>">
							<span class="text-danger"><?= $validation->getError('titleFaq'); ?></span><br/>
								
							<label class="control-label" for="focusedInput">Respuesta</label>
							<textarea class="form-control" style="max-width:100%" name="descriptFaq" rows="5" id="textArea" placeholder="Respuesta"><?= $row['descriptFaq']; ?></textarea>
							<span class="text-danger"><?= $validation->getError('descriptFaq'); ?></span><br/>

							<input type="hidden" name="idFaq" value="<?= $row['idFaq']; ?>">

							<hr>
							<input type="submit" name="editFaq" class="btn btn-primary" value="Guardar cambios" >
						</form>

						<?php } ?>

					</div>

				</div>
				
			</div>
			
		</div>
