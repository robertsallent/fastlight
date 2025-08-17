<main>

	<h1>Test de la clase Model</h1>
	<h2>Operaciones READ del CRUD</h2>
	
	
	
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
    
    <h2>Recuperar por ID</h2>
    
    <section id="find">
    	<h3>find()</h3>
    	<p>El método estático <code>find()</code> permite <b>recuperar una entidad a partir de su identificador
    	único</b>, por ejemplo, para recuperar el producto con id de valor 3 haremos: <code>$product = Product::find(3);</code>.</p>
    	
    	<?php dump(Product::find(3)) ?>
    	
    	<p>El método asume que el campo en el que buscar se llama <b>id</b>, para buscar en otros campos,
    	se pueden usar los métodos 
    	<code><a href="#getFiltered">getFiltered()</a></code>, 
    	<code><a href="#where">where()</a></code> o 
    	<code><a href="#whereExactMatch">whereExactMatch()</a></code>.</p>
    	
    	<p>Si intentamos buscar una entidad inexistente, retorna <code>null</code>.</p> 
    	<p>Por ejemplo <code>$product = Product::find(3000);</code>.</p>
    	
    	<?php dump(Product::find(3000)) ?>
    	
    </section>
    
    
    <section id="findOrFail">
    	<h3>findOrFail()</h3>
    	<p>El método estático <code>findOrFail()</code> permite <b>recuperar una entidad a partir de su identificador
    	único</b>. La diferencia con el método <code>find()</code> es que, si no encuentra la entidad, se produce
    	una excepción de tipo <b>NotFoundException</b>. Esta excepción el framework la trata y redirige al usuario automáticamente
    	hacia la vista de error 404.</p>
    	
    	<p><code>$product = Product::findOrFail(3);</code></p>
    	<?php dump(Product::findOrFail(3)) ?> 
    	
    	
    	<p>En el ejemplo siguiente Se busca un producto inexistente. Como el método lanza
    	una excepción, he puesto un <code>try - catch</code> para no acabar en la página 
    	de error de <i>FastLight</i>.
    	<code>$product = Product::findOrFail(3000);</code></p>
    	
    	<?php 
    	try{
    	    dump(Product::findOrFail(3000)); 
    	}catch(NotFoundException $e){
    	       echo "<p class='danger p1'>".$e->getMessage()."</p>"; 
    	}?>  	    	
    </section>
    
    
    <h2>Múltiples resultados</h2>

	<section id="all">
    	<h3>all()</h3>
    	<p>El método estático <code>all()</code> permite <b>recuperar todas las entidades</b>
    	del modelo a modo de array de objetos. Los objetos serán del tipo de modelo,
    	por ejemplo, para recuperar la lista de productos haremos: <code>$products = Product::all()</code>.</p>
    	
    	<p>Opcionalmente, se puede indicar un límite y un <i>offset</i> para los resultados.
		Por ejemplo, para limitar a los tres primeros resultados: <code>$products = Product::all(3)</code></p>
    	<?php dump(Product::all(3)) ?>
    </section>
    
    
    <section id="orderBy">
    	<h3>orderBy()</h3>
    	<p>El método estático <code>orderBy()</code> permite recuperar todas las entidades
    	del modelo a modo de array de objetos, ordenados por el campo que queramos. 
    	Los objetos serán del tipo de modelo,
    	por ejemplo, para recuperar la lista de productos ordenado por nombre del producto
    	descendente haremos: <code>$products = Product::orderBy('name','DESC');</code>.</p>
    	
    	<?php dump(Product::orderBy('name','DESC')) ?>
    </section>
    
    
    <section id="getFiltered">
    	<h3>getFiltered()</h3>
    	<p>El método estático <code>getFiltered()</code> permite recuperar entidades
    	del modelo a modo de array de objetos, <b>aplicando un filtro sobre un único campo</b> 
    	usando <code>LIKE</code> en la sentencia SQL. Los objetos de la lista serán del tipo de modelo.</p>
    	
    	<p>Por ejemplo, para recuperar la lista de productos con la palabra 'computer' en el nombre, haremos: 
    	<code>$products = Product::getFiltered('name','computer');</code>.</p>
    	
    	<?php dump(Product::getFiltered('name','computer')) ?>
    </section>
    
    
     <section id="where">
    	<h3>where()</h3>
    	<p>El método estático <code>where()</code> permite recuperar entidades
    	del modelo a modo de array de objetos, <b>aplicando múltiples filtros</b> usando <code>LIKE</code>
    	en la sentencia SQL. Los objetos de la lista serán del tipo de modelo.</p>
    	
    	<p>Los filtros deben indicarse a modo de array asociativo en pares de campo => valor buscado.
    	Por ejemplo, para recuperar la lista de productos con 'computer' en el campo 'name' haremos: 
    	<code>$products = Product::where(['name' => 'computer']);</code>.</p>
    	
    	<?php dump(Product::where(['name' => 'computer'])) ?>
    </section>
    
     <section id="whereExactMatch">
    	<h3>whereExactMatch()</h3>
    	<p>El método estático <code>whereExactMatch()</code> permite recuperar entidades
    	del modelo a modo de array de objetos, <b>aplicando múltiples filtros y buscando una coincidencia exacta</b>.
    	Los objetos de la lista serán del tipo de modelo.</p>
    	<p>Los filtros deben indicarse a modo de array asociativo en pares de campo => valor buscado.
    	Por ejemplo, para recuperar ventas con dos productos haremos: 
    	<code>$sales = Sale::whereExactMatch(['quantity' => 2]);</code>.</p>
    	
    	<?php dump(Sale::whereExactMatch(['quantity' => 2])) ?>
    </section>
    
    <section id="isNull">
    	<h3>isNull()</h3>
    	<p>El método estático <code>isNull()</code> permite recuperar entidades
    	del modelo a modo de array de objetos, <b>buscando valores nulos en un campo concreto</b>. 
    	Los objetos de la lista serán del tipo de modelo. Por ejemplo, para recuperar la lista 
    	de usuarios sin foto haremos: 
    	<code>$users = User::isNull('picture');</code>.</p>
    	
    	<?php dump(User::isNull('picture')) ?>
    </section>
    
    
    <section id="isNotNull">
    	<h3>isNotNull()</h3>
    	<p>El método estático <code>isNotNull()</code> permite recuperar entidades
    	del modelo a modo de array de objetos, <b>buscando valores no nulos en un campo concreto</b>. 
    	Los objetos de la lista serán del tipo de modelo. Por ejemplo, para recuperar la lista 
    	de usuarios con foto haremos: 
    	<code>$users = User::isNotNull('picture');</code>.</p>
    	
    	<?php dump(User::isNotNull('picture')) ?>
    </section>
    
    
</main>    
    
    