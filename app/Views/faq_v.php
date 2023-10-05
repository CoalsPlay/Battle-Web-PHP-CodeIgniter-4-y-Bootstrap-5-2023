<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">

					<div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/book.png'); ?>"> FAQ - Preguntas frecuentes</div>

					<div class="card-body">

						<span class="text-secondary">
							<?= $siteInfo['helpFaq']; ?>
						</span>
						<hr/>	

						<?php if(count($getFaq)){ ?>

						<div class="row">

						<?php foreach($getFaq as $row){ ?>

						<div class="col-md-6">

							<div id="accordion">

								<div class="card mb-3">

									<div class="card-header">

										<a class="card-link" data-bs-toggle="collapse" href="#collapse<?= $row['idFaq']; ?>">
											<?= substr($row['titleFaq'], 0, 30); ?>


										<?php
											if(isset($getSession['userSession']))
											{
												if($userInfo['rank'] > 0)
												{
													echo '
														<a href="'.base_url('/admin/faq/edit/'.$row['idFaq']).'">
															<button type="button" class="btn btn-sm btn-primary float-end">Editar</button>
														</a>';
												}
											}
										?>
																
										</a>

									</div>

									<div id="collapse<?= $row['idFaq']; ?>" class="collapse" data-parent="#accordion">
										<div class="card-body">
											<?= $row['descriptFaq']; ?>
										</div>

									</div>

								</div>

							</div>

						</div>

						<?php } //end foreach ?>

						</div> <!-- End .row -->

						<?php }else{ ?>

							<div class="alert alert-info d-flex align-items-center" role="alert">
									<div>
									  <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay preguntas y respuestas creadas.</h4>
								 </div>
							</div>

						<?php } ?>

					</div> <!-- End .card-body main -->

				</div> <!-- End .card main -->

			</div> <!-- End .col-md-9 -->
				
			</div>
			
		</div>
