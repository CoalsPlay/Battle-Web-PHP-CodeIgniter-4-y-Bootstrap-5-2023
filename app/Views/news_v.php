<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">
				<?php foreach($getNews as $row){ ?>
				<div class="card">
					<div class="card-header text-center" style="word-wrap:break-word;"><i class="bi bi-newspaper"></i>&nbsp; Noticia de <?= $siteInfo['siteName']; ?> - <b><?= $row['titleNews']; ?></b></div>
					<div class="card-body">

					<div class="card" id="#">
						<div class="card-body text-secondary" style="word-wrap: break-word;">
						  <h3><?= $row['titleNews']; ?></h3>
						  <?= $row['textNews']; ?>
						  <hr>
						  <small><a href="<?= base_url('/profile/'.$row['user']); ?>"><img style="position:relative; margin-right:10px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <?= $row['user']; ?></a>&nbsp; el:&nbsp;<?= $row['dateNews']; ?> - Comentarios <span class="badge bg-primary"><?= $row['commentsNews']; ?></span>
							</span>
						   <?php if(isset($getSession['userSession'])){ ?>
						   		<?php if($userInfo['rank'] > 0){ ?>
									<small class="float-end"><a class="btn btn-primary btn-sm" href="<?= base_url('/admin/news/edit/'.$row['idNews']); ?>">Editar</a></small>
								<?php } ?>
						   <?php } ?>

						  <hr>

						    <?php if(isset($getSession['userSession'])){ ?>
						    	
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

								<textarea class="form-control" style="max-width:100%;" name="textComment" rows="2" id="textArea" placeholder="Comentario"></textarea>
								<span class="text-danger"><?= $validation->getError('textComment'); ?></span><br/>

								<input type="hidden" name="idNewsComment" value="<?= $row['idNews']; ?>">

								<hr>
								<input type="submit" name="sendComment" class="btn btn-primary" value="Comentar">
							</form>

						    <?php }else{ ?>
						    <h5 class="text-muted text-center">Debes estar conectado para poder comentar.<br/> <a href="<?= base_url('/login'); ?>">Conectarse</a> o <a href="<?= base_url('/register'); ?>">Registrarse</a></h5>
						    <?php } ?>
							<hr>

							<?php if(count($getComments)){
									foreach($getComments as $row){ 
							?>
							<div class="card">
							  <div class="card-body">
							    <?= $row['textComment']; ?>
							    <hr>
							    <a href="<?= base_url('/profile/'.$row['user']); ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <b><?= $row['user']; ?></b></a> - el: <?= $row['dateComment']; ?>
							   <?php if(isset($getSession['userSession'])){ ?>
							   		<?php if($userInfo['rank'] == 1 or $userInfo['rank'] == 2){ ?>
											<div class="btn-group float-end" role="group" aria-label="Basic example">
												<form method="post" class="btn-group" action="<?= current_url(); ?>">
													<input type="hidden" name="idComment" value="<?= $row['idComment'] ?>">
													<input type="submit" name="deleteComment" class="btn btn-sm btn-danger" value="Borrar">
												</form>
											</div>
									<?php } ?>
							   <?php } ?>

							  </div>
							</div>
							<br/>
							<?php } }else{ ?>
									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay comentarios en esta noticia. ¡Sé el primero en comentar!</h4>
									  </div>
									</div>
							<?php } ?>

							<hr/>
							<!-- Pagination -->
							<?= $pager->links('commentsList'); ?>
							<!-- End Pagination -->
						</div>
					</div>
					<?php } ?>
					</div>
				</div>
				
			</div>
			
		</div>
