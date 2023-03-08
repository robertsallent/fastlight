<?php

    echo "<h1>Test de login</h1>";

    // recupera un usuario
    $user = (USER_PROVIDER)::identificar('admin@fastlight.com', md5('1234'));
    
    if(!$user)
        throw new Exception('Identificación incorrecta');
        
    // haz login
    Login::set($user);
    
    // recupera el usuario logueado y muéstralo
    echo "<p>Resultado del login:</p>";
    dump(Login::user());

   
    