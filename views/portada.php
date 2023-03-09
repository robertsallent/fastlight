<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Portada - <?= APP_NAME ?></title>
		<link rel="stylesheet" type="text/css" href="/css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('Portada') ?>
		<?= Template::getMenu() ?>
		
		<main>
    		<h2>FastLight Framework</h2>
    		<p>Framework de clase para desarrollar aplicaciones web.</p>
    		<p>En la carpeta database encontrarás el SQL de una pequeña
    		   base de datos para test. Contiene también el ejemplo de la 
    		   estructura para de tabla users.</p>
		</main>
		<?= Template::getFooter() ?>
	</body>
</html>

