<?php

    echo "<h1>Test de User</h1>";
    echo "<h2>Métodos de Authenticable</h2>";
    
    // identifica mediante email (probad con admin y con biblio)
    $user = User::authenticate('admin@fastlight.com', md5('1234'));
    dump($user);
    
    // identificación incorrecta (probad distintos mails, passwords...)
    $user = User::authenticate('robert@fastlight.com', md5('1234'));
    dump($user);
    
    // identifica mediante teléfono (probad con admin y con biblio)
    $user = User::authenticate('666666666', md5('1234'));
    dump($user);
        
    
    echo "<h2>Métodos de Authorizable</h2>";
    echo "<p>En la próxima presentación.</p>";
    
    
    
    