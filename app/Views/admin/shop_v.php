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

					<a class="btn btn-success" href="<?= base_url('/admin/shop/item/add'); ?>">
						+ Agregar producto
					</a>

					<hr/>

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.current_url()); ?>
	               <?php endif ?>

					<form action="<?= current_url(); ?>" method="get" id="searchForm" class="form-horizontal">

						<div class="input-group mb-3">
							<input type="search" name="search" class="form-control" placeholder="Buscar producto..." aria-describedby="buttonSearch" value="<?= $search; ?>">
						    <input class="btn btn-success" type="submit" onclick='document.getElementById("searchForm").submit();' id="buttonSearch" value="Buscar">
						</div>

					</form>					

					<table class="table table-striped table-hover ">
					  <thead>
					    <tr>
					      <th>Id</th>
					      <th>Imagen</th>
					      <th>Nombre</th>
					      <th>Precio</th>
					      <th>Acción</th>
					    </tr>
					  </thead>
					  <tbody>

					<?php if(count($getItem) > 0){ ?>
					<?php foreach ($getItem as $row){ ?>

					    <tr>
					      <td><?= $row['idItem']; ?></td>
					      <td><img src="<?= base_url('/assets/img/items/'.$row['imgItem']); ?>"></td>
					      <td><b><?= $row['nameItem']; ?></b></td>
					      <td><b><?= $row['priceItem'].' '.$siteInfo['moneyName']; ?></b></td>
					      <td><a class="btn btn-primary btn-sm" href="<?= base_url('/admin/shop/item/edit/'.$row['idItem']); ?>"><i class="bi bi-pencil-square"></i></a></td>
					    </tr>

					<?php } ?>

					<?php }else{ ?>

						<div class="alert alert-info d-flex align-items-center" role="alert">
							<div>
								<h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún objeto en la tienda.</h4>
							</div>
						</div>

					<?php } ?>

					  </tbody>
					</table>

					<!-- Pagination -->
					<?= $pager->links('itemsList'); ?>
					<!-- End Pagination -->

				  </div>
				</div>
				
			</div>
			
		</div>
