<?php 

    echo "<h1>Test de conexión DB (biblioteca)</h1>";    

    // cambia a la BDD de la biblioteca para hacer las pruebas
    $conexion = DB::get()->select_db('biblioteca');
    
    // pruebas de select() o selectOne()
    echo "<h2>Recuperando el socio 5...</h2>";
    echo "<pre>";
    var_dump(DB::select("SELECT * FROM socios WHERE id=5"));
    echo "</pre>";
    
    echo "<h2>Recuperando el socio 5000... (no existe)</h2>";
    echo "<pre>";
    var_dump(DB::select("SELECT * FROM socios WHERE id=5000"));
    echo "</pre>";
    
    
    // pruebas de selectAll()
	echo "<h2>Recuperando los temas...</h2>";
	echo "<pre>";
    var_dump(DB::selectAll("SELECT * FROM temas"));
    echo "</pre>";
    
    
    echo "<h2>Recuperando libros de Stephen King (no hay)...</h2>";
    echo "<pre>";
    var_dump(DB::selectAll("SELECT * FROM libros WHERE autor='Stephen King'"));
    echo "</pre>";
       
    
    // prueba de insert()
    echo "<h2>Guardando un tema...</h2>";
    
    $consulta = "INSERT INTO temas(tema, descripcion) 
                 VALUES('Viajes','Viaje con nosotros si quiere jugar')";
     
    $id = DB::insert($consulta);
    
	echo "<p>El ID del nuevo tema es $id</p>";
    
	
	
    // prueba de update()
    echo "<h2>Actualizando un tema...</h2>";
    
    $consulta = "UPDATE temas SET tema='Test de Tema' WHERE id=$id";
    $filas = DB::update($consulta);
    
    echo "<p>Filas afectadas $filas</p>";
    
    // comprobación de que se ha actualizado correctamente 
    echo "<pre>";
    var_dump(DB::select("SELECT * FROM temas WHERE id = $id"));
    echo "</pre>";
    
    
    
    // prueba de delete()
    echo "<h2>Borrando un tema...</h2>";
    
    $filas = DB::delete("DELETE FROM temas WHERE id=$id");
    echo "<p>Filas afectadas $filas</p>";

    // comprobación de que se ha borrado correctamente 
    echo "<pre>";
    var_dump(DB::select("SELECT * FROM temas WHERE id=$id"));
    echo "</pre>";
    

    // pruebas de totales
    echo "<h2>Totales...</h2>";
    
    echo "<p>Total de socios: ".DB::total('socios')."</p>";
    echo "<p>Fecha de alta del último socio: ".DB::total('socios','MAX','alta')."</p>";
    echo "<p>Nacimiento del socio mayor: ".DB::total('socios','MIN','nacimiento')."</p>";
    echo "<p>Precio medio de ejemplares: ".DB::total('ejemplares','AVG','precio')."</p>";

    
    
    
    echo "<h2>Escapando caracteres...</h2>";
    $tema = DB::escape("L'aperitiu");
    $descripcion = DB::escape("Probando ¡& ' ' cosas <script></script> raras \n test ");
    
    $consulta = "INSERT INTO temas(tema, descripcion)
                 VALUES('$tema', '$descripcion')";
    
    echo $consulta;
    
    $id = DB::insert($consulta);
    
    echo "<pre>";
    var_dump(DB::select("SELECT * FROM temas WHERE id=$id"));
    echo "</pre>";
   
    DB::delete("DELETE FROM temas WHERE id=$id ") ;
    
    /*
    // prueba de una consulta errónea
    echo "<h2>Si realizamos un SELECT erróneo...</h2>";
    echo "<p>Si estamos en DEBUG, debe mostrar que no existe la tabla members.</p>";
    echo "<p>Si no estamos en DEBUG, mostrará 'error en la consulta'.</p>";
    
    DB::select("SELECT * FROM members WHERE id=5");
    */
    
    