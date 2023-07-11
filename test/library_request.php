<?php
    echo "<h1>Test de la clase Request</h1>";

    $request = Request::create();
    
    echo "<h2>Propiedades</h2>";
    echo "<p>request->user</p>";
    dump($request->user);
    
    echo "<p>request->url</p>";
    dump($request->url);
    
    echo "<p>request->csrfToken</p>";
    dump($request->csrfToken);
     
    
    echo "<h2>Métodos</h2>";
    echo "<h3>request->all()</h3>";
    echo "<p>URL: /test/request?id=10&texto=hola</p>";
    dump($request->all());
 ?>   
    
    <h2>Rutas</h2>
    <p>Previa:<?= $request->previousUrl ?></p>
<p>Actual:<?= $request->url ?></p>

    
    
