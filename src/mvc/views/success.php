<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Éxito",
                "Operación realizada con éxito"
        ) ?>           
        <?= $template->css() ?>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Éxito en la operación') ?>
		<?= $template->breadCrumbs(["Éxito" => NULL]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h2>Éxito en la operación solicitada</h2>
    
    		<div class='success'>
    			<?= $mensaje ?>
			</div>
			
			<nav class="enlaces centrado">
    			<a class="button" onclick="history.back()">Atrás</a>  
    		</nav>
    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

