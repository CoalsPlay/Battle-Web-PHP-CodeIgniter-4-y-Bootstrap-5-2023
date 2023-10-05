		<div class="row">
			
			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>

			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/page_white_edit.png'); ?>"> Administración - Edición de noticias</div>
				  <div class="card-body">
				  	<div class="col-md-12">

				  		<?php foreach($getNews as $row){ ?>

						<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
						  <ol class="breadcrumb">
						    <li class="breadcrumb-item"><a href="<?= base_url('/admin/news_manager'); ?>">Noticias</a></li>
						    <li class="breadcrumb-item active" aria-current="page"><?= $row['titleNews']; ?></li>
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

							<label class="control-label" for="focusedInput">Título de la noticia</label>
							<input type="text" class="form-control" id="inputEmail" name="titleNews" value="<?= $row['titleNews']; ?>">
							<span class="text-danger"><?= $validation->getError('titleNews'); ?></span><br/>
							
							<label class="control-label" for="focusedInput">Texto de la noticia</label>
							<textarea class="form-control" style="max-width:100%" name="textNews" rows="13" id="textArea"><?= $row['textNews']; ?></textarea>
							<span class="text-danger"><?= $validation->getError('textNews'); ?></span><br/>
							
							<label class="control-label" for="focusedInput">Autor de la noticia</label>
							<input type="text" class="form-control" id="inputEmail" disabled name="authorNews" value="<?= $row['user']; ?>"><br/>

							<input type="hidden" value="<?= $row['idNews']; ?>" name="idNews">

							<hr>
							<input type="submit" name="editNews" class="btn btn-primary" value="Guardar cambios">
							<a href="#" data-bs-toggle="modal" data-bs-target="#deleteNews" class="btn btn-danger">Borrar noticia</a>

							<!-- Modal -->
							<div class="modal fade" id="deleteNews" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteNewsLabel" aria-hidden="true">
							  <div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="deleteNewsLabel">¿Estás seguro de eliminar esta noticia?</h5>
							        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							      </div>
							      <div class="modal-footer">
							        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Cancelar</button>
							        <input type="submit" data-bs-toggle="modal" data-bs-target="#deleteNews" name="deleteNews" class="btn btn-danger" value="Borrar noticia">
							      </div>
							    </div>
							  </div>
							</div>
							
						</form>
						
						<?php } ?>

					</div>
				  </div>
				</div>
				

			</div>
			
		</div>