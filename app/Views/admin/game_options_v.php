<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/wrench.png'); ?>"> Administración - Ajustes del juego</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.current_url()); ?>
	               <?php endif ?>

				  	<form class="form-horizontal" action="<?= current_url(); ?>" method="post">
				  		<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<h3 class="text-muted">Opciones del juego</h3>
						<hr/>

				  		<label class="control-label" for="focusedInput">Nivel máximo</label>
				  		<input type="text" name="maxLvl" value="<?= $siteInfo['maxLvl']; ?>" class="form-control" id="inputEmail" placeholder="Nivel máximo">
						<span class="text-danger"><?= $validation->getError('maxLvl'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Puntos de atributos por nivel</label>
				  		<input type="text" name="attributePointsPerLvl" value="<?= $siteInfo['attributePointsPerLvl']; ?>" class="form-control" id="inputEmail" placeholder="Puntos de atributos por nivel">Cantidad de puntos de atributos que será otorgado al usuario cada vez que suba un nivel.<br/>
						<span class="text-danger"><?= $validation->getError('attributePointsPerLvl'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Experiencia por nivel</label>
				  		<input type="text" name="intervalExp" value="<?= $siteInfo['intervalExp']; ?>" class="form-control" id="inputEmail" placeholder="Experiencia por nivel">Incrementa la experiencia requerida para el siguiente nivel.<br/>
						<span class="text-danger"><?= $validation->getError('intervalExp'); ?></span><br/>
						

				  		<label class="control-label" for="focusedInput">Rango de nivel para PvP</label>
				  		<input type="text" name="intervalLvl" value="<?= $siteInfo['intervalLvl']; ?>" class="form-control" id="inputEmail" placeholder="Rango de nivel para PvP">Diferencia de nivel en la que no se podrá atacar a un usuario por clara ventaja.<br/>
						<span class="text-danger"><?= $validation->getError('intervalLvl'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Nombre de la moneda del juego</label>
				  		<input type="text" name="moneyName" value="<?= $siteInfo['moneyName']; ?>" class="form-control" id="inputEmail" placeholder="Nombre de la moneda del juego">
						<span class="text-danger"><?= $validation->getError('moneyName'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Número de usuarios en TOP</label>
				  		<input type="text" name="maxTop" value="<?= $siteInfo['maxTop']; ?>" class="form-control" id="inputEmail" placeholder="Máximos usuarios en TOP">
						<span class="text-danger"><?= $validation->getError('maxTop'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Capacidad de objetos en inventario</label>
				  		<input type="text" name="maxItemsInventory" value="<?= $siteInfo['maxItemsInventory']; ?>" class="form-control" id="inputEmail" placeholder="Máxima capacidad de objetos en inventario">
						<span class="text-danger"><?= $validation->getError('maxItemsInventory'); ?></span><br/>

				  		<label class="control-label" for="focusedInput">Capacidad de amigos agregados</label>
				  		<input type="text" name="maxFriends" value="<?= $siteInfo['maxFriends']; ?>" class="form-control" id="inputEmail" placeholder="Máximos usuarios en TOP">
						<span class="text-danger"><?= $validation->getError('maxFriends'); ?></span><br/>
				        
				        <hr>
						<input type="submit" name="saveConfiguration" class="btn btn-primary" value="Guardar cambios">

				  	</form>
				  </div>
				</div>
					
			</div>
			
		</div>
