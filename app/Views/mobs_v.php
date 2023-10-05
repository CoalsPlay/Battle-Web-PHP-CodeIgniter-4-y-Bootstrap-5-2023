<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/bug.png'); ?>"> Lista de enemigos</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
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

				  	<div class="col-md-4">

						<div class="card mb-3">
						  <div class="card-header text-center">
						    <b class="card-title"><?= $row['nameMob']; ?></b>
						  </div>

						  <center>
						  <img class="img-fluid" style="height:200px; width:200px; margin-top:10px; margin-bottom:10px;" src="<?= base_url('/assets/img/mobs/'.$row['imgMob']); ?>" title="<?= $row['nameMob']; ?>">
						  </center>
						  
						  <ul class="list-group list-group-flush">

						    <li class="list-group-item">

						      <button class="btn btn-info btn-block" type="button" data-bs-toggle="collapse" data-bs-target="#infMob_<?= $row['idMob']; ?>" aria-expanded="false" aria-controls="infMob_<?= $row['idMob']; ?>" style="width:100%;">
							    Información
							  </button>
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

					<br/>
					<?php } ?>

					</div> <!-- End .row -->

					<?php }else{ ?>

							<div class="alert alert-info d-flex align-items-center" role="alert">
							  <div>
							    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún enemigo registrado.</h4>
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
