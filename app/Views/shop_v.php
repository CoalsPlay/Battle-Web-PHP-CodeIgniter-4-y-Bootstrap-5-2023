
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div> <!-- End .col-md-3 -->
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/cart.png'); ?>"> Tienda</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('failS') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

					<form action="<?= current_url(); ?>" method="get" id="searchForm" class="form-horizontal">

						<div class="input-group mb-3">
						    <input type="search" name="search" class="form-control" placeholder="Buscar producto..." aria-describedby="buttonSearch" value="<?= $search; ?>">

						    <input class="btn btn-success" type="submit" onclick='document.getElementById("searchForm").submit();' id="buttonSearch" value="Buscar">
						</div>

					</form>

					<hr/>

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.current_url()); ?>
	               <?php endif ?>

					        	
					<?php if(count($getItem)){ ?>

					<div class="row">

					<?php foreach($getItem as $row){ ?>
					        		
					<div class="col-md-4">

					<div class="card mb-3">
						<b class="card-header text-center"><?= $row['nameItem']; ?></b>

						<center><img style="margin-top:20px; margin-bottom:20px; width:40px; height:40px;" src="<?= base_url('/assets/img/items/'.$row['imgItem']); ?>"></center>

						<ul class="list-group list-group-flush">
							<li class="list-group-item"><?= $row['descriptionItem']; ?></li>
						</ul>

						<div class="card-footer text-muted float-left">
							<b><?= $row['priceItem']; ?></b> <img src="<?= base_url('/assets/img/iconos/coins.png'); ?>">


						<form method="post" class="float-end" action="<?= current_url(); ?>">

							<input type="hidden" value="<?= $row['idItem']; ?>" name="idItemInv" >
							<input type="hidden" value="<?= $row['nameItem']; ?>" name="nameItemInv" >

							<input type="submit" name="buyItem" class="btn btn-success float-end btn-sm" value="Comprar">

						</form>

						</div>
					</div>

					</div> <!-- End .col-md-4 -->


					<?php } ?>

					</div> <!-- End .row -->

					<?php }else{ ?>
					        		
							<div class="alert alert-info d-flex align-items-center" role="alert">
							  <div>
							    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún objeto en la tienda.</h4>
							  </div>
							</div>

					<?php } ?>

					<hr/>

					<!-- Pagination -->
					<?= $pager->links('itemsList'); ?>
					<!-- End Pagination -->

					</div> <!-- End .card-body -->
				</div> <!-- End .card -->

	</div> <!-- End .col-md-9 -->

</div> <!-- End .row -->