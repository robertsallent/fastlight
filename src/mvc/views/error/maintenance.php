<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Modo mantenimiento",
                "Esta aplicación se encuentra en MODO MANTENIMIENTO"
        ) ?>           
        <?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Modo mantenimiento') ?>
		<?= $template->breadCrumbs(["Modo mantenimiento" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h2>Modo mantenimiento</h2>
    		
    		<div class="flex-container">
        		<section class='p2 m2 flex2'>
                    <h3>¡Estamos trabajando para ti!</h3>
                    
                    <p>En este momento nuestro sitio web se encuentra en mantenimiento programado. 
                    Estamos realizando mejoras para ofrecerte una mejor experiencia.</p>
                    
                    <p>Por favor, vuelve a visitarnos más tarde.</p>
                    
                    <p>Gracias por tu paciencia y comprensión.</p>
                    
                    <p class="bold">El equipo de FastLight (Robert Sallent)</p>
    			</section>
			</div>
    		
    	</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

