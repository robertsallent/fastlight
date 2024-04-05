<?php
    echo "<h1>Test de la librería XML</h1>";

    echo "<h2>Probando XML::encode().</h2>";
    
    echo "<p>Intentando convertir a XML dos usuarios decuperados desde la BDD.</p>";
    $usuarios = User::orderBy('id', 'ASC', 2);
    
    $xml = XML::encode($usuarios, 'usuarios', 'user');
    echo "<pre>".htmlspecialchars($xml)."</pre>";
    
    
    echo "<h2>Probando XML::decode().</h2>";
   
    echo "<p>Mapeando a stdClass el XML con los dos usuarios.</p>";
    dump(XML::decode($xml, 'stdClass', false));
    
    echo "<p>Mapeando a User el XML con los dos usuarios.</p>";
    dump(XML::decode($xml, 'User', false));
    
