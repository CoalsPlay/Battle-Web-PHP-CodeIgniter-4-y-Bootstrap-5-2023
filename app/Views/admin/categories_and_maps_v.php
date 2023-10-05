		<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
					<div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/map_go.png'); ?>"> Administración - Categorías y mapas</div>
					<div class="card-body">

							<ul class="nav nav-tabs">
							  <li class="nav-item">
							    <a class="nav-link active" data-bs-toggle="tab" href="#categories">Categorías</a>
							  </li>
							  <li class="nav-item">
							    <a class="nav-link" data-bs-toggle="tab" href="#maps">Mapas</a>
							  </li>
							</ul>
							<div id="myTabContent" class="tab-content">
							  <div class="tab-pane fade show active" id="categories">
							    <p>
							    	
							    	<div class="row">
									  	<div class="col-md-6">

							               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
							                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
							               <?php endif ?>

							               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
							                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
							                   <?php header('Refresh:1; url= '.current_url()); ?>
							               <?php endif ?>

									  		<form method="post" action="<?= current_url(); ?>">
												<?php $validation = \Config\Services::validation(); ?>
												<?= csrf_field(); ?>

										        <label for="category" class="control-label">Nombre de la categoría</label>
										        <input type="text" name="nameCategory" class="form-control" id="category" placeholder="Nombre de la categoría">
												<span class="text-danger"><?= $validation->getError('nameCategory'); ?></span><br/>

												<label class="control-label" for="focusedInput">Descripción de la categoría</label>
												<textarea class="form-control" style="max-width:100%" name="descriptCategory" rows="5" id="textArea" placeholder="Descripción de la categoría"></textarea>
												<span class="text-danger"><?= $validation->getError('descriptCategory'); ?></span><br/>

										        <input type="submit" class="btn btn-primary" value="Agregar categoría" name="addCategory">
									  		</form><br/>
									  	</div> <!-- End .col-md-6 -->

									  	<div class="col-md-6">
											<div class="alert alert-warning">Borrar una categoría también borrará los mapas que estén asignados a ella.</div>
											<hr/>
									  		<?php 
									  			if(count($getCategories)){
									  				foreach ($getCategories as $row){
									  		?>

											<div id="accordion">

												<div class="card" style="margin-top:1px;">

													<div class="card-header">

														<a class="card-link" data-bs-toggle="collapse" href="#collapse<?= $row['idCategory']; ?>">
															<?= $row['nameCategory']; ?>

															<div class="btn-group float-end" role="group" aria-label="Basic example">
																<a href="<?= base_url('/admin/categories_and_maps/category/edit/'.$row['idCategory']); ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>

																<form method="post" class="btn-group" action="<?= current_url(); ?>">
																	<input type="hidden" name="idCategory" value="<?= $row['idCategory']; ?>">
																	<a href="" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteCategory_<?= $row['idCategory']; ?>"><i class="bi bi-trash-fill"></i></a>

																<!-- Modal -->
																<div class="modal fade" id="deleteCategory_<?= $row['idCategory']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
																  <div class="modal-dialog">
																    <div class="modal-content">
																      <div class="modal-header">
																        <h5 class="modal-title" id="deleteCategoryLabel">¿Estás seguro de borrar <b class="text-primary"><?= $row['nameCategory']; ?></b>?</h5>
																        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																      </div>
																      <div class="modal-body">
																        <p class="text-danger"><b>Esta acción no se puede revertir.</b></p>
																        <p class="text-danger"><b>Se borrarán los siguientes mapas asociados a esta categoría:</b>

																        <?php
																			$getMapsByCategory = $db1->getMapsByCategory($row['idCategory']);
																			if(count($getMapsByCategory)){
																				foreach ($getMapsByCategory as $row){
																		?>
																		<li class="list-group-item"><?= $row['nameMap']; ?></li>
																		<?php
																				}
																			}else{
																				echo '<div class="alert alert-info d-flex align-items-center" role="alert">
																						  <div>
																						    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay ningún mapa asociado a esta categoría.</h4>
																						  </div>
																						</div>';
																			}
																		?>
																        </p>

																      </div>
																      <div class="modal-footer">
																        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Cancelar</button>
																        <input type="submit" name="deleteCategory" class="btn btn-danger" value="Borrar categoría">
																      </div>
																    </div>
																  </div>
																</div>

																</form>
															</div>			
														</a>
													</div>

													<div id="collapse<?= $row['idCategory']; ?>" class="collapse" data-parent="#accordion">
														<div class="card-body">
															<ul class="list-group list-group-flush">
															<?php
																$getMapsByCategory = $db1->getMapsByCategory($row['idCategory']);
																if(count($getMapsByCategory)){
																	foreach ($getMapsByCategory as $row){
															?>
															<li class="list-group-item"><?= $row['nameMap']; ?></li>
															<?php
																	}
																}else{
																	echo '<div class="alert alert-info d-flex align-items-center" role="alert">
																						  <div>
																						    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay ningún mapa asociado a esta categoría.</h4>
																						  </div>
																						</div>';
																}
															?>
															</ul>
														</div>

													</div>

												</div>

											</div>									  				
									  		<?php
									  				}
									  			}else{
									  		?>

											<h5 class="text-muted text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ninguna categoría creada.</h5>

									  		<?php
									  			}
									  		?>
									   
									    </div> <!-- End .col-md-6 -->

									</div> <!-- End .row -->
							    	
							    </p>
							  </div>
							  <div class="tab-pane fade" id="maps">
							    <p>
							    	<br/>
									<a href="<?= base_url('/admin/add_map'); ?>">
								  		<button type="button" class="btn btn-success"> + Agregar mapa</button>
								  	</a>

								  	<hr/>

								  	
								  	<?php if(count($getMaps)){ ?>

									<div class="row">

								  	<?php foreach($getMaps as $row){ ?>

									  	<div class="col-md-3">

											<div class="card mb-3">
											  <h5 class="card-header text-center"><?= $row['nameMap']; ?></h5>
											  <center><img style="margin-top:20px;" src="<?= base_url('/assets/img/maps/'.$row['imageMap']); ?>" width="150" height="100"></center>
											  <br/>
											  <ul class="list-group list-group-flush">
											    <li class="list-group-item">Categoría: <span class="text-secondary"><?= $row['nameCategory']; ?></span></li>
											  </ul>
											  <ul class="list-group list-group-flush">
											    <li class="list-group-item">Nivel requerido: <span class="text-secondary"><?= $row['lvlMap']; ?></span></li>
											  </ul>
											  <div class="card-footer text-muted float-left">

											  	<center>
												<div class="btn-group" role="group" aria-label="Basic example">
													<a href="<?= base_url('/admin/categories_and_maps/map/edit/'.$row['idMap']); ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>

													<form method="post" class="btn-group" action="<?= current_url(); ?>">
														<input type="hidden" name="idMap" value="<?= $row['idMap']; ?>">
														<a href="" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMap_<?= $row['idMap']; ?>"><i class="bi bi-trash-fill"></i></a>

													<!-- Modal -->
													<div class="modal fade" id="deleteMap_<?= $row['idMap']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteMapLabel" aria-hidden="true">
													  <div class="modal-dialog">
													    <div class="modal-content">
													      <div class="modal-header">
													        <h5 class="modal-title" id="deleteMapLabel">¿Estás seguro de borrar <b class="text-primary"><?= $row['nameMap']; ?></b>?</h5>
													        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													      </div>
													      <div class="modal-footer">
													        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancelar</button>
													        <input type="submit" name="deleteMap" class="btn btn-danger" value="Borrar mapa">
													      </div>
													    </div>
													  </div>
													</div>

													</form>
												</div>	
												</center>

											  </div>
											</div>

										</div>

								  	<?php } ?>

									</div><!-- End .row -->

								  	<?php }else{ ?>

										<h4 class="text-secondary text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay ningún mapa creado.</h4>

								  	<?php } ?>

							    </p>

							  </div>

							</div>

					</div>

				</div> <!-- End .card Main -->

			</div> <!-- End .col-md-9 -->
			
		</div> <!-- End .row -->
