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
		<?= $template->acceptCookies() ?>
		
		<main>
        	<h1>Listado de tests</h1>
        	
        	<section>
            	<h2>Información</h2>
            	
            	<p>A continuación se muestra el listado de <b>tests</b> disponibles en la carpeta 
            	<span class='path'><?= TEST_FOLDER ?></span> y que se pueden
            	ejecutar simplemente haciendo clic sobre el nombre del fichero. 
            	Continenen explicaciones y ejemplos, así que <b class='maxi'>os servirán como ejemplo</b> para comprender
            	algunos de los mecanismos del <i>framework</i>.</p> 
            	
            	<p>También muestran una forma interesante de realizar 
            	<b>pruebas unitarias</b> sencillas con <i>FastLight</i>, pudiendo añadir vuestros
            	propios test.</p>
            	
            	<h3>Añadiendo tests</h3>
            	
            	<p>Para crear vuestros propios tests, tan solo tenéis que añadir el fichero <i>PHP</i> con la prueba
            	   a realizar en la carpeta <span class='path'><?= TEST_FOLDER ?></span>. 
            	   Tomad como ejemplo alguno de los existentes.</p>
        
            	<h3>Consideraciones:</h3>
            	<ul>
                	<li>Los test que realizan operaciones con usuarios, autenticación o autorización pueden provocar
                	   que se cierre la sesión de usuario, con lo que se os solicitará hacer <i>login</i> de nuevo 
                	   al volver al listado.</li>
                	   
                	<li>Los test que trabajan con entidades (modelos),
                	   funcionan con <b>la bases de datos de prueba <i>sales_example.sql</i></b>, así que es preferible
                	   usar esta base de datos para las pruebas, en lugar de la <i>basic_tables.sql</i>.</li>
                	   
                	<li>Los test <b>están documentados</b>, aunque también es interesante observar el código fuente.</li> 
                	
                	<li>Si un test requiere del envío de un formulario, estará preparado en el 
                	    mismo fichero, para que resulte fácil la prueba.</li> 
                	   
            	</ul>
        	</section>
        	
        	<section class="danger p2">
            	<h2>IMPORTANTE</h2>
            	<p>La presencia de estos ejemplos en producción <b class='uppercase'>puede provocar
            	   problemas de seguridad</b>.</p>
            	   
            	<p>Solamente se comparten <b>por 
            	motivos docentes</b>. A producción 
            	<b class="uppercase maxi">no subiremos</b> la carpeta <span class='path'><?= TEST_FOLDER ?></span>,
            	 el controlador <i>TestController</i> ni la carpeta <span class='path'>mvc/views/test</span>. 
            	También deberíamos eliminar el enlace desde el menú, que se encuentra en el fichero
            	<span class='path'>templates/Base.php</span>.</p>
        	</section>
     

        	<section id="test-list-section">
            	<h2>Tests disponibles</h2>
            	
            	<ul id="test-list" class="three-columns">
                <?php
                    
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

   
        
        </main>
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

