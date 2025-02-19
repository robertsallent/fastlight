<main>

	<h1>Test de la clase Model</h1>
	<h2>Saneamiento de entradas</h2>
	
	<?php 
    	// clases del modelo para las pruebas
    	class Product extends Model{};
	?>

    <section id="saneate">
    	<h3>saneate()</h3>
    	
    	<p>El método <code>saneate()</code> <b>sanea las propiedades de una entidad</b> para 
    	evitar ciertas SQL Injections.</p>
    	
    	<p>Cuando tomamos datos que llegan por
    	GET, POST o COOKIE a través de los métodos de la clase
		<a href='/test/http_request'><b>Request</b></a>,
    	el saneamiento es automático, así que no haría falta usar este método. 
    	Ahora bien, si creamos entidades del modelo de otras formas (desde ficheros o APIs, por ejemplo), 
    	hay que invocarlo expresamente, por ejemplo:</p>
    	
    	<pre>
    		<code>
    $product = new Product();
    
    $product->name = '  Monitor black"     ';
    $product->vendor = "  Samsung 'Cool Blue'      ";
    		</code>
    	</pre>
    	
	    <?php 
    	    $product = new Product();
    	    $product->name         = 'Monitor "black"';
    	    $product->vendor       = "Samsung 'Cool Blue'";
    	    
    	    echo "<p>Sin sanear:</p>"; 
    	    dump($product);
    	    
    	    echo "<p>Saneado:</p>"; 
    	    dump($product->saneate());
        ?>  	
	</section>
	
    <section id="trim">
    	<h3>trim()</h3>
    	
    	<p>El método <code>trim()</code> <b>quita espacios en blanco</b> del inicio y final
    	de los campos de la entidad.</p>
    	
    	
    	<pre>
    		<code>
    $product = new Product();
    $product->name      = '  Monitor      ';
    $product->vendor    = "Samsung Cool Blue      ";
    		</code>
    	</pre>
    	
	    <?php 
            $product = new Product();
            $product->name      = '  Monitor      ';
            $product->vendor    = "Samsung Cool Blue      ";
            
            echo "<p>Sin quitar espacios al inicio y final:</p>"; 
            dump($product);
            
            echo "<p>Quitando espacios al inicio y final:</p>"; 
            dump($product->trim());
        ?>  	
	</section>	

</main>    
    
    