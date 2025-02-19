<main>

	<h1>Test de la clase Model</h1>
	<h2>Relaciones 1 a N</h2>

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
	
    
    <?php 
    	// clases del modelo para las pruebas
    	class Product extends Model{};
    	class Customer extends Model{};
    	class Sale extends Model{};
	?>
	
	
	<section id="hasAny">
		<h2>hasAny()</h2>
		
		<p>El método <code>hasAny()</code> sirve para <b>comprobar si una entidad
		del lado 1 tiene otras entidades relacionadas en la tabla del lado N</b>.</p>
		
		<p>Por ejemplo,
		si queremos comprobar si el cliente 1 ha comprado algo podemos hacer 
		<code>$hasSales = Customer::find(1)->hasAny('Sale')</code>.</p>
		
		<?php
            echo Customer::find(1)->hasAny('Sale') ? 
                    "<p><b>El cliente 1 ha comprado cosas.</b></p>":
                    "<p><b>El cliente 1 no ha comprado nada.</b></p>";
        ?>
        
        <p>Si lo probamos con el cliente 13, veremos que no ha comprado nada
        <code>$hasSales = Customer::find(13)->hasAny('Sale')</code>.</p>
        <?php 
            echo Customer::find(13)->hasAny('Sale') ?
                    "<p><b>El cliente 13 ha comprado cosas.</b></p>":
                    "<p><b>El cliente 13 no ha comprado nada.</b></p>";
        ?> 
	</section>
	
	 
	<section id="hasMany">
    	<h2>hasMany()</h2>
    	
    	<p>El método <code>hasMany()</code> permite <b>recuperar las entidades del lado N relacionadas con la entidad
    	principal en una relación 1 a N</b>.</p>
    	
    	<p>Por ejemplo, para recuperar todas las compras del cliente 1, podemos hacer:
    	<code>$sales = Customer::find(1)->hasMany('Sale');</code>.</p>
    	<pre>
<?php var_dump(Customer::find(1)->hasMany('Sale')) ?>
    	</pre>
    	
    	<p>Si lo probamos con el cliente 13, veremos que no ha comprado nada:</p>
    	<pre>
<?php var_dump(Customer::find(13)->hasMany('Sale')) ?>
    	</pre>
    	
    	<p>Las ventas en las que se ha adquirido el producto 11:  
    	<code>$sales = Product::find(11)->hasMany('Sale');</code></p>
    	
    	<pre>
<?php var_dump(Product::find(11)->hasMany('Sale')) ?>
    	</pre>
    	    	
    </section>
    
	 
	<section id="belongsToAny">
		<h2>belongsToAny()</h2>
		
		<p>El método <code>belongsToAny()</code> sirve para <b>comprobar si una entidad
		del lado N está relacionada en la tabla del lado 1</b>. Esto solamente tiene sentido
		si en la clave foránea se permiten valores nulos (el 0 en la relación).</p>
		
		<p> Por ejemplo, si queremos comprobar si conocemos el cliente de la venta 5, podemos hacer:
		<code>$hasCustomer = Sale::find(5)->belongsToAny('Customer')</code>.</p>
		<?php
		  echo Sale::find(5)->belongsToAny('Customer') ? 
                    "<p><b>Conocemos el cliente de la venta 5.</b></p>":
                    "<p><b>No conocemos el cliente de la venta 5.</b></p>";
        ?>
        
        <p>Si lo probamos con el la venta 28, veremos que no conocemos el cliente
        <code>$hasCustomer = Sale::find(28)->belongsToAny('Customer')</code>.</p>
        <?php
            echo $hasCustomer = Sale::find(28)->belongsToAny('Customer') ? 
                    "<p><b>Conocemos el cliente de la venta 28.</b></p>":
                    "<p><b>No conocemos el cliente de la venta 28.</b></p>";
        ?>
	</section>
    
 
 
    <section id="belongsTo()">
    	<h2>belongsTo()</h2>
    	
    	<p>El método <code>belongsTo()</code> permite <b>recuperar la entidad del lado 1 relacionada
    	con una entidad del lado N</b> (recorre la relación desde la N hasta el 1). Por ejemplo, 
    	para encontrar el cliente que realizó la compra 5, podemos hacer:
    	<code>$customer = Sale::find(5)->belongsTo('Customer');</code></p>
    	
    	<pre>
<?php var_dump(Sale::find(5)->belongsTo('Customer')) ?>
    	</pre>
    	
    	<p>Si de una venta no sabemos el cliente, retorna <i>NULL</i>. Por ejemplo para la venta 28: 
    	<code>$customer = Sale::find(28)->belongsTo('Customer');</code>.</p>
    	
    	<pre>
<?php var_dump(Sale::find(28)->belongsTo('Customer')) ?>
    	</pre>  	
    </section>
   
   
   
	<section id="views">
		<h2>Trabajando con vistas</h2>
		
		<?php class V_sale extends Model{} ?>

		<p>Si queremos información extra del producto, sin sobrecargar en exceso la base de datos, podemos
    	usar el mecanismo de <b>vistas en la BDD</b>.</p>
    	<p>En la BDD <i>sales_example</i> existe una vista <i>v_sales</i> con la información
    	ampliada de la venta. Tan solo tenemos que crear una clase del modelo llamada <i>V_sale</i> y hacer: 
    	<code>$extendedSales = Customer::find(1)->hasMany('V_sale');</code>. Observad que los dos últimos campos son el nombre
    	del producto y el precio actual, que salen de la tabla <i>products</i>.</p>
    	
    	<pre>
<?php var_dump(Customer::find(1)->hasMany('V_sale')) ?>
    	</pre>    	
	</section>
</main>    
    