<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<meta charset="UTF-8">
		<title>LogIn - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nueva clave en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Generación de una nueva clave') ?>
		<?= $template->breadCrumbs(["LogIn" => "/Login", "Nueva clave" => NULL]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
			
        		<form class="w50 bloque-centrado" method="POST" autocomplete="off" id="login" action="/Forgotpassword/send">
        			
        			<?= csrf() ?>
        			
        			<h2 class="centered">Generación de una nueva clave</h2>
    				<p class="justificado info">Rellena este formulario para recibir una 
    					nueva clave en tu <i>email</i> con la que podrás acceder a la aplicación.</p> 
    				
    				<div style="margin: 10px;">
            			<label for="email">email:</label>
            			<input class="long" type="email" name="email" id="email" value="<?= old('email') ?>" required>
            			<br>
            			<label for="phone">teléfono:</label>
            			<input class="long" type="text" name="phone" id="phone" value="<?= old('phone') ?>" required>
        			</div>
        			
        			
        			<div class="centered m2">
        				<input type="submit" class="button" name="nueva" value="Nueva clave">
        			</div>  
        			
        			<p class="justificado info">Recuerda que debes cambiarla lo antes posible desde tu espacio personal.</p>
    		
    		
        			<div class="right">
        				<a class="button-light" href="/Login">Volver a Login</a>
        			</div>      			
        		</form>
        		
        		
    		
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

