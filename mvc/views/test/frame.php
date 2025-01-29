<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Test de <?= $test ?> - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Test de <?= $test ?> en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	
	
	<body>
		<?= $template->login() ?>
		<?= $template->header("Test de $test") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([ "Test" => "/test", $test => NULL]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<?php 
    		try{
    		    @require $file;
    		}catch(Error $e){
	    ?>
			<div class="danger my2 p2 w75 centered centered-block box-shadow">
				<h2>ERROR</h2>
				<p>Se produjo un error en el test <b><i><?= $test ?></i></b> con el siguiente mensaje: 
				<i><?= $e->getMessage() ?></i></p>
				<p>Revisa el código que se encuentra justo en este punto del test para solucionarlo.</p>
			</div>  
    	<?php } ?>
		
		<div class='centrado m2'>
                <p class="maxi">Fin del test <code><?= $test ?></code></p>
                <a class='button' href='/test#test-list-section'>Lista de test.</a>
        </div>
            
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

