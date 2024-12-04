    <!DOCTYPE html>
    <html lang="es">
    	<head>
    		<meta charset="UTF-8">
			<title>Listado de errores en  - <?= APP_NAME ?></title>
		
    		<!-- META -->
    		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<meta name="description" content="Lista de errores en <?= APP_NAME ?>">
    		<meta name="author" content="Robert Sallent">
    		
    		<!-- FAVICON -->
    		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
    		
    		<!-- CSS -->
    		<?= $template->css() ?>
    	</head>
    	<body>
    		<?= $template->login() ?>
    		<?= $template->header('Lista de errores') ?>
    		<?= $template->menu() ?>
    		<?= $template->breadCrumbs(["Lista de errores" => NULL]) ?>
    		<?= $template->messages() ?>
    		
    		<main>
        		<h1><?= APP_NAME ?></h1>
        		
        		<?php if(DB_ERRORS){ ?>
        		
        		
            		<h2>Lista completa de errores</h2>
        			
        			<p>Utiliza el formulario de búsqueda para filtrar resultados. Las búsquedas 
        			   se mantendrán guardadas aunque cambies de página.</p>
        			   
        			<?php 
        			
        			// coloca el formulario de filtro
        			echo isset($filtro) ?
        			     $template->removeFilterForm($filtro):
        			     
        			     $template->filterForm(
            			     [
            			         'Tipo' => 'level',
            			         'URL' => 'url',
            			         'Mensaje' => 'message',
            			         'Usuario' => 'user'
            			     ],
            			     [
            			         'Tipo' => 'level',
            			         'URL' => 'url',
            			         'Mensaje' => 'message',
            			         'Usuario' => 'user',
            			         'Fecha' => 'date'
            			     ], 
            			     'Tipo',
            			     'Fecha'
		            );

        			     
        			if($errores) { ?>
     	
         				<div class="flex-container">
         					<div class="flex1">
            					<a class="button button-danger" href="/Error/clear">Vaciar lista</a>
            				</div>
            				<div class="flex1 derecha">
            					<?= $paginator->stats()?>
            				</div>
            			</div>
            			
            			
            			<table class="table w100">
                			<tr>
                				<th>Fecha</th>
                				<th>Tipo</th>
                				<th>URL</th>
                				<th>Mensaje</th>
                				<th>Usuario</th>
                				<th>IP</th>
                				<th class="centrado">Acciones</th>
                			</tr>
                    		<?php foreach($errores as $error){ ?>
                				<tr>
                    				<td><?=$error->date?></td>
                    				<td class='negrita'><?=$error->level?></td>
                    				<td class='cursiva'>
                    					<a href="<?=$error->url?>"><?=$error->url?></a>
                    				</td>
                    				<td class="mini"><?=$error->message?></td>
                    				<td>
                    					<?php if($error->user){ ?>
                    						<a href="mailto:<?= $error->user?>"><?=$error->user ?></a>
                    					<?php }else{ 
                    						echo "Invitado";
                    				    }?>
                					</td>
                    				<td><?=$error->ip?></td>
                    				<td class="centrado">
                    					<a class="button button-danger" href="/Error/destroy/<?= $error->id ?>">Borrar</a>
                					</td>
                			   </tr>
                    		<?php } ?>
                		</table>
                		
                		<?= $paginator->ellipsisLinks() ?>
            		
            		<?php }else{ ?>
            			<p class="success">No hay errores que mostrar.</p>
            		<?php } ?>
            	
            	<?php } ?>
        		
        		<?php if(LOG_ERRORS || LOG_LOGIN_ERRORS){ ?>
        		<section>
            		<h2>Ficheros de LOG</h2>
            		<p>Los ficheros de log sirven para registrar errores en disco.</p>
            		
            		<h3>Descargar</h3>
            		
            		<p>Puedes descargar los ficheros de log mediante los siguientes enlaces 
            		   (no se muestran si no existen ficheros de LOG).</p>
            		   
            		<?php if(LOG_ERRORS && is_readable(ERROR_LOG_FILE)){ ?>
            		<a class="button" href="/Error/download">Descargar LOG</a>
            		<?php } ?>
            		
            		<?php if(LOG_LOGIN_ERRORS && is_readable(LOGIN_ERRORS_FILE)){ ?>
        			<a class="button" href="/Error/download/login">Descargar errores de LogIn</a>
        			<?php } ?>
        			     			
            		<h3>Borrar</h3>
            		<p>Puedes eliminar los ficheros de log mediante los siguientes enlaces 
            		   (no se muestran si no existen ficheros de LOG).</p>
            		   
            		<?php if(LOG_ERRORS && is_readable(ERROR_LOG_FILE)){ ?>
            		<a class="button button-danger" href="/Error/erase">Borrar LOG</a>
            		<?php } ?>
            		
            		<?php if(LOG_LOGIN_ERRORS && is_readable(LOGIN_ERRORS_FILE)){ ?>
        			<a class="button button-danger" href="/Error/erase/login">Borrar LOG de Login</a>
        			<?php } ?>
        		</section>
        		<?php } ?>
        		
        		<nav class="enlaces centrado">
        			<a class="button" onclick="history.back()">Atrás</a>
        		</nav>
        		
    		</main>
    		<?= $template->footer() ?>
    		<?= $template->version() ?>
    	</body>
    </html>

