<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Éxito - <?= APP_NAME ?></title>
		<link rel="stylesheet" type="text/css" href="/css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('Éxito') ?>
		<?= Template::getMenu() ?>
		
		<main>
    		<h2>Éxito en la operación solicitada</h2>
    
    		<div class='success'>
    			<?= $mensaje ?>
			</div>
		</main>
		<?= Template::getFooter() ?>
	</body>
</html>

