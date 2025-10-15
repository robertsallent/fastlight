<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Error 400",
                "Se ha producido un error con código HTTP 400 - BAD REQUEST"
        ) ?>           
        <?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Error 400') ?>
		<?= $template->breadCrumbs(["Error 400" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h2 class="http-code">400</h2>
    		<p class="http-message centrado">Bad Request</p>
    
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

