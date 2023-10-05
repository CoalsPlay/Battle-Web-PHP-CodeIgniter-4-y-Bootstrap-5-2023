<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/list_users.gif'); ?>"> Lista de usuarios</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

					<form action="<?= current_url(); ?>" method="get" id="searchForm" class="form-horizontal">

						<div class="input-group mb-3">
						    <input type="search" name="search" class="form-control" placeholder="Buscar enemigo..." aria-describedby="buttonSearch" value="<?= $search; ?>">
							<input class="btn btn-success" type="submit" onclick='document.getElementById("searchForm").submit();' id="buttonSearch" value="Buscar">
						</div>

					</form>
					

					
				  	<table class="table table-striped table-hover ">
					  <thead>
					    <tr>
					      <!--<th>Estado</th>-->
					      <th>Usuario</th>
					      <th>Nivel</th>
					      <th>Redes sociales</th>
					      <th>Fecha de registro</th>
					    </tr>
					  </thead>
					  <tbody>
					  	<?php if(count($usersPag) > 0){ ?>
					  	<?php foreach($usersPag as $row){ ?>
					    <tr>
					      <td><img style="position:relative; top:-1px;" width="25" height="25" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="...">&nbsp;&nbsp; <a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a></td>
					      <td class="hidden-xs"><?= $row['level']; ?></td>
					      <td>
						        <?php
						        	if($row['twitter'] != NULL ){
						        		echo '<a href="https://twitter.com/'.$row['twitter'].'"><img src="'.base_url('/assets/img/redsocial/tw.png').'"></a> ';
						        	}
						        	if($row['facebook'] != NULL ){
						        		echo '<a href="https://facebook.com/'.$row['facebook'].'"><img src="'.base_url('/assets/img/redsocial/fb.png').'"></a> ';
						        	}
						        	if($row['youtube'] != NULL ){
						        		echo '<a href="https://www.youtube.com/user/'.$row['youtube'].'"><img src="'.base_url('/assets/img/redsocial/yt.png').'"></a> ';
						        	}
						        ?>
					      </td>
					      <td><?= $row['registrationDate']; ?></td>
					    </tr>
					  	<?php } ?>
					  	<?php }else{ ?>
							<center><h3 class="text-muted"><i class="fa fa-info-circle" aria-hidden="true"></i> No se ha encontrado a ningún usuario.</h3></center><hr/>
					  	<?php } //First If ?>

					  </tbody>
					</table>
					
					<hr/>
					<!-- Pagination -->
					<?= $pager->links('usersList'); ?>
					<!-- End Pagination -->

				  </div>
				</div>

				<!-- Users Online -->
				<?php //echo $box_onlines; ?>
				<!-- End Users Online -->
				
			</div>
			
		</div>
