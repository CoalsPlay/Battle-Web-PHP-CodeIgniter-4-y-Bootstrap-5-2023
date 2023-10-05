<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/chart_bar.png'); ?>"> TOP <?= $siteInfo['maxTop']; ?> - <?= $siteInfo['siteName']; ?></div>
				  <div class="card-body">
				  	<div class="row">
				  		<div class="col-md-6">
							<div class="card">
							  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/coins.png'); ?>"> TOP <?= $siteInfo['maxTop']; ?> con más <?= $siteInfo['moneyName']; ?></div>
							  <div class="card-body">
								<?php if(count($topGold) > 0){ $i = 1; ?>

								<table class="table table-striped table-hover ">
								    <thead>
									    <tr>
									    	<th>#</th>
									    	<th>Usuario</th>
									    	<th><?= $siteInfo['moneyName']; ?></th>
									    </tr>
								    </thead>

								    <tbody>
 	
								<?php foreach ($topGold as $row){ ?>

								    <tr>
								      <td><?= $i++; ?></td>
								      <td><a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a></td>
								      <td><?= $row['gold']; ?></td>
								    </tr>

								<?php } ?>

								  </tbody>
								</table>

								<?php }else{ ?>

									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario, excepto el administrador.</h4>
									  </div>
									</div>

								<?php } ?>

							  </div>
							</div>

							<br/>

							<div class="card">
							  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/rosette.png'); ?>"> TOP <?= $siteInfo['maxTop']; ?> con más Nivel</div>
							  <div class="card-body">

								<?php if(count($topLvl)){ $i = 1; ?>

								<table class="table table-striped table-hover ">
								  <thead>
								    <tr>
								      <th>#</th>
								      <th>Usuario</th>
								      <th>Nivel</th>
								    </tr>
								  </thead>
								  <tbody>	

								<?php foreach ($topLvl as $row){ ?>

								    <tr>
								      <td><?= $i++; ?></td>
								      <td><a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a></td>
								      <td><?= $row['level']; ?></td>
								    </tr>

								<?php } ?>

								  </tbody>
								</table>

								<?php }else{ ?>

									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario, excepto el administrador.</h4>
									  </div>
									</div>

								<?php } ?>

							  </div>
							</div>
				  		</div>

				  		<div class="col-md-6">
							<div class="card">
							  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/bullet_star.png'); ?>"> TOP <?= $siteInfo['maxTop']; ?> con más Reputación</div>
							  <div class="card-body">

								<?php if(count($topRep)){ $i = 1; ?>

								<table class="table table-striped table-hover ">
								  <thead>
								    <tr>
								      <th>#</th>
								      <th>Usuario</th>
								      <th>Reputación</th>
								    </tr>
								  </thead>
								  <tbody>

								<?php foreach ($topRep as $row){ ?>

								    <tr>
								      <td><?= $i++; ?></td>
								      <td><a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a></td>
								      <td><?= $row['reputation']; ?></td>
								    </tr>

								<?php } ?>

								  </tbody>
								</table>

								<?php }else{ ?>

									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario, excepto el administrador.</h4>
									  </div>
									</div>

								<?php } ?>

							  </div>
							</div>

							<br/>

							<div class="card">
							  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/objetive.png'); ?>"> TOP <?= $siteInfo['maxTop']; ?> con más Bajas</div>
							  <div class="card-body">

								<?php if(count($topKills)){ $i = 1; ?>

								<table class="table table-striped table-hover ">
								  <thead>
								    <tr>
								      <th>#</th>
								      <th>Usuario</th>
								      <th>Bajas</th>
								    </tr>
								  </thead>
								  <tbody>

								<?php foreach ($topKills as $row){ ?>

								    <tr>
								      <td><?= $i++; ?></td>
								      <td><a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a></td>
								      <td><?= $row['kills']; ?></td>
								    </tr>

								<?php } ?>

								  </tbody>
								</table>
								
								<?php }else{ ?>

									<div class="alert alert-info d-flex align-items-center" role="alert">
									  <div>
									    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún usuario, excepto el administrador.</h4>
									  </div>
									</div>

								<?php } ?>

							  </div>
							</div>
				  		</div>
				  	</div>
				  </div>
				</div>
				
			</div>
			
		</div>
