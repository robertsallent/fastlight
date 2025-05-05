<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Panel del administrador - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Panel del administrador en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('AdminPanel') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(["Panel del administrador" => null]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1>Panel del administrador</h1>
    		
    		<p>A continuación se muestran los enlaces a las distintas operaciones 
    		   de administración de la aplicación <b><?= APP_NAME ?></b>.</p>
    		
    		<div class="flex-container gap2">
        		
        		
        		<section class="flex1">
        			<h2>Administración</h2>
        			<ul>
        				<?php if((Login::oneRole(ERROR_ROLES)) && (DB_ERRORS || LOG_ERRORS || LOG_LOGIN_ERRORS)){ ?>
        				<li><a href='/Error/list'>Errores</a></li>
        				<?php } ?>
        				
        				<?php if(SAVE_STATS && Login::oneRole(STATS_ROLES)){ ?>
        				<li><a href='/Stat'>Visitas</a></li>
        				<?php } ?>
        				
        				<?php if(Login::oneRole(TEST_ROLES)){ ?>
           				<li><a href='/Test'>Test</a></li>
						<?php } ?>
        			</ul>
        			<p>Se muestran operaciones a las que tiene acceso el usuario administrador, siempre
        			y cuando se le haya dado permiso en el fichero de configuración.</p>
        		</section>
        		
        		<?php if(Login::isAdmin()) {?>
        		<section class="flex1">
        			<h2>Gestión de usuarios</h2>
    
        			<ul>
        				<li><a href='/User'>Lista de usuarios</a> (TODO)</li>
        				<li><a href='/User/create'>Nuevo usuario</a> (TODO)</li>
        				<li>...</li>
        			</ul>
        			<p>Estas operaciones se implementan en clase, están descritas en los apuntes.</p>
        		</section>
        		<?php } ?>
    		</div>
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

