<main>
	<h1>Test de conexión con BDD (mysqli)</h1>
	
	<p>En este test se prueba el funcionamiento de los métodos para implementar el 
		<b>CRUD</b> de la clase <b class='maxi'>DBMysqli</b>, que trabaja con el 
		conector <b>mysqli</b> de <i>PHP</i>. 
		Cada uno de los test está planteado también a modo de ejemplo e incluye una 
		pequeña explicación (se recomienda también consultar el código del test).</p>

	<p>Este test es idéntico al test para <a href="/test/db_pdo">DBPDO</a>, 
	solamente se ha cambiado el nombre de la clase.</p>
	
    <section id="select">
        <h2>Pruebas de select()</h2>
        
        <p>Para recuperar los datos desde la BDD, se usan los métodos <code>select()</code>
        y <code>selectAll()</code>. El primero se usa para consultas que puedan retornar 
        uno o ningún resultado, mientras que el segundo se usa para consultas que pueden
        retornar múltiples resultados.</p>
        
        <p>Recuperando el producto 2.</p>
        <p><code>$product = DBMysqli::select("SELECT * FROM products WHERE id = 2")</code></p>
        
        <?php dump(DBMysqli::select("SELECT * FROM products WHERE id = 2")) ?>
        
        <p>Recuperando el producto 5000... (no existe).</p>
        <p><code>$product = DBMysqli::select("SELECT * FROM products WHERE id = 5000")</code></p> 
           
        <?php dump(DBMysqli::select("SELECT * FROM products WHERE id = 5000")) ?>
    </section>
    
    
    <section id="selectall">
        <h2>Pruebas de selectAll()</h2>  
        
        <p>Recuperando todos los productos (solamente 3)...</p>
        <p><code>$products = DBMysqli::selectAll("SELECT * FROM products LIMIT 3")</code></p> 
        
        <?php dump(DBMysqli::selectAll("SELECT * FROM products LIMIT 3"))?>    
    </section>
    
    
    <section id="map">
        <h2>Mapeando a tipos concretos</h2>  
        
        <p>En los ejemplos anteriores, hemos visto que los métodos <code>select()</code>
        y <code>selectAll()</code> retornan un <i>array</i> de objetos <i>stdClass</i>.
        Normalmente querremos trabajar con listas de objetos de tipos concretos (entidades
        del modelo, por ejemplo <i>Product</i>).</p>
        
        <p>Para ello, ambos métodos incorporan la posibilidad de recibir
        como <b>segundo parámetro el tipo de entidad</b> al que queremos
        mapear los resultados.</p>
        
        <?php class Product extends Model{} ?>
        
        <p>Recuperando el producto 2 a modo de <i>Product</i>.</p>
        <p><code>$product = DBMysqli::select("SELECT * FROM products WHERE id = 2", 'Product')</code></p>
        
        <?php dump(DBMysqli::select("SELECT * FROM products WHERE id = 2", 'Product')) ?>
        
        <p>Recuperando todos los productos (solamente 3) a modo de <i>Product</i>...</p>
        <p><code>$products = DBMysqli::selectAll("SELECT * FROM products LIMIT 3", 'Product')</code></p> 
        
        <?php dump(DBMysqli::selectAll("SELECT * FROM products LIMIT 3", 'Product'))?>    
    </section>
    
    
    <section id="insert">
        <h2>Pruebas de insert()</h2>
        
        <p>El método <code>insert()</code> se utiliza para realizar consultas de inserción
        sobre la BDD. Recibe la consulta a modo de cadena de texto y retorna el ID 
        autonumérico del registro insertado.</p>
        
        <p>Guardando un producto...</p>
        <p><code>$id = DBMysqli::insert(INSERT INTO products(name, description, price) VALUES('Toothbrush', 'English smile', 3))</code></p>
        
        <?php             
            $consulta = "INSERT INTO products(name, description, price) 
                         VALUES('Toothbrush', 'English smile', 3)";
             
            $id = DBMysqli::insert($consulta);
        ?> 
        
       	<p>El ID del nuevo producto es <?= $id ?></p>
        
        <p>Comprobando que se guardó correctamente...</p>
        <p><code>$product = DBMysqli::selectOne("SELECT * FROM products WHERE id=<?= $id ?>")</code></p>
        
        <?php dump(DBMysqli::selectOne("SELECT * FROM products WHERE id=$id")) ?>
        
    </section>
    
    
    <section id="update">
        <h2>Pruebas de update()</h2>
        
        <p>El método <code>update()</code> se utiliza para realizar consultas de actualización
        sobre la BDD. Recibe la consulta a modo de cadena de texto y retorna el número de filas afectadas.</p>
        
        <p>Actualizando un producto...</p>
        <p><code>$rows = DBMysqli::update(UPDATE products SET name='Toothpaste' WHERE id = <?= $id ?>)</code></p>
        
        <?php              
            $consulta = "UPDATE products SET name='Toothpaste' WHERE id = $id";
            $filas = DBMysqli::update($consulta);
        ?>    
        
		<p>Filas afectadas <?= $filas ?></p>
            
        <p>Comprobando que se actualizó correctamente...</p>
        <p><code>$product = DBMysqli::select("SELECT * FROM products WHERE id = <?= $id ?>")</code></p>
        
        <?php  dump(DBMysqli::select("SELECT * FROM products WHERE id = $id")) ?>
    </section>
     
     
    <section id="delete">   
        <h2>Pruebas de delete()</h2>
        
        <p>El método <code>delete()</code> se utiliza para realizar consultas de borrado.
        sobre la BDD. Recibe la consulta a modo de cadena de texto y retorna el número de filas afectadas.</p>
        
        <p>Borrando un producto...</p>
        <p><code>$rows = DBMysqli::delete("DELETE FROM products WHERE id = <?= $id ?>")</code></p>
       
        <?php $filas = DBMysqli::delete("DELETE FROM products WHERE id = $id") ?>
        
        <p>Filas afectadas <?= $filas ?></p>
        
        <p>Comprobando que se borró correctamente...</p>
        <p><code>$product = DBMysqli::selectOne("SELECT * FROM products WHERE id = <?= $id ?>")</code></p>
        
        <?php dump(DBMysqli::selectOne("SELECT * FROM products WHERE id = $id")) ?>
    </section>
    
    
    <section id="total">
        <h2>Pruebas de totales()</h2>
        
        <p>El método estático <code>total()</code>, permite realizar consultas de totales
        sin agrupar sobre una sola tabla. Le pasaremos por parámetro:
        
    	<ul>
    		<li>Nombre de la tabla.</li>
    		<li>Función de agregado a aplicar (opcional, por defecto COUNT).</li>
    		<li>Campo sobre el que calcular el total (opcional, por defecto *).</li>
    	</ul>
        
        <p>Por ejemplo: <code>$count = DBMysqli::total('products')</code> 
       	o bien <code>$avg = DBMysqli::total('products','AVG','price')</code></p>
        

		<p>Total de productos: 
       		<b><?= DBMysqli::total('products') ?></b>
		</p>
		<p>Fecha de alta del último usuario: 
			<b><?= DBMysqli::total('users','MAX','created_at') ?></b>
		</p>
		<p>Menor precio de un producto:
			<b><?= DBMysqli::total('products','MIN','price') ?>€</b>
		</p>
        <p>Precio medio de los productos: 
        	<b><?= DBMysqli::total('products','AVG','price') ?>€</b>
    	</p>
    </section>    
    
    
    <section id="totalGroup">
        <h2>Pruebas de totales con grupos (una tabla)</h2>
        
        <p>El método <code>groupBy()</code> permite realizar operaciones de totales con grupos.
        Se pueden indicar múltiples grupos y operaciones, pero con la limitación de que se deben
        realizar sobre una misma tabla.</p>
        
        <p>Sus parámetros son:</p>
        <ul>
        	<li>El nombre de la tabla, por ejemplo <i>customers</i>.</li>
        	<li>Un array asociativo de campo=>operacion, por ejemplo <code>['id'=>'COUNT']</code></li>
        	<li>Un array indezado de campos de agrupado, por ejemplo <code>[city]</code>.</li>
        </ul>
        
        <p>Este método retorna una lista de objetos de tipo <i>stdClass</i> con los campos de
        agrupado y los campos de totales, que tienen el nombre compuesto en orden operacion y valor
        en minúsculas, por ejemplo: idcount.</p>
        
        <p>Vamos a buscar el total de clientes por ciudad en la BDD de ejemplo:</p>
        <p><code>$resultados = DBMysqli::groupBy('customers', ['id'=>'COUNT'], ['city'])</code></p>
        
        
        <?php 
            $resultados = DBMysqli::groupBy('customers', ['id'=>'COUNT'], ['city']);
            dump($resultados);
        ?>
        
        <h3>Mostrados en una lista</h3>
        
        <ul>
        <?php    
            foreach($resultados as $resultado)
                echo "<li>$resultado->city: <b>$resultado->idcount</b></li>";
        ?>
        </ul>
     </section>
     
     <section id="totalGroups">
        <h2>Pruebas de totales con grupos (varias tablas)</h2>
        
        <p>Si queremos hacer consultas de totales y agrupado con varias tablas, 
        no nos sirve el método <code>groupBy()</code>, pero podemos
    	usar el método <code>selectAll()</code> y escribir directamente la consulta.</p>
    	
    	<p>Por ejemplo: cuenta de ventas agrupado por cliente:</p>
    	<p><code>$resultados = DBMysqli::selectAll(SELECT c.id, c.name, COUNT(s.id) AS totalSales
        FROM customers c LEFT JOIN sales s ON c.id=s.idcustomer
        GROUP BY c.id, c.name)</code></p>

    	<table class="table centered w50">
    		<tr>
    			<th>id</th>
    			<th>name</th>
    			<th>sales</th>
			</tr>
            <?php 
                $consulta ="SELECT c.id, c.name, COUNT(s.id) AS totalSales
                            FROM customers c LEFT JOIN sales s ON c.id=s.idcustomer
                            GROUP BY c.id, c.name";
                $resultados = DBMysqli::selectAll($consulta);
                
                foreach($resultados as $resultado){
                    echo "<tr>";
                    echo "<td>$resultado->id</td>";
                    echo "<td class='left'>$resultado->name</td>";
                    echo "<td class='bold'>$resultado->totalSales</td>";
                    echo "</tr>";
                }
            ?>
        </table>
    </section>    
    
    <section id="escape">
        <h2>Pruebas de escape()</h2>
        
        <p>El método <code>escape()</code> sanea las entradas para evitar
        ataques de <i>SQL Injections</i> o <i>XSS</i>.</p>
                
        <p>En el ejemplo se intentan guardar en base de datos textos con comillas, 
        apóstrofes, símbolos y también un script en JavaScript. Si bien el script
        se guardará en la BDD, se consigue que no se ejecute en el navegador.</p>
        
        <?php     
            echo "";
            
            $name = DBMysqli::escape("L'aperitiu");
            $description = DBMysqli::escape("Probando ¡& ' ' cosas <script>alert('hola')</script> raras \n de test.");
            $price = intval("10patatas");
            
            $consulta = "INSERT INTO products(name, description, price)
                         VALUES('$name', '$description', $price)";
            
            echo "<p>Consulta a ejecutar: <code>$consulta</code></p>";

            $id = DBMysqli::insert($consulta);
         ?>  
           
		<p>Comprobando que se insertó correctamente...</p>
		<p><code>$id = DBMysqli::select("SELECT * FROM products WHERE id = <?= $id ?>")</code></p>
        
        <?php dump(DBMysqli::select("SELECT * FROM products WHERE id = $id")) ?>
       
        <p>Borrando el registro que acabamos de guardar...</p>
        <p><code>$rows = DBMysqli::delete("DELETE FROM products WHERE id= <?= $id ?> ")</code></p>
        <?php $filas = DBMysqli::delete("DELETE FROM products WHERE id=$id ") ?>
        
        <p>Filas afectadas <?= $filas ?></p>
        
        
        
        <p>Comprobando que se borró correctamente...</p>
        <p><code>$product = DBMysqli::select("SELECT * FROM products WHERE id = <?= $id ?>")</code></p>
        <?php  dump(DBMysqli::select("SELECT * FROM products WHERE id = $id")) ?>

    </section>   
 </main>       

    