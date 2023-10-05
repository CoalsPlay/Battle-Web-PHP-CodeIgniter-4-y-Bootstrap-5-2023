
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/report_user.png'); ?>"> Peticiones de amistad 
				  	(<b><?= count($getRequests); ?></b>)</div>
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
					  	
						  	<span>Capacidad de amigos agregados <b><?= $numFriends.'/'.$siteInfo['maxFriends']; ?></b>

							<div class="progress">
							  <div class="progress-bar" role="progressbar" style="width: <?= round(($numFriends / $siteInfo['maxFriends']) * 100); ?>%;" aria-valuenow="<?= round(($numFriends / $siteInfo['maxFriends']) * 100); ?>" aria-valuemin="0" aria-valuemax="100"></div>
							</div>

							<hr/>

							<ul class="list-group">
								<?php if(count($getRequests)){ ?>
								<?php foreach($getRequests as $row){ ?>

								<li class="list-group-item">
								    <a href="<?= base_url('/profile/'.$row['user']); ?>">
									    <img class="media-object img-circle" width="35" height="35" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="...">
									</a>

									<span class="text-muted" style="position:relative; margin-left:15px;">¡<a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a> quiere ser tu amigo!</span>

									<div class="btn-group float-end" style="position:relative; top:2px;" role="group" aria-label="requests">
										<form method="post" action="<?= base_url('/friends'); ?>">
									      	<input type="hidden" name="idAuthorRequest" value="<?= $row['idAuthorRequest']; ?>" />

											<input type="submit" name="acceptRequest" value="Aceptar" class="btn btn-success btn-sm">
											<input type="submit" name="deleteRequest" value="Rechazar" class="btn btn-danger btn-sm">
										</form>
									</div>
								</li>

								<?php } ?>
								<?php }else{ ?>
									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No tienes ninguna petición de amistad pendiente</h4>
									  </div>
									</div>
								<?php } ?>
							</ul>

					  </div> <!-- End .col-md-8 -->
					  
					  <div class="col-md-4">
					  	<ul class="list-group">
						  <li class="list-group-item">
						    Amigos agregados: <b><?= $numFriends; ?></b>
						  </li>
						  	<?php if(count($getFriends)){ ?>
						  	<?php foreach($getFriends as $row){ ?>
							  <li class="list-group-item">

							  <form method="post" action="<?= current_url(); ?>">
							  	<input type="hidden" name="idFriend2" value="<?= $row['idFriend2']; ?>">
							  	<a href="#" data-bs-toggle="modal" data-bs-target="#deleteFriend" class="btn btn-danger btn-sm float-end">Borrar</a>

								<!-- Modal -->
								<div class="modal fade" id="deleteFriend" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteFriendLabel" aria-hidden="true">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="deleteFriendLabel">¿Estás seguro de eliminar a <?= $row['user']; ?>?</h5>
								        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-footer">
								        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Cancelar</button>
								        <input type="submit" data-bs-toggle="modal" data-bs-target="#deleteFriend" name="deleteFriend" class="btn btn-danger" value="Borrar amigo">
								      </div>
								    </div>
								  </div>
								</div>

							  </form>
							    
							    <a href="<?= base_url('/profile/'.$row['user']); ?>">
								<img style="position:relative; margin-top:-2px; margin-right:5px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="...">
								<span style="position:relative; margin-left:10px";><?= $row['user']; ?></span></a>
							  </li>
							<?php } ?>
							<?php }else{ ?>
								<li class="list-group-item text-center">
									<h5 class="text-muted">No tienes amigos</h5>
								</li>
							<?php } ?>
						</ul>

						<hr/>
						<!-- Pagination -->
						<?= $pager->links('friendsList'); ?>
						<!-- End Pagination -->
						
					</div> <!-- End .col-md-4 -->
				</div><!-- End .row -->

				</div>

				</div>
				
			</div>
			
		</div>
