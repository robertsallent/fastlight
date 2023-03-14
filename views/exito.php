<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Éxito - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Éxito en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/images/template/smallLogo.png" type="image/png">	
		
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('Éxito') ?>
		<?= Template::getMenu() ?>
		<?= Template::getMigas(["Éxito" => NULL]) ?>
		<?= Template::getSuccess() ?>
		<?= Template::getWarning() ?>
		<?= Template::getError() ?>
		
		<main>
    		<h2>Éxito en la operación solicitada</h2>
    
    		<div class='success'>
    			<?= $mensaje ?>
			</div>
			
			<div class="enlaces centrado">
    			<a class="button" onclick="history.back()">Atrás</a>  
    		</div>
    		
		</main>
		<?= Template::getFooter() ?>
	</body>
</html>

