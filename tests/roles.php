<?php

    echo "<h1>Test de gestión de roles</h1>";

    echo "<p>Recupera el usuario 1:</p>";
    $usuario = User::getById(1);
    dump($usuario);
 
    
    echo "<p>Muestra los roles:</p>";
    dump($usuario->getRoles());
    
    
    echo "<p>Comprueba si es admin:</p>";
    echo "Es admin?: ".($usuario->isAdmin() ? 'SI' : 'NO');
    
    
    echo "<p>Añade un rol al usuario:</p>";
    $usuario->addRole('ROLE_TEST');
    $usuario->update(); // para aplicar los cambios a la BDD
    dump(User::getById(1));
    
    
    echo "<p>Comprueba si el usuario tiene un rol:</p>";
    echo "ROLE_TEST: ".($usuario->hasRole('ROLE_TEST') ? 'SI' : 'NO');
    echo "<br>";
    echo "ROLE_DEVELOPER: ".($usuario->hasRole('ROLE_DEVELOPER') ? 'SI' : 'NO');
    
    
    echo "<p>Elimina un rol del usuario:</p>";
    $usuario->removeRole('ROLE_TEST');
    $usuario->update();  // para aplicar los cambios a la BDD
    dump(User::getById(1));

    
    