<main>
	<h1>Test de FileList</h1>
	
	<h2><code>FileList::get()</code></h2>
	<p>El método estático <code>FileList::get()</code> es todo lo que necesitamos para realizar listados 
	   de directorio con o sin filtrar. 
	   Alternativamente, se puede trabajar con objetos de tipo <code>FileList</code> y usar el método
	   <code>getEntries()</code> para realizar la misma tarea, pero es más sencilla la primera opción.</p>
	
	<section>
		<h2>Listado de directorio de la carpeta actual</h2>
		<p>Si invocamos el método <code>FileList::get()</code> sin parámetros, retorna un listado de 
		entradas del directorio actual, sin las entradas especiales '.' (directorio actual) ni 
		'..' (directorio de orden superior).</p>
		
		<p>Contenido de la carpeta actual:</p>
		<?php dump(FileList::get()) ?>
	</section>
	
	<section>
		<h2>Listado de directorio</h2>
		<p>El método <code>FileList::get()</code> puede recibir como primer parámetro la ruta del 
		directorio a escanear.</p>
		
		<p>Contenido de la carpeta <code>templates</code>:</p>
		<?php dump(FileList::get('../templates')) ?>
	</section>
	
	
	<section>
		<h2>Listado con filtro por extensión</h2>
		<p>El método <code>FileList::get()</code> puede recibir como segundo parámetro un filtro 
		mediante un listado de extensiones. Solamente listará entradas coincidentes con esas
		extensiones.</p>
		
		<p>Ficheros php, ini o xml de la carpeta public:</p>
		<?php dump(FileList::get('../public', ['xml','php','ini'])) ?>
	</section>
	
	<section>
		<h2>Listado con filtro de expresión regular</h2>
		<p>El método <code>FileList::get()</code> también puede recibir como segundo parámetro un filtro 
		mediante expresión regular. Solamente listará entradas coincidentes con esa expresión regular.</p>
		
		<p>Ficheros php o txt de la carpeta public:</p>
		<?php dump(FileList::get('../public', '/\.(php|txt)$/i')) ?>
	</section>
	
	<section>
		<h2>Entradas especiales '.' y '..'</h2>
		
		<p>Contenido de la carpeta <code>public/images/template</code>:</p>
		<?php dump(FileList::get('../public/images/template')) ?>
		
		<p>Si queremos que liste las entradas especiales '.' y '..' 
		podemos indicarlo mediante el tercer parámetro (por defecto <code>false</code>).</p>
		
		<p>Ficheros PNG en <code>public/images/template</code> con las entradas '.' y '..' incluidas:</p>
		<?php dump(FileList::get('../public/images/template', ['png'], true)) ?>
		
		<p>Si no queremos aplicar filtro, el segundo parámetro puede ser NULL, cadena vacía o 
		array vacío (no podemos omitirlo).</p>
		
		<p>Contenido de la carpeta <code>public/images/template</code> con las entradas '.' y '..' incluidas:</p>
		<?php dump(FileList::get('../public/images/template', NULL, true)) ?>
	</section>
 </main>