
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/map.png'); ?>"> Mapa</div>
				  <div class="card-body">

					<?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
		                <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
		            <?php endif ?>
					
					<?php
						$i = 0;
						if(count($getCategories)){
					?>

					<ul class="nav nav-tabs">
						
					<?php
							foreach($getCategories as $row){
								$i++;			
					?>

					<li class="nav-item <?php if($i == 1){ echo 'show'; } ?>">
						<button class="nav-link" id="category_<?= $i; ?>-tab" data-bs-toggle="tab" data-bs-target="#category_<?= $i; ?>" type="button" role="tab" aria-controls="category_<?= $i; ?>" aria-selected="false"><?= $row['nameCategory']; ?></button>
					</li>

						<?php } ?>

					</ul>

					<?php }else{ ?>
						
							<div class="alert alert-info d-flex align-items-center" role="alert">
							  <div>
							    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay ninguna categoría ni mapa creados.</h4>
							  </div>
							</div>

					<?php } ?>

					<div id="myTabContent" class="tab-content">
						<?php 
							$m = 0;
							if(count($getCategories)){
								foreach($getCategories as $row){
									$m++;
											
						?>	
					    <div class="tab-pane fade <?php if($m == 1){ echo 'show active'; } ?>" id="category_<?= $m; ?>"><br/>
					    	<span class="text-secondary"><?= $row['descriptCategory']; ?></span>
					    	<hr/>


					    <div class="accordion" id="accordionMap">	
						<?php 
							$getMapsByCategory = $db1->getMapsByCategory($row['idCategory']);
							$i.= 0;
							if(count($getMapsByCategory)){
								foreach($getMapsByCategory as $row2){
									$i++;
						?>
						  <div class="accordion-item">
						    <h2 class="accordion-header" id="headingOne">
						      <button <?php if($userInfo['level'] < $row2['lvlMap']){ echo 'class="accordion-button" disabled style="background:#f8d7da;'; }else{ echo 'class="accordion-button"'; } ?> type="button" data-bs-toggle="collapse" data-bs-target="#map_<?= $i; ?>" aria-expanded="true" aria-controls="#map_<?= $i; ?>">
						        <?php if($userInfo['level'] < $row2['lvlMap']){ 
						        		echo '<i class="bi bi-lock-fill"></i> &nbsp;';
						        	  }else{
						        		echo '<i class="bi bi-unlock-fill"></i> &nbsp;';
						        	  } ?>
									
								<?= $row2['nameMap']; ?>
						      </button>
						    </h2>
						    <div id="map_<?= $i; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionMap">
						      <div class="accordion-body">
						      	<span class="text-secondary"><?= $row2['descriptMap']; ?></span>
						      	<hr/>

						        <center>
						      		<a href="<?= base_url('/map/explore/'.$row2['idMap']); ?>">
						      			<img class="img-fluid" style="margin-top:20px;" src="<?= base_url('/assets/img/maps/'.$row2['imageMap']); ?>">
						      		</a>
						      	</center>		        
						      </div>
						    </div>
						  </div>

						<?php
						
								}
							}else{
								echo '<br/><h3 class="text-center text-secondary"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay ningún mapa asignado a esta categoría.</h3>';
							}
						?>
						</div> <!-- End. accordion -->

					    </div>
					    <?php
					    		}
					    	}
					    ?>
					</div>

					</div>
				</div>
				
			</div>
			
		</div>
