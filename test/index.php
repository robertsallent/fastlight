
	<h1>Listado de tests</h1>
	
	<p>Aquí se muestra el listado de <b>tests</b> disponibles en la carpeta <i>test</i> y que se pueden
	lanzar haciendo clic sobre el nombre del fichero. Esta sección solamente <b>existe por 
	motivos docentes</b>, no se incluye en los proyectos reales.</p>
	
	<p>El aspecto es diferente, usa el template TestTemplate.</p>
	
	<h2>Tests disponibles:</h2>
	
	<ul>
    <?php
        
    $tests = FileList::get(TEST_FOLDER, ['php']);
    $tests = array_diff($tests, [TEST_FOLDER.'/index.php']);
    
    foreach ($tests as $fichero){
        
        $file = pathinfo($fichero, PATHINFO_FILENAME);
        echo "<li><a href='/test/$file'>$file</a></li>";    
    }
        
    
    ?>
	</ul>