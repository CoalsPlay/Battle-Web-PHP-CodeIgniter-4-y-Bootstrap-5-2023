
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/briefcase.png'); ?>"> Inventario de <b><?= $userInfo['user']; ?></b></div>

				  <div class="card-body">
				  	
					<span>Capacidad de objetos que puedes llevar <b><?= count($dataInv).'/'. $siteInfo['maxItemsInventory']; ?></b>

					<div class="progress">
						 <div class="progress-bar" role="progressbar" style="width:<?= round((count($dataInv) / $siteInfo['maxItemsInventory']) * 100); ?>%; max-width:100%;" aria-valuenow="<?= round((count($dataInv) / $siteInfo['maxItemsInventory']) * 100); ?>" aria-valuemin="0" aria-valuemax="100"></div>
					</div>

					<hr/>

	                <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                    <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	                <?php endif ?>

	                <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                    <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                    <?php header('Refresh:1; url= '.current_url()); ?>
	                <?php endif ?>


					<?php if(count($getItems) > 0){ ?>

					<div class="row">

					<?php foreach($getItems as $row){ ?>

					<div class="col-md-4">

					<div class="card mb-3">
					  <b class="card-header text-center"><?= $row['nameItem']; ?></b>

					  <center><img style="margin-top:20px; margin-bottom:20px; width:40px; width:40px;" src="<?= base_url('/assets/img/items/'.$row['imgItem']); ?>"></center>

					  <ul class="list-group list-group-flush">
					  	<li class="list-group-item"><?= $row['descriptionItem']; ?></li>
					  </ul>
					  
					  <div class="card-footer text-muted">

						<center>
						<div class="btn-group" role="group" aria-label="Form">

							<form method="post" class="btn-group" action="<?= current_url(); ?>">		

								<input type="submit" name="useItem" class="btn btn-info btn-xs" value="Usar">

								<input type="hidden" name="idInventory" value="<?= $row['idInventory']; ?>">
								<input type="hidden" name="nameItemInv" value="<?= $row['nameItemInv']; ?>">

								<input type="submit" name="deleteItem" class="btn btn-xs btn-danger" value="Tirar">

							</form>

						</div>	
						</center>

					  </div>
					</div>

					</div> <!-- End .col-md-4 -->

					    <?php } // End foreach ?>

					    </div> <!-- End .row -->

					    <?php }else{ ?>
							<div class="alert alert-info d-flex align-items-center" role="alert">
							  <div>
							    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Inventario vacío.</h4>
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
