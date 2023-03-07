<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Error  - <?= APP_NAME ?></title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('Error') ?>
		<?= Template::getMenu() ?>
		
		<h2>Error en la operación solicitada</h2>

		<p class='error'><?= $mensaje ?></p>
		
		<?= Template::getFooter() ?>
	</body>
</html>

