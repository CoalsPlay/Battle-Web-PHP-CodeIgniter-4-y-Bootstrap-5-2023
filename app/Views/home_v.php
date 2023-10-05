<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><i class="bi bi-newspaper"></i>&nbsp; Noticias de <?= $siteInfo['siteName']; ?></div>
				  <div class="card-body">
				  	<?php 
				  		if(count($getNews)){
				  			foreach($getNews as $row){ ?> 
		
					<div class="card" id="<?= $row['idNews']; ?>">
						<div class="card-body text-break">
						  <a href="<?= base_url('/news/'.$row['idNews']); ?>"><h3><?= $row['titleNews']; ?></h3></a>
						  <?= substr($row['textNews'], 0, 300); ?>
						  <?php
						  	if(strlen($row['textNews']) >= 300){ 
						  		echo '... <a href="'.base_url('/news/'.$row['idNews']).'"> Leer más</a>'; 
						  	} ?></a>
						</div>
						<div class="card-footer">
						  <a href="<?= base_url('/profile/'.$row['user']); ?>"><img style="margin-right:10px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <?= $row['user']; ?></a>&nbsp; el:&nbsp; <?= $row['dateNews']; ?>
						   <a href="<?= base_url('/news/'.$row['idNews']); ?>">
						   	<button type="button" class="btn btn-primary btn-sm" style="margin-left:20px;">
							  Comentarios <span class="badge bg-secondary"><?= $row['commentsNews']; ?></span>
							</button>
						   </a> 

						   <?php if(isset($getSession['userSession'])){ ?>

						   		<?php if($userInfo['rank'] > 0){ ?>
									<a class="btn btn-primary btn-sm" href="<?= base_url('/admin/news/edit/'.$row['idNews']); ?>">Editar</a>
								<?php } ?>

						   <?php } ?>

						</div> <!-- End .card-footer -->
					</div>
					<br/>
					<?php } }else{ ?>
						<div class="alert alert-info d-flex align-items-center" role="alert">
								<div>
									 <h3 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ninguna noticia</h3>
								</div>
						</div>
					<?php } ?>

					<hr/>
					<!-- Pagination -->
					<?= $pager->links('newsList'); ?>
					<!-- End Pagination -->

				  </div>
				</div>
				
				<!-- Changelog -->
				<?= $box_changelog; ?>
				<!-- End Changelog -->
				
			</div>
			
		</div>
