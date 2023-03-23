<?php

    echo "<h1>Test de gestión de roles</h1>";

    echo "<p>Recupera el usuario 1 y muestra sus roles:</p>";
    $usuario = User::getById(1);
    dump($usuario->getRoles());
    
    echo "Es admin?: ".($usuario->isAdmin() ? 'SI' : 'NO');
    
    echo "<p>Añade un rol ROLE_TEST al usuario:</p>";
    $usuario->addRole('ROLE_TEST');
    $usuario->update(); // para aplicar los cambios a la BDD
    dump($usuario->getRoles());
    
    echo "<p>Recupera el usuario 1 y muestra sus roles (para comprobar que en BDD está OK):</p>";
    $usuario = User::getById(1);
    dump($usuario->getRoles());
    
    echo "ROLE_TEST: ".($usuario->hasRole('ROLE_TEST') ? 'SI' : 'NO');
    echo "<br>";
    echo "ROLE_DEVELOPER: ".($usuario->hasRole('ROLE_DEVELOPER') ? 'SI' : 'NO');
    echo "<br>";
    echo "ROLE_USER AND ROLE_TEST: ".($usuario->allRoles(['ROLE_USER', 'ROLE_TEST']) ? 'SI' : 'NO');
    echo "<br>";
    echo "ROLE USER OR ROLE_TEST: ".($usuario->oneRole(['ROLE_USER', 'ROLE_TEST']) ? 'SI' : 'NO');
    
    echo "<p>Quita un rol ROLE_TEST al usuario:</p>";
    $usuario->removeRole('ROLE_TEST');
    $usuario->update(); // para aplicar los cambios a la BDD
    dump($usuario->getRoles());
    
    echo "<p>Recupera el usuario 1 y muestra sus roles (para comprobar que en BDD está OK):</p>";
    $usuario = User::getById(1);
    dump($usuario->getRoles());
    
    echo "ROLE_USER AND ROLE_TEST: ".($usuario->allRoles(['ROLE_USER', 'ROLE_TEST']) ? 'SI' : 'NO');
    echo "<br>";
    echo "ROLE_USER OR ROLE_TEST: ".($usuario->oneRole(['ROLE_USER', 'ROLE_TEST']) ? 'SI' : 'NO');
         
    echo "<p>Elimina ROLE_OTHER del usuario:</p>";
    $usuario->removeRole('ROLE_OTHER');
    $usuario->update();  // para aplicar los cambios a la BDD
    dump($usuario->getRoles());
    
    echo "<p>Recupera el usuario 1 y muestra sus roles (para comprobar que en BDD está OK):</p>";
    $usuario = User::getById(1);
    dump($usuario->getRoles());
    
 