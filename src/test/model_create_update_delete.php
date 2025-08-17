<main>

	<h1>Test de la clase Model</h1>
	<h2>Operaciones Create, Update y Delete del CRUD</h2>
	
	<?php 
    	// clases del modelo para las pruebas
    	class Product      extends Model{};
    	class Customer     extends Model{};
    	class Sale         extends Model{};
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
    
    <section id="save">
    	<h3>save()</h3>
    	
    	<p>Podemos crear entidades del modelo haciendo uso del constructor, asignando
    	los valores de las propiedades y llamando al método <code>save()</code>.</p>
    	
    	<p>Por ejemplo:</p>
    	<pre><code>
    $product = new Product();
    
    $product->name = 'Screen';
    $product->description = 'Full HD';
    $product->price = 300;
    
    $id = $product->save();
    	</code></pre>
    	
    <p>El método <code>save()</code> retorna el id autonumérico generado en la tabla
    de la base de datos o 0 en caso de que la tabla no dispona de autonumérico.</p> 	
    <?php 
        $product                = new Product();
        $product->name          = 'Screen';
        $product->description   = 'Full HD';
        $product->price         = 300;
        
        $idProduct = $product->save();
        
        echo "<p>Producto <b>guardado con id $idProduct</b>. Comprobando:</p>";
        dump(Product::find($idProduct));
    ?>
    
    </section>
       
    
    <section id="create">
    	<h3>create()</h3>
    	
    	<p>Existe un método <code>create()</code>, que permite la creación del objeto
    	y guardado en la BDD en un solo paso, a partir de un array asociativo.</p>
    	
    	<pre>
    	<code>
    $user = User::create([
        'displayname' => 'Robert',
        'email'       => 'robert@fastlight.com',
        'phone'       => '12345612345',
        'password'    =>  md5('Hola')
    ]);
    	</code>
    	</pre>
    	
    	
    	<?php 
            $user = User::create([
                'displayname' => 'Robert',
                'email'       => 'robert@fastlight.com',
                'phone'       => '12345612345',
                'password'    =>  md5('Hola')
            ]);
            
            echo "<p>Usuario <b>creado con id $user->id</b>.</p>";
            
            echo "<p>Objeto User creado:</p>";
            dump($user);
            
            echo "<p>Objeto User guardado y recuperado desde la BDD:</p>";
            dump(User::find($user->id));
        ?>

    	
    	<p>Este método puede ser <span class="maxi">peligroso</span> si lo usamos en combinación con los métodos  
    	<code><a href="https://fastlight-demo.robertsallent.com/test/http_request#all">all()</a></code> o 
    	<code><a href="https://fastlight-demo.robertsallent.com/test/http_request#post">posts()</a></code> de la clase <b>Request</b>, que recuperan los 
    	datos que nos envían desde formularios a modo de <i>array</i> asociativo.</p>
    	
    	<p>La operación <code>$id = User::create(request()->posts())</code>
    	permite crear un usuario a partir de los datos recibidos en el formulario de registro
    	en una sola línea de código, pero está <b>expuesta a inyecciones de datos peligrosas</b> (por ejemplo
    	sobre el campo <i>roles</i>).</p>
    	
    	<p>Afortunadamente, desde la versión <b>v1.8.0</b> se incorpora una protección para esta situación: solamente
    	se realiza la asignación masiva sobre los campos indicados en la propiedad estática <code>$fillable</code>
    	del modelo.</p>
    	
    	<p>Por ejemplo, en la lista de campos "rellenables" de la clase User, no está la propiedad <code>$roles</code>,
    	aquí podemos ver los campos que hay:</p>
    	
    	<p><code>protected static $fillable = ['displayname', 'email', 'phone', 'password', 'picture'];</code></p>
    	
    </section>
    
    
    <h2>Actualizando entidades</h2>
    <section id="update">
    	<h3>update()</h3>
    	
    	<p>El método de objeto <code>update()</code> <b>actualiza los datos de la base
    	de datos con los datos contenidos en el objeto PHP</b>.
    	Por ejemplo, para cambiar los datos del monitor creado anteriormente,
    	podemos hacer:</p>
    	
    	<pre>
    		<code>
    $product = Product::find(<?= $idProduct ?>);
    
    $product->name = 'Monitor';
    $product->description = 'Older one';
    $product->price = 200;
    
    $rows = $product->update();   		
    		</code>
    	</pre>
    
    <?php 
        $product = Product::find($idProduct);
        $product->name = 'Monitor';
        $product->description = 'Older one';
        $product->price = 200;
        $rows = $product->update();   		
    ?>
    
        <p>Este método retorna el número de filas afectadas.</p>
        
        <p>Se ha actualizado el producto <?= $idProduct ?>. Comprobando:</p>
        <?php dump(Product::find($idProduct)) ?>
    </section>
    
    
    
    <section id="create2">
    	<h3>create()</h3>
    	
    	<p>El método <code>create()</code>, además del guardado de una nueva entidad, 
    	también permite la actualización. Para ello debe recibir el ID mediante el array
    	asociativo o bien mediante el segundo parámetro.</p>
    	
    	<pre>
    	<code>
    $data = [
        'displayname'=>'FastLight',
    	'phone' => '0000000'
	];
    
    $user = User::create($data, <?= $user->id ?>);
    	</code>
    	</pre>
    	
        <?php 
            $data = [
            	'displayname'=>'FastLight',
                'phone' => '0000000'
        	];
            
            $user = User::create($data, $user->id);
            
            echo "<p>Usuario <b>actualizado con id $user->id</b>.</p>";
            
            echo "<p>Objeto User creado:</p>";
            dump($user);
            
            echo "<p>Objeto User actualizado y recuperado desde la BDD:</p>";
            dump(User::find($user->id));
        ?>
    </section>	
    
    
    <h2>Eliminando entidades</h2>
    
    <section id="delete">
    	<h3>delete()</h3>
    	
    	<p>Para borrar entidades de la BDD, podemos usar el método estático <code>delete()</code>,
    	que <b>elimina un registro a partir de su id</b>.
    	Por ejemplo: <code>$rows = User::delete(<?= $idUser ?>)</code>.</p>
    	
    	<p class='bold'><?= User::delete($user->id) ? "Usuario $idUser borrado correctamente" : "No se pudo borrar $idUser" ?>.</p>
    
    </section>


	<section id="deleteObject">
    	<h3>deleteObject()</h3>
    	
    	<p>Existe también el método <code>deleteObject()</code>,
    	que se comporta de manera similar al método anterior pero que, al tratarse de un método
    	de objeto, no es necesario que le pasemos el identificador.
		Por ejemplo: <code>$rows = $product->deleteObject()</code>.</p>
    	
    	<p class='bold'><?= $product->deleteObject() ? "Producto $product->id borrado correctamente" : "No se pudo borrar $product->id" ?>.</p>   
   
    </section>
    
  
  
</main>    
    
    