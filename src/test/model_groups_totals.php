<main>

	<h1>Test de la clase Model</h1>
	<h2>Totales y grupos</h2>
	
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
	
	
    <h2>Creando nuevas entidades</h2>
    
    <h2>Cálculo de totales</h2>
    
    <section id="total">
    	<h3>total()</h3>
    	<p>El método estático <code>total()</code> permite <b>hacer cálculos de totales
    	sobre un campo concreto</b>. Para ello, recibe el nombre de la función de 
    	agregado a utilizar y el nombre del campo. Por ejemplo, para obtener el precio promedio de los productos: 
    	<code>$total = Product::total('AVG','price');</code>
   
   		<p>El precio promedio es <b><?= Product::total('AVG','price') ?></b> euros.</p>
    	
    	<p>Los parámetros son opcionales, si no se indican realizará la operación <i>COUNT</i>
    	 sobre el campo id. Retorna un único valor.</p>
    	 
    	 
        <?php 
            echo "<p>COUNT de productos: <b>".Product::total()."</b></p>";
            echo "<p>MAX del precio: <b>".Product::total('MAX', 'price')."</b> euros.</p>";
            echo "<p>MIN del precio: <b>".Product::total('MIN', 'price')."</b> euros.</p>";
            echo "<p>AVG del precio: <b>".Product::total('AVG', 'price')."</b> euros.</p>";
            echo "<p>SUM del precio: <b>".Product::total('SUM', 'price')."</b> euros.</p>";
        ?>
    </section>
    
    <h2>Totales y grupos</h2>
    
    <section id="groupBy">
    	<h3>groupBy()</h3>
    	
    	<p>El método <code>groupBy()</code> permite <b>recuperar datos de totales
    	con condiciones de agrupado, sobre una sola tabla</b>. Recibe dos parámetros: el primero es un array asociativo con
    	pares de 'campo' => 'funcion de agregado' y el segundo es un array indexado
    	con la lista de campos para agrupar por.</p>
    	
    	<p>Por ejemplo, para contar los clientes de cada ciudad podemos hacer:
    	<code>$resultados = Customer::groupBy(['id'=>'COUNT'], ['city']);</code>.</p>
    	
    	<p>Es importante mencionar que los campos de totales tendrán el nombre combinado
    	   <i>campofunción</i>, por ejemplo <b>idcount</b> para el ejemplo anterior.</p>
    	
        <ul>
        <?php 
            $resultados = Customer::groupBy(['id'=>'COUNT'], ['city']); 
            
            foreach($resultados as $resultado)
                echo "<li>$resultado->city: <b>$resultado->idcount</b></li>";
        ?>
        </ul>
   
    
        <p>Si queremos hacer consultas de totales y agrupado con varias tablas, podemos
        usar el método <code>selectAll()</code> de las clases para 
		indicar expresamente la consulta, encontraréis el ejemplo en el test de  
		<a href="/test/db_pdo#totalGroups">db_pdo</a>.</p>
    </section>
 
</main>    
    
    