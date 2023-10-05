
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
					  <a href="<?= base_url('/sent_msg'); ?>" class="list-group-item active">
					    <img src="<?= base_url('/assets/img/iconos/email.png'); ?>">&nbsp;&nbsp; Mensajes enviados
					  </a>
					  <a href="<?= base_url('/send_msg'); ?>" class="list-group-item">
					  	<img src="<?= base_url('/assets/img/iconos/email_add.png'); ?>">&nbsp;&nbsp; Enviar mensaje
					  </a>
					</div>
				  </div>
				</div>	
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/email.png'); ?>"> Mensajes enviados</div>
				  <div class="card-body">

					<?php if(count($getMsg)){ ?>

					<table class="table table-striped table-hover ">
					  <thead>
					    <tr>
					      <th>Estado</th>
					      <th>Asunto</th>
					      <th>Para:</th>
					      <th>Fecha</th>
					    </tr>
					  </thead>
					  <tbody>

					<?php foreach($getMsg as $row){ ?>

					    <tr>
					      <td>

					      	<?php 
					      		if($row['statusMsg'] == 0)
					      		{
					      			echo '<img src="'.base_url('/assets/img/iconos/email.png').'" title="Sin leer">';
					      		}elseif($row['statusMsg'] == 1){
					      			echo '<img src="'.base_url('/assets/img/iconos/email_open.png').'" title="Leído">';
					      		}
					      	?>

					      </td>
					      <td id="messages"><a href="#message_<?= $row['idMsg']; ?>"><?= substr(htmlspecialchars($row['titleMsg']), 0, 30); ?></a></td>
					      <td><a href="<?= base_url('/profile/'.$row['receiverNameMsg']); ?>"><?= $row['receiverNameMsg']; ?></a>
					      </td>
					      <td><?= $row['dateMsg']; ?></td>
					    </tr>

					<?php } ?>

					  </tbody>
					</table>

					<?php }else{ ?>

							<div class="alert alert-info d-flex align-items-center" role="alert">
							  <div>
							    <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No has enviado ningún mensaje.</h4>
							  </div>
							</div>

					<?php } ?>

						<hr/>

					  	<?php if(count($getMsg)){ ?>

						<div data-bs-spy="scroll" data-bs-target="#messages" data-bs-offset="0" class="scrollspy-example text-secondary">

					  	<?php foreach($getMsg as $row){ ?>
							<div class="card" id="message_<?= $row['idMsg']; ?>">
							  <div class="card-header" style="word-wrap: break-word;"><u><h4><?= htmlspecialchars($row['titleMsg']); ?></h4></u></div>
							  <div class="card-body" style="word-wrap: break-word;">
						    	<?= htmlspecialchars($row['textMsg']); ?>
							  </div>
							  <div class="card-footer">
							  	<small>De: <a href="<?= base_url('/profile/'.$row['user']); ?>"><img style="position:relative; top:-4px; margin-right:5px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="..."> <?= $row['user']; ?></td>
					      <td></a>Para: <a href="<?= base_url('/profile/'.$row['receiverNameMsg']); ?>"> <?= $row['receiverNameMsg']; ?></a>&nbsp; el:&nbsp; <i><?= $row['dateMsg']; ?></i></small>
							  </div>
							</div>
							<br/>

					    <?php } ?>

						</div><hr/>

					    <?php } // End If ?>

					
					<!-- Pagination -->
					<?= $pager->links('msgList'); ?>
					<!-- End Pagination -->

				  </div>
				</div>
				
			</div>
			
		</div>
