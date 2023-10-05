<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/posts.gif'); ?>"> Administración - Inicio</div>
				  <div class="card-body">

				  	<div class="row">
					  	<div class="col-md-4">

							<div class="card">
							  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/chart_bar.png'); ?>"> Usuarios</div>
							  <div class="card-body">

								<ul class="list-group list-group-flush">
								  <li class="list-group-item">
									<center>Último usuario
									<hr/>
									<b><a href="<?= base_url('/profile/'.$ultUser['user']); ?>"><?= $ultUser['user']; ?></a></b></center>
								  </li>
								  <li class="list-group-item d-flex justify-content-between align-items-center">
					    			Usuarios registrados:
					    			<span class="badge bg-primary badge-pill"><?= $countUsers; ?></span>
					  			  </li>

								</ul>

							  </div>
							</div>  		
						</div> <!-- End .col-md-4 -->

						<div class="col-md-4">
							<div class="card">
							  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/chart_bar.png'); ?>"> Noticias</div>
							  <div class="card-body">

								<ul class="list-group">
								  <li class="list-group-item d-flex justify-content-between align-items-center">
								  	Noticias

								    <span class="badge bg-primary badge-pill">
								    <?= $numNews; ?>
								    </span>
								  </li>

								  <li class="list-group-item d-flex justify-content-between align-items-center">
								  	Comentarios
								    <span class="badge bg-primary badge-pill">
								    <?= $numComments; ?>
								    </span>
								  </li>
								</ul>

							  </div>
							</div>  		
						</div> <!-- End .col-md-4 -->

						<div class="col-md-4">

							<div class="card">
							  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/bomb.png'); ?>"> Mobs</div>
							  <div class="card-body">

								<ul class="list-group">
								  <li class="list-group-item d-flex justify-content-between align-items-center">
								  	Nº de Mobs

								    <span class="badge bg-primary badge-pill">
								    <?= $numMobs; ?>
								    </span>
								  </li>

								</ul>

							  </div>
							</div>  		
						</div> <!-- End .col-md-4 -->
					</div>

				  </div>
				</div>

				<!-- Changelog -->
				<?= $box_changelog; ?>
				<!-- End Changelog -->
				
			</div>
			
		</div>
