
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
					  			

							<ul class="list-group">
							  <li class="list-group-item text-center">
							    <b><?= $userInfo['user']; ?></b>
							  </li>
							  <li class="list-group-item text-center">
							  	<center><img width="150" height="150" class="img-thumbnail" src="<?= base_url('/assets/img/avatars/'.$userInfo['avatar']); ?>"></center>
							  </li>
							  <li class="list-group-item">
							    <img src="<?= base_url('/assets/img/iconos/rosette.png'); ?>"> Nivel: <b><?= $userInfo['level']; ?></b>
							  </li>
							  <li class="list-group-item">
							    <img src="<?= base_url('/assets/img/iconos/attack.png'); ?>"> Ataque: <b><?= $userInfo['attack']; ?></b>
							  </li>
							  <li class="list-group-item">
							  	<img src="<?= base_url('/assets/img/iconos/heart.png'); ?>"> Salud: <b><span class="text-danger"><?= $userInfo['health']; ?></span></b>/<b><span class="text-danger"><?= $userInfo['maxHealth']; ?></span></b> HP

									<div class="progress" style="height:28px;">
									  <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>%" aria-valuenow="<?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $userInfo['health']; ?>/<?= $userInfo['maxHealth']; ?> HP" style="width:<?= round(($userInfo['health'] / $userInfo['maxHealth']) * 100); ?>%; max-width:100%;">
									  	<b><?= $userInfo['health']; ?>/<?= $userInfo['maxHealth']; ?> HP</b>
									  </div>
									</div>

							  </li>
							    <li class="list-group-item">
							    	
								    <img src="<?= base_url('/assets/img/iconos/energia.png'); ?>"> Energía: <b><span class="text-info"><?= $userInfo['energy']; ?></span></b>/<b><span class="text-info"><?= $userInfo['maxEnergy']; ?></span></b>

									<div class="progress" style="height:28px;">
									  <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: <?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>%" aria-valuenow="<?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $userInfo['energy']; ?>/<?= $userInfo['maxEnergy']; ?> de energía" style="width:<?= round(($userInfo['energy'] / $userInfo['maxEnergy']) * 100); ?>%; max-width:100%;">
									  	<b><?= $userInfo['energy']; ?>/<?= $userInfo['maxEnergy']; ?> HP</b>
									  </div>
									</div>

							    </li>

							    <!--<li class="list-group-item">

							    	<p>
									  <button class="btn btn-secondary" style="width: 100%;" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
									    <img src="<?= base_url('/assets/img/iconos/briefcase.png'); ?>"> Inventario
									  </button>
									</p>
									<div class="collapse" id="collapseExample">
									  <div class="card card-body">
									    ITEMS
									  </div>
									</div>

							    </li>-->
							</ul>
					  		</div>
					  	</div> <!-- End .col-md-4 -->


					  	<?php foreach($checkFight as $row){ ?>

					  	<div class="col-md-4">
							<div class="card">
							  <div class="card-header text-center">Información de combate</div>
							  <div class="card-body">
							  
							    <?php if(isset($msg)){ echo $msg; }else{ ?>
								<center><b>Esperando acción...</b><br/><br/>
								<div class="spinner-border" role="status">
								  <span class="sr-only">Loading...</span>
								</div>
								</center>
							    <?php } ?>
							    
							  </div>
							</div>
					  		<br/><br/><br/><br/><br/><br/>
					  		<center><h1>VS</h1></center>
					  	</div> <!-- End .col-md-4 -->

					  	<div class="col-md-4">
					  		<div class="well">
					  			

							<ul class="list-group">
							  <li class="list-group-item text-center">
							    <b><?= $row['nameMob']; ?></b>
							  </li>
							  <li class="list-group-item text-center">
							  	<center><img width="130" height="150" src="<?= base_url('/assets/img/mobs/'.$row['imgMob']); ?>"></center>
							  </li>
							  <li class="list-group-item">
							  	<img src="<?= base_url('/assets/img/iconos/heart.png'); ?>"> Salud: <b><span class="text-danger"><?= $row['healthEnemyFight']; ?></span></b>/<b><span class="text-danger"><?= $row['maxHealthEnemyFight']; ?></span></b> HP

									<div class="progress" style="height:28px;">
									  <div class="progress-bar progress-bar-striped bg-danger progress-bar-animated" role="progressbar" style="width: <?= round(($row['healthEnemyFight'] / $row['maxHealthEnemyFight']) * 100); ?>%" aria-valuenow="<?= round(($row['healthEnemyFight'] / $row['maxHealthEnemyFight']) * 100); ?>" aria-valuemin="0" aria-valuemax="100" title="<?= $row['healthEnemyFight']; ?>/<?= $row['maxHealthEnemyFight']; ?> HP" style="width:<?= round(($row['healthEnemyFight'] / $row['maxHealthEnemyFight']) * 100); ?>%; max-width:100%;">
									  	<b><?= $row['healthEnemyFight']; ?>/<?= $row['maxHealthEnemyFight']; ?> HP</b>
									  </div>
									</div>

							  </li>

							<?php if($row['healthEnemyFight'] == 0 or $userInfo['health'] == 0 or $userInfo['energy'] < 5){ echo '</ul>'; }else{ ?>
							  		
							  <li class="list-group-item">
							  	<form action="<?= current_url(); ?>" method="post">
							    	<input type="submit" name="attack" style="width:100%;" class="btn btn-primary" value="Atacar">
							    </form>
							  </li>
							  <li class="list-group-item">
							  	<form action="<?= current_url(); ?>" method="post">
							    	<input type="submit" name="surrender" style="width:100%;" class="btn btn-danger" value="Rendirme">
							    </form>
							  </li>

							<?php } ?>

							  <?php } // End Foreach ?>

							</ul>

					  		</div> <!-- End .well -->

					  	</div> <!-- End .col-md-4 -->

				  	</div> <!-- End .row -->

				  </div> <!-- End .card body -->

				</div> <!-- End .card -->
				
			</div> <!-- End .col-md-9 -->
			
		</div> <!-- End firs .row -->