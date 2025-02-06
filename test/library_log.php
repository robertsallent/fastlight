<main>
	<h1>Test de la librería Log</h1>
	
	<p>La clase <span class='bold italic'>Log</span> nos permitirá guardar información en ficheros
	de <i>Log</i>.</p>
	

	<section id="addMessage">
		<h2>Log::addMessage()</h2>
		<p>El método estático <code>Log::addMessage()</code> es la forma más sencilla de 
		añadir un mensaje al fichero de registro. Vamos a guardar un nuevo mensaje
		en el fichero <span class="path">../logs/test.log</span>, haciendo: </p>
		<p><code>Log::addMessage('../logs/test.log', 'NOTICE', 'Esto es un test')</code>.</p>
		
		<p>Se han escrito <b><?= Log::addMessage('../logs/test.log', 'NOTICE', 'Esto es un test') ?> bytes</b>.</p>
		
	</section>
	
	<section id="add">
		<h2>add()</h2>
		<p>El método <code>add()</code> es el método de objeto que permite <b>añadir un mensaje al 
		final del fichero de LOG</b>.
		
		<p>Vamos a guardar otro mensaje en el fichero test.log:</p>
		<pre>
		<code>
$fichero = new Log('../logs/test.log');
$bytes = $fichero->add('WARNING', 'Este es otro test, ahora con el método de objeto.');
		</code>
		</pre>
		
		<?php 
    		$fichero = new Log('../logs/test.log');
    		$bytes = $fichero->add('WARNING', 'Este es otro test, ahora con el método de objeto.');
		?>
		<p>Se han escrito <b><?= $bytes ?> bytes</b>.</p>
		
	</section>
	

	<section id="getFile">
		<h2>getFile()</h2>
		
		<p>El método <code>getFile()</code> nos <b>permite recuperar una instancia de 
		<a href="/test/library_file">File</a></b> 
		a partir del fichero de LOG. A partir de ese momento, podremos usar sobre él todos los 
		métodos de objeto de la clase, por ejemplo para copiar, mover o comprobar el tamaño.</p>
		
		<pre>
		<code>
$fichero = new Log('../logs/test.log');
$fichero = $fichero->getFile();

dump($fichero);

echo "Ruta: ".$fichero->getPath();
echo "Extensión: ".$fichero->getExtension();
echo "Size: ".$fichero->getSize()." bytes";   	
		</code>
		</pre>
		
	<p>El resultado es:</p>
		<?php 
    		$fichero = (new Log('../logs/test.log'))->getFile();    		
    		dump($fichero);
    		
    		echo "<p>Ruta: <b>".$fichero->getPath()."</b><br>";
    		echo "Extensión: <b>".$fichero->getExtension()."</b><br>";
    		echo "Size: <b>".$fichero->getSize()." bytes</b></p>";
		?>
	
	</section>
	
		
	<section>
		<h2>Leyendo el fichero de Log</h2>
		
		<p>Cuando recuperamos el fichero de <i>LOG</i> a modo de <i>File</i>,
		podemos usar el método <code><a href="/test/library_file#read">read()</a></code> para recuperar su contenido
		textual. Para que se muestren bien los saltos de línea, podemos
		usar el <i>helper</i> <code>paragraph()</code>.</p>
		
		<p>Ejemplo:</p>
		
		<pre>
		<code>
$text = (new Log('../logs/test.log'))->getFile()->read();	
echo paragraph($text);
		</code>
		</pre>
		
		<p>Este es el contenido del fichero:</p>
		<?php 
		  $text = (new Log('../logs/test.log'))->getFile()->read();
		  echo paragraph($text);
		?>
		
	</section>
	
	
	<section>
		<h2>Borrando el fichero de Log</h2>
		
		<p>Cuando recuperamos el fichero de <i>LOG</i> a modo de <i>File</i>,
		podemos usar el método <code><a href="/test/library_file#delete">delete()</a></code>
		 para eliminarlo.</p>
		
		<p>Ejemplo:</p>
		
		<pre>
		<code>
$fichero = (new Log('../logs/test.log'))->getFile();
$deleted = $fichero->delete();	

echo $fichero->exists() ? "No se ha borrado" : "Fichero borrado";
		</code>
		</pre>
		
		<?php 
    		$fichero = (new Log('../logs/test.log'))->getFile();
    		$deleted = $fichero->delete();
    		
    		echo $fichero->exists() ? 
    		  "<p class='bold'>No se ha borrado.</p>" : 
    		  "<p class='bold'>Fichero borrado.</p>";
		?>
		
	</section>
	
 </main>