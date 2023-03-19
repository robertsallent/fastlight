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
    		<?= (TEMPLATE)::getCss() ?>
    	</head>
    	<body>
    		<?= (TEMPLATE)::getLogin() ?>
    		<?= (TEMPLATE)::getHeader('Lista de errores') ?>
    		<?= (TEMPLATE)::getMenu() ?>
    		<?= (TEMPLATE)::getBreadCrumbs(["Lista de errores" => '/Error/list']) ?>
    		<?= (TEMPLATE)::getSuccess() ?>
    		<?= (TEMPLATE)::getError() ?>
    		<main>
        		<h1><?= APP_NAME ?></h1>
        		
        		<?php if(DB_ERRORS){ ?>
        		<section>
        		
            		<h2>Lista completa de errores</h2>
        			
        			<p>Utiliza el formulario de búsqueda para filtrar resultados. Las búsquedas 
        			   se mantendrán guardadas aunque cambies de página.</p>
        			   
        			<?php if(!empty($filtro)){?>
            			
        				<form class="filtro derecha" method="POST" action="/Error/list">
        					<label><?= $filtro ?></label>
        					<input class="button" style="display:inline" type="submit" 
        					       name="quitarFiltro" value="Quitar filtro">
        				</form>
            		
        			<?php }else{ ?>
        			
            			<form method="POST" class="filtro derecha" action="/Error/list">
            				<input type="text" name="texto" placeholder="Buscar...">
            				<select name="campo">
            					<option value="level">Nivel</option>
            					<option value="url">URL</option>
            					<option value="message" selected>Mensaje</option>
            					<option value="user">Usuario</option>
            					<option value="ip">IP</option>
            				</select>
            				
            				<label>Ordenar por:</label>
            				<select name="campoOrden">
            					<option value="date" selected>Fecha</option>
            					<option value="level">Nivel</option>
            					<option value="url">URL</option>
            					<option value="message">Mensaje</option>
            					<option value="user">Usuario</option>
            					<option value="ip">IP</option>
            				</select>
            				<input type="radio" name="sentidoOrden" value='ASC'>
            				<label>Ascendente</label>
            				<input type="radio" name="sentidoOrden" value='DESC' checked>
            				<label>Descendente</label>
            				<input class="button" type="submit" name="filtrar" value="Filtrar">
            			</form>
        			<?php } ?>
            			
            			
        			<?php if($errores) { ?>
     	
         				<div class="flex-container">
         					<div class="flex1">
            					<a class="button" href="/Error/clear">Vaciar lista</a>
            				</div>
            				<div class="flex1 derecha">
            					<?= $paginator->stats()?>
            				</div>
            			</div>
            			
            			
            			<table>
                			<tr>
                				<th>Fecha</th>
                				<th>Nivel</th>
                				<th>URL</th>
                				<th>Mensaje</th>
                				<th>Usuario</th>
                				<th>IP</th>
                				<th>Operaciones</th>
                			</tr>
                    		<?php foreach($errores as $error){ ?>
                				<tr>
                    				<td><?=$error->date?></td>
                    				<td><?=$error->level?></td>
                    				<td><?=$error->url?></td>
                    				<td><?=$error->message?></td>
                    				<td><?=$error->user ?? " -- "?></td>
                    				<td><?=$error->ip?></td>
                    				<td><a class="button" href="/Error/destroy/<?= $error->id ?>">Borrar</a></td>
                			   </tr>
                    		<?php } ?>
                		</table>
                		
                		<?= $paginator->ellipsisLinks() ?>
            		
            		<?php }else{ ?>
            			<p class="success">No hay errores que mostrar.</p>
            		<?php } ?>
            	</section>
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
            		<a class="button" href="/Error/erase">Borrar LOG</a>
            		<?php } ?>
            		
            		<?php if(LOG_LOGIN_ERRORS && is_readable(LOGIN_ERRORS_FILE)){ ?>
        			<a class="button" href="/Error/erase/login">Borrar LOG de Login</a>
        			<?php } ?>
        		</section>
        		<?php } ?>
        		
        		<nav class="enlaces centrado">
        			<a class="button" onclick="history.back()">Atrás</a>
        		</nav>
        		
    		</main>
    		<?= (TEMPLATE)::getFooter() ?>
    	</body>
    </html>

