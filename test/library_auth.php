<?php

    $id = 1; // id del usuario con el que haremos la prueba (configurable)

    echo "<h1>Test de la clase Auth</h1>";

    echo "<p>Recupera el usuario $id y hace login:</p>";
    Login::set(User::getById($id));
    
    echo "<p>El usuario $id tiene los roles:</p>";
    echo arrayToString(Login::user()->getRoles());
    
    echo "<h2>Comprobaciones de Auth</h2>";
    
    echo "<p>Hay que comentar y descomentar las comprobaciones
          que se encuentran a continuación, puesto que lanzan excepciones.";

    echo " Si se produce un error de autorización, aparecerá un mensaje
          justo debajo de este párrafo.</p>";
    
    try{
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
        Auth::oneRole(['ROLE_EDITOR','ROLE_TEST']);
    
        echo "<p>No se detectaron problemas de autorización.</p>";
        
        
    }catch(AuthException $exception){
        
        $mensaje  = "<h2 style='color:red'>Detectado problema de autorización</h2>";
        $mensaje .= "<p><b>".$exception->getMessage()."</b>.</p>";
        $mensaje .= "<p>Se detuvo la ejecución en la línea <b>".$exception->getTrace()[0]['line']."</b>";
        $mensaje .= " del fichero <b>".File::name($exception->getTrace()[0]['file'])."</b>.</p>";
        
        echo $mensaje;
    }
 