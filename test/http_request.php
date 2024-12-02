<main>
    <h1>Test de la clase <code>Request</code></h1>
    
    <section>
        <h2>Objeto <code>Request</code> actual</h2>
        
        <p>Este objeto <b>contiene la información y datos que llegan al servidor</b> a través de la 
        petición <code>HTTP</code> que realiza el cliente. También dispone de referencias
        al usuario identificado, tokens...</p>
        
        <?php 
            $request = Request::take(); 
            dump($request);
        ?>
    </section>
    
    
    <section>
        <h2>Propiedades de <code>Request</code></h2>
        
        <p>Estas son algunas de sus propiedades:</p>
        
        <ul>
            <li>Ruta previa (<code>previousUrl</code>): <?= $request->previousUrl ?></li>
            <li>Ruta actual (<code>url</code>): 		  <?= $request->url ?></li>
            <li>Método (<code>method</code>): 		  <?= $request->method ?></li>
        </ul>
        
        <p>Dispone de una referencia al objeto <code>User</code>:</p>
        <?php dump($request->user); ?>
       
       <p>Y contiene el token CSRF si llega:</p>
       <?php  dump($request->csrfToken); ?>
    </section>
    
    
    <section>
        <h2>Probando el método <code>get()</code></h2>     
        <p>Probemos la siguiente URL: /test/http_request?id=10&texto=hola</p>
        <?php    
            echo "<p>ID: ".$request->get('id')."</p>";
            echo "<p>texto: ".$request->get('texto')."</p>";
        ?>  
    </section>
    
    
    <section>
        <h2>Probando el método <code>gets()</code></h2>     
        <p>Probemos la siguiente URL: /test/http_request?id=10&texto=hola</p>
        <?php    
            dump($request->gets());
        ?> 
    </section>
    
     
    <section>
        <h2>Probando el método <code>all()</code></h2>     
        <p>Probemos la siguiente URL: /test/http_request?id=10&texto=hola</p>
        <?php    
            dump($request->all());
        ?>   
    </section>
    
    
    <section>
    <h2>Probando el método <code>cookie()</code></h2>     
    <?php    
        dump($request->cookie('PHPSESSID'));
    ?>  
    </section>
    
    
    <section>
    <h2>Probando el método <code>header()</code></h2>     
    <?php    
        dump($request->header('User-Agent'));
    ?>   
    </section>    
        
    
    
    <section>
        <h2>Método <code>urlHas()</code></h2>
        <p>La ruta tiene el texto /test? <?= $request->urlHas('/test') ? 'SI' : 'NO' ?></p>
        <p>La ruta tiene el texto library? <?= $request->urlHas('library') ? 'SI' : 'NO' ?></p>
        <p>La ruta tiene el texto patata? <?= $request->urlHas('patata') ? 'SI' : 'NO' ?></p>  
    </section>
    
    
    <section>
        <h2>Método <code>urlBeginsWith()</code></h2>
        <p>La ruta comienza por el texto /test? <?= $request->urlBeginsWith('/test') ? 'SI' : 'NO' ?></p>
        <p>La ruta comienza por el texto library? <?= $request->urlBeginsWith('library') ? 'SI' : 'NO' ?></p>
        <p>La ruta comienza por el texto patata? <?= $request->urlBeginsWith('patata') ? 'SI' : 'NO' ?></p>  
    </section>    
       
    
    <section>    
    <h2>Método <code>Request::create()</code></h2>
    <p>Crea un objeto <code>Request</code> a partir de los datos que recibe el servidor. Este método
    no lo usaremos en las aplicaciones, el objeto <code>Request</code> es creado en el núcleo de FastLight en 
    <code>/core/Kernel.php</code> automáticamente, aquí solamente lo estoy testeando.</p>
    <?php
        $request = Request::create();
        dump($request);
    ?>
    </section>
</main>    
