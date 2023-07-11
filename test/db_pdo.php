<h1>Test de conexión DBPDO (PDO)</h1>

<h2>Pruebas de select() y selectOne()</h2>
<?php 
    echo "<p>Recuperando producto 2...</p>";
    dump(DBPDO::select("SELECT * FROM products WHERE id = 2"));
    
    echo "<p2>Recuperando producto 3...</p>";
    dump(DBPDO::selectOne("SELECT * FROM products WHERE id = 3"));
    
    echo "<p>Recuperando el producto 5000... (no existe)</p>";
    dump(DBPDO::select("SELECT * FROM products WHERE id = 5000"));
    
    echo "<p>Recuperando el producto 5001... (no existe)</p>";
    dump(DBPDO::selectOne("SELECT * FROM products WHERE id = 5001"));
?>


<h2>Pruebas de selectAll()</h2>   
<?php     
	echo "<p>Recuperando todos los productos...</p>";
    dump(DBPDO::selectAll("SELECT * FROM products"));
?>


<h2>Pruebas de insert()</h2>
<?php  
    echo "<p>Guardando un producto...</p>";
    
    $consulta = "INSERT INTO products(name, vendor, price) 
                 VALUES('Toothbrush', 'Colgate', 3)";
     
    $id = DBPDO::insert($consulta);
	echo "<p>El ID del nuevo producto es $id</p>";
    
	echo "<p>Comprobando que se guardó correctamente...</p>";
	dump(DBPDO::selectOne("SELECT * FROM products WHERE id=$id"));
?>


<h2>Pruebas de update()</h2>
<?php  
    // prueba de update()
    echo "<p>Actualizando un producto...</p>";
    
    $consulta = "UPDATE products SET name='Toothpaste' WHERE id = $id";
    $filas = DBPDO::update($consulta);
    
    echo "<p>Filas afectadas $filas</p>";
    
    echo "<p>Comprobando que se actualizó correctamente...</p>";
    dump(DBPDO::select("SELECT * FROM products WHERE id = $id"));
?>
 
    
<h2>Pruebas de delete()</h2>
<?php 
    echo "<p>Borrando un producto...</p>";
    
    $filas = DBPDO::delete("DELETE FROM products WHERE id = $id");
    echo "<p>Filas afectadas $filas</p>";

    echo "<p>Comprobando que se borró correctamente...</p>";
    dump(DBPDO::selectOne("SELECT * FROM products WHERE id = $id"));    
?>


<h2>Pruebas de totales()</h2>
<?php 
    echo "<p>Total de productos: ".DBPDO::total('products')."</p>";
    echo "<p>Fecha de alta del último usuario: ".DBPDO::total('users','MAX','created_at')."</p>";
    echo "<p>Menor precio de un producto: ".DBPDO::total('products','MIN','price')."</p>";
    echo "<p>Precio medio de los productos: ".DBPDO::total('products','AVG','price')."</p>";
?>
    

<h2>Pruebas de escape()</h2>
<?php     
    echo "<p>Escapando caracteres y guardando...</p>";
    
    $name = DBPDO::escape("L'aperitiu");
    $vendor = DBPDO::escape("Probando ¡& ' ' cosas <script></script> raras \n de test.");
    $price = intval("10patatas");
    
    $consulta = "INSERT INTO products(name, vendor, price)
                 VALUES('$name', '$vendor', $price)";
    
    echo $consulta;
    $id = DBPDO::insert($consulta);
    
    echo "<p>Comprobando que se insertó correctamente...</p>";
    dump(DBPDO::select("SELECT * FROM products WHERE id = $id"));
   
    DBPDO::delete("DELETE FROM products WHERE id=$id ") ;
    
    echo "<p>Comprobando que se borró correctamente...</p>";
    dump(DBPDO::select("SELECT * FROM products WHERE id = $id"));
?>   
    

    