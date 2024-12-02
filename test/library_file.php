<main>

    <h1>Test de la clase File</h1>
    
    <p>Mediante objetos de tipo <code>File</code> representaremos los ficheros
    del sistema de ficheros, pudiendo recuperar información (path, nombre, extensión, tamaño...) 
    o manipularlos (copiar, mover, borrar...).</p>


	<section>
		<h2>Recuperando datos de un fichero</h2>
	
		<p>En este ejemplo recuperamos la información del fichero 
		<code>../public/favicon.ico</code> y la mostraremos en la página.
		Lo representaremos mediante un objeto de tipo <code>File</code>.</p>
		
		<h3>Creando el objeto <code>File</code></h3>
		<?php 
		  $fichero = new File('../public/favicon.ico'); 
		  dump($fichero);  
	    ?>
        
        <h3><code>getPath()</code></h3>
        <p>Recupera la ruta relativa del fichero, tomando como partida el 
           directorio desde donde se invoca al método (carpeta <code>test</code> en este caso).</p>
        <?= "<p><b>Ruta completa</b>: ".$fichero->getPath().".</p>" ?>
        
        <h3><code>getBaseName()</code></h3>
        <p>Nombre completo del fichero.</p>
        <?= "<p><b>Nombre del fichero</b>: ".$fichero->getBaseName().".</p>" ?>
            
		<h3><code>getName()</code></h3>
		<p>Noombre del fichero, sin la extensión.</p>
        <?= "<p><b>Nombre sin extensión</b>: ".$fichero->getName().".</p>" ?>
        
		<h3><code>getExtension()</code></h3>
		<p>Extensión del fichero, sin el nombre.</p>
        <?= "<p><b>Extensión</b>: ".$fichero->getExtension().".</p>" ?>
        
		<h3><code>getFolder()</code></h3>
		<p>Carpeta en la que se encuentra el fichero. Ruta relativa desde el 
		punto donde se invocó la método (desde <code>test</code>).</p>
        <?= "<p><b>Carpeta</b>: ".$fichero->getFolder().".</p>" ?>   
        
        <h3><code>getSize()</code></h3>
        <p>Tamaño del fichero en bytes.</p>
        <?= "<p><b>Tamaño</b>: ".$fichero->getSize()." bytes.</p>" ?>    
    </section>
        
        
        
    <section>
        <h2>Comprobando tipos MIME.</h2>
        
        <p>Hagamos las comprobaciones de tipo sobre el mismo fichero 
        <code>../public/favicon.ico</code>.
        
        <h3><code>getMime()</code></h3>
        <p>Recupera el tipo MIME real del fichero.</p>
        <?= "<p>Tipo mime real: ".$fichero->getMime().".</p>" ?>
        
        <h3><code>is()</code></h3>
        <p>Comprueba si el fichero es de un tipo MIME concreto.</p>
        <?php
            echo "<p>Es PDF?: "         .($fichero->is('application/pdf') ? 'SI':'NO')."</p>";
            echo "<p>Es icon?: "        .($fichero->is('image/vnd.microsoft.icon') ? 'SI':'NO')."</p>";
        ?>   
         
        <h3><code>checkMime()</code></h3> 
        <p>Contrasta el tipo MIME mediante una expresión regular.</p>
        <?php    
            echo "<p>Es PDF, jpg o jpeg?: ".($fichero->checkMime('/\/(pdf|jpe?g)$/i') ? 'SI':'NO')."</p>";
            echo "<p>Es imagen?: "      .($fichero->checkMime('/^image\//i') ? 'SI':'NO')."</p>";
        ?>    
        
        <h3><code>has()</code></h3> 
        <p>Comprueba si el fichero es de alguno de los que le indiquemos mediante una lista.</p>
        <?php     
            echo "<p>Es PDF o jpeg?: "  .($fichero->has(['application/pdf','image/jpeg']) ? 'SI':'NO')."</p>";
            echo "<p>Es jpeg o ico?: "  .($fichero->has(['image/vnd.microsoft.icon','image/jpeg']) ? 'SI':'NO')."</p>";
        ?>
    </section>
    
    <section>    
        <h2>Comprobando tipos MIME (métodos estáticos)</h2>
        
        <p>Los métodos estáticos nos permiten recuperar información del tipo MIME 
        sin necesidad de tener que crear el objeto <code>File</code>.</p>
        
        
        <h3><code>File::mime()</code></h3>
        <p>Recupera el tipo real de un fichero del que le pasamos la ruta.</p>
        
        <p>El fichero <code>../test/library_file.php</code> es de tipo 
        <?= File::mime('../public/sitemap.xml') ?>.</p>
        
        <p>El fichero <code>../public/images/template/logo.png</code> es de tipo 
        <?= File::mime('../public/images/template/logo.png') ?>
        </p>    

		<h3><code>File::isMime()</code></h3>
        <p>Permite saber si un fichero tiene un determinado tipo o no.</p> 
        
        <p>Es el fichero <code>../public/humans.txt</code> un fichero de txt?
   		<?= File::isMime('../public/humans.txt', 'text/plain') ? 'SI' : 'NO' ?>
   		</p>
              
        <p>Es <code>../public/humans.txt</code> un fichero png?    
        <?= File::isMime('../public/humans.txt', 'image/png') ? 'SI' : 'NO' ?>
        </p>
        
        
        <h3><code>File::mimeCheck()</code></h3>
        <p>Validar el tipo MIME mediante una expresión regular.</p>    
       
        <p>El fichero <code>../public/favicon.ico</code> es de tipo <code>image/*</code>?       
		<?= File::mimeCheck('../public/favicon.ico', '/^image\/*/i') ? 'SI' : 'NO' ?>
		</p>
            
        <p>El fichero <code>../public/favicon.ico</code> es de tipo <code>video/*</code>?
        <?= File::mimeCheck('../public/favicon.ico', '/^video\/*/i') ? 'SI' : 'NO' ?>
         
         
         <h3><code>File::hasMime()</code></h3>   
         <p>Comprueba si el fichero
         tiene uno de los tipos MIME indicados en una lista.</p>      
            
         <p>El fichero <code>../public/robots.txt</code> es text/plain o text/csv?   
         <?= File::hasMime('../public/robots.txt', ['text/plain', 'text/csv']) ? 'SI':'NO' ?>
         </p>
            
          <p>El fichero <code>../public/robots.txt</code> es imagen/jpeg o text/csv?   
         <?= File::hasMime('../public/robots.txt', ['image/jpeg', 'text/csv']) ? 'SI' : 'NO' ?>
         </p>
    </section>
    
    
    <section>
    	<h2>Copiando, moviendo y eliminando ficheros</h2>
    	
    	<h3><code>copy()</code></h3>
    	<p>Sirve para copiar ficheros. Es un método de objeto.</p>
     	
     	<?php $fichero = new File('../logs/readme.txt') ?>
            
        <p>Intentando <b>copiar</b> el fichero <code>../logs/readme.txt</code>...</p>
        <?php     
            $ficheroCopiado = $fichero->copy('../logs/copyTest.txt');
            echo "<p>Copiados ".$ficheroCopiado->size()." bytes a $ficheroCopiado.</p>";
        ?>
        
        <h3><code>exists()</code></h3>
        <p>Comprueba si un fichero existe realmente en el sistema de ficheros.</p>
        
        <p>Comprobando si el fichero copiado <code><?= $ficheroCopiado ?></code> existe realmente: 
        <?= $ficheroCopiado->exists() ? 'SI' : 'NO' ?>
        </p>
        
        <h3><code>isReadable()</code></h3>
        <p>Comprueba si un fichero existe y es legible (se tienen los permisos adecuados).</p>
        
        <p>Comprobando si el fichero <code><?= $ficheroCopiado ?></code> se puede leer: 
        <?= $ficheroCopiado->isReadable() ? 'SI' : 'NO' ?>
        </p>
            
        <h3><code>move()</code></h3>
        <p>Este método permite mover o renombrar un fichero.</p>    
        
		<p>Intentando <b>mover</b> <code><?= $ficheroCopiado ?></code> a un <code>../logs/moved.txt</code>...</p>
        <?php 
            $ficheroCopiado->move('../logs/moved.txt');
            echo "<p>Movidos ".$ficheroCopiado->size()." a <code>$ficheroCopiado</code>.</p>";
        ?>
            
        <p>Comprobando si el fichero copiado <code><?= $ficheroCopiado ?></code> existe realmente: 
        <?= $ficheroCopiado->exists() ? 'SI' : 'NO' ?>
        </p>
            
        <p>Comprobando si el fichero <code><?= $ficheroCopiado ?></code> se puede leer: 
        <?= $ficheroCopiado->isReadable() ? 'SI' : 'NO' ?>
        </p>
            
            
        <h3><code>delete()</code></h3>    
        <p>Elimina un fichero del sistema de ficheros.</p>    
        
		<p>Intentando <b>eliminar</b> <code><?= $ficheroCopiado ?></code>...</p>
        <?php 
            $ficheroCopiado->delete();
            echo "<p>Se ha borrado $ficheroCopiado del sistema de ficheros.</p>";
        ?>    
        
		<p>Comprobando si el fichero copiado <code><?= $ficheroCopiado ?></code> existe realmente: 
        <?= $ficheroCopiado->exists() ? 'SI' : 'NO' ?>
        </p>
            
        <p>Comprobando si el fichero <code><?= $ficheroCopiado ?></code> se puede leer: 
        <?= $ficheroCopiado->isReadable() ? 'SI' : 'NO' ?>
        </p>
    </section>
</main>    
    
    
    