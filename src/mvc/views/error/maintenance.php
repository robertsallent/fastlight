<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Modo mantenimiento",
                "Esta aplicación se encuentra en MODO MANTENIMIENTO"
        ) ?>           
        <?= $template->css() ?>
        
        <!-- JS -->
        <script src="/js/Modal.js"></script>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Modo mantenimiento') ?>
		<?= $template->breadCrumbs(["Modo mantenimiento" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h2>Modo mantenimiento</h2>
    		
    		<div class="flex-container gap2 flex-wrap-reverse">
        		<section class='p2 my2 flex2'>
                    <h3>¡Estamos trabajando para ti!</h3>
                    
                    <p>En este momento nuestro sitio web se encuentra en mantenimiento programado. 
                    Estamos realizando mejoras para ofrecerte una mejor experiencia.</p>
                    
                    <p>Por favor, vuelve a visitarnos más tarde.</p>
                    
                    <p>Gracias por tu paciencia y comprensión.</p>
                    
                    <p class="bold">El equipo de FastLight (Robert Sallent)</p>
    			</section>
    			
    			<figure class="flex1 card p2 my2">
        			<img src="/images/template/obras.jpg" class="fit with-modal" alt="En obras"
        			     data-description="Estamos en obras, volveremos pronto"
        			     data-caption="En obras">
        			<figcaption>Estamos en obras, paciencia.</figcaption>
        		</figure>
			</div>
    		
    	</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

