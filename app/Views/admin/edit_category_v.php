<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/map_go.png'); ?>"> Administración - Editar categoría</div>
				  <div class="card-body">

				  	<?php foreach($getCategory as $row){ ?>

					<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url('/admin/categories_and_maps'); ?>">Categorías y mapas</a></li>
							<li class="breadcrumb-item active" aria-current="page"><?= $row['nameCategory']; ?></li>
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

				  		<label class="control-label" for="focusedInput">Nombre de la categoría</label>
				  		<input type="text" name="nameCategory" class="form-control" id="inputEmail" placeholder="Nombre de la categoría" value="<?= $row['nameCategory']; ?>">
						<span class="text-danger"><?= $validation->getError('nameCategory'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción de la categoría</label>
				  		<input type="text" name="descriptCategory" class="form-control" id="inputEmail" placeholder="Descripción de la categoría" value="<?= $row['descriptCategory']; ?>">
						<span class="text-danger"><?= $validation->getError('descriptCategory'); ?></span><br/>

				  		<input type="hidden" name="idCategory" value="<?= $row['idCategory']; ?>">
				  		
				  		<hr/>
						<input type="submit" name="editCategory" class="btn btn-primary" value="Guardar cambios">
				  	</form>
				  	<?php } ?>

				  </div>
				</div>
				
			</div>
			
		</div>
