
	<h1>Listado de tests</h1>
	
	<h2>Información</h2>
	
	<p>Aquí se muestra el listado de <b>tests</b> disponibles en la carpeta <i>test</i> y que se pueden
	lanzar haciendo clic sobre el nombre del fichero. Os servirán como ejemplo para comprender
	algunos de los mecanismos del framework, pero también como muestra de cómo realizar pruebas
	unitarias de forma sencilla con <code>FastLight</code>.</p>
	
	<p>Solamente se comparten <b>por 
	motivos docentes</b>. A producción 
	<b>no subiremos la carpeta test, el TestController ni el template de Test</b>. 
	También deberíamos eliminar el enlace desde el menú del template base.</p>
	
	<p>Los test que realizan operaciones con usuarios, autenticación o autorización provocarán
	   que se cierre la sesión de usuario que hay abierta ahora mismo y obligarán a hacer login
	   nuevamente.</p>
	   
    <p>El aspecto de esta sección es diferente, porque usa el template Test.</p>
	
	<h2>Tests disponibles</h2>
	
	<ul id="test-list">
    <?php
        
    $tests = FileList::get(TEST_FOLDER, ['php']);
    $tests = array_diff($tests, [TEST_FOLDER.'/index.php']);
    
    foreach ($tests as $fichero){
        
        $file = pathinfo($fichero, PATHINFO_FILENAME);
        echo "<li><a href='/test/$file'>$file</a></li>";    
    }
 
    ?>
	</ul>
	
	<h2>Instrucciones</h2>
	
	<p>Para crear vuestros propios tests, tan solo tenéis que añadir el fichero php con la prueba
	   en la carpeta <i>tests</i>. Tomad como ejemplo alguno de los existentes.</p>
	
	
	