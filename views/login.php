<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>LogIn - <?= APP_NAME ?></title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
	<body>
		<?= Template::getHeader('LogIn') ?>
		<?= Template::getMenu() ?>
		
		<h2>Acceso a la aplicación</h2>
		<p>Introduce tus datos en el formulario para identificarte.</p>
		
		<form method="POST" id="login" action="/Login/enter">
			<label for="email">email:</label>
			<input type="email" name="user" id="email" required>
			<br>
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" required>
			<br>
			<input type="submit" name="login" value="LogIn">
		</form>
		
		<?= Template::getFooter() ?>
	</body>
</html>

