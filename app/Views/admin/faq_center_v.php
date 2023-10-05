<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">

				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/book.png'); ?>"> Administración - Centro FAQ</div>

					<div class="card-body">

						<a href="<?= base_url('/admin/faq_add'); ?>">
					  		<button type="button" class="btn btn-success"> + Agregar pregunta y respuesta</button>
					  	</a>

					  	<hr/>

		               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
		                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
		               <?php endif ?>

		               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
		                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
		               <?php endif ?>

						<form method="post" action="<?= current_url(); ?>" class="form-horizontal">
							<?php $validation = \Config\Services::validation(); ?>
							<?= csrf_field(); ?>
								
							<label class="control-label" for="focusedInput">Respuesta</label>
							<textarea class="form-control" style="max-width:100%" name="helpFaq" rows="3" id="textArea" placeholder="Texto de instrucción"><?= $siteInfo['helpFaq']; ?></textarea>
							<span class="text-danger"><?= $validation->getError('helpFaq'); ?></span><br/>

							<input type="submit" name="editTextFaq" class="btn btn-primary" value="Actualizar" >
						</form>

					  	<hr/>

						<?php if(count($getFaq)){ ?>
						<?php foreach($getFaq as $row){ ?>

							<div id="accordion">

								<div class="card" style="margin-top:1px;">

									<div class="card-header">

										<a class="card-link" data-bs-toggle="collapse" href="#collapse<?= $row['idFaq']; ?>">
											<?= $row['titleFaq']; ?>

											<div class="btn-group float-end" role="group" aria-label="Delete Faq">
												<a href="<?= base_url('/admin/faq/edit/'.$row['idFaq']); ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>

												<form method="post" class="btn-group" action="<?= current_url(); ?>">
													<input type="hidden" name="idFaq" value="<?= $row['idFaq']; ?>">
													<a href="#" data-bs-toggle="modal" data-bs-target="#deleteFaq_<?= $row['idFaq']; ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></a>

													<!-- Modal -->
													<div class="modal fade" id="deleteFaq_<?= $row['idFaq']; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteFaqLabel" aria-hidden="true">
													  <div class="modal-dialog">
													    <div class="modal-content">
													      <div class="modal-header">
													        <h5 class="modal-title" id="deleteFaqLabel">¿Estás seguro de eliminar esta FAQ?</h5>
													        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													      </div>
													      <div class="modal-footer">
													        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Cancelar</button>
													        <button type="submit" name="deleteFaq" class="btn btn-danger">Eliminar FAQ</button>
													      </div>
													    </div>
													  </div>
													</div>
												</form>
											</div>			
										</a>
									</div>

									<div id="collapse<?= $row['idFaq']; ?>" class="collapse" data-parent="#accordion">
										<div class="card-body">
												<?= $row['descriptFaq']; ?>
										</div>

									</div>

								</div>

							</div>

						<?php } // End foreach ?>
						<?php }else{ ?>
							<div class="alert alert-info d-flex align-items-center" role="alert">
								<div>
									<h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No hay ninguna pregunta y respuesta.</h4>
								</div>
							</div>
						<?php } ?>

				  </div>

				</div>
				
			</div>
			
		</div>
