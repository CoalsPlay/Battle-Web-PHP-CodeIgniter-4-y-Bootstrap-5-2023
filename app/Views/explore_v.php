<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/attack.png'); ?>"> Combate</div>
				  <div class="card-body">

				  	<div class="row">
					  	<div class="col-md-4">

					  		<div class="well">
					  			<center><img width="150" height="150" src="<?= base_url('/assets/img/avatars/'.$userInfo['avatar']); ?>"></center>

					  			<hr>
							<ul class="list-group">
							  <li class="list-group-item text-center">
							    <b><?= $userInfo['user']; ?></b>
							  </li>
							  <li class="list-group-item">
							    <img src="<?= base_url('/assets/img/iconos/rosette.png'); ?>"> Nivel: <b><?= $userInfo['level']; ?></b>
							  </li>
							  <li class="list-group-item">
							    <img src="<?= base_url('/assets/img/iconos/attack.png'); ?>"> Ataque: <b><?= $userInfo['attack']; ?></b>
							  </li>
							  <li class="list-group-item">
							  	<img src="<?= base_url('/assets/img/iconos/heart.png'); ?>"> Salud: <b><span class="text-danger"><?= $userInfo['health']; ?></span></b>/<b><span class="text-danger"><?= $userInfo['maxHealth']; ?></span></b> HP

									<div class="progress">
									  <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>%" aria-valuenow="<?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $userInfo['health']; ?>/<?= $userInfo['maxHealth']; ?> HP" style="width:<?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>%; max-width:100%;">
									  	<b><?= $userInfo['health']; ?>/<?= $userInfo['maxHealth']; ?> HP</b>
									  </div>
									</div>

							  </li>
							    <li class="list-group-item">
							    	
								    <img src="<?= base_url('/assets/img/iconos/energia.png'); ?>"> Energía: <b><span class="text-info"><?= $userInfo['energy']; ?></span></b>/<b><span class="text-info"><?= $userInfo['maxEnergy']; ?></span></b>

									<div class="progress">
									  <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: <?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>%" aria-valuenow="<?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $userInfo['energy']; ?>/<?= $userInfo['maxEnergy']; ?> de energía" style="width:<?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>%; max-width:100%;">
									  	<b><?= $userInfo['energy']; ?>/<?= $userInfo['maxEnergy']; ?> HP</b>
									  </div>
									</div>

							    </li>
							</ul>
					  		</div>
					  	</div> <!-- End .col-md-4 -->

					  	<div class="col-md-4">
					  		<br/><br/><br/><br/><br/><br/><br/><br/>
					  		<center><h1>VS</h1></center>
					  	</div> <!-- End .col-md-4 -->

					  	<div class="col-md-4">
					  		<?php 
					  			if(count($getRandomMob)){
					  			foreach($getRandomMob as $row){
					  		?>
					  		<div class="well">
					  			<center><img width="130" height="150" src="<?= base_url('/assets/img/mobs/'.$row['imgMob']); ?>"></center>

					  			<hr>
							<ul class="list-group">
							  <li class="list-group-item text-center">
							    <b><?= $row['nameMob']; ?></b>
							  </li>
							  <li class="list-group-item">
							  	<img src="<?= base_url('/assets/img/iconos/heart.png'); ?>"> Salud: <b><span class="text-danger"><?= $row['healthMob']; ?></span></b>/<b><span class="text-danger"><?= $row['maxHealthMob']; ?></span></b> HP

									<div class="progress">
									  <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?= round(($row['healthMob'] / $row['maxHealthMob']) * 100); ?>%" aria-valuenow="<?= round(($row['healthMob'] / $row['maxHealthMob']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $row['healthMob']; ?>/<?= $row['maxHealthMob']; ?> HP" style="width:<?= ($row['healthMob'] / $row['maxHealthMob']) * 100; ?>%; max-width:100%;">
									  	<b><?= $row['healthMob']; ?>/<?= $row['maxHealthMob']; ?> HP</b>
									  </div>
									</div>

							  </li>
								  <li class="list-group-item">
								  <form action="<?= current_url(); ?>" method="post">
								  		<input type="hidden" name="idMob" value="<?= $row['idMob']; ?>">
								  		<input type="hidden" name="healthMob" value="<?= $row['healthMob']; ?>">
								  		<input type="hidden" name="maxHealthMob" value="<?= $row['maxHealthMob']; ?>">
								  		<input type="hidden" name="atkMob" value="<?= $row['atkMob']; ?>">
								    	<input type="submit" onClick="restringir()" name="fight" style="width:100%;" class="btn btn-primary" value="Combatir">
								    </form>
								  </li>
							  <li class="list-group-item">
							  	<form method="post" action="<?= current_url(); ?>">
							    	<input type="submit" name="run" style="width:100%;" class="btn btn-danger" value="Huir">
							  	</form>
							  </li>
							</ul>

					  		</div> <!-- End .well -->

					  		<?php 
					  				} // End Foreach 
					  			}
					  		?>

					  	</div> <!-- End .col-md-4 -->

				  	</div> <!-- End .row -->

				  </div> <!-- End .card body -->
				  
				</div> <!-- End .card -->
				
			</div> <!-- End .col-md-9 -->
			
		</div> <!-- End firs .row -->
