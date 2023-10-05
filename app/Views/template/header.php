<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8" />
		<title><?= $siteInfo['siteName'].' - '.$pag; ?></title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="author" content="CoalsDesigN">
		<meta name="description" content="<?= $siteInfo['siteDescript']; ?>">

		<link rel="shortcut icon" href="<?= base_url('/assets/img/favicon.ico'); ?>" />
		
		<!-- CSS -->
		<link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.min.css'); ?>" />
		<link rel="stylesheet" href="<?= base_url('/assets/css/font-awesome.min.css'); ?>">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
		<link rel="stylesheet" href="https://kit.fontawesome.com/c58c6cbca2.css" crossorigin="anonymous">
		<!-- End JS -->

		<!-- JS -->
		<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
		<script defer src="<?= base_url('/assets/js/bootstrap.min.js'); ?>"></script>
		<script defer src="<?= base_url('/assets/js/holder.js'); ?>"></script>
		<!-- End JS -->

	</head>
	<body style="">
		<?php if(isset($getSession['userSession'])) { ?>
			
		<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
			<div class="container">
			  <a class="navbar-brand" href="<?= base_url(); ?>"><?= $siteInfo['siteName']; ?></a>
			  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		      </button>

			  <div class="collapse navbar-collapse" id="navbarScroll">
			    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
			      <li class="nav-item <?php if($pag == 'Inicio'){ echo "active"; } ?>">
			        <a class="nav-link" href="<?= base_url(); ?>"><img src="<?= base_url('/assets/img/iconos/house.png'); ?>"> Inicio <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item <?php if($pag == 'Tienda'){ echo "active"; } ?>">
			        <a class="nav-link" href="<?= base_url('/shop'); ?>"><img src="<?= base_url('/assets/img/iconos/cart.png'); ?>"> Tienda</a>
			      </li>
			      <li class="nav-item <?php if($pag == 'Inventario'){ echo "active"; } ?>">
			        <a class="nav-link" href="<?= base_url('/inventory'); ?>"><img src="<?= base_url('/assets/img/iconos/briefcase.png'); ?>"> Inventario</a>
			      </li>
			      <li class="nav-item <?php if($pag == 'Mapa'){ echo "active"; } ?>">
			        <a class="nav-link" href="<?= base_url('/map'); ?>"><img src="<?= base_url('/assets/img/iconos/map.png'); ?>"> Mapa</a>
			      </li>
				  <li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" role="button" href="#" id="navbarScrollingDropdown" data-bs-toggle="dropdown" aria-expanded="false">
				          <img src="<?= base_url('/assets/img/iconos/picture.png'); ?>"> Información de <?= $siteInfo['siteName']; ?>
				        </a>

				       	<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
				            <li>
				            	<a class="dropdown-item <?php if($pag == 'TOP'){ echo "active"; } ?>" href="<?= base_url('/top'); ?>"><img src="<?= base_url('/assets/img/iconos/chart_bar.png'); ?>"> Top <?= $siteInfo['maxTop']; ?></a>
				            </li>
				            <li>
				            	<a class="dropdown-item <?php if($pag == 'Lista de Mobs'){ echo "active"; } ?>" href="<?= base_url('/mobs_list'); ?>"><img src="<?= base_url('/assets/img/iconos/bug.png'); ?>"> Lista de enemigos</a>
				            </li>
				            <li>
				            	<a class="dropdown-item <?php if($pag == 'Lista de usuarios'){ echo "active"; } ?>" href="<?= base_url('/users_list'); ?>"><img src="<?= base_url('/assets/img/iconos/list_users.gif'); ?>"> Usuarios</a>
				            </li>
				        	<li>
				        		<a class="dropdown-item <?php if($pag == 'Staff'){ echo "active"; } ?>" href="<?= base_url('/staff'); ?>"><img src="<?= base_url('/assets/img/iconos/icon_security.gif'); ?>"> Staff</a>
				        	</li>
				        	<li>
				        		<a class="dropdown-item <?php if($pag == 'FAQ'){ echo "active"; } ?>" href="<?= base_url('/faq'); ?>"><img src="<?= base_url('/assets/img/iconos/book.png'); ?>"> FAQ</a>
				        	</li>
				        </ul>
				  </li>
			    </ul>

			    <ul class="nav navbar-nav">
					<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img style="position:relative; top:-4px;" width="30" height="30" class="media-object rounded-circle" src="<?= base_url('/assets/img/avatars/'.$userInfo['avatar']); ?>" alt="...">&nbsp; <?= $userInfo['user']; ?> <span class="caret"></span></a>
				        </a>
				        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
				        	<li>
				        		<a class="dropdown-item" href="<?= base_url('/profile/'.$userInfo['user']); ?>"><img src="<?= base_url('/assets/img/iconos/icon_user.gif'); ?>"> Mi Perfil</a>
				        	</li>
				        	<li>
				        		<a class="dropdown-item" href="<?= base_url('/inbox'); ?>"><img src="<?= base_url('/assets/img/iconos/email.png'); ?>"> Mensajes privados (<b><?= $db->unreadMsg($userInfo['id']); ?></b>)</a>
				        	</li>
				        	<li>
				        		<a class="dropdown-item" href="<?= base_url('/friends'); ?>"><img src="<?= base_url('/assets/img/iconos/report_user.png'); ?>"> Amigos y Peticiones (<b><?= $friends; ?></b>)</a>
				        	</li>
				        	<li>
				        		<a class="dropdown-item" href="<?= base_url('/settings'); ?>"><img src="<?= base_url('/assets/img/iconos/cog.png'); ?>"> Configuración</a>
				        	</li>
				        	<li>
				        		<a class="dropdown-item" href="<?= base_url('/report_bug'); ?>"><img src="<?= base_url('/assets/img/iconos/bug_add.png'); ?>"> Reportar Bug</a>
				        	</li>
				        	<li>
				        		<a class="dropdown-item" href="<?= base_url('/suggestion'); ?>"><img src="<?= base_url('/assets/img/iconos/add_sug.png'); ?>"> Crear Sugerencia</a>
				        	</li>
				        	<li>
				        		<?php if($userInfo['rank'] > 0){ ?>
									<a class="dropdown-item bg-info text-white" href="<?= base_url('/admin/administration'); ?>"><img src="<?= base_url('/assets/img/iconos/admin_go.png'); ?>"> Administración</a>
								<?php } ?>
				        	</li>
				        	<li class="dropdown-divider"></li>

				        	<li>
				        		<a class="dropdown-item bg-danger text-white" data-bs-toggle="modal" data-bs-target="#staticBackdrop" href="#"><img src="<?= base_url('/assets/img/iconos/door_in.png'); ?>"> Desconectar</a>
				        	</li>
							
				        </ul>
				    </li>
			    </ul>

			  </div>
			</div>
		</nav><br/><br/><br/><br/>

		<?php }else { ?>

		<nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
			<div class="container">
			  <a class="navbar-brand" href="<?= base_url(); ?>"><?= $siteInfo['siteName']; ?></a>
			  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		      </button>

			  <div class="collapse navbar-collapse" id="navbarScroll">
			    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
			      <li class="nav-item <?php if($pag == 'Inicio'){ echo "active"; } ?>">
			        <a class="nav-link" href="<?= base_url(); ?>"><img src="<?= base_url('/assets/img/iconos/house.png'); ?>"> Inicio <span class="sr-only">(current)</span></a>
			      </li>
			      <li class="nav-item <?php if($pag == 'Registro'){ echo "active"; } ?>">
			        <a class="nav-link" href="<?= base_url('/register'); ?>"><img src="<?= base_url('/assets/img/iconos/user_add.png'); ?>"> Registro</a>
			      </li>
				  <li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				          <img src="<?= base_url('/assets/img/iconos/picture.png'); ?>"> Información de <?= $siteInfo['siteName']; ?>
				        </a>
				        <div class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
				          <a class="dropdown-item <?php if($pag == 'TOP'){ echo "active"; } ?>" href="<?= base_url('/top'); ?>"><img src="<?= base_url('/assets/img/iconos/chart_bar.png'); ?>"> Top <?= $siteInfo['maxTop']; ?></a>
				          <a class="dropdown-item <?php if($pag == 'Lista de usuarios'){ echo "active"; } ?>" href="<?= base_url('/users_list'); ?>"><img src="<?= base_url('/assets/img/iconos/list_users.gif'); ?>"> Usuarios</a>
				          <a class="dropdown-item <?php if($pag == 'Staff'){ echo "active"; } ?>" href="<?= base_url('/staff'); ?>"><img src="<?= base_url('/assets/img/iconos/icon_security.gif'); ?>"> Staff</a>
				          <a class="dropdown-item <?php if($pag == 'FAQ'){ echo "active"; } ?>" href="<?= base_url('/faq'); ?>"><img src="<?= base_url('/assets/img/iconos/book.png'); ?>"> FAQ</a>
				        </div>
				  </li>
			    </ul>

			    <ul class="nav navbar-nav navbar-right">
					<li class="nav-item dropdown">
				        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				          Visitante
				        </a>
				        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
				        	<li>
				        		<a class="dropdown-item" href="<?= base_url('/login'); ?>"><img src="<?= base_url('/assets/img/iconos/door_in.png'); ?>"> Conectarse</a>
				        	</li>
				            <li>
				          		<a class="dropdown-item" href="<?= base_url('/register'); ?>"><img src="<?= base_url('/assets/img/iconos/user_add.png'); ?>"> Registrarse</a>
				            </li>
				          
				        </ul>
				    </li>
			    </ul>

			  </div>
			</div>
		</nav><br/><br/><br/><br/>

		<?php } ?>

		</div>

		<!-- Main container -->
		<div class="container">

			<!-- Modal -->
			<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="staticBackdropLabel">¿Estás seguro de cerrar sesión?</h5>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-footer">
			        <button type="button" data-bs-dismiss="modal" class="btn btn-primary">Cancelar</button>
			        <a href="<?= base_url('/auth/logout'); ?>" class="btn btn-danger">Cerrar sesión</a>
			      </div>
			    </div>
			  </div>
			</div>