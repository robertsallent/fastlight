<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de ejemplos de maquetación - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Listado de ejemplos de maquetación en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Ejemplos de maquetación') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(["Ejemplos de maquetación" => NULL]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
        	<h1>Listado de ejemplos</h1>
        	
        	<section>
            	<h2>Información</h2>
            	
            	<p>A continuación se muestra el listado de <b>ejemplos de maquetación</b> disponibles en la carpeta 
            	<code><?= EXAMPLE_FOLDER ?></code> y que se pueden
            	lanzar haciendo clic sobre el nombre del fichero en la lista que hay a continuación. 
            	Os servirán como ejemplo para comprender algunos de los componentes de GUI y estilos del 
            	framework, pero también como muestra de cómo maquetar de forma sencilla con <code>FastLight</code>.
            	</p>
            	
            	<h3>Añadir nuevos ejemplos</h3>
            	
            	<p>Para crear vuestros propios ejemplos, tan solo tenéis que añadir el fichero php con la prueba
            	   en la carpeta <code><?= EXAMPLE_FOLDER ?></code>. Tomad como referencia alguno de los existentes.</p>
            	   
        	</section>
        	
        	
        	
        	<section>
            	<h2>Ejemplos disponibles</h2>
            	
            	<ul id="test-list" class="three-columns">
                <?php

                foreach ($examples as $source){
                    
                    $file = new File($source);
                    echo "<li>";
                    echo "<a title='fichero ".EXAMPLE_FOLDER."/".$file->getBaseName()." (".$file->getSize()." bytes)' ";
                    echo "href='/example/".$file->getName()."'>".$file->getName()."</a>";
                    echo "</li>";    
                }
             
                ?>
            	</ul>
        	</section>	
        	
        	
        	<section class="danger p2">
            	<h2>IMPORTANTE</h2>
            	<p>No se deben subir estos ejemplos a producción, solamente se comparten <b>por 
            	motivos docentes</b>. A producción <b>no subiremos</b> la carpeta <code><?= EXAMPLE_FOLDER ?></code>,
            	 ni el controlador <code>ExampleController</code>. 
            	También deberíamos eliminar el enlace del menú, que se encuentra en el fichero
            	<code>/templates/Base.php</code>.</p>
        	</section>
        	
        		
        
        </main>	
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

