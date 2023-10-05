<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">
				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/page_white_edit.png'); ?>"> Administración - Edición de usuario: <b><?= $userData['user']; ?></b></div>
				  <div class="card-body">

					<nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
					  <ol class="breadcrumb">
					    <li class="breadcrumb-item"><a href="<?= base_url('/admin/users'); ?>">Usuarios</a></li>
					    <li class="breadcrumb-item active" aria-current="page"><a href="<?= base_url('/profile/'.$userData['user']); ?>"><?= $userData['user']; ?></a></li>
					  </ol>
					</nav>
					<hr/>

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.current_url()); ?>
	               <?php endif ?>

				  	<div class="col-md-12">

				  		<div class="row">

							<div class="col-md-6">
								<form method="post" action="<?= current_url(); ?>">
									<?php $validation = \Config\Services::validation(); ?>
									<?= csrf_field(); ?>

									<label>Usuario</label>
									<input type="text" class="form-control" id="inputEmail" name="user" value="<?= $userData['user']; ?>">
									<span class="text-danger"><?= $validation->getError('user'); ?></span><br/>


									<label>Email</label>
									<input type="text" class="form-control" id="inputEmail" name="email" value="<?= $userData['email']; ?>">
									<span class="text-danger"><?= $validation->getError('email'); ?></span><br/>

									<label class="control-label" for="disabledInput">Ip</label>
									<input class="form-control" id="disabledInput" type="text" name="ip" value="<?= $userData['ip']; ?>" disabled="disabled"><br/>

									<label class="control-label" for="focusedInput">Sobre mi</label>
									<textarea class="form-control" style="max-width:100%" placeholder="Información no especificada" name="aboutMe" rows="5" id="textArea"><?= $userData['aboutMe']; ?></textarea>
									<span class="text-danger"><?= $validation->getError('aboutMe'); ?></span><br/>

									<label class="control-label" for="disabledInput">Fecha de registro</label>
									<input class="form-control" id="disabledInput" type="text" name="fecha_registro" value="<?= $userData['registrationDate'].' '.$userData['registrationTime']; ?>" disabled="disabled"><br/>

									<label class="control-label" for="focusedInput">Twitter</label>
									<input type="text" class="form-control" name="twitter"placeholder="Información no especificada" id="inputEmail" value="<?= $userData['twitter']; ?>">
									<span class="text-danger"><?= $validation->getError('twitter'); ?></span><br/>

									<label class="control-label" for="focusedInput">Facebook</label>
									<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="facebook" value="<?= $userData['facebook']; ?>">
									<span class="text-danger"><?= $validation->getError('facebook'); ?></span><br/>

									<label class="control-label" for="focusedInput">Youtube</label>
									<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="youtube" value="<?= $userData['youtube']; ?>">
									<span class="text-danger"><?= $validation->getError('youtube'); ?></span><br/>

									<label class="control-label" for="focusedInput">Nivel</label>
									<input type="text" class="form-control" id="inputEmail" name="level" value="<?= $userData['level']; ?>">
									<span class="text-danger"><?= $validation->getError('level'); ?></span><br/>

									<label class="control-label" for="focusedInput"><?= $siteInfo['moneyName']; ?></label>
									<input type="text" class="form-control" id="inputEmail" name="money" value="<?= $userData['gold']; ?>">
									<span class="text-danger"><?= $validation->getError('money'); ?></span><br/>
							</div> <!-- End .col-md-6 -->

							<div class="col-md-6">

									<label class="control-label" for="focusedInput">Enemigos derrotados</label>
									<input type="text" class="form-control" id="inputEmail" name="kills" value="<?= $userData['kills']; ?>">
									<span class="text-danger"><?= $validation->getError('kills'); ?></span><br/>

									<label class="control-label" for="focusedInput">Reputación</label>
									<input type="text" class="form-control" id="inputEmail" name="reputation" value="<?= $userData['reputation']; ?>">
									<span class="text-danger"><?= $validation->getError('reputation'); ?></span><br/>

									<label class="control-label" for="disabledInput">Experiencia</label>
									<input class="form-control" id="disabledInput" type="text" name="exp" value="<?= $userData['exp']; ?>" disabled="disabled">
									<span class="text-danger"><?= $validation->getError('exp'); ?></span><br/>

									<label class="control-label" for="disabledInput">Energía</label>
									<input class="form-control" id="disabledInput" type="text" name="energy" value="<?= $userData['energy']; ?>">
									<span class="text-danger"><?= $validation->getError('energy'); ?></span><br/>

									<label class="control-label" for="disabledInput">Energía máxima</label>
									<input class="form-control" id="disabledInput" type="text" name="maxEnergy" value="<?= $userData['maxEnergy']; ?>">
									<span class="text-danger"><?= $validation->getError('maxEnergy'); ?></span><br/>

									<label class="control-label" for="focusedInput">Ataque</label>
									<input type="text" class="form-control" id="inputEmail" name="attack" value="<?= $userData['attack']; ?>">
									<span class="text-danger"><?= $validation->getError('attack'); ?></span><br/>

									<label class="control-label" for="focusedInput">Salud</label>
									<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="health" value="<?= $userData['health']; ?>">
									<span class="text-danger"><?= $validation->getError('health'); ?></span><br/>

									<label class="control-label" for="focusedInput">Salud máxima</label>
									<input type="text" class="form-control" placeholder="Información no especificada" id="inputEmail" name="maxHealth" value="<?= $userData['maxHealth']; ?>">
									<span class="text-danger"><?= $validation->getError('maxHealth'); ?></span><br/>

									<hr/>
									<input type="submit" name="updateUser" class="btn btn-primary" value="Guardar cambios">
									<a href="" data-bs-toggle="modal" data-bs-target="#deleteUser" class="btn btn-danger">Borrar usuario</a>

									<!-- Modal -->
									<div class="modal fade" id="deleteUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteFriendLabel" aria-hidden="true">
									  <div class="modal-dialog">
									    <div class="modal-content">
									      <div class="modal-header">
									        <h5 class="modal-title" id="deleteUserLabel">¿Estás seguro de eliminar a <?= $userData['user']; ?>?</h5>
									        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									      </div>
									      <div class="modal-body">
									        <p class="text-danger"><b>Esta acción no se puede revertir.</b></p>
									        <p class="text-danger"><b>Se borrará desde noticias, hasta comentarios y toda información del usuario dejado en el sitio.</b></p>
									      </div>
									      <div class="modal-footer">
									        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Cancelar</button>
									        <input type="submit" data-bs-toggle="modal" data-bs-target="#deleteUser" name="deleteUser" class="btn btn-danger" value="Borrar usuario">
									      </div>
									    </div>
									  </div>
									</div>

								</form>

							</div> <!-- End .col-md-6 -->
						</div> <!-- End .row -->

					</div>
				  </div>
				<?php //} ?>
				</div>
		

			</div>
			
		</div>
