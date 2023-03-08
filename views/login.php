<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>LogIn - <?= APP_NAME ?></title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('LogIn') ?>
		<?= Template::getMenu() ?>
		
		<main class="flex-container">
			<div class="flex1"> </div>
    		<form class="flex2" method="POST" autocomplete="off" id="loginForm" action="/Login/enter">
    			
    			<h2>Acceso a la aplicación</h2>
				<p>Introduce tus datos en el formulario para identificarte.</p>
		
				<div style="margin: 10px;">
        			<label for="email">email:</label>
        			<input type="email" name="user" id="email" required>
        			<br>
        			<label for="password">Password:</label>
        			<input type="password" name="password" id="password" required>
    			</div>
    			<div class="centrado">
    				<input type="submit" class="button" name="login" value="LogIn">
    			</div>
    		</form>
    		<div class="flex1"> </div>
		</main>
		
		<?= Template::getFooter() ?>
	</body>
</html>

