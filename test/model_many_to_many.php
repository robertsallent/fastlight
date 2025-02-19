<main>
    <h1>Test de la clase Model</h1>
    <h2>Relaciones N a M</h2>
    
    
    <?php 
    	// clases del modelo para las pruebas
    	class Product extends Model{};
    	class Customer extends Model{};
    	class Sale extends Model{};
    	class Provider extends Model{};
    ?>
    	
    <div class="warning p2">
    	<h2>Advertencia!</h2>
    	
    	<p>Las siguientes pruebas han sido realizadas sobre la base de datos del 
    	ejemplo <b>sales_example</b>, que se puede encontrar en la carpeta
    	<i>database_examples</i>.</p>
    </div>  
    
    
    <p>Las clases del modelo para la realización de estas pruebas
    han sido implementadas de la siguiente forma:</p>
	
	
	<pre>
	<code>
class Product extends Model{};
class Customer extends Model{};
class Sale extends Model{};	
	</code>
	</pre>
	
    
    <section id="belongsToMany">
    	<h2>belongsToMany()</h2>
    	
    	<p>El método <code>belongsToMany()</code> nos permite <b>buscar entidades relacionadas
    	en una relación varios a varios</b>. Más detalles en las presentaciones en PDF.</p>
    	
    	<p>Por ejemplo, para buscar productos suministrados por el proveedor 1:</p>
    	<pre>
    		<code>
    	$provider = Provider::find(1);
    	$products = $provider->belongsToMany('Product', 'products_providers');
    		</code>
    	</pre>
    	
    	<p>El proveedor es:</p>
    	<?php 
        	$provider = Provider::find(1);
            dump($provider);
        ?>
        
        <p>Y sus productos son:</p>
        <?php 
    	   $products = $provider->belongsToMany('Product', 'products_providers');
    	   dump($products);
    	?>
    	
    	<p>El nombre de la tabla intermedia se puede omitir, <b>se calcula automáticamente</b> 
    	como la union del nombre de ambas entidades <b>acabados en s, lower snake case y en orden alfabético</b>.
    	el ejemplo funciona igual haciendo: <code>$products = $provider->belongsToMany('Product');</code></p>
    	
    	<p>Los nombres de los campos implicados en la relación también se <b>calculan automáticamente</b>.
    	Se usan los campos de nombre <b><i>id</i> en las tablas 
    	principales</b> y los <b>campos <i>idnombreentidad</i></b> en la
    	tabla intermedia. El método <code>belongsToMany()</code> puede recibir parámetros adicionales 
    	para indicar los nombres de los campos en caso de no ser así (consultad la 
    	documentación completa en PDF o la API para el programador - EN PROCESO).</p> 
    </section>
    
    <section>
    	<h2>belongsToMany() (en el otro sentido)</h2>
    	
    	<p>En el ejemplo anterior, hemos buscado los productos de un proveedor,
    	pero también podemos recorrer la relación en sentido inverso.
    	Por ejemplo, para buscar proveedores del producto 4:</p>
    	<pre>
    		<code>
    	$product = Product::find(4);
    	$providers = $product->belongsToMany('Provider', 'products_providers');
    		</code>
    	</pre>
    	
    	<p>El producto es:</p>
    	<?php 
    	   $product = Product::find(4);
           dump($product);
        ?>
        
        <p>Y sus proveedores son:</p>
        <?php 
           $providers = $product->belongsToMany('Provider', 'products_providers');
    	   dump($providers);
    	?>
    	
    </section>
</main>