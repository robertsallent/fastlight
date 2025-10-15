<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Error 404",
                "Se ha producido un error con código HTTP 404 - NOT FOUND"
        ) ?>           
        <?= $template->css() ?>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Error 404') ?>
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

