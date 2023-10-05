<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				<?php foreach($getMap as $row){ ?>
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/map_go.png'); ?>"> Administración - Editar Mapa: <?= $row['nameMap']; ?></div>
				  <div class="card-body">

					<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url('/admin/categories_and_maps'); ?>">Categorías y mapas</a></li>
							<li class="breadcrumb-item active" aria-current="page"><?= $row['nameMap']; ?></li>
						</ol>
					</nav>
					<hr/>

			        <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
			            <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
			        <?php endif ?>

			        <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
			            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
			            <?php header('Refresh:1; url= '.base_url('/admin/categories_and_maps')); ?>
			        <?php endif ?>

				  	<form class="form-horizontal" action="<?= current_url(); ?>" method="post">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

				  		<label class="control-label" for="focusedInput">Nombre del mapa</label>
				  		<input type="text" name="nameMap" value="<?= $row['nameMap']; ?>" class="form-control" id="inputEmail" placeholder="Nombre del mapa">
						<span class="text-danger"><?= $validation->getError('nameMap'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del mapa</label>
				  		<input type="text" name="descriptMap" value="<?= $row['descriptMap']; ?>" class="form-control" id="inputEmail" placeholder="Descripción del mapa">
						<span class="text-danger"><?= $validation->getError('descriptMap'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Nivel requerido para el mapa</label>
				  		<input type="number" name="lvlMap" value="<?= $row['lvlMap']; ?>" class="form-control" id="inputEmail" placeholder="Nivel del mapa">
						<span class="text-danger"><?= $validation->getError('lvlMap'); ?></span><br/>
				  		
						<label for="select" class="control-label">Categoría</label>
						<select class="form-control" id="select" name="idCategoryMap" >
							<option value="<?= $row['idCategory']; ?>"><?= $row['nameCategory']; ?></option>
							<option disabled>──────────</option>
							<?php
								if(count($getCategory)){
									foreach ($getCategory as $row2){
							?>

							<option value="<?= $row2['idCategory']; ?>"><?= $row2['nameCategory']; ?></option>

							<?php
									}
								}
							?>
						</select>
						<span class="text-danger"><?= $validation->getError('idCategoryMap'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Imagen del mapa</label>
						<select class="form-control" name="imageMap">
							<option value="<?= $row['imageMap']; ?>"><?= $row['imageMap']; ?></option>
							<option disabled>──────────</option>
						<?php 
							$dir = opendir("assets/img/maps/"); 
							while($listar_d = readdir($dir)){ 
								if ($listar_d[0] != "." && $listar_d[0] != ".." ){ 
									echo "<option value=\"$listar_d\">$listar_d</option>"; 
								} 
							} 
							echo '</select>';
							closedir($dir); 
						?>
						<span class="text-danger"><?= $validation->getError('imageMap'); ?></span><br/>

						<hr/>
						<input type="submit" name="editMap" class="btn btn-primary" value="Gurdar cambios">
				  	</form>

				  </div>
				</div>
				<?php } ?>
				
			</div>
			
		</div>
