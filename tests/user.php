<?php

    echo "<p>Recupera el usuario 1:</p>";
    $usuario = User::getById(1);
    
    echo "<pre>";
    echo var_dump($usuario);
    echo "</pre>";
    
    echo "<p>Muestra los roles:</p>";
    echo "<pre>";
    echo var_dump($usuario->getRoles());
    echo "</pre>";
    
    echo "<p>Comprueba si es admin:</p>";
    echo "<pre>";
    echo "Es admin?: ".($usuario->isAdmin() ? 'SI' : 'NO');
    echo "</pre>";
    
    echo "<p>Añade un rol al usuario:</p>";
    $usuario->addRole('ROLE_TEST');
    $usuario->update(); // para aplicar los cambios a la BDD
    
    echo "<pre>";
    echo var_dump(User::getById(1));
    echo "</pre>";
    
    echo "<p>Comprueba si el usuario tiene un rol:</p>";
    echo "ROLE_TEST: ".($usuario->hasRole('ROLE_TEST') ? 'SI' : 'NO');
    echo "<br>";
    echo "ROLE_DEVELOPER: ".($usuario->hasRole('ROLE_DEVELOPER') ? 'SI' : 'NO');
    
    echo "<p>Elimina un rol del usuario:</p>";
    $usuario->removeRole('ROLE_TEST');
    $usuario->update();  // para aplicar los cambios a la BDD
    
    echo "<pre>";
    echo var_dump(User::getById(1));
    echo "</pre>";