<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
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
		
		<!-- SCRIPTS -->
		<script src="/js/CodeDisplay.js"></script>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header(null, "Ejemplo de $example") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([ "Ejemplos de maquetación" => "/example", $example => NULL]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<?php 
    		try{
    		    @require EXAMPLE_FOLDER."/".str_replace('-','/', $example).".html";
    		}catch(Throwable $t){
    		    
    		    Session::error("Se produjo un error al cargar el ejemplo <b>$example</b>, 
                                es posible que haya cambiado de nombre y el enlace que has usado
                                ya no sea válido.
                                No te preocupes estas siendo redireccionado al listado completo
                                de ejemplos de maquetación, donde encontrarás lo que buscas.");
    		    
	    ?>
	    	<script>location.href="/example#list"</script>
	    	
			<div class="danger my2 p2 w75 centered centered-block box-shadow">
				<h2>ERROR</h2>
				<p>Se produjo un error al cargar el ejemplo <b><?= $example ?></b>.</p>
			</div>  

    	<?php } ?>
		
		<div class='centrado m2'>
                <p class="maxi">Fin del ejemplo <code><?= $example ?></code></p>
                <a class='button' href='/example#list'>Lista de ejemplos.</a>
        </div>
            
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

