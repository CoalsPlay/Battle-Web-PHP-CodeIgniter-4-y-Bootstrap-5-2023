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
						    <input type="search" name="search" class="form-control" placeholder="Buscar usuario..." aria-describedby="buttonSearch" value="<?= $search; ?>">
						    <input class="btn btn-success" type="submit" onclick='document.getElementById("searchForm").submit();' id="buttonSearch" value="Buscar">
						</div>

					</form>

				  	<table class="table table-striped">
					  <thead>
					    <tr>
							<th>Id</th>
					    	<th>Usuario</th>
					    	<th>Email</th>
					    	<th>Acción</th>
					    </tr>
					  </thead>
					  <tbody>

					  	<?php if(count($usersPag) > 0){ ?>
					  	<?php foreach($usersPag as $row){ ?>
					    <tr>
						  <td><?= $row['id']; ?></td>
					      <td><img style="position:relative; top:-1px;" width="30" height="30" class="media-object rounded-circle pull-left" src="<?= base_url('/assets/img/avatars/'.$row['avatar']); ?>" alt="...">&nbsp;&nbsp; <a href="<?= base_url('/profile/'.$row['user']); ?>"><?= $row['user']; ?></a></td>
					      <td class="hidden-xs"><?= $row['email']; ?></td>
					      <td>
					      	<a href="<?= base_url('/admin/user/edit/'.$row['id']); ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i></a>
					      </td>
					    </tr>
					  	<?php } ?>
					  	<?php }else{ ?>
							<div class="alert alert-info d-flex align-items-center" role="alert">
									<div>
									  <h4 class="text-center"><i class="fa fa-info-circle" aria-hidden="true"></i> No se ha encontrado a ningún usuario.</h4>
								 </div>
							</div>
					  	<?php } //First If ?>

					  </tbody>
					</table>

					<hr/>
					<!-- Pagination -->
					<?= $pager->links('usersList'); ?>
					<!-- End Pagination -->

				  </div>
				</div>
				
			</div>
			
		</div>
