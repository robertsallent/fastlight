<main>

	<h1>Test de la clase Model</h1>
	<h2>Exportación a JSON o XML</h2>
	
	
	
	<?php 
    	// clases del modelo para las pruebas
    	class Product extends Model{};
    	class Customer extends Model{};
    	class Sale extends Model{};
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
    
    <h2>Exportar a JSON</h2>
    <section id="json">
    	<h3>toJSON()</h3>
    	<p>TODO.</p>
    	
    	<?php dump(Product::find(3)->toJSON()) ?>	
    </section>
    
    
    <h2>Exportar a XML</h2>
    <section id="xml">
    	<h3>toXML()</h3>
    	<p>TODO.</p>
    	
    	<?= htmlentities(Product::find(3)->toXML()) ?>
    </section>
    
    
    <h2>Exportar a CSV</h2>
    <section id="csv">
    	<h3>toCSV()</h3>
    	<p>TODO.</p>
    	
    	<?php dump(Product::find(3)->toCSV()) ?>	
    </section>
    
    
    <h2>Exportar a texto</h2>
    <section id="string">
    	<h3>_toString()</h3>
    	<p>TODO.</p>
    	
    	<?= Product::find(3) ?>	
    </section>
    
</main>    
    
    