<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Error 404 en <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Error 404 en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Error 404') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(["Error 404" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h2 class="http-code">404</h2>
    		<p class="http-message centrado">Not Found</p>
    
    		<section class='danger p2 m2'>
    			<h2>Información adicional</h2>
    			<?= $message ?? $mensaje ?? '' ?>
			</section>
			
			<nav class="enlaces centrado">
    			<a class="button" onclick="history.back()">Atrás</a>  
    		</nav>
    		
    	</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

