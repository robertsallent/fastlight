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
    		<?= $template->acceptCookies() ?>
    		
    		<main>
        		<h1><?= APP_NAME ?></h1>
        		
        		<?php if(DB_ERRORS){ ?>
        		
        		
            		<h2>Errores detectados</h2>
        			
        			<p>Utiliza el formulario de búsqueda para filtrar resultados. Las búsquedas 
        			   se mantendrán guardadas aunque cambies de página.</p>
        			   
        			<?php 
        			
        			// coloca el formulario de filtro
        			echo isset($filtro) ?
        			     $template->removeFilterForm($filtro):
        			     
        			     $template->filterForm(
            			     [
            			         'Tipo' => 'type',
            			         'Clase' => 'level',
            			         'URL' => 'url',
            			         'Mensaje' => 'message',
            			         'Usuario' => 'user',
            			         'Fecha' => 'date'
            			     ],
            			     [
            			         'Tipo' => 'type',
            			         'Clase' => 'level',
            			         'URL' => 'url',
            			         'Mensaje' => 'message',
            			         'Usuario' => 'user',
            			         'Fecha' => 'date'
            			     ], 
            			     'Clase',
            			     'Fecha'
		            );

        			     
        			if($errores) { ?>
     	
        				<div class="derecha">
        					<?= $paginator->stats()?>
        				</div>
        		
            			<table class="table w100 drop-shadow">
                			<tr>
                				<th>Tipo</th>
                				<th>URL</th>
                				<th>Clase</th>
                				<th>Fecha</th>
                				<th>Mensaje</th>
                				<th>Usuario</th>
                				<th>IP</th>
                				<th class="centrado">Acciones</th>
                			</tr>
                    		<?php foreach($errores as $error){ ?>
                				<tr>
                					<td class="negrita"><?=$error->type?></td>
                					<td class='url mini'>
                    					<a href="<?=$error->url?>"><?=$error->url?></a>
                    				</td>
                    				<td class='negrita'><?=$error->level?></td>
                    				<td class="mini"><?=$error->date?></td>
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
                    					<a class="button-danger" href="/Error/destroy/<?= $error->id ?>">Borrar</a>
                					</td>
                			   </tr>
                    		<?php } ?>
                		</table>
                		
                		<?= $paginator->ellipsisLinks() ?>
            		
     					<div class="flex-container my2">
     						<div class="flex1">
        						<a class="button-danger" href="/Error/clear">Vaciar lista</a>
        					</div>
        					
        					<?= $template->exportForm('/Error/export') ?>
        				</div>
        				
        				
        				<section id="summary mt2">
                    		<h2>Resumen de errores</h2>
                    		
                    		<p>A continuación se muestra un resumen de la cantidad de errores de cada clase y de cada
                    		tipo (WEB o API):</p>
                    		
                    		<div class="flex-container gap2">
                        		<table class="table drop-shadow flex1 valign-up">
                        			<tr>
                        				<th>Clase</th>
                        				<th>Ocurrencias</th>
                        			</tr>
                        			<?php foreach($summary as $line){?>
                        			<tr>
                        				<td><?= $line->level ?></td>
                        				<td><?= $line->idcount ?></td>
                        			</tr>     
                        			<?php } ?>
                        		</table>
                        		
                        		<table class="table drop-shadow flex1 valign-up">
                        			<tr>
                        				<th>Tipo</th>
                        				<th>Ocurrencias</th>
                        			</tr>
                        			<?php foreach($types as $line){?>
                        			<tr>
                        				<td><?= $line->type ?></td>
                        				<td><?= $line->idcount ?></td>
                        			</tr>     
                        			<?php } ?>
                        		</table>
                        		
                        	</div>
                    	</section>

            		<?php }else{ ?>
            			<div class="success my2 p3 centrado">
            				<p>No hay errores que mostrar.</p>
            			</div>
            		<?php } ?>
            	
            	<?php } ?>
        		
        		
        		
            	
            	
        		<?php if(LOG_ERRORS || LOG_LOGIN_ERRORS){ ?>
        		<section>
            		<h2>Ficheros de LOG</h2>
            		<p>Los ficheros de <i>log</i> sirven para <b>guardar los errores producidos en tiempo de ejecución
            		de la aplicación</b> en ficheros de texto.</p>
            		 
            		<p>Los datos no se borrarán aunque vaciemos la tabla de errores de la BDD, para hacerlo 
            		se debe eliminar expresamente el fichero pulsando el botón "borrar" o directamente en el sistema de 
            		ficheros del servidor.</p>
            		
            		<p>El tamaño máximo configurado para los ficheros de <i>LOG</i> es de <b><?= formatInt(LOG_MAX_SIZE) ?> bytes</b>.</p>
            		
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

