<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/cart_edit.png'); ?>"> Administración - Gestor de la tienda</div>
				  <div class="card-body">

					<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url('/admin/shop'); ?>">Gestión de la tienda</a></li>
							<li class="breadcrumb-item active" aria-current="page">Agregar nuevo producto</li>
						</ol>
					</nav>
					<hr/>

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.base_url('/admin/shop')); ?>
	               <?php endif ?>

				  	<form class="form-horizontal" action="<?= current_url(); ?>" method="post">
				  		<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

				  		<label class="control-label" for="focusedInput">Nombre del artículo</label>
				  		<input type="text" name="nameItem" value="<?= set_value('nameItem'); ?>" class="form-control" id="inputEmail" placeholder="Nombre del artículo">
						<span class="text-danger"><?= $validation->getError('nameItem'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Precio del artículo</label>
				  		<input type="text" name="priceItem" value="<?= set_value('priceItem'); ?>" class="form-control" id="inputEmail" placeholder="Precio del artículo">
						<span class="text-danger"><?= $validation->getError('priceItem'); ?></span><br/>
				        
				  		<label class="control-label" for="focusedInput">Acción del artículo</label>
				        <select class="form-control" id="select" name="actionItem">
				          <option value="hp">Salud</option>
				          <option value="sp">Energía</option>
				          <option value="atk">Ataque</option>
				        </select>
						<span class="text-danger"><?= $validation->getError('actionItem'); ?></span><br/>
				        
				  		<label class="control-label" for="focusedInput">Cantidad de acción del artículo</label>
				        <input type="text" name="amountActionItem" value="<?= set_value('amountActionItem'); ?>" class="form-control" id="inputEmail" placeholder="Cantidad acción">
						<span class="text-danger"><?= $validation->getError('amountActionItem'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del artículo</label>
				  		<textarea class="form-control" style="max-width:100%;" name="descriptionItem" rows="2" id="textArea" placeholder="Descripción del artículo"><?= set_value('descriptionItem'); ?></textarea>
						<span class="text-danger"><?= $validation->getError('descriptionItem'); ?></span><br/>
						
				  		<label class="control-label" for="focusedInput">Imagen del artículo</label>
						<select class="form-control" value="<?= set_value('imgItem'); ?>" name="imgItem">
							<option>Imagen</option>
							<?php 
								$dir = opendir("assets/img/items"); 
								while($listar_d = readdir($dir))
								{ 
									if($listar_d[0] != "." && $listar_d[0] != ".." )
									{ 
										echo "<option value=\"$listar_d\">$listar_d</option>"; 
									} 
								} 
								echo '</select>';
								closedir($dir); 
							?>
							<span class="text-danger"><?= $validation->getError('imgItem'); ?></span><br/>

						<hr/>
						<input type="submit" name="addItem" class="btn btn-primary" value="Agregar artículo">
				  	</form>
				  </div>
				</div>
					
			</div>
			
		</div>
