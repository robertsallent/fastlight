<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Olvidé mi clave",
                "Formulario de recuperación de password"
        ) ?>           
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
			
        		<form class="w50 phone100 bloque-centrado my2" method="POST" autocomplete="off" id="login" action="/forgot-password/send">
        			
        			<?= csrf() ?>
        			
        			<h2 class="centered">Nueva clave</h2>
    				<p class="justificado info">Rellena este formulario para recibir una 
    					nueva clave en tu <i>email</i> con la que podrás acceder a la aplicación.</p> 
    				
    				<div style="margin: 10px;">
            			<label for="email">email:</label>
            			<input class="long" type="email" name="email" id="email" value="<?= old('email') ?>" required>
            			<br>
            			<label for="phone">teléfono:</label>
            			<input class="long" type="text" name="phone" id="phone" value="<?= old('phone') ?>" required>
        			</div>
        			
        			
        			<div class="centered my3">
        				<input type="submit" class="button phone75" name="nueva" value="Nueva clave">
        			</div>  
        			
        			<p class="caution">Debes cambiarla lo antes posible desde tu espacio personal.</p>
    		
    		
        			<div class="right phone-centered">
        				<a class="button-light phone75" href="/Login">Volver a Login</a>
        			</div>      			
        		</form>
        		
        		
    		
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

