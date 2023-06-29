<?php

    echo "<h1>Test de autenticación</h1>";
    echo "<h2>Métodos de Authenticable</h2>";
    
    
    // identifica mediante email (probad con admin y con biblio)  
    echo "<h3>Identificación email correcta</h3>";
    $user = User::authenticate('admin@fastlight.com', md5('1234'));
    dump($user);
    
    
    // identificación incorrecta (probad distintos mails, passwords...)
    echo "<h3>Identificación email incorrecta</h3>";
    $user = User::authenticate('robert@fastlight.com', md5('1234'));
    dump($user);
    
    // identifica mediante teléfono (probad con admin y con biblio)
    echo "<h3>Identificación teléfono correcta</h3>";
    $user = User::authenticate('666666666', md5('1234'));
    dump($user);
    
    echo "<h3>Identificación teléfono incorrecta</h3>";
    $user = User::authenticate('666666665', md5('1234'));
    dump($user);
        
   
    
    
    
    