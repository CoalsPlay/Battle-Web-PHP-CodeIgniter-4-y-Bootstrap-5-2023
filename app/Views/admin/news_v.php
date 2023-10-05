		<div class="row">
				<div class="col-md-3">

					<!-- Boxs Left -->
					<?= $box_left; ?>
					<!-- End Left -->
					
				</div>

				<div class="col-md-9">

					<div class="card">
					  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/page_white_edit.png'); ?>"> Administración - Gestor de noticias</div>
					  <div class="card-body">

					  	<div class="row">

					  	<div class="col-md-8">

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
								<input type="text" class="form-control" id="inputEmail" name="titleNews" placeholder="Título de la noticia">
								<span class="text-danger"><?= $validation->getError('titleNews'); ?></span><br/>
					
								<label class="control-label" for="focusedInput">Texto de la noticia</label>
								<textarea class="form-control" style="max-width:100%" name="textNews" rows="5" id="textArea" placeholder="Noticia"></textarea>
								<span class="text-danger"><?= $validation->getError('textNews'); ?></span><br/>

								<input type="submit" name="saveNews" class="btn btn-primary" value="Crear noticia" >
								
							</form>
							<br/>

						</div> <!-- End .col-md-8 -->

					  	<div class="col-md-4">

					  		<label class="control-label" for="focusedInput">Noticias creadas (<b><?= $numNews; ?></b>)</label>
							<div class="list-group">

								<?php if(count($getNews)){ ?>
								<?php foreach($getNews as $row){ ?>

								<a href="<?= base_url('/admin/news/edit/'.$row['idNews']); ?>" class="list-group-item">
									<?= substr($row['titleNews'], 0, 25); ?>
								</a>
								
								<?php } ?>

								<?php }else{ ?>

									<a class="list-group-item">
										<h5 class="text-secondary text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay noticias.</h5>
									</a>

								<?php } ?>
							</div>

							<hr/>
							<!-- Pagination -->
							<?= $pager->links('newsList'); ?>
							<!-- End Pagination -->

						</div> <!-- End .col-md-4 -->
					</div> <!-- End .row -->

				  </div>
				</div>
				

			</div>
			
		</div>