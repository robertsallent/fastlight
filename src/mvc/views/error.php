<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Error",
                "Se ha producido un error"
        ) ?>           
        <?= $template->css() ?>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Se ha producido un error') ?>
		<?= $template->breadCrumbs(["Error" => NULL]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h2>Error en la operación solicitada</h2>
    
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

