<!-- ========================================================================= -->
<!-- Admins options -->
<!-- ========================================================================= -->


				<div class="card">
				  <div class="card-header text-center"><img src="<?= base_url('/assets/img/iconos/cog.png'); ?>"> Opciones</div>
				  <div class="card-body">
					<div class="list-group">
						<a href="<?= base_url('/admin/administration'); ?>" class="list-group-item list-group-item-action">
							<img src="<?= base_url('/assets/img/iconos/house.png'); ?>">&nbsp;&nbsp; Inicio
						</a>
					  <?php
					  	if($userInfo['rank'] == 1){
					  ?>
					  <a href="<?= base_url('/admin/configuration'); ?>" class="list-group-item list-group-item-action">
					    <img src="<?= base_url('/assets/img/iconos/cog.png'); ?>">&nbsp;&nbsp; Configuración
					  </a>
					  <a href="<?= base_url('/admin/game_options'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/wrench.png'); ?>">&nbsp;&nbsp; Opciones del juego
					  </a>
					  <a href="<?= base_url('/admin/users'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/vcard.png'); ?>">&nbsp;&nbsp; Gestor de usuarios
					  </a>
					  <a href="<?= base_url('/admin/ranks'); ?>" class="list-group-item list-group-item-action">
					    <img src="<?= base_url('/assets/img/iconos/icon_security.gif'); ?>">&nbsp;&nbsp; Gestor de Rangos
					  </a>
					  <a href="<?= base_url('/admin/shop'); ?>" class="list-group-item list-group-item-action">
					    <img src="<?= base_url('/assets/img/iconos/cart_edit.png'); ?>">&nbsp;&nbsp; Gestor de tienda
					  </a>
					  <a href="<?= base_url('/admin/categories_and_maps'); ?>" class="list-group-item list-group-item-action">
					    <img src="<?= base_url('/assets/img/iconos/map_go.png'); ?>">&nbsp;&nbsp; Categorías y mapas
					  </a>
					  <a href="<?= base_url('/admin/mobs_manager'); ?>" class="list-group-item list-group-item-action">
					    <img src="<?= base_url('/assets/img/iconos/bomb.png'); ?>">&nbsp;&nbsp; Gestor de enemigos
					  </a>
					  <a href="<?= base_url('/admin/news_manager'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/page_white_edit.png'); ?>">&nbsp;&nbsp; Gestor de noticias
					  </a>
					  <a href="<?= base_url('/admin/feedback'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/sug.png'); ?>">&nbsp;&nbsp; Centro de Feedback
					  </a>
					  <a href="<?= base_url('/admin/faq_center'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/book.png'); ?>">&nbsp;&nbsp; Editar FAQ
					  </a>
					  <?php
					  	}

					  	if($userInfo['rank'] == 2){

					  ?>
					  <a href="<?= base_url('/admin/shop'); ?>" class="list-group-item list-group-item-action">
					    <img src="<?= base_url('/assets/img/iconos/cart_edit.png'); ?>">&nbsp;&nbsp; Gestor de tienda
					  </a>
					  <a href="<?= base_url('/admin/mobs_manager'); ?>" class="list-group-item list-group-item-action">
					    <img src="<?= base_url('/assets/img/iconos/bomb.png'); ?>">&nbsp;&nbsp; Gestor de Mobs
					  </a>
					  <a href="<?= base_url('/admin/news_manager'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/page_white_edit.png'); ?>">&nbsp;&nbsp; Gestor de noticias
					  </a>
					  <a href="<?= base_url('/admin/feedback'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/sug.png'); ?>">&nbsp;&nbsp; Centro de Feedback
					  </a>
					  <a href="<?= base_url('/admin/faq_center'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/book.png'); ?>">&nbsp;&nbsp; Editar FAQ
					  </a>
					  <?php
					  	}

					  	if($userInfo['rank'] == 3){
					  ?>
					  <a href="<?= base_url('/admin/news_manager'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/page_white_edit.png'); ?>">&nbsp;&nbsp; Gestor de noticias
					  </a>
					  <a href="<?= base_url('/admin/feedback'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/sug.png'); ?>">&nbsp;&nbsp; Centro de Feedback
					  </a>
					  <a href="<?= base_url('/admin/faq_center'); ?>" class="list-group-item list-group-item-action">
					  	<img src="<?= base_url('/assets/img/iconos/book.png'); ?>">&nbsp;&nbsp; Editar FAQ
					  </a>
					  <?php
					  	}
					  ?>
					</div>

				  </div>
				</div>