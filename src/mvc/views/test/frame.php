<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
            "Test de {$test}",
            "Resultado de la ejecución del test {$test}"
        ) ?>           
        <?= $template->css() ?>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, "Test de $test") ?>
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

