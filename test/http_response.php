<h1>Responses</h1>

<h2>Pruebas con la clase Response</h2>

<p>Creando una nueva respuesta HTML vacía.</p>
<?php
    $response = new Response();  
    dump($response);
?>


<h2>Pruebas con la clase JsonResponse</h2>

<p>Creando una nueva respuesta <b>JSON</b>.</p>
<?php 
    $response = new JsonResponse([new stdclass(), new stdclass()]);
    dump($response);
?>
