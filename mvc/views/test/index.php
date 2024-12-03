<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Listado de test - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Listado de test') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs(["Test" => NULL]) ?>
		<?= $template->messages() ?>
		
		<main>
        	<h1>Listado de tests</h1>
        	
        	<section>
            	<h2>Información</h2>
            	
            	<p>Aquí se muestra el listado de <b>tests</b> disponibles en la carpeta <code><?= TEST_FOLDER ?></code> y que se pueden
            	lanzar haciendo clic sobre el nombre del fichero. Os servirán como ejemplo para comprender
            	algunos de los mecanismos del framework, pero también como muestra de cómo realizar pruebas
            	unitarias de forma sencilla con <code>FastLight</code>.</p>
            	
            	<h3>Añadiendo tests</h3>
            	
            	<p>Para crear vuestros propios tests, tan solo tenéis que añadir el fichero php con la prueba
            	   en la carpeta <code><?= TEST_FOLDER ?></code>. Tomad como ejemplo alguno de los existentes.</p>
            	   
        	</section>
        	
        	

        	<section>
            	<h2>Tests disponibles</h2>
            	
            	<ul id="test-list" class="three-columns">
                <?php
                    
                $tests = FileList::get(TEST_FOLDER, ['php']);
                
                foreach ($tests as $fichero){
                    
                    $file = new File($fichero);
                    echo "<li>";
                    echo "<a title='fichero ".TEST_FOLDER."/".$file->getBaseName()." (".$file->getSize()." bytes)' ";
                    echo "href='/test/".$file->getName()."'>".$file->getName()."</a>";
                    echo "</li>";    
                }
             
                ?>
            	</ul>
        	</section>
        	
        	
        	<section class="danger p2">
            	<h2>IMPORTANTE</h2>
            	<p>La presencia de estos ejemplos en producción <b class='uppercase'>puede provocar
            	   problemas de seguridad</b>.</p>
            	   
            	<p>Solamente se comparten <b>por 
            	motivos docentes</b>. A producción 
            	<b class="uppercase">no subiremos</b> la carpeta <code><?= TEST_FOLDER ?></code>, el controlador 
            	<code>TestController</code> ni la carpeta <code>mvc/views/test</code>. 
            	También deberíamos eliminar el enlace desde el menú, que se encuentra en el fichero
            	<code>/templates/Base.php</code>.</p>
        	</section>
        	
        	
        	<section>
            	<h3>Consideraciones:</h3>
            	<ul>
                	<li>Los test que realizan operaciones con usuarios, autenticación o autorización provocarán
                	   que se cierre la sesión de usuario y obligarán a hacer login nuevamente.</li>
                	   
                	<li>Los que trabajan con entidades (modelos),
                	   funcionan con las bases de datos de prueba "sales_example.sql"
                	   o bien con el ejemplo de la biblioteca, no os asustéis si no funcionan."</li> 
                	   
            	</ul>
        	</section>
        	
        
        </main>
		<?= $template->footer() ?>
	</body>
</html>

