<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Error 500",
                "Se ha producido un error con código HTTP 500 - INTERNAL SERVER ERROR"
        ) ?>           
        <?= $template->css() ?>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Error 500') ?>
		<?= $template->breadCrumbs(["Error 500" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h2 class="http-code">500</h2>
    		<p class="http-message centrado">Internal Server Error</p>
    
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

