<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<meta charset="UTF-8">
		<title>Panel de administrador - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Panel de administrador en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Panel de administrador') ?>
		<?= $template->breadCrumbs(["Panel de administrador" => null]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1>Panel del administrador</h1>
    		
    		<p>A continuación se muestran los enlaces a las distintas operaciones 
    		   de administración de la aplicación <b><?= APP_NAME ?></b>.</p>
    		
    		
        	<div class="flex-container gap2">
        		<section class="flex1">
        			<h2 class="my2">Administración</h2>
        			<ul class="my2">
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
        			
        		</section>
        		
        		<?php if(Login::isAdmin()) {?>
        		<section class="flex1">
        			<h2 class="my2">Gestión de usuarios</h2>
    
        			<ul class="my2">
        				<li><a href='/User'>Lista de usuarios</a> (se implementa en clase)</li>
        				<li><a href='/User/create'>Nuevo usuario</a> (se implementa en clase)</li>
        			</ul>
        		</section>
        		<?php } ?>
    		</div>
    		
    		
    		<div class="flex-container gap2">
        		
        		<section class="flex2 p1">
        			<h2 class="my2">Estadísticas del disco</h2>

					<p>Estas estadísticas muestran el espacio total y disponible del 
					disco o partición en la que se encuentra hospedada la aplicación.</p>
					
					
					
        			<ul class="my2">
        				<?php 
        				    // cálculos
            				$espacioTotal   = disk_total_space('.');
            				$espacioLibre   = disk_free_space('.');
            				$espacioOcupado = $espacioTotal-$espacioLibre;
            				$porcentaje     = $espacioOcupado/$espacioTotal*100;
        				?>
        				<li>
        					<span class="inline-block w50">Espacio total en la partición:</span> 
        					<b><?= round($espacioTotal/1024/1024/1024,2) ?></b> Gb
        				</li>
        				<li>
        					<span class="inline-block w50">Espacio ocupado:</span>
        					<b><?= round($espacioOcupado/1024/1024/1024,2) ?></b> Gb
        				</li>	
        				<li>
        					<span class="inline-block w50">Espacio disponible:</span>
        					<b><?= round($espacioLibre/1024/1024/1024,2) ?></b> Gb
        				</li>
        				<li>
        					<span class="inline-block w50">Porcentaje de ocupación:</span>
        					<b><?= floor($porcentaje) ?></b>%
        				</li>				
        			</ul>	
        			
        			<p class="caution">No corresponden con el espacio de usuario
					disponible en hostings compartidos.</p>
					
					<p>El espacio disponible y total para la cuenta de usuario se
					consulta desde el panel de control del hosting.</p>
					
        		</section>
        		
        		<figure class="flex1">
        			<img src="/images/template/disk.png" alt="estadísticas del disco" title="estadísticas del disco">
        		</figure>
        	</div>
        	
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

