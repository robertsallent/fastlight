    <!DOCTYPE html>
    <html lang="es">
    	<head>
    		<meta charset="UTF-8">
    		<title><?= APP_NAME ?></title>
    		<link rel="stylesheet" type="text/css" href="/css/estilo.css">
    	</head>
    	<body>
    		<?= Template::getLogin() ?>
    		<?= Template::getHeader('Lista de errores') ?>
    		<?= Template::getMenu() ?>
    		<?= Template::getMigas(["Lista de errores" => '/Error/list']) ?>
    		<?= Template::getSuccess() ?>
    		<?= Template::getError() ?>
    		<main>
        		<h1><?= APP_NAME ?></h1>
        		
        		<?php if(DB_ERRORS){ ?>
        		<section>
            		<h2>Lista completa de errores</h2>
        			
        			<?php if($errores) { ?>
     	
        			<a class="button" href="/Error/clear">Vaciar lista</a>
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
    		<?= Template::getFooter() ?>
    	</body>
    </html>

