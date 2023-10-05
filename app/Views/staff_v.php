<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/icon_security.gif'); ?>"> Staff de <?= $siteInfo['siteName']; ?></div>
				  <div class="card-body">
				  	<div class="row">
				  	<div class="col-md-4">
						<div class="card">
						  <div class="card-header bg-danger text-white">Administradores</div>
						  <div class="card-body">
							<ul class="list-group list-group-flush">
								<?php if(count($foreach_adm) > 0){ ?>
								<?php foreach($foreach_adm as $row){ ?>
									<li class="list-group-item">
									  	<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a>
									    </li>
								<?php } ?>
								<?php }else{ ?>
									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario con este rango.</h4>
									  </div>
									</div>

								<?php } ?>
							</ul>
						  </div>
						</div>
				  	</div>

				  	<div class="col-md-4">
						<div class="card">
						  <div class="card-header bg-success text-white">Moderadores</div>
						  <div class="card-body">
							<ul class="list-group list-group-flush">
								<?php if(count($foreach_mod)){ ?>
								<?php foreach($foreach_mod as $row){ ?>
									<li class="list-group-item">
									  	<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user'] ?></a>
									    </li>
								<?php } ?>
								<?php }else{ ?>
									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario con este rango.</h4>
									  </div>
									</div>
								<?php } ?>
							</ul>
						  </div>
						</div>
				  	</div>

				  	<div class="col-md-4">
						<div class="card">
						  <div class="card-header bg-primary text-white">Colaboradores</div>
						  <div class="card-body">
							<ul class="list-group list-group-flush">
								<?php if(count($foreach_col)){ ?>
								<?php foreach($foreach_col as $row){ ?>
									<li class="list-group-item">
									  	<img style="position:relative; top:-5px; margin-right:10px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a>
									    </li>
								<?php } ?>
								<?php }else{ ?>
									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario con este rango.</h4>
									  </div>
									</div>
								<?php } ?>
							</ul>
						  </div>
						</div>
				  	</div>
				  </div>
				  </div>
				</div>
				
			</div>
			
		</div>
