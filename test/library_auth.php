<?php

    echo "<h1>Test de la clase Auth</h1>";

    echo "<p>Recupera el usuario 1 y hace login:</p>";
    $usuario = User::getById(1);
    Login::set($usuario);
    
    dump($usuario->getRoles());
    
    echo "<h2>Comprobaciones de Auth</h2>";
    echo "<p>Usuario identificado.</p>";
    dump($usuario);
    
    echo "<p>Hay que comentar y descomentar puesto que lanzan excepciones.</p>";

    // Auth::guest();  // usuario no identificado
    Auth::check();  // usuario identificado
    Auth::admin();  // usuario admin

    // pruebas con roles
    Auth::role('ROLE_ADMIN');
    // Auth::role('ROLE_TEST');
    Auth::allRoles(['ROLE_USER','ROLE_ADMIN']);
    // Auth::allRoles(['ROLE_USER','ROLE_TEST']);
    Auth::oneRole(['ROLE_USER','ROLE_ADMIN']);
    Auth::oneRole(['ROLE_USER','ROLE_TEST']);
    // Auth::oneRole(['ROLE_EDITOR','ROLE_TEST']);
    
 