<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Error  - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Error en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/images/template/smallLogo.png" type="image/png">	
		
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('Error') ?>
		<?= Template::getMenu() ?>
		<?= Template::getMigas(["Error" => NULL]) ?>
		<?= Template::getSuccess() ?>
		<?= Template::getWarning() ?>
		<?= Template::getError() ?>
		
		<main>
    		<h2>Error en la operación solicitada</h2>
    
    		<div class='error'>
    			<?= $mensaje ?>
			</div>
			
			<nav class="enlaces centrado">
    			<a class="button" onclick="history.back()">Atrás</a>  
    		</nav>
    		
    	</main>
		<?= Template::getFooter() ?>
	</body>
</html>

