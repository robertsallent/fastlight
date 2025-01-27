<main>

	<h1>Test de la clase Model</h1>
	
	<?php 
    	// clases del modelo para las pruebas
    	class Product extends Model{};
    	class Customer extends Model{};
	?>


	<section>
    	<h2>all()</h2>
    	<p>El método estático <code>all()</code> permite recuperar todas las entidades
    	del modelo a modo de array de objetos. Los objetos serán del tipo de modelo,
    	por ejemplo, para recuperar la lista de productos haremos: <code>$products = Product::all();</code>.</p>
    	
    	<?php dump(Product::all()) ?>
    </section>
    
    
    
    <?php 
    echo "<h3>Producto 3:</h3>";
    dump(Product::find(3));
    
    echo "<h3>Producto 3000 (no existe):</h3>";
    dump(Product::find(3000));
    
    echo "<h3>Productos de Apple (con getFiltered()):</h3>";
    dump(Product::getFiltered('vendor','Apple'));
    
    echo "<h3>Productos ordenados por nombre descendente:</h3>";
    dump(Product::orderBy('name','DESC'));
    
    echo "<h3>Productos de Apple (con where()):</h3>";
    dump(Product::where(['vendor' => 'Apple']));
    
    echo "<h3>Guardando un producto:</h3>";
    $product = new Product();
    $product->name = 'Screen';
    $product->vendor = 'Philips';
    $product->price = 300;
    $product->save();
    
    echo "<p>Se ha guardado: ".Product::find($product->id)."</p>";
    
    echo "<h3>Actualizando un producto:</h3>";
    $product->name = 'Monitor';
    $product->vendor = 'Samsung';
    $product->price = 200;
    $product->update();
    
    echo "<p>Se ha actualizado: ".Product::find($product->id)."</p>";
    
    echo "<h3>Borrando un producto:</h3>";
    $product->deleteObject();
    
    echo "<p>Se ha borrado? ".(Product::find($product->id)? "NO" : "SI" )."</p>";
    
    
    echo "<h3>Totales:</h3>";
    echo "<p>Total de productos: ".Product::total()."</p>";
    echo "<p>Max del precio: ".Product::total('MAX', 'price')."</p>";
    echo "<p>Min del precio: ".Product::total('MIN', 'price')."</p>";
    echo "<p>AVG del precio: ".Product::total('AVG', 'price')."</p>";
    echo "<p>SUM del precio: ".Product::total('SUM', 'price')."</p>";

    echo "<h3>Grupos:</h3>";
    $resultados = Customer::groupBy(['id'=>'COUNT'], ['city']);
           
    echo "<ul>";
    foreach($resultados as $resultado)
        echo "<li>$resultado->city: <b>$resultado->idcount</b></li>";
    echo "</ul>";
    
    ?>
    
    <p>Si queremos hacer consultas de totales y agrupado con varias tablas, podemos
    usar el método <code>selectAll()</code> de las clases para trabajar con base de datos.</p>
    
    <?php 
    echo "<h3>Saneamiento de entradas y trim strings:</h3>";
    $product->name = '  Monitor <black>     ';
    $product->vendor = "  Samsung 'Cool Blue'      ";
    
    echo "<p>Wrong product name: $product->name</p>";
    echo "<p>Wrong product vendor: $product->vendor</p>";
    
    dump($product->saneate());
    dump($product->trim());
    
    echo "<p>Correct product name: $product->name</p>";
    echo "<p>Correct product vendor: $product->vendor</p>";
?>

</main>    
    
    