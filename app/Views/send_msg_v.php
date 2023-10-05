<div class="row">

			<div class="col-md-3">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/email.png'); ?>"> Panel de mensajería</div>
				  <div class="card-body">
					<div class="list-group list-group-flush">
					  <a href="<?= base_url('/inbox'); ?>" class="list-group-item">
					    <img src="<?= base_url('/assets/img/iconos/email.png'); ?>">&nbsp;&nbsp; Bandeja de entrada 
					    (<b><?= $unreadMsg; ?></b>)
					  </a>
					  <a href="<?= base_url('/sent_msg'); ?>" class="list-group-item">
					    <img src="<?= base_url('/assets/img/iconos/email.png'); ?>">&nbsp;&nbsp; Mensajes enviados
					  </a>
					  <a href="<?= base_url('/send_msg'); ?>" class="list-group-item active">
					  	<img src="<?= base_url('/assets/img/iconos/email_add.png'); ?>">&nbsp;&nbsp; Enviar mensaje
					  </a>
					</div>
				  </div>
				</div>	
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/email_add.png'); ?>"> Enviar mensaje</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.current_url()); ?>
	               <?php endif ?>

				  	<form method="post" action="<?= current_url(); ?>" class="form-horizontal">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<span class="text-danger"><?= $validation->getError('toMsg'); ?></span><br/>
						<div class="form-floating mb-3">
						  <input type="text" name="toMsg" value="<?= set_value('toMsg'); ?>" class="form-control" id="floatingInput" placeholder="Carlos53">
						  <label for="floatingInput">Para: (Usuario)</label>
						</div>
						
						<span class="text-danger"><?= $validation->getError('titleMsg'); ?></span><br/>
						<div class="form-floating mb-3">
						  <input type="text" name="titleMsg" value="<?= set_value('titleMsg'); ?>" class="form-control" id="floatingInput" placeholder="Asunto">
						  <label for="floatingInput">Asunto</label>
						</div>
						
						<span class="text-danger"><?= $validation->getError('textMsg'); ?></span><br/>
						<div class="form-floating">
						  <textarea class="form-control" rows="3" name="textMsg" placeholder="Mensaje" id="floatingTextarea2" style="height: 100px"><?= set_value('textMsg'); ?></textarea>
						  <label for="floatingTextarea2">Mensaje</label>
						</div>
						

						<hr/>
						<input type="submit" name="sendMsg" class="btn btn-primary" value="Enviar mensaje">
					</form>
				  </div>
				</div>
				
			</div>
			
		</div>
