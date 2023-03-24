<?php


    echo "<h1>Test de gestión de roles</h1>";
    echo "<h2>Añadiendo y recuperando roles</h2>";
    
    echo "<p>Recupera el usuario 1 y muestra sus roles:</p>";
    $u = User::getById(1);
    dump($u->getRoles());     // ROLE_USER, ROLE_ADMIN
    
    echo "Es admin?: ".($u->isAdmin() ? 'SI' : 'NO'); // SI
    
    echo "<p>Añade ROLE_TEST y ROLE_FOO al usuario:</p>";
    $u->addRole('ROLE_TEST', 'ROLE_FOO');
    dump($u->getRoles());     // ROLE_USER, ROLE_ADMIN, ROLE_TEST, ROLE_FOO
    
    echo "<p>Recupera el usuario 1 de BDD y muestra sus roles:</p>";
    $u->update();             // aplica a la BDD
    $u = User::getById(1);    // recupera de la BDD
    dump($u->getRoles());     // ROLE_USER, ROLE_ADMIN, ROLE_TEST, ROLE_FOO
    
    echo "<br>TEST: ".($u->hasRole('ROLE_TEST') ? 'SI' : 'NO');                                  // SI
    echo "<br>DEVELOPER: ".($u->hasRole('ROLE_DEVELOPER') ? 'SI' : 'NO');                        // NO
    echo "<br>USER and TEST: ".($u->allRoles(['ROLE_USER', 'ROLE_TEST']) ? 'SI' : 'NO');         // SI
    echo "<br>USER and EDITOR: ".($u->allRoles(['ROLE_USER', 'ROLE_EDITOR']) ? 'SI' : 'NO');     // NO
    echo "<br>USER or EDITOR: ".($u->oneRole(['ROLE_USER', 'ROLE_EDITOR']) ? 'SI' : 'NO');       // SI
    echo "<br>EDITOR or ADVISOR: ".($u->oneRole(['ROLE_EDITOR', 'ROLE_ADVISOR']) ? 'SI' : 'NO'); // NO
    
    
    echo "<h2>Quitando roles</h2>";
    echo "<p>Quita ROLE_TEST al usuario:</p>";
    $u->removeRole('ROLE_TEST');
    dump($u->getRoles());           // ROLE_USER, ROLE_ADMIN, ROLE_FOO
    
    echo "<p>Comprobación con la BDD:</p>";
    $u->update();                   // aplica los cambios a la BDD
    $u = User::getById(1);
    dump($u->getRoles());           // ROLE_USER, ROLE_ADMIN, ROLE_FOO
  
    echo "<p>Elimina ROLE_OTHER y ROLE_FOO del usuario:</p>";
    $u->removeRole('ROLE_OTHER', 'ROLE_FOO');
    dump($u->getRoles());           // ROLE_USER, ROLE_ADMIN
    
    echo "<p>Comprobación con la BDD:</p>";
    $u->update();                   // aplica los cambios a la BDD
    $u = User::getById(1);
    dump($u->getRoles());           // ROLE_USER, ROLE_ADMIN
    
 