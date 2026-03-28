    <!DOCTYPE html>
    <html lang="<?= LANGUAGE_CODE ?>">
    	<head>
    		<?= $template->metaData(
                "Listado de errores",
                "Listado de errores en tiempo de ejecución"
            ) ?>           
            <?= $template->css() ?>
    	</head>
    	
    	<body>
    		<?= $template->login() ?>
			<?= $template->menu() ?>
    		<?= $template->header(null, 'Lista de errores detectados en tiempo de ejecución') ?>
    		<?= $template->breadCrumbs([
		              "Panel de administrador" => "/Admin",
    		          "Lista de errores" => NULL  
    		      ]);
    		?>
    		<?= $template->messages() ?>
    		<?= $template->acceptCookies() ?>
    		
    		<main>
        		<h1><?= APP_NAME ?></h1>
        		
        		<?php if(DB_ERRORS){ ?>
        		
        		
            		<h2 id="errors">Errores detectados</h2>
        			
        			<p>A continuación se muestran los <b>errores detectados en tiempo de ejecución</b>.
        			Esta herramienta es útil para detectar tanto errores como distintos tipos
        			de ataques informáticos.</p>
        			
     
        			<?php 
        			
        			// coloca el formulario para poner o quitar filtro
        			echo $template->filter(
            			// opciones para el desplegable "buscar en"
            			[
                			'Tipo' => 'type',
                			'Clase' => 'level',
                			'URL' => 'url',
                			'Mensaje' => 'message',
                			'Usuario' => 'user',
                			'Fecha' => 'date'
        			    ],
        			    
        			    // opciones para el desplegable "ordenar por"
        			    [
            			    'Tipo' => 'type',
            			    'Clase' => 'level',
            			    'URL' => 'url',
            			    'Mensaje' => 'message',
            			    'Usuario' => 'user',
            			    'Fecha' => 'date'
            		    ],
            		    'Clase', // opción seleccionada por defecto en "buscar en"
            		    'Fecha', // opción seleccionada por defecto en "ordenar por"
            		    $filtro  // filtro aplicado (null si no hay) - viene del controlador
        		    );

        			     
        			if($errores) { ?>
        				<div class="right">
        					<?= $paginator->stats()?>
        				</div>
        		
            			<div class="grid-list">
                    		<div class="grid-list-header">
                                <span>Tipo</span>
                                <span class="span3">URL</span>
                                <span class="span2">Clase</span>
                                <span class="span2">Fecha</span>
                                <span class="span3">Usuario e IP</span>
                              	<span class="right">Acciones</span>
                    		</div>
                    		                    		
                    		<?php foreach($errores as $error){ ?>
                				<div class="grid-list-item">
                					<span data-label="Tipo" class="bold"><?=$error->type?></span>
                					<span data-label="URL" class='url span3'>
                    					<a href="<?=$error->url?>"><?=$error->url?></a>
                    				</span>
                    				<span title="<?=$error->message?>" class='bold span2' data-label="Clase"><?=$error->level?></span>
                    				<span class="span2" data-label="Fecha"><?=$error->date?></span>
                    				<span class="span3" data-label="Usuario e IP">
                    					<?php if($error->user){ ?>
                    						<a href="mailto:<?= $error->user?>"><?=$error->user ?></a>
                    					<?php } ?>
                					(<?=$error->ip?>)</span>
                    				<span data-label="Acciones" class="right">
										<a class="button-danger action-icon" href="/Error/destroy/<?= $error->id ?>">
											<img src="/images/icons/delete.png" alt="Borrar" title="Borrar registro">
										</a>
                					</span>
                			   </div>
                    		<?php } ?>
                    		
                    	</div>
                		
                		<?= $paginator->ellipsisLinks() ?>
            		
     					<section class="my2">
     						<h2>Operaciones</h2>
     						<p class="info">Pulsa el botón para vaciar el registro de errores. 
     						Esta operación no se puede deshacer.</p>
     						<div class="phone-centered">
     							<a class="button-danger phone75" href="/Error/clear">Vaciar lista</a>
     						</div>
        				</section>
        					
        				<?= $template->exportForm('/Error/export') ?>
        				
        				
        				<section id="summary" class="mt1 pc">
                    		<h2>Resumen de errores</h2>
                    		
                    		<p>A continuación se muestra un resumen del total de errores de cada clase y 
                    		tipo (WEB o API):</p>
                    		
                    		<p class="info">Utiliza los botones para aplicar filtros directamente.</p>
                    		
                    		
                    		<div class="flex-container gap2">
                        		<div class="grid-list flex1 my1">
                            		<div class="grid-list-header">
                                        <span>Clase</span>
                                        <span>Ocurrencias</span>
                                        <span>Operaciones</span>
                            		</div>
                        	
                        			<?php foreach($summary as $line){?>
                    				<form method="post" action="/Error/list#errors" class="grid-list-item no-border">
                        				<span data-label="Nivel"><?= $line->level ?></span>
                        				<span data-label="Recuento"><?= $line->idcount ?></span>
                        				<span data-label="Operaciones">
                        						<input type="hidden" name="_campo" value="level">
                        						<input type="hidden" name="_texto" value="<?= $line->level ?>">
                        						<input type="hidden" name="_campoOrden" value="date">
                        						<input type="hidden" name="_sentidoOrden" value="DESC">
                        						<input type="submit" class="button-light" name="_filtrar" value="Filtrar por clase">
                        					
                        				</span>
                    				</form>
                        			<?php } ?>
                        		</div>
                        		
                        		<div class="grid-list flex1 my1">
                            		<div class="grid-list-header">
                                        <span>Tipo</span>
                                        <span>Ocurrencias</span>
                                        <span>Operaciones</span>
                            		</div>
    
                        			<?php foreach($types as $line){?>
                        			<form method="post" action="/Error/list#errors" class="grid-list-item no-border">
                        				<span data-label="Tipo"><?= $line->type ?></span>
                        				<span data-label="Recuento"><?= $line->idcount ?></span>
                        				<span data-label="Operaciones">
                       						<input type="hidden" name="_campo" value="type">
                    						<input type="hidden" name="_texto" value="<?= $line->type ?>">
                    						<input type="hidden" name="_campoOrden" value="date">
                    						<input type="hidden" name="_sentidoOrden" value="DESC">
                    						<input type="submit" class="button-light" name="_filtrar" value="Filtrar por tipo">
                        				</span>
                        			</form>   
                        			<?php } ?>
                        		</div>
                        		
                        	</div>
                    	</section>

            		<?php }else{ ?>
            			<div class="success my2 p3 centrado">
            				<p>No hay errores que mostrar.</p>
            			</div>
            		<?php } ?>
            	
            	<?php } ?>
        		
        		
        		
            	
            	
        		<?php if(LOG_ERRORS || LOG_LOGIN_ERRORS){ ?>
        		<section id="logs">
            		<h2>Ficheros de registro en disco</h2>
            		
            		<p class="info">Los ficheros de registro o <i>LOG</i> permiten <b>guardar los 
            		errores producidos en tiempo de ejecución</b> en ficheros de texto. Se pueden guardar
            		tanto los errores de ejecución como los errores de identificación.</p>
            		
            		<p class="pc">Son una herramienta complementaria al registro de errores en base de datos, se
            		pueden activar o desactivar estas características de forma independiente.</p>
            		 
            		<p class="pc">Los datos no se borrarán aunque vaciemos la tabla de errores de la BDD, para hacerlo 
            		se debe eliminar expresamente el fichero pulsando el botón "borrar" o directamente en el sistema de 
            		ficheros del servidor.</p>
            		
            		<p class="caution">El tamaño máximo configurado para los ficheros de <i>LOG</i> es de <b><?= formatInt(LOG_MAX_SIZE) ?> bytes</b>.</p>
            		
            		
            		<h3>Descarga de ficheros</h3>
            		
            		<p class="info">Descarga los ficheros mediante los siguientes enlaces 
            		   (no se muestran si no existen ficheros de LOG).</p>
            		   
            		   
            		<div class="phone-centered">
                		<?php if(LOG_ERRORS && is_readable(ERROR_LOG_FILE)){ ?>
                		<a class="button-success phone75" href="/Error/download">Fichero de registro</a>
                		<?php } ?>
                		
                		<?php if(LOG_LOGIN_ERRORS && is_readable(LOGIN_ERRORS_FILE)){ ?>
            			<a class="button-success phone75" href="/Error/download/login">Fichero de Login</a>
            			<?php } ?>
        			</div>
        			     			
            		<h3>Borrado de ficheros</h3>
            		<p class="info">Puedes eliminar los ficheros de log mediante los siguientes enlaces 
            		   (no se muestran si no existen ficheros de LOG). Esta operación no se puede deshacer.</p>
            		   
            		<div class="phone-centered">
                		<?php if(LOG_ERRORS && is_readable(ERROR_LOG_FILE)){ ?>
                		<a class="button-danger phone75" href="/Error/erase">Borrar fichero de registro</a>
                		<?php } ?>
                		
                		<?php if(LOG_LOGIN_ERRORS && is_readable(LOGIN_ERRORS_FILE)){ ?>
            			<a class="button-danger phone75" href="/Error/erase/login">Borrar fichero de Login</a>
            			<?php } ?>
        			</div>
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

