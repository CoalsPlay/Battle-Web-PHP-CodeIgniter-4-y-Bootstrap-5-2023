<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/sug.png'); ?>"> Administración - Centro de soporte</div>

				  <div class="card-body">

					<ul class="nav nav-tabs">
					  <li class="nav-item">
					    <a class="nav-link active" data-bs-toggle="tab" href="#bugs"><img src="<?= base_url('/assets/img/iconos/bug.png'); ?>"> Bugs</a>
					  </li>
					  <li class="nav-item">
					    <a class="nav-link" data-bs-toggle="tab" href="#suggestions"><img src="<?= base_url('/assets/img/iconos/sug.png'); ?>"> Sugerencias</a>
					  </li>
					</ul>
					<div id="myTabContent" class="tab-content">
					  <div class="tab-pane fade show active" id="bugs">
					  	<p>

						  	<?php if(count($data_bug)){ ?>
						  	<?php foreach($data_bug as $row){ ?>
						  		
							<div class="card mb-3">
								<div class="card-body" style="word-wrap: break-word;">
								  <?= htmlspecialchars($row['textBug']); ?>
								  <hr>
								  <small><a href="<?= base_url('/profile/'.$row['user']); ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."><?= $row['user']; ?></a>&nbsp; el:&nbsp; <i><?= $row['dateBug']; ?></i></small>
								</div>
							</div>

							<?php } // End foreach ?>
							<?php }else{ ?>
								<br/>
								<center><h3 class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ningún bug reportado.</h3></center>
							<?php } ?>

						</p>
					  </div>

					  <div class="tab-pane fade" id="suggestions">
					    <p>
					    	
						  	<?php if(count($data_sugg)){ ?>
						  	<?php foreach($data_sugg as $row){ ?>

							<div class="card mb-3">
								<div class="card-body" style="word-wrap: break-word;">
									<?= htmlspecialchars($row['textSuggestion']); ?>
									<hr/>
									<small><a href="<?= base_url('/profile/'.$row['user']); ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."><?= $row['user']; ?></a>&nbsp; el:&nbsp; <i><?= $row['dateSuggestion']; ?></i></small>
								</div>
							</div>
							
							<?php } // End foreach ?>
							<?php }else{ ?>
								<br/>
								<center><h3 class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> Actualmente no hay ninguna sugerencia.</h3></center>
							<?php } ?>

					    </p>
					  </div>
					</div>

				  </div> <!-- End .card-body Main -->

				</div> <!-- End .card Main -->
				
			</div> <!-- End .col-md-9 -->
			
		</div> <!-- End .row -->
