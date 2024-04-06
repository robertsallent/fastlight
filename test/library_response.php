<h1>Responses</h1>

<h2>Pruebas con la clase Response</h2>

<p>Creando una nueva respuesta vacía.</p>
<?php
    $response = new Response();  
    dump($response);
?>


<p>Creando una nueva respuesta <b>HTML</b>.</p>
<?php 
    $response = new Response(htmlspecialchars('<p>Hola</p>'));
    dump($response);
?>


<p>Creando una nueva respuesta <b>XML</b>.</p>
<?php 
    $response = new Response(htmlspecialchars('<nombre>Pepe</nombre>'), 'text/xml');
    dump($response);
?>


<p>Creando una nueva respuesta <b>JSON</b>.</p>
<?php 
    $response = new Response("{'nombre':'Eva'}", 'application/json');
    dump($response);
?>


<h2>Pruebas con la clase JsonResponse</h2>

<p>Creando una nueva respuesta <b>JSON</b>.</p>
<?php 
    $response = new JsonResponse([new stdclass(), new stdclass()]);
    dump($response);
?>
