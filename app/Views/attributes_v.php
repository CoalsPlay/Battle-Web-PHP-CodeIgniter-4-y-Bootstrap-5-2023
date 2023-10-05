<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/upgrade.png'); ?>"> Puntos de atributos</div>
				  <div class="card-body">
				  	<span style="font-size:14pt;">Actualmente dispones de <b><span class="text-danger">
				  		<?php
				  			if($userInfo['ptsAttributes'] > 0){

				  				echo '<span class="text-success">'.$userInfo['ptsAttributes'].'</span>';
				  			}else{
				  				echo '<span class="text-danger">'.$userInfo['ptsAttributes'].'</span>';
				  			}
				  		?>
				  	</span></b> puntos de atributos.</span><br/><br/>

					<table class="table table-striped table-hover ">
					  <tbody>
					    <tr>
					      <td><img src="<?= base_url('/assets/img/iconos/attack.png'); ?>"></td>
					      <td>Fuerza</td>
					      <td>Incrementa tu fuerza en 3, para dar golpes más contundentes.</td>
					      <td>

			               <?php if( !empty( session()->getFlashdata('successAtk') ) ) : ?>
			                   <b><span class="text-success"><?= session()->getFlashdata('successAtk'); ?></span></b>
			               <?php endif ?>

			               <?php if( !empty( session()->getFlashdata('failAtk') ) ) : ?>
			                   <b><span class="text-danger"><?= session()->getFlashdata('failAtk'); ?></span></b>
			               <?php endif ?>

					  	  </td>
					      <td>
					      <?php
					      	if($userInfo['ptsAttributes'] > 0){

					      		echo '<form action="'.current_url().'" method="post">
										<button type="submit" value="attack" name="attack" class="btn btn-success btn-xs"><i class="bi bi-plus-lg"></i></button>
					      			  </form>';
					      	}else{
					      		echo '<button disabled="disabled" class="btn btn-danger btn-xs"><i class="bi bi-x-lg"></i></button>';
					      	}
					      ?>
					      </td>
					      <td><span class="badge bg-secondary"><?= $userInfo['attack']; ?></span></td>
					    </tr>
					    <tr>
					      <td><img src="<?= base_url('/assets/img/iconos/heart.png'); ?>"></td>
					      <td>Salud</td>
					      <td>Aumenta tu salud máxima en 10, para disponer de más HP en los combates.</td>
						  <td>

			               <?php if( !empty( session()->getFlashdata('successHp') ) ) : ?>
			                   <b><span class="text-success"><?= session()->getFlashdata('successHp'); ?></span></b>
			               <?php endif ?>

			               <?php if( !empty( session()->getFlashdata('failHp') ) ) : ?>
			                   <b><span class="text-danger"><?= session()->getFlashdata('failHp'); ?></span></b>
			               <?php endif ?>

					  	  </td>
					      <td>
					      <?php
					      	if($userInfo['ptsAttributes'] > 0){

					      		echo '<form action="'.current_url().'" method="post">
										<button type="submit" value="maxHealth" name="maxHealth" class="btn btn-success btn-xs"><i class="bi bi-plus-lg"></i></button>
					      			  </form>';
					      	}else{
					      		echo '<button disabled="disabled" class="btn btn-danger btn-xs"><i class="bi bi-x-lg"></i></button>';
					      	}
					      ?>
					      </td>
					      <td><span class="badge bg-secondary"><?= $userInfo['maxHealth']; ?></span></td>
					    </tr>
					    <tr>
					      <td><img src="<?= base_url('/assets/img/iconos/energia.png'); ?>"></td>
					      <td>Energía</td>
					      <td>Aumenta tu energía en 5, para tener más energía y poder combatir durante más tiempo sin cansarte.</td>
					      <td>

			               <?php if( !empty( session()->getFlashdata('successSp') ) ) : ?>
			                   <b><span class="text-success"><?= session()->getFlashdata('successSp'); ?></span></b>
			               <?php endif ?>

			               <?php if( !empty( session()->getFlashdata('failSp') ) ) : ?>
			                   <b><span class="text-danger"><?= session()->getFlashdata('failSp'); ?></span></b>
			               <?php endif ?>

					  	  </td>
					      <td>
					      <?php
					      	if($userInfo['ptsAttributes'] > 0){

					      		echo '<form action="'.current_url().'" method="post">
										<button type="submit" name="maxEnergy" value="maxEnergy" class="btn btn-success btn-xs"><i class="bi bi-plus-lg"></i></button>
					      			  </form>';
					      	}else{
					      		echo '<button disabled="disabled" class="btn btn-danger btn-xs"><i class="bi bi-x-lg"></i></button>';
					      	}
					      ?>
					      </td>
					      <td><span class="badge bg-secondary"><?= $userInfo['maxEnergy']; ?></span></td>
					    </tr>
					  </tbody>
					</table> 
				  </div>
				</div>

				<!-- Users Online -->
				<?//= $box_onlines; ?>
				<!-- End Users Online -->
				
			</div>
			
		</div>
