
<div class="row">

			<div class="col-md-3">

				<!-- Boxs Left -->
				<?= $box_left; ?>
				<!-- End Left -->
				
			</div>
			
			<div class="col-md-9">

				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/cog.png'); ?>"> Opciones y Configuraciones</div>
				  <div class="card-body">

	               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
	                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
	               <?php endif ?>

	               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
	                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
	                   <?php header('Refresh:1; url= '.base_url('/settings/change_information')); ?>
	               <?php endif ?>

					<form method="post" action="<?= current_url(); ?>" class="form-horizontal">
						<?php $validation = \Config\Services::validation(); ?>
						<?= csrf_field(); ?>

						<h3 class="text-secondary">Información</h3>
						<hr/>

						<label for="aboutMe">Sobre mí</label>
						<textarea class="form-control" style="max-width:100%;" name="aboutMe" maxlength="300" rows="3" id="textArea" placeholder="Escribe algo sobre ti. (300 carácteres.)"><?= $userInfo['aboutMe']; ?></textarea>
						<span class="text-danger"><?= $validation->getError('aboutMe'); ?></span><br/>

						<label for="gender">Género</label>
				        <select class="form-control" name="gender" id="select">
				          <option <?php if($userInfo['gender'] == 0){ echo 'selected="selected" '; } ?> value="0">No especificar</option>
				          <option <?php if($userInfo['gender'] == 1){ echo 'selected="selected" '; } ?> value="1">Masculino</option>
				          <option <?php if($userInfo['gender'] == 2){ echo 'selected="selected" '; } ?> value="2">Femenino</option>
				        </select>
				        
				        <!--<h3 class="text-secondary" style="margin-top:50px;">Apariencia</h3>
				        <hr/>

				        <label for="theme">Tema</label>
				        <select class="form-control" name="theme" id="select">
				          <option <?php if($userInfo['theme'] == "bootstrap.min.css"){ echo 'selected="selected" '; } ?> value="bootstrap.min.css">De serie</option>
				          <option <?php if($userInfo['theme'] == "lumen.css"){ echo 'selected="selected" '; } ?> value="lumen.css">Lumen</option>
				          <option <?php if($userInfo['theme'] == "cerulean.css"){ echo 'selected="selected" '; } ?> value="cerulean.css">Cerulean</option>
				          <option <?php if($userInfo['theme'] == "cyborg.css"){ echo 'selected="selected" '; } ?> value="cyborg.css">Cyborg</option>
				          <option <?php if($userInfo['theme'] == "darkly.css"){ echo 'selected="selected" '; } ?> value="darkly.css">Darkly</option>
				          <option <?php if($userInfo['theme'] == "flatly.css"){ echo 'selected="selected" '; } ?> value="flatly.css">Flatly</option>
				          <option <?php if($userInfo['theme'] == "litera.css"){ echo 'selected="selected" '; } ?> value="litera.css">Litera</option>
				          <option <?php if($userInfo['theme'] == "journal.css"){ echo 'selected="selected" '; } ?> value="journal.css">Journal</option>
				          <option <?php if($userInfo['theme'] == "sandstone.css"){ echo 'selected="selected" '; } ?> value="sandstone.css">Sandstone</option>
				          <option <?php if($userInfo['theme'] == "simplex.css"){ echo 'selected="selected" '; } ?> value="simplex.css">Simplex</option>
				          <option <?php if($userInfo['theme'] == "spacelab.css"){ echo 'selected="selected" '; } ?> value="spacelab.css">Spacelab</option>
				          <option <?php if($userInfo['theme'] == "superhero.css"){ echo 'selected="selected" '; } ?> value="superhero.css">Superhero</option>
				          <option <?php if($userInfo['theme'] == "united.css"){ echo 'selected="selected" '; } ?> value="united.css">United</option>
				          <option <?php if($userInfo['theme'] == "yeti.css"){ echo 'selected="selected" '; } ?> value="yeti.css">Yeti</option>
				          <option <?php if($userInfo['theme'] == "materia.css"){ echo 'selected="selected" '; } ?> value="materia.css">Materia</option>
				          <option <?php if($userInfo['theme'] == "cosmo.css"){ echo 'selected="selected" '; } ?> value="cosmo.css">Cosmo</option>
				          <option <?php if($userInfo['theme'] == "minty.css"){ echo 'selected="selected" '; } ?> value="minty.css">Minty</option>
				          <option <?php if($userInfo['theme'] == "solar.css"){ echo 'selected="selected" '; } ?> value="solar.css">Solar</option>
				          <option <?php if($userInfo['theme'] == "lux.css"){ echo 'selected="selected" '; } ?> value="lux.css">Lux</option>
				          <option <?php if($userInfo['theme'] == "pulse.css"){ echo 'selected="selected" '; } ?> value="pulse.css">Pulse</option>
				          <option <?php if($userInfo['theme'] == "sketchy.css"){ echo 'selected="selected" '; } ?> value="sketchy.css">Sketchy</option>
				        </select>
				        <span class="text-danger"><?= $validation->getError('theme'); ?></span><br/>-->

				        <h3 class="text-secondary" style="margin-top:50px;">Redes sociales</h3>
				        <hr/>

				        <label for="twitter">Twitter</label>
						<input type="text" class="form-control"  value="<?= $userInfo['twitter']; ?>" name="twitter" id="inputEmail" placeholder="Usuario de Twitter (sin @)">
						<span class="text-danger"><?= $validation->getError('twitter'); ?></span><br/>

						<label for="facebook">Facebook</label>
						<input type="text" class="form-control" value="<?= $userInfo['facebook']; ?>" name="facebook" id="inputEmail" placeholder="Usuario de Facebook">
						<span class="text-danger"><?= $validation->getError('facebook'); ?></span><br/>

						<label for="youtube">Youtube</label>
						<input type="text" class="form-control" value="<?= $userInfo['youtube'];; ?>" name="youtube" id="inputEmail" placeholder="Usuario de YouTube">
						<span class="text-danger"><?= $validation->getError('youtube'); ?></span><br/>

						<hr/>
						<input type="submit" name="saveInfo" class="btn btn-primary" value="Guardar cambios">
						
					</form>
				  </div>
				</div>
				
			</div>
			
		</div>
