<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Portada - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/images/template/smallLogo.png" type="image/png">	
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>
	</head>
	<body>
		<?= (TEMPLATE)::getLogin() ?>
		<?= (TEMPLATE)::getHeader('Portada') ?>
		<?= (TEMPLATE)::getMenu() ?>
		<?= (TEMPLATE)::getSuccess() ?>
		<?= (TEMPLATE)::getWarning() ?>
		<?= (TEMPLATE)::getError() ?>
		
		<main>
    		<h2>FastLight Framework</h2>
    		
    		<p>Framework de clase para desarrollar aplicaciones web.</p>
    		<p>En la carpeta database encontrarás el SQL de una pequeña
    		   base de datos para test. Contiene también el ejemplo de la 
    		   estructura para de tabla users.</p>
		</main>
		<?= (TEMPLATE)::getFooter() ?>
	</body>
</html>

