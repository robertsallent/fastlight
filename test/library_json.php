<main>
<?php
    echo "<h1>Test de la librería JSON</h1>";

    echo "<h2>Probando JSON::encode().</h2>";
    
    echo "<p>Intentando convertir a JSON dos usuarios decuperados desde la BDD.</p>";
    $usuarios = User::orderBy('id', 'ASC', 2);
    $json = JSON::encode($usuarios, true, true);
    echo "<pre>$json</pre>";
    
    
    echo "<h2>Probando JSON::decode().</h2>";
   
    echo "<p>Mapeando a stdClass el JSON con los dos usuarios.</p>";
    dump(JSON::decode($json));
    
    echo "<p>Mapeando a User el JSON con los dos usuarios.</p>";
    dump(JSON::decode($json, 'User'));
    
    
    echo "<p>Probando el comportamiento ante un error, en caso de no lanzar excepciones.</p>";
    dump(JSON::decode('{test:error}', 'User', false));
    
?>

</main>