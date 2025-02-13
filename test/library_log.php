<main>
	<h1>Test de la librería Log</h1>
	
	<p>La clase <span class='bold italic'>Log</span> nos permitirá guardar información en ficheros
	de <i>Log</i>.</p>
	

	<h2>Métodos estáticos</h2>
	
	<section id="addMessage">
		<h3>Log::addMessage()</h3>
		<p>El método estático <code>Log::addMessage()</code> es la forma más sencilla de 
		añadir un mensaje al fichero de registro. Vamos a guardar un nuevo mensaje
		en el fichero <span class="path">../logs/test.log</span>, haciendo: </p>
		<p><code>Log::addMessage('../logs/test.log', 'NOTICE', 'Esto es un test')</code>.</p>
		
		<p>Se han escrito <b><?= Log::addMessage('../logs/test.log', 'NOTICE', 'Esto es un test') ?> bytes</b>.</p>
		
	</section>
	
	
	
	<h2>Métodos de objeto</h2>
	
	<section id="constructor">
		<h3>Constructor</h3>
		<p>El constructor simplemente recibe la ruta para el fichero, por ejemplo
		<code> $log = new Log('../logs/test.log')</code>.</p>
		
		<pre>
			<?php 
			     $log = new Log('../logs/test.log');
			     dump($log); 
		     ?>
		</pre>

		<p>Una vez creado el objeto, podremos añadir mensajes con el método <a href="#add"><code>add()</code></a>.
		Como esta clase hereda de <i>File</i>, podremos realizar multitud de operaciones sobre el fichero, 
		consultad el test y documentación de 
		<a href="/test/library_file">library_file</a>.</p>
		
	</section>
	
	<section id="add">
		<h3>add()</h3>
		<p>El método <code>add()</code> es el método de objeto que permite <b>añadir un mensaje al 
		final del fichero de LOG</b>.</p>
		
		<p>Vamos a guardar otro mensaje en el fichero test.log:</p>
		<pre>
		<code>
$bytes = $log->add('WARNING', 'Este es otro test, ahora con el método de objeto.');
		</code>
		</pre>
		
		<?php 
    		$bytes = $log->add('WARNING', 'Este es otro test, ahora con el método de objeto.');
		?>
		<p>Se han escrito <b><?= $bytes ?> bytes</b>.</p>
		
	</section>
	


	<h2>Usando métodos de File</h2>
	
	<section id="file">
		<h3>Métodos de File</h3>
		
		<p>Como el objeto <i>Log</i> es un tipo de <i>File</i>, podremos usar sobre él todos los 
		métodos de objeto de la clase, por ejemplo para copiar, mover o comprobar el tamaño.</p>
		
		<pre>
		<code>
dump($log);

echo "Ruta: ".$log->getPath();
echo "Extensión: ".$log->getExtension();
echo "Size: ".$log->getSize()." bytes";   	
		</code>
		</pre>
		
	<p>El resultado es:</p>
		<?php 		
    		dump($log);
    		
    		echo "<p>Ruta: <b>".$log->getPath()."</b><br>";
    		echo "Extensión: <b>".$log->getExtension()."</b><br>";
    		echo "Size: <b>".$log->getSize()." bytes</b></p>";
		?>
	
	</section>
		
	<section id="leyendo">
		<h3>Leyendo el fichero de Log</h3>
		
		<p>Podemos usar el método <code><a href="/test/library_file#read">read()</a></code> para recuperar su contenido
		textual. Para que se muestren bien los saltos de línea, podemos
		usar el <i>helper</i> <code>paragraph()</code>.</p>
				
		<pre>
		<code>
$text = $log->read();	
echo paragraph($text);
		</code>
		</pre>
		
		<p>Este es el contenido del fichero:</p>
		<div class="border p1 my1">
		<?php 
	      $text = $log->read();
		  echo paragraph($text);
		?>
		</div>
		<p><?= "El tamaño ahora es de: <b>".$log->getSize()." bytes</b>" ?></p>		
	</section>
	
	
	
	<section id="setMaxSize">
		<h3>setMaxSize()</h3>
		
		<p>El método <code>setMaxSize()</code> permite <b>establecer el tamaño máximo para
		el fichero de LOG</b>. Hagamos una prueba, limitando el tamaño a 150 bytes y añadiendo
		un nuevo mensaje.</p>
		
		
		<pre>
		<code>
$log->setMaxSize(150);
$log->add('ERROR', 'Este mensaje hará que el fichero ocupe más de 150 bytes.');

echo paragraph($log->read());
		</code>
		</pre>
		
		<p>Este es el contenido del fichero, observad que se ha borrado la primera línea del fichero:</p>
		<div class="border p1 my1">
		<?php 
    		$log->setMaxSize(150);
    		$log->add('ERROR', 'Este mensaje hará que el fichero ocupe más de 150 bytes.');
    		
    		echo paragraph($log->read());
		?>
		</div>
		<p><?= "El tamaño ahora es de: <b>".$log->getSize()." bytes</b>" ?>, no pasa nada si excede
		los 150 bytes por unos pocos bytes, lo que importa es que al añadir una línea nueva al final
		 eliminará la primera. Si intentamos guardar algunos mensajes más...</p>	
		 
		 <pre>
		<code>
$log->add('NOTICE', 'Toma otro mensaje.');
$log->add('NOTICE', 'Y otro.');

echo paragraph($log->read());
		</code>
		</pre>
		<div class="border p1 my1">
		<?php 
    		$log->add('NOTICE', 'Toma otro mensaje.');
    		$log->add('NOTICE', 'Y otro.');
    		
    		echo paragraph($log->read());
		?>
		</div>
		<p><?= "El tamaño ahora es de: <b>".$log->getSize()." bytes</b>" ?></p>
	</section>
	
	
	
	<section id="borrando">
		<h3>Borrando el fichero de Log</h3>
		
		<p>Podemos usar el método <code><a href="/test/library_file#delete">delete()</a></code>
		 para eliminarlo.</p>
		
		<pre>
		<code>
$log = new Log('../logs/test.log');
$log->delete();	

echo $log->exists() ? "No se ha borrado" : "Fichero borrado";
		</code>
		</pre>
		
		<?php 
    		$log = new Log('../logs/test.log');
    		$log->delete();
    		
    		echo $log->exists() ? 
    		  "<p class='bold'>No se ha borrado.</p>" : 
    		  "<p class='bold'>Fichero borrado.</p>";
		?>
		
	</section>
	
 </main>