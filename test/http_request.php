<h1>Test de la clase <code>Request</code></h1>

<h2>Objeto <code>$request</code> actual</h2>

<?php 
    $request = Request::take(); 
    dump($request);
?>


<h2>Propiedades de <code>Request</code></h2>

<p>Ruta previa (previousUrl): <?= $request->previousUrl ?></p>
<p>Ruta actual (url): 		  <?= $request->url ?></p>
<p>Método (method): 		  <?= $request->method ?></p>

<?php 
    echo "<p>Usuario (user):</p>";
    dump($request->user);
    
    echo "<p>request->csrfToken</p>";
    dump($request->csrfToken);
?>


<h2>Probando el método <code>get()</code></h2>     
<p>Probemos la siguiente URL: /test/http_request?id=10&texto=hola</p>
<?php    
    echo "<p>ID: ".$request->get('id')."</p>";
    echo "<p>texto: ".$request->get('texto')."</p>";
?>  

<h2>Probando el método <code>gets()</code></h2>     
<p>Probemos la siguiente URL: /test/http_request?id=10&texto=hola</p>
<?php    
    dump($request->gets());
?>  

<h2>Probando el método <code>all()</code></h2>     
<p>Probemos la siguiente URL: /test/http_request?id=10&texto=hola</p>
<?php    
    dump($request->all());
?>   
    



<h2>urlHas()</h2>
<p>La ruta tiene el texto /test? <?= $request->urlHas('/test') ? 'SI' : 'NO' ?></p>
<p>La ruta tiene el texto library? <?= $request->urlHas('library') ? 'SI' : 'NO' ?></p>
<p>La ruta tiene el texto patata? <?= $request->urlHas('patata') ? 'SI' : 'NO' ?></p>  

<h2>urlBeginsWith()</h2>
<p>La ruta comienza por el texto /test? <?= $request->urlBeginsWith('/test') ? 'SI' : 'NO' ?></p>
<p>La ruta comienza por el texto library? <?= $request->urlBeginsWith('library') ? 'SI' : 'NO' ?></p>
<p>La ruta comienza por el texto patata? <?= $request->urlBeginsWith('patata') ? 'SI' : 'NO' ?></p>  
    
    
<h2>Método <code>Request::create()</code></h2>
<p>Crea una nueva Request,</p>
<?php
    $request = Request::create();
    dump($request);
?>
    
