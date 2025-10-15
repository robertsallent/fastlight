<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Error 419",
                "Se ha producido un error con código HTTP 419 - PAGE EXPIRED"
        ) ?>           
        <?= $template->css() ?>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Error 419') ?>
		<?= $template->breadCrumbs(["Error 419" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h2 class="http-code">419</h2>
    		<p class="http-message centrado">Page Expired</p>
    
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

