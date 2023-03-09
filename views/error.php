<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Error  - <?= APP_NAME ?></title>
		<link rel="stylesheet" type="text/css" href="/css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('Error') ?>
		<?= Template::getMenu() ?>
		
		<main>
    		<h2>Error en la operación solicitada</h2>
    
    		<div class='error'>
    			<?= $mensaje ?>
			</div>
    	</main>
		<?= Template::getFooter() ?>
	</body>
</html>

