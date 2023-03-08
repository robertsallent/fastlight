<?php

    echo "<h1>Test de la clase Session</h1>";

    echo "<h2>Variables de sesión</h2>";

    echo "<p>Guarda una variable de sesión:</p>";
    Session::set('test', 'Test de sesión');
    
    echo "<p>Comprueba lo guardado:";
    echo Session::get('test');
    echo "</p>";

    echo "<p>Comprueba si existe la variable de sesión: ";
    echo Session::has('test') ? 'SI':'NO';  // SI
    echo "</p>";
    
    echo "<p>Borra una variable de sesión:</p>";
    Session::forget('test');
    
    echo "<p>Comprueba si existe la variable de sesión:";
    echo Session::has('test') ? 'SI':'NO';  // NO
    echo "</p>";
    
    echo "<h2>Flasheo de mensajes</h2>";
  
    echo "<p>Guarda un mensaje:</p>";
    Session::flash('success', 'Operación realizada con éxito.');
    
    echo "<p>Recupera un mensaje:";
    echo Session::getFlash('success');
    echo "</p>";
    
    echo "<p>Recupera un mensaje (no existe):";
    echo Session::getFlash('success');  // ya no debe existir
    echo "FIN</p>";
   