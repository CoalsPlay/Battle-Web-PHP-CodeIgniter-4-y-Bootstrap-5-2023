
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/bomb.png'); ?>"> Administración - Gestor de enemigos</div>
				  <div class="card-body">

					<a class="btn btn-success float-left" href="<?= base_url('/admin/mob/add'); ?>">
						+ Agregar enemigo
					</a>

					<br/>
					<hr/>

		               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
		                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
		               <?php endif ?>

		               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
		                   <?php header('Refresh:1; url= '.current_url()); ?>
		               <?php endif ?>

						<form action="<?= current_url(); ?>" method="get" id="searchForm" class="form-horizontal">

							<div class="input-group mb-3">
							  <input type="search" name="search" class="form-control" placeholder="Buscar enemigo..." aria-describedby="buttonSearch" value="<?= $search; ?>">
							  <input class="btn btn-success" type="submit" onclick='document.getElementById("searchForm").submit();' id="buttonSearch" value="Buscar">
							</div>

						</form>
						<hr/>

				  	<?php if(count($getMobs)){ ?>

					<div class="row">

				  	<?php foreach($getMobs as $row){ ?>

				  	<div class="col-md-3">

						<div class="card mb-3">
						  <div class="card-header text-center">
						    <b class="card-title"><?= $row['nameMob']; ?></b>
						  </div>

						  <center>
						  <img class="img-fluid" style="height:200px; width:200px; margin-top:10px; margin-bottom:10px;" src="<?= base_url('/assets/img/mobs/'.$row['imgMob']); ?>" title="<?= $row['nameMob']; ?>">
						  </center>
						  
						  <ul class="list-group list-group-flush">

						    <li class="list-group-item">
						      <center>
							  <div class="btn-group" role="group" aria-label="groupButtons">
								  <a type="button" href="<?= base_url('/admin/mob/edit/'.$row['idMob']); ?>"  class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
								  <button type="button" data-bs-target="#infMob_<?= $row['idMob']; ?>" aria-expanded="false" data-bs-toggle="collapse" class="btn btn-info">Información</button>
							  </div>
							  </center>

							</p>
							<div class="collapse" id="infMob_<?= $row['idMob']; ?>">

							  	<ul class="list-group list-group-flush">

								    <li class="list-group-item">

								    	<span class="text-secondary"><img src="<?= base_url('/assets/img/iconos/book_open.png'); ?>"> Descripción</span><hr/>
										<span class="card-text"><?= $row['descriptMob']; ?></span>

								    </li>

								    <li class="list-group-item">

								    	<span class="text-secondary"><img src="<?= base_url('/assets/img/iconos/map.png'); ?>"> Localización</span><hr/>
										<span class="card-text"><b><?= $row['nameMap']; ?></b></span>

										- <span class="badge badge-<?php if($userInfo['level'] < $row['lvlMap']){ echo 'danger'; }else{ echo 'success'; } ?>">Nivel: <?= $row['lvlMap']; ?></span>

								    </li>
								    <li class="list-group-item">
								    	
										<img src="<?= base_url('/assets/img/iconos/attack.png'); ?>"> <b><span class="text-secondary">ATK: </span><?= $row['atkMob']; ?></b>

								    </li>
								    <li class="list-group-item">
								    	
								    	<img src="<?= base_url('/assets/img/iconos/heart.png'); ?>"> <b><span class="text-danger">HP: </span> <?= $row['maxHealthMob']; ?></b>

								    </li>
								    <li class="list-group-item">
								    	
										<img src="<?= base_url('/assets/img/iconos/exp.png'); ?>"> <b><span class="text-success">EXP: </span> <?= $row['expMob']; ?></b>

								    </li>
								    <li class="list-group-item">
								    	
										<img src="<?= base_url('/assets/img/iconos/bullet_star.png'); ?>"> <span>Reputación: </span> <b><?= $row['reputationMob']; ?></b>

								    </li>
								    <li class="list-group-item">
								    	
										<img src="<?= base_url('/assets/img/iconos/coins.png'); ?>"> <span><?= $siteInfo['moneyName']; ?>: </span> <b><?= $row['goldMob']; ?></b>

								    </li>

							  	</ul>

							</div>

						  </ul>

						</div>

					</div> <!-- End .col-md-4 -->

				  	<?php } ?>

					</div> <!-- End .row -->

				  	<?php }else{ ?>

							<div class="alert alert-info d-flex align-items-center" role="alert">
							  <div>
							    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No se ha encontrado ningún enemigo.</h4>
							  </div>
							</div>

				  	<?php } ?>

				  	<hr/>
					<!-- Pagination -->
					<?= $pager->links('mobsList'); ?>
					<!-- End Pagination -->

				  </div>
				  
				</div>			

			</div>
				
			</div>
			
		</div>
