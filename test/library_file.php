<main>

    <h1>Test de la librería File</h1>
    
    <p>Mediante objetos de tipo <code>File</code> representaremos los ficheros
    del sistema de ficheros, pudiendo recuperar información (path, nombre, extensión, tamaño...) 
    o manipularlos (copiar, mover, borrar...).</p>

	<p>En este ejemplo recuperamos la información del fichero 
	<i>../public/favicon.ico</i> y la mostraremos en la página.
	Lo representaremos mediante un objeto de tipo <i>File</i>.</p>


	<h2>Creando el objeto File</h2>
	
	<section id="constructor">
		<h3>Usando el constructor</h3>
	
		<p>Para crear un objeto <i>File</i>, usaremos su <b>constructor</b>, que recibe
		la ruta en el sistema de ficheros donde se encuentra.</p>
		
		<p>Por ejemplo, para crear el objeto vinculado al fichero <i>favicon.ico</i> de la carpeta <i>public</i>:</p> 
		<p><code>$fichero = new File('../public/favicon.ico');</code></p>
		<?php 
		  $fichero = new File('../public/favicon.ico'); 
		  dump($fichero);  
	    ?>
    </section>  
       
       
    <h2>Comprobando existencia y permisos</h2>
        
    <section id="exists">
        <h3>exists()</h3>
        <p>indica <b>si el fichero con la ruta dada existe</b> en el sistema de ficheros del servidor.</p>
        
        <p><code>$fichero->exists();</code></p>
        <p><b><?= $fichero->exists() ? 'SI' : 'NO' ?></b></p>     
     </section>
     
     
     <section id="isReadable">
        <h3>isReadable()</h3>
        <p>indica <b>si el fichero con la ruta dada se puede leer</b>.</p>
        
        <p><code>$fichero->isReadable();</code></p>
        <p><b><?= $fichero->isReadable() ? 'SI' : 'NO' ?></b></p>     
     </section>
     
     
      <section id="isWritable">
        <h3>isWritable()</h3>
        <p>indica <b>si el fichero con la ruta dada puede ser escrito</b>.</p>
        
        <p><code>$fichero->isWritable();</code></p>
        <p><b><?= $fichero->isWritable() ? 'SI' : 'NO' ?></b></p>     
     </section>
     
        
    <h2>Métodos para recuperar información</h2>
        
    <section id="getPath">
        <h3>getPath()</h3>
        <p>Recupera la <b>ruta relativa del fichero</b>, tomando como partida el 
           directorio desde donde se invoca al método (carpeta <i>test</i> en este caso).</p>
        
        <p><code>$fichero->getPath(); </code></p>
        <p><b><?= $fichero->getPath() ?></b></p>
     </section>
     
     
     <section id="getBaseName">  
        <h3>getBaseName()</h3>
        <p>Retorna el <b>nombre completo</b> del fichero.</p>
        
        <p><code>$fichero->getBaseName();</code></p>
        <p><b><?= $fichero->getBaseName() ?></b></p>
     </section>
     
     
     <section id="getName">       
		<h3>getName()</h3>
		<p>Nombre del fichero, <b>sin la extensión</b>.</p>
        <p><code>$fichero->getName();</code></p>
        <p><b><?= $fichero->getName() ?></b></p>
    </section>
    
    
    <section id="getExtension">    
		<h3>getExtension()</h3>
		<p>Retorna la <b>extensión del fichero</b>, sin el nombre.</p>
        <p><code>$fichero->getExtension();</code></p>
        <p><b><?= $fichero->getExtension() ?></b></p>
    </section>
    
    
    <section id="getFolder">    
		<h3>getFolder()</h3>
		<p>Recupera la <b>carpeta en la que se encuentra el fichero</b>. Ruta relativa desde el 
		punto donde se invocó la método (desde <code>test</code>).</p>
        <p><code>$fichero->getFolder();</code></p>
        <p><b><?= $fichero->getFolder() ?></b></p>
   </section>
   
   
   <section id="getSize">     
        <h3>getSize()</h3>
        <p>Retorna el <b>tamaño del fichero en bytes</b>.</p>
        <p><code>$fichero->getSize();</code></p>
        <p><b><?= formatInt($fichero->getSize()) ?></b> bytes.</p>   
    </section>
        
        
   
   
    <h2>Comprobación de tipos MIME.</h2>     
    
    <p>Haremos las comprobaciones de tipo sobre el mismo fichero 
        <i>../public/favicon.ico</i>.</p>
       
        
    <section id="getMime">
       <h3>getMime()</h3>
        <p>Recupera <b>el tipo MIME real</b> del fichero, no mira la extensión sino que usa la
        extensión de <i>PHP fileinfo</i> para obtener la información.</p>
        
        <p><code>$fichero->getMime();</code></p>
        <p><b><?= $fichero->getMime() ?></b></p>        
    </section>
    
    
    <section id="is">
        <h3>is()</h3>
        <p>Comprueba <b>si el fichero es de un tipo MIME concreto</b>.</p>
        
        <p>Por ejemplo, para comprobar
        si un fichero es <i>PDF</i>, podemos hacer: <code>$fichero->is('application/pdf');</code></p>
        <?= "<p>Es <i>application/pdf</i>?: <b>".($fichero->is('application/pdf') ? 'SI':'NO')."</b></p>" ?>
        
        <p>Por ejemplo, para comprobar si es un icono: <code>$fichero->is('image/vnd.microsoft.icon');</code></p>
        <?= "<p>Es <i>image/vnd.microsoft.icon</i>?: <b>".($fichero->is('image/vnd.microsoft.icon') ? 'SI':'NO')."</b></p>" ?>   
     </section>
     
     
     <section id="checkMime">     
        <h3>checkMime()</h3> 
        <p>Comprueba el tipo MIME <b>haciendo uso de una expresión una expresión regular</b>.</p>
        
        <p>Por ejemplo para comprobar tipos concretos podemos hacer:
        <code>$fichero->checkMime('/\/(pdf|jpe?g)$/i');</code></p>
        <?= "<p>Es <i>PDF</i>, <i>jpg</i> o <i>jpeg</i>?: <b>".($fichero->checkMime('/\/(pdf|jpe?g)$/i') ? 'SI':'NO')."</b></p>" ?>
        
        <p>Para comprobar tipos genéricos haremos: 
        <code>$fichero->checkMime('/^image\//i');</code>.</p>
        <?= "<p>Es imagen?: <b>".($fichero->checkMime('/^image\//i') ? 'SI':'NO')."</b></p>" ?>    
    </section>
    
    
    <section id="has">
        <h3>has()</h3> 
        <p>Comprueba si el fichero es de <b>alguno de los tipos MIME que le indiquemos mediante 
        una lista</b>.</p>
        
        <p>Podremos hacer cosas como: </p>
        <p><code>$fichero->has(['application/pdf','image/jpeg']);</code></p>
        <?= "<p>Es <i>PDF</i> o <i>jpeg</i>?: <b>".($fichero->has(['application/pdf','image/jpeg']) ? 'SI':'NO')."</b></p>" ?>
        
        <p><code>$fichero->has(['image/vnd.microsoft.icon','image/jpeg']);</code></p>
        <?= "<p>Es <i>jpeg</i> o <i>ico</i>?: <b>".($fichero->has(['image/vnd.microsoft.icon','image/jpeg']) ? 'SI':'NO')."</b></p>";
        ?>
    </section>
    
    
     <h2>Copiando, moviendo y eliminando ficheros</h2>
    
    <section id="copy">
    	<h3>copy()</h3>
    	<p>El método de objeto <code>copy()</code> <b>copia ficheros</b>.</p>
    	<p>Por ejemplo,
    	si queremos realizar una copia del fichero <i>'logs/readme.txt'</i> 
    	en el fichero <i>'logs/copia.txt'</i>, podemos hacer:</p>
    	
    	<pre>
    		<code>
$fichero = new File('../logs/readme.txt');
$copia = $fichero->copy('../logs/copia.txt');
    		</code>
    	</pre>
     	
     	<?php $fichero = new File('../logs/readme.txt') ?>
            
        <p>Intentando <b>copiar</b> el fichero...</p>
        <?php     
            $copia = $fichero->copy('../logs/copia.txt');
            echo "<p>OK, <b>copiados ".$copia->getSize()." bytes</b> a $copia.</p>";
        ?>

        <p>Para comprobar si se copió el fichero en el punto anterior, podemos hacer:</p> 
        <p><code>$copia->exists()</code>.</p>
        <p><b><?= $copia->exists() ? 'SI' : 'NO' ?></b></p>
    
		<p>Para comprobar si el fichero creado anteriormente es legible, podemos 
        hacer:</p>
        <p><code>$copia->isReadable()</code>.</p>
        <p><b><?= $copia->isReadable() ? 'SI' : 'NO' ?></b></p>
     </section>
     
     
     <section id="move">
        <h3>move()</h3>
        <p>Este método permite <b>mover o renombrar un fichero</b>. Por ejemplo, vamos a mover el 
        fichero <i>'<?= $copia ?>'</i> a <i>'../logs/moved.txt'</i> haciendo;</p>
        <p><code>$copia->move('../logs/moved.txt')</code>.</p>    
        
		<p>Intentando <b>mover</b>...</p>
        <?php 
        $copia->move('../logs/moved.txt');
        echo "<p><b>Movidos ".$copia->getSize()." bytes</b> a <i>$copia</i>.</p>";
        ?>
            
        <p><code>$copia->isReadable()</code>.</p>
        <p><b><?= $copia->isReadable() ? 'SI' : 'NO' ?></b></p>
    </section>   
           
           
    <section id="delete">        
        <h3>delete()</h3>    
        <p><b>Elimina un fichero</b> del sistema de ficheros.</p>  
        
        <p>Por ejemplo: <code>$copia->delete()</code>.</p>  
        
		<p>Intentando <b>eliminar</b> <i><?= $copia ?></i>...</p>
        <?php 
            $copia->delete();
            echo "<p>Se ha borrado $copia del sistema de ficheros.</p>";
        ?>    
        
		<p>Comprobando si el fichero copiado <code><?= $copia ?></code> existe realmente: 
        <b><?= $copia->exists() ? 'SI' : 'NO' ?></b>
        </p>
            
        <p>Comprobando si el fichero <code><?= $copia ?></code> se puede leer: 
        <b><?= $copia->isReadable() ? 'SI' : 'NO' ?></b>
        </p>
    </section>
    
    
    <h2>Comprobando tipos MIME (métodos estáticos)</h2>
        
    <p>Los métodos estáticos de <i>File</i> para tipos, nos permiten recuperar información del tipo MIME 
    sin necesidad de tener que crear el objeto.</p>
        
        
    <section id="mime">    
        <h3>File::mime()</h3>
        <p>Recupera el <b>tipo real de un fichero</b> del que le pasamos la ruta.</p>
        
        <p><code>File::mime('../public/sitemap.xml');</code></p>   
        <p><b><?= File::mime('../public/sitemap.xml') ?></b>.</p>
        
        <p><code>File::mime('../public/images/template/logo.png');</code></p>   
        <p><b><?= File::mime('../public/images/template/logo.png') ?></b>.</p>       
    </section>
    
    
    
    <section id="isMime">
		<h3>File::isMime()</h3>
		
        <p>Permite saber <b>si un fichero tiene un determinado tipo</b> o no.</p> 
        
        <p>Probando si el fichero <i>'../public/humans.txt'</i> es un fichero <i>TXT</i>:</p>
        <p><code>File::isMime('../public/humans.txt', 'text/plain');</code></p> 
   		<p><b><?= File::isMime('../public/humans.txt', 'text/plain') ? 'SI' : 'NO' ?></b>
   		</p>
              
        <p>Probando si el fichero <i>'../public/humans.txt'</i> es un fichero <i>PNG</i>:</p>
        <p><code>File::isMime('../public/humans.txt', 'image/png');</code></p>    
        <p><b><?= File::isMime('../public/humans.txt', 'image/png') ? 'SI' : 'NO' ?></b>
        </p>
    </section>
    
    <section id="mimeCheck">
        <h3>File::mimeCheck()</h3>
        <p>Valida el tipo MIME mediante una expresión regular.</p>    
       
        <p>Probando si el tipo MIME del fichero <i>'../public/favicon.ico'</i> 
        cumple con la expresión regular <i>'/^image\/*/i'</i>:</p>
        <p><code>File::isMime('../public/favicon.ico', '/^image\/*/i');</code></p>       
		<p><b><?= File::mimeCheck('../public/favicon.ico', '/^image\/*/i') ? 'SI' : 'NO' ?></b></p>
		
            
        <p>Probando si el tipo MIME del fichero <i>'../public/favicon.ico'</i> 
        cumple con la expresión regular <i>'/^video\/*/i'</i>:</p> 
        <p><code>File::isMime('../public/favicon.ico', '/^video\/*/i');</code></p> 
        <p><b><?= File::mimeCheck('../public/favicon.ico', '/^video\/*/i') ? 'SI' : 'NO' ?></b></p> 
     </section>
     
     
     <section id="hasMime">
         <h3>File::hasMime()</h3>   
         <p>Comprueba si el fichero
         <b>tiene uno de los tipos MIME indicados en una lista</b>.</p>      
            
         <p>El fichero <i>../public/robots.txt</i> es text/plain o text/csv?</p>
         <p><code>File::hasMime('../public/robots.txt', ['text/plain', 'text/csv']);</code></p>
		 <P><b><?= File::hasMime('../public/robots.txt', ['text/plain', 'text/csv']) ? 'SI':'NO' ?></b></p>
            
         <p>El fichero <i>../public/robots.txt</i> es imagen/jpeg o text/csv?</p>
         <p><code>File::hasMime('../public/robots.txt', ['image/jpeg', 'text/csv']);</code></p>
		 <p><b><?= File::hasMime('../public/robots.txt', ['image/jpeg', 'text/csv']) ? 'SI' : 'NO' ?></b></p>
    </section>
    
    
    <h2>Copiando, moviendo y eliminando ficheros (métodos estáticos)</h2>
    
    <section id="makeCopy">
    	<h3>File::makeCopy()</h3>
    	
    	<p>El método <code>File::makeCopy()</code> hace una copia de un fichero:</p>
    	<p><code>File::makeCopy('../public/css/base.css', '../tmp/test.css');</code></p>
    	<p>Copiado a <?= File::makeCopy('../public/css/base.css', '../tmp/test.css') ?>.</p>
    	
    	<p>Existe <i>test.css</i>? <b><?= (new File('../tmp/test.css'))->exists() ? 'SI' : 'NO' ?></b>.</p>
    </section>
    
    <section id="doMove">	
    	<h3>File::doMove()</h3>
    	<p>El método <code>File::doMove()</code> mueve un fichero:</p>
    	<p><code>File::doMove('../tmp/test.css', '../tmp/test2.css');</code></p>
    	<p>Movido? <b><?= File::doMove('../tmp/test.css', '../tmp/test2.css') ? 'SI' : 'NO' ?></b>.</p>
    	
    	<p>Existe <i>test.css</i>? <b><?= (new File('../tmp/test.css'))->exists() ? 'SI' : 'NO' ?></b>.</p>
    	<p>Existe <i>test2.css</i>? <b><?= (new File('../tmp/test2.css'))->exists() ? 'SI' : 'NO' ?></b>.</p>
    </section>
    
    	
    <section id="remove">		
    	<h3>File::remove()</h3>
    	<p>El método <code>File::remove()</code> elimina un fichero:</p>
    	<p><code>File::remove('../tmp/test2.css');</code></p>
    	<p>Eliminado? <b><?= File::remove('../tmp/test2.css') ? 'SI' : 'NO' ?></b>.</p>
    	
    	<p>Existe <i>test2.css</i>? <b><?= (new File('../tmp/test2.css'))->exists() ? 'SI' : 'NO' ?></b>.</p>
    	
    </section>
   
</main>    
    
    
    