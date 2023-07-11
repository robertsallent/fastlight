
<h1>Test de gestión de roles</h1>


<h2>Recuperando roles</h2>
<p>Comenzaremos recuperando el usuario 1 y mostrando sus roles.</p>
<?php
    $u = User::find(1);
    dump($u->getRoles());     // ROLE_USER, ROLE_ADMIN
?>
<p> Es administrador? <?= $u->isAdmin() ? 'SI' : 'NO' ?>.</p>



<h2>Añadiendo roles</h2>
<p>Añadiremos los roles ROLE_TEST y ROLE_FOO al usuario 1, aplicando los cambios
   en la base de datos.</p>
<?php     
    $u->addRole('ROLE_TEST', 'ROLE_FOO');
    $u->update();             // aplica a la BDD
?>

<p>Ahora recuperaremos de nuevo el usuario desde la BDD para comprobar si se
   asignaron bien los nuevos roles.</p>
<?php 
    $u = User::find(1);       // recupera de la BDD
    dump($u->getRoles());     // ROLE_USER, ROLE_ADMIN, ROLE_TEST, ROLE_FOO
?>


<h2>Probando los métodos hasRole(), allRoles() y oneRole()</h2>
 <?php    
    echo "<br>TEST: ".($u->hasRole('ROLE_TEST') ? 'SI' : 'NO');                                  // SI
    echo "<br>DEVELOPER: ".($u->hasRole('ROLE_DEVELOPER') ? 'SI' : 'NO');                        // NO
    echo "<br>USER and TEST: ".($u->allRoles(['ROLE_USER', 'ROLE_TEST']) ? 'SI' : 'NO');         // SI
    echo "<br>USER and EDITOR: ".($u->allRoles(['ROLE_USER', 'ROLE_EDITOR']) ? 'SI' : 'NO');     // NO
    echo "<br>USER or EDITOR: ".($u->oneRole(['ROLE_USER', 'ROLE_EDITOR']) ? 'SI' : 'NO');       // SI
    echo "<br>EDITOR or ADVISOR: ".($u->oneRole(['ROLE_EDITOR', 'ROLE_ADVISOR']) ? 'SI' : 'NO'); // NO
?>    


<h2>Eliminando roles</h2>    
<p>Quitamos ROLE_TEST al usuario y aplicamos los cambios en la base de datos.</p>
<?php 
    $u->removeRole('ROLE_TEST');
    $u->update();                   // aplica los cambios a la BDD
?>

<p>Ahora recuperaremos de nuevo el usuario desde la BDD para comprobar si se
   eliminaron bien los roles.</p>
<?php     
    $u = User::find(1);
    dump($u->getRoles());           // ROLE_USER, ROLE_ADMIN, ROLE_FOO
?>
 
<p>Intentamos quitar ROLE_OTHER y ROLE_FOO del usuario, aplicando los cambios en la BDD.</p>
<?php 
    $u->removeRole('ROLE_OTHER', 'ROLE_FOO');
    $u->update();                   // aplica los cambios a la BDD
?>    
 
 <p>Ahora recuperaremos de nuevo el usuario desde la BDD para comprobar si se
   eliminaron bien los roles.</p> 
<?php  dump(User::find(1)->getRoles());  // ROLE_USER, ROLE_ADMIN ?>

