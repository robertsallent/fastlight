<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Error 500 en <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Error 500 en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Error 500') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(["Error 500" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h2 class="http-code">500</h2>
    		<p class="http-message centrado">Internal Server Error</p>
    
    		<p class='http-details centrado'>
    			<?= $message ?? $mensaje ?? '' ?>
			</p>
			
			<nav class="enlaces centrado">
    			<a class="button" onclick="history.back()">Atrás</a>  
    		</nav>
    		
    	</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

