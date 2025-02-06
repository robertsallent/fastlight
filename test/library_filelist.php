<main>
	<h1>Test de FileList</h1>
	
	<h2>Trabajando con los métodos estáticos</h2>
	

	<section id="get">
		<h2>FileList::get()</h2>
		
		<p>El método estático <code>FileList::get()</code> <b>recupera una lista de entradas de directorio</b>
		a modo de <b>array de strings</b>. 
	   
	   Alternativamente, se puede trabajar con objetos de tipo <i>FileList</i> y usar el método
	   <code><a href="#getEntries">getEntries()</a></code> para realizar la misma tarea.</p>
	   
		<p>Si invocamos el método sin parámetros, retorna un listado de 
		entradas del directorio actual, sin las entradas especiales '.' (directorio actual) ni 
		'..' (directorio de orden superior).</p>
		
		<p>Contenido de la carpeta actual:</p>
		<p><code>FileList::get();</code></p>
		
		<?php dump(FileList::get()) ?>
	</section>
	
	
	
	<section id="actual">
		<h2>Listar un directorio distinto al actual</h2>
		<p>El método <code>FileList::get()</code> puede recibir como primer parámetro la ruta del 
		directorio a escanear.</p>
		
		<p>Contenido de la carpeta <i>templates</i>:</p>
		<p><code>FileList::get(<b>'../templates'</b>);</code></p>
		
		<?php dump(FileList::get('../templates')) ?>
	</section>
	
	
	
	<section id="extension">
		<h2>Listado con filtro por extensión</h2>
		<p>El método <code>FileList::get()</code> puede recibir como segundo parámetro un listado de extensiones. 
		Solamente listará entradas coincidentes con esas
		extensiones.</p>
		
		<p>Ficheros <i>php</i>, <i>ini</i> o <i>xml</i> de la carpeta public:</p>
		<p><code>FileList::get('../public', <b>['xml','php','ini']</b>);</code></p>
		
		<?php dump(FileList::get('../public', ['xml','php','ini'])) ?>
	</section>
	
	
	
	<section id="regexp">
		<h2>Listado con filtro de expresión regular</h2>
		<p>El método <code>FileList::get()</code> también puede recibir como segundo parámetro una expresión regular. 
		Solamente listará entradas coincidentes con esa expresión regular.</p>
		
		<p>Ficheros <i>php</i> o <i>txt</i> de la carpeta public:</p>
		<p><code>FileList::get('../public', <b>'/\.(php|txt)$/i'</b>);</code></p>
		
		<?php dump(FileList::get('../public', '/\.(php|txt)$/i')) ?>
	</section>
	
	
	
	<section id="special">
		<h2>Entradas especiales '.' y '..'</h2>
		
		<p>Ficheros PNG en <i>public/images/template</i> sin listar el '.' ni '..':</p> 
		<p><code>FileList::get('../public/images/template', ['png']);</code></p>
		
		<?php dump(FileList::get('../public/images/template', ['png'])) ?>
		
		
		<p>Si queremos que liste las entradas especiales '.' y '..' 
		podemos indicarlo mediante el tercer parámetro (por defecto <code>false</code>).
		Por ejemplo, ficheros PNG en <i>public/images/template</i> con las entradas '.' y '..' incluidas:</p>
		<p><code>FileList::get('../public/images/template', ['png'], <b>true</b>);</code></p>
		
		<?php dump(FileList::get('../public/images/template', ['png'], true)) ?>
		
		
		<p>Si no queremos aplicar filtro, el segundo parámetro puede ser NULL, cadena vacía o 
		array vacío (pero no podemos omitirlo). Por ejemplo, contenido de la carpeta 
		<i>public/images/template</i> con las entradas '.' y '..' incluidas:</p> 		
		<p><code>FileList::get('../public/images/template', <b>NULL</b>, <b>true</b>);</code></p>
		
		<?php dump(FileList::get('../public/images/template', NULL, true)) ?>
	</section>
	
	
	
	<section id="file">
		<h2>Recuperando listas de objetos File</h2>
		<p>El método <code>FileList::getFiles()</code> permite recuperar una lista de
		objetos de tipo <i>File</i>, en lugar de una lista de <i>strings</i>. Al igual que 
		los otros métodos, puede recibir una expresión regular o un <i>array</i> de extensiones
		para aplicar el filtro.</p>
		
	   <p>Alternativamente, se puede trabajar con objetos de tipo <i>FileList</i> y usar el método
	   <code><a href="#getFiles">getFiles()</a></code> para realizar la misma tarea.</p>
		
		<p>Ficheros <i>php</i> de la carpeta public:</p>
		<p><code>FileList::files('../public', ['php']);</code></p>
		
		<?php dump(FileList::files('../public', ['php'])) ?>
		
		<p>Al recuperar así los ficheros, podremos usar los métodos de 
		<a href="/test/library_file" class="bold italic">File</a> sobre cada
		uno de los ficheros de la carpeta, por ejemplo:</p>
		
		<pre>
		<code>
$ficheros = FileList::files('../public', ['php']);

foreach($ficheros as $fichero){
	echo "Ruta: ".$fichero->getPath();
	echo "Extensión: ".$fichero->getExtension();
	echo "Size: ".$fichero->getSize()." bytes";
}
		</code>
		</pre>
		
		<?php 
    		$ficheros = FileList::files('../public', ['php']);
        
            foreach($ficheros as $fichero){
            	echo "<p>Ruta: <b>".$fichero->getPath()."</b><br>";
            	echo "Extensión: <b>".$fichero->getExtension()."</b><br>";
            	echo "Size: <b>".$fichero->getSize()." bytes</b></p>";
            }
        ?>
	</section>
	
	
	<h2>Trabajando con los métodos de objeto</h2>
	
	<section id="getEntries">
		<h2>getEntries()</h2>
		
		<p>El método de objeto <code>getEntries()</code> <b>recupera una lista de entradas de directorio</b>
		a modo de <b>array de strings</b>. Puede recibir la expresión regular para el filtro o el 
		array de extensiones para el filtrado.</p>
	   
		<p>Lista de ficheros <i>CSS</i> en la carpeta <span class='path'>css</span>: </p>
		<pre>
		<code>
$fileList = new FileList('css');
$ficheros = $fileList->getEntries(['css']);
		</code>
		</pre>
		
		<?php
		
		$fileList = new FileList('css');
		$ficheros = $fileList->getEntries(['css']);
		
		dump($ficheros); 
		?>
	</section>
	
	
	<section id="getFiles">
		<h2>getFiles()</h2>
		
		<p>El método de objeto <code>getFiles()</code> <b>recupera una lista de entradas de directorio</b>
		a modo de <b>array de <a href="/test/library_file">File</a></b>. 
		Puede recibir la expresión regular para el filtro o el 
		array de extensiones para el filtrado.</p>
	   
		<p>Ficheros cuyo nombre comienza por 'base' en la carpeta <span class='path'>css</span>: </p>
		<pre>
		<code>
$fileList = new FileList('css');
$ficheros = $fileList->getFiles("/^base/");
		</code>
		</pre>
		
		<?php
		
		$fileList = new FileList('css');
		$ficheros = $fileList->getFiles("/^base/");
		
		dump($ficheros); 
		?>
	</section>

 </main>