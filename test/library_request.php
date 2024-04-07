<h1>Test de la clase Request</h1>

<h2>Request::create()</h2>
<?php
    $request = Request::create();
    
    echo "<p>request->user</p>";
    dump($request->user);
    
    echo "<p>request->url</p>";
    dump($request->url);
    
    echo "<p>request->csrfToken</p>";
    dump($request->csrfToken);
?>


<h2>request->all()</h2>     
<p>Probemos la siguiente URL: /test/request?id=10&texto=hola</p>
<?php    
    echo "";
    dump($request->all());
?>   
    
<h2>Rutas actual y previa</h2>
<p>Previa: <?= $request->previousUrl ?></p>
<p>Actual: <?= $request->url ?></p>


<h2>urlHas()</h2>
<p>La ruta tiene el texto /test? <?= $request->urlHas('/test') ? 'SI' : 'NO' ?></p>
<p>La ruta tiene el texto library? <?= $request->urlHas('library') ? 'SI' : 'NO' ?></p>
<p>La ruta tiene el texto patata? <?= $request->urlHas('patata') ? 'SI' : 'NO' ?></p>  

<h2>urlBeginsWith()</h2>
<p>La ruta comienza por el texto /test? <?= $request->urlBeginsWith('/test') ? 'SI' : 'NO' ?></p>
<p>La ruta comienza por el texto library? <?= $request->urlBeginsWith('library') ? 'SI' : 'NO' ?></p>
<p>La ruta comienza por el texto patata? <?= $request->urlBeginsWith('patata') ? 'SI' : 'NO' ?></p>  
    
