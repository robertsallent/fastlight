<h1>Test de conexión DB (mysqli)</h1>

<h2>Pruebas de select() y selectOne()</h2>
<?php 
    echo "<p>Recuperando producto 2...</p>";
    dump(DB::select("SELECT * FROM products WHERE id = 2"));
    
    echo "<p2>Recuperando producto 3...</p>";
    dump(DB::selectOne("SELECT * FROM products WHERE id = 3"));
    
    echo "<p>Recuperando el producto 5000... (no existe)</p>";
    dump(DB::select("SELECT * FROM products WHERE id = 5000"));
    
    echo "<p>Recuperando el producto 5001... (no existe)</p>";
    dump(DB::selectOne("SELECT * FROM products WHERE id = 5001"));
?>


<h2>Pruebas de selectAll()</h2>   
<?php     
	echo "<p>Recuperando todos los productos...</p>";
    dump(DB::selectAll("SELECT * FROM products"));
?>


<h2>Pruebas de insert()</h2>
<?php  
    echo "<p>Guardando un producto...</p>";
    
    $consulta = "INSERT INTO products(name, vendor, price) 
                 VALUES('Toothbrush', 'Colgate', 3)";
     
    $id = DB::insert($consulta);
	echo "<p>El ID del nuevo producto es $id</p>";
    
	echo "<p>Comprobando que se guardó correctamente...</p>";
	dump(DB::selectOne("SELECT * FROM products WHERE id=$id"));
?>


<h2>Pruebas de update()</h2>
<?php  
    // prueba de update()
    echo "<p>Actualizando un producto...</p>";
    
    $consulta = "UPDATE products SET name='Toothpaste' WHERE id = $id";
    $filas = DB::update($consulta);
    
    echo "<p>Filas afectadas $filas</p>";
    
    echo "<p>Comprobando que se actualizó correctamente...</p>";
    dump(DB::select("SELECT * FROM products WHERE id = $id"));
?>
 
    
<h2>Pruebas de delete()</h2>
<?php 
    echo "<p>Borrando un producto...</p>";
    
    $filas = DB::delete("DELETE FROM products WHERE id = $id");
    echo "<p>Filas afectadas $filas</p>";

    echo "<p>Comprobando que se borró correctamente...</p>";
    dump(DB::selectOne("SELECT * FROM products WHERE id = $id"));    
?>


<h2>Pruebas de totales()</h2>
<?php 
    echo "<p>Total de productos: ".DB::total('products')."</p>";
    echo "<p>Fecha de alta del último usuario: ".DB::total('users','MAX','created_at')."</p>";
    echo "<p>Menor precio de un producto: ".DB::total('products','MIN','price')."</p>";
    echo "<p>Precio medio de los productos: ".DB::total('products','AVG','price')."</p>";
?>
    

<h2>Pruebas de escape()</h2>
<?php     
    echo "<p>Escapando caracteres y guardando...</p>";
    
    $name = DB::escape("L'aperitiu");
    $vendor = DB::escape("Probando ¡& ' ' cosas <script></script> raras \n de test.");
    $price = intval("10patatas");
    
    $consulta = "INSERT INTO products(name, vendor, price)
                 VALUES('$name', '$vendor', $price)";
    
    echo $consulta;
    $id = DB::insert($consulta);
    
    echo "<p>Comprobando que se insertó correctamente...</p>";
    dump(DB::select("SELECT * FROM products WHERE id = $id"));
   
    DB::delete("DELETE FROM products WHERE id=$id ") ;
    
    echo "<p>Comprobando que se borró correctamente...</p>";
    dump(DB::select("SELECT * FROM products WHERE id = $id"));
?>   
    

    