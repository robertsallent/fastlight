<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
            "Panel del administrador",
            "Panel de control con las operaciones principales para el administrador"
        ) ?>           
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
        		<section class="flex3">
        			<h2 class="my2">Administración</h2>
        			<ul class="my2">
        				<?php if((Login::oneRole(ERROR_ROLES)) && (DB_ERRORS || LOG_ERRORS || LOG_LOGIN_ERRORS)){ ?>
        				<li><a href='/Error/list'>Listado de errores</a>.</li>
        				<?php } ?>
        				
        				<?php if(SAVE_STATS && Login::oneRole(STATS_ROLES)){ ?>
        				<li><a href='/Stat'>Recuento de visitas</a>.</li>
        				<?php } ?>
        				
        				<?php if(Login::oneRole(TEST_ROLES)){ ?>
           				<li><a href='/Test'>Ejecución de tests</a>.</li>
						<?php } ?>
						
						<?php if(Login::isAdmin()){ ?>
           				<!-- <li><a href='/Admin/exportdb'>Descargar backup de la BDD (Linux)</a>.</li>  --> 
           				<li><a href='/Admin/exportdbzip'>Descargar backup de la BDD en ZIP (Linux)</a>.</li>
						<?php } ?>
        			</ul>
        			
        			<?php if(Login::isAdmin()){ ?>
        			<p class="caution">Para poder exportar la base de datos, el usuario debe tener 
        			<b>permiso de SELECT y LOCK TABLES</b> y, si hay vistas también necesita <b>SHOW VIEW</b> .</p>
        			<?php } ?>
        			
        		</section>
        		
        		<figure class="flex1 pc">
        			<img src="/images/template/admin.png" alt="Tareas del administrador" title="Tareas del administrador">
        		</figure>
        	</div>
        	
        	<div class="flex-container gap2">	
        	
        		<figure class="flex1 pc">
        			<img src="/images/template/user.png" alt="operaciones con usuarios" title="operaciones con usuarios">
        		</figure>
        	
        	
        		<?php if(Login::isAdmin()) {?>
        		<section class="flex3">
        			<h2 class="my2">Gestión de usuarios</h2>
     				
     				<p class="info">Estas operaciones se implementan en clase, también se puede encontrar
     				la información en la documentación en PDF.</p>
     				
        			<ul class="my2">
        				<li><a href='/User'>Lista de usuarios (TODO)</a></li>
        				<li><a href='/User/create'>Nuevo usuario (TODO)</a></li>
        			</ul>
        		</section>
        		<?php }else{ ?>
        		    
        		    <div class="error p2">
        		    	<h2>PELIGRO</h2>
        		    	<p class="caution">No deberías estar aquí.</p>
        		    </div>
        		    
        		<?php } ?>
    		</div>
    		
    		
    		<div class="flex-container gap2">
        		
        		<section class="flex3 p1">
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
        		
        		<figure class="flex1 pc">
        			<img src="/images/template/disk.png" alt="estadísticas del disco" title="estadísticas del disco">
        		</figure>
        	</div>
        	
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

