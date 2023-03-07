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
		
		<main>
    		<h2>Acceso a la aplicación</h2>
    		<p>Introduce tus datos en el formulario para identificarte.</p>
		
    		<form method="POST" id="login" action="/Login/enter">
    			<label for="email">email:</label>
    			<input type="email" name="user" id="email" required>
    			<br>
    			<label for="password">Password:</label>
    			<input type="password" name="password" id="password" required>
    			<br>
    			<div class="centrado">
    				<input type="submit" class="button" name="login" value="LogIn">
    			</div>
    		</form>
		</main>
		
		<?= Template::getFooter() ?>
	</body>
</html>

