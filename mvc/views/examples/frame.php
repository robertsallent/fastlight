<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Ejemplo de <?= $example ?> - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Ejemplo de <?= $example ?> en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header("Ejemplo de $example") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([ "Ejemplos de maquetación" => "/example", $example => NULL]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<?php @require EXAMPLE_FOLDER."/".str_replace('-','/', $example).".php" ?>
		
		<div class='centrado m2'>
                <p class="maxi">Fin del ejemplo <code><?= $example ?></code></p>
                <a class='button' href='/example'>Lista de ejemplos.</a>
        </div>
            
		<?= $template->footer() ?>
	</body>
</html>

