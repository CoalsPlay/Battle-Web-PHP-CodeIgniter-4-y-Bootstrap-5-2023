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
				  	<?php foreach($getItem as $row){ ?>

					<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?= base_url('/admin/shop'); ?>">Gestión de tienda</a></li>
							<li class="breadcrumb-item active" aria-current="page"><?= $row['nameItem']; ?></li>
						</ol>
					</nav>
					<hr/>

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

				  		<label class="control-label" for="focusedInput">Nombre del artículo</label>
				  		<input type="text" name="nameItem" value="<?= $row['nameItem']; ?>" class="form-control" id="inputEmail" placeholder="Nombre del artículo">
						<span class="text-danger"><?= $validation->getError('nameItem'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Precio del artículo</label>
				  		<input type="text" name="priceItem" value="<?= $row['priceItem']; ?>" class="form-control" id="inputEmail" placeholder="Precio del artículo">
						<span class="text-danger"><?= $validation->getError('priceItem'); ?></span><br/>
						
				  		<label class="control-label" for="focusedInput">Acción del artículo</label>
				        <select class="form-control" id="select" name="actionItem">
				          <option <?php if($row['actionItem'] == 'hp'){ echo 'selected="selected" '; } ?> value="hp">Salud</option>
				          <option <?php if($row['actionItem'] == 'sp'){ echo 'selected="selected" '; } ?> value="sp">Energía</option>
				          <option <?php if($row['actionItem'] == 'atk'){ echo 'selected="selected" '; } ?> value="atk">Ataque</option>
				        </select><br/>
				  		
				  		<label class="control-label" for="focusedInput">Cantidad de acción del artículo</label>
				  		<input type="text" name="amountActionItem" value="<?= $row['amountActionItem']; ?>" class="form-control" id="inputEmail" placeholder="Acción del artículo">
						<span class="text-danger"><?= $validation->getError('amountActionItem'); ?></span><br/>
				  		
				  		<label class="control-label" for="focusedInput">Descripción del artículo</label>
				  		<textarea class="form-control" style="max-width:100%;" name="descriptionItem" rows="2" id="textArea" placeholder="Descripción del artículo"><?= $row['descriptionItem']; ?></textarea>
						<span class="text-danger"><?= $validation->getError('descriptionItem'); ?></span><br/>
						
				  		<label class="control-label" for="focusedInput">Imagen del artículo</label>
						<select class="form-control" name="imgItem">
							<option><?= $row['imgItem']; ?></option>
						<?php 
							$dir = opendir("assets/img/items"); 
							while($listar_d = readdir($dir)){ 
								if ($listar_d[0] != "." && $listar_d[0] != ".." ){ 
									echo "<option value=\"$listar_d\">$listar_d</option>"; 
								} 
							} 
							echo '</select>';
							closedir($dir);
						?>
						<span class="text-danger"><?= $validation->getError('imgItem'); ?></span><br/>

						<hr/>
						<input type="submit" name="updateItem" class="btn btn-primary" value="Guardar cambios">
						<a href="" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteItem">Borrar producto</a>


						<!-- Modal -->
						<div class="modal fade" id="deleteItem" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteItemLabel" aria-hidden="true">
						  <div class="modal-dialog">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="deleteItemLabel">¿Estás seguro de borrar este producto?</h5>
						        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
						        <input type="submit" name="deleteItem" class="btn btn-danger" value="Borrar producto">
						      </div>
						    </div>
						  </div>
						</div>

				  	</form>
				  	<?php } ?>
				  </div>
				</div>
					

			</div>
			
		</div>
