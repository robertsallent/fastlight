
	<h1>Listado de tests</h1>
	
	<p>Aquí se muestra el listado de tests disponibles en la carpeta test. puedes lanzar
	cada uno de los test haciendo clic sobre el nombre del fichero.</p>
	
	<h2>Tests disponibles:</h2>
	
	<ul>
    <?php
        
    $tests = FileList::get(TEST_FOLDER, ['php']);
    
    foreach ($tests as $fichero){
        
        $file = pathinfo($fichero, PATHINFO_FILENAME);
        
        echo "<li><a href='/test/$file'>$file</a></li>";    
    }
        
    
    ?>
	</ul>