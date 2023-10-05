<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/icon_security.gif'); ?>"> Administración - Gestor de Rangos</div>
				  <div class="card-body">

				  	<div class="row">
					  	<div class="col-md-6">

			               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
			                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
			               <?php endif ?>

			               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
			                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
			               <?php endif ?>

					  		<form method="post" action="<?= current_url(); ?>">
								<?php $validation = \Config\Services::validation(); ?>
								<?= csrf_field(); ?>

						        <label for="rango" class="control-label">Usuario</label>
						        <input type="text" name="user" class="form-control" id="rank" placeholder="Usuario">
								<span class="text-danger"><?= $validation->getError('user'); ?></span><br/>

						        <label for="select" class="control-label">Rango</label>
						        <select class="form-control" id="select" name="rankValue">
						          <option value="0">Sin rango</option>
						          <option value="1">Administrador</option>
						          <option value="2">Moderador</option>
						          <option value="3">Colaborador</option>
						        </select><br/>

						        <input type="submit" style="width:100%;" class="btn btn-primary" value="Actualizar rango" name="update_rank">
					  		</form>
					  	</div> <!-- End .col-md-6 -->

					  	<div class="col-md-6">

							<div class="accordion" style="margin-top:20px;">

							  <div class="card">

							    <div class="card-header" id="headingOne">

									<a class="card-link" data-bs-toggle="collapse" href="#admin">
									Administradores
									</a>

							    </div>


							    <div id="admin" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							      <div class="card-body">
									<ul class="list-group">
										<?php if(count($foreach_adm)){ ?>
										<?php foreach($foreach_adm as $row){ ?>
											<li class="list-group-item">
										  		<img style="position:relative; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <a style="position:relative; top:2px;" href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a>
										    </li>
										<?php } ?>
										<?php }else{ ?>
											<center><h4 class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario con este rango.</h4></center>
										<?php } ?>
									</ul>
							      </div>
							    </div>

							  </div> <!-- End card 1 -->

							  <div class="card">
							    <div class="card-header" role="tab" id="headingTwo">

									<a class="card-link" data-bs-toggle="collapse" href="#mod">
									Moderadores
									</a>

							    </div>

							    <div id="mod" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							      <div class="card-body">
									<ul class="list-group">
										<?php if(count($foreach_mod)){ ?>
										<?php foreach($foreach_mod as $row){ ?>
											<li class="list-group-item">
										  		<img style="position:relative; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <a style="position:relative; top:2px;" href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a>
										    </li>
										<?php } ?>
										<?php }else{ ?>
											<center><h4 class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario con este rango.</h4></center>
										<?php } ?>
									</ul>
							      </div>
							    </div>
							  </div> <!-- End card 2 -->

							  <div class="card">

							    <div class="card-header" role="tab" id="headingThree">

									<a class="card-link" data-bs-toggle="collapse" href="#col">
									Colaboradores
									</a>

							    </div>

							    <div id="col" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							      <div class="card-body">
									<ul class="list-group">
										<?php if(count($foreach_col)){ ?>
										<?php foreach($foreach_col as $row){ ?>
											<li class="list-group-item">
										  		<img style="position:relative; margin-right:10px;" width="30" height="30" class="media-object img-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <a style="position:relative; top:2px;" href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a>
										    </li>
										<?php } ?>
										<?php }else{ ?>
											<center><h4 class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario con este rango.</h4></center>
										<?php } ?>
									</ul>
							      </div>
							    </div>
							  </div>

							</div>
					   
					    </div> <!-- End .col-md-6 -->

					</div> <!-- End .row -->

				</div>			

			</div>
			
		</div>
			
		</div>
