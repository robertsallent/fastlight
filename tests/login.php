<?php

    echo "<h1>Test de login</h1>";
    echo "<h2>Nadie identificado</h2>";
    
    Login::clear(); // nos aseguramos que no hay nadie identificado
    
    echo Login::guest() ? "Nadie identificado<br>" : "Alguien identificado<br>";  // nadie
    echo Login::check() ? "Alguien identificado<br>" : "Nadie identificado<br>";  // nadie
    echo Login::isAdmin() ? "Administrador<br>" : "No administrador<br>";  // NO
    
    echo "<h2>Usuario hace login</h2>";
    
    // identifica (probad con admin y con biblio)
    $user = (USER_PROVIDER)::authenticate('admin@fastlight.com', md5('1234'));
    if(!$user) throw new LoginException('Identificación incorrecta');
        
    Login::set($user); // hace Login
    
    echo "<h2>Info del usuario</h2>";
    echo Login::guest() ? "Nadie identificado<br>" : "Alguien identificado<br>";  // alguien
    echo Login::check() ? "Alguien identificado<br>" : "Nadie identificado<br>";  // alguien
    echo Login::isAdmin() ? "Administrador<br>" : "No administrador<br>";  // Administrador
    
    dump(Login::user()); // admin
    
    
    
    