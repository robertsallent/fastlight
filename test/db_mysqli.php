<?php 

    echo "<h1>Test de conexión DB</h1>";    
    
    // pruebas de select() o selectOne()
    echo "<h2>Recuperando producto 2...</h2>";
    dump(DB::select("SELECT * FROM products WHERE id = 1"));
    
    echo "<h2>Recuperando el producto 5000... (no existe)</h2>";
    dump(DB::select("SELECT * FROM products WHERE id = 5000"));
    
    
    // pruebas de selectAll()
	echo "<h2>Recuperando los productos...</h2>";
	echo "<pre>";
    dump(DB::selectAll("SELECT * FROM products"));
    echo "</pre>";

    // prueba de insert()
    echo "<h2>Guardando un producto...</h2>";
    
    $consulta = "INSERT INTO products(name, vendor, price) 
                 VALUES('Toothbrush', 'Colgate', 3)";
     
    $id = DB::insert($consulta);
	echo "<p>El ID del nuevo tema es $id</p>";
    
	
    // prueba de update()
    echo "<h2>Actualizando un producto...</h2>";
    
    $consulta = "UPDATE products SET name='Toothpaste' WHERE id = $id";
    $filas = DB::update($consulta);
    
    echo "<p>Filas afectadas $filas</p>";
    
    // comprobación de que se ha actualizado correctamente 
    dump(DB::select("SELECT * FROM products WHERE id = $id"));

    // prueba de delete()
    echo "<h2>Borrando un producto...</h2>";
    
    $filas = DB::delete("DELETE FROM products WHERE id = $id");
    echo "<p>Filas afectadas $filas</p>";

    // comprobación de que se ha borrado correctamente 
    dump(DB::selectOne("SELECT * FROM products WHERE id = $id"));
    
    // pruebas de totales
    echo "<h2>Totales...</h2>";
    
    echo "<p>Total de productos: ".DB::total('products')."</p>";
    echo "<p>Fecha de alta del último usuario: ".DB::total('users','MAX','created_at')."</p>";
    echo "<p>Menor precio de un producto: ".DB::total('products','MIN','price')."</p>";
    echo "<p>Precio medio de los productos: ".DB::total('products','AVG','price')."</p>";

    
    
    echo "<h2>Escapando caracteres...</h2>";
    
    $name = DB::escape("L'aperitiu");
    $vendor = DB::escape("Probando ¡& ' ' cosas <script></script> raras \n de test.");
    $price = intval("10patatas");
    
    $consulta = "INSERT INTO products(name, vendor, price)
                 VALUES('$name', '$vendor', $price)";
    
    echo $consulta;
    $id = DB::insert($consulta);
    
    dump(DB::select("SELECT * FROM products WHERE id = $id"));
   
    DB::delete("DELETE FROM products WHERE id=$id ") ;
    dump(DB::select("SELECT * FROM products WHERE id = $id"));
    
 
    