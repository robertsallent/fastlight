<?php

    echo "<h1>Test de login</h1>";

    // recupera un usuario
    $u = (USER_PROVIDER)::identificar('admin@fastlight.com', md5('1234'));
    
    if(!$u)
        throw new Exception('Identificación incorrecta');
        
    // haz login
    Login::set($u);
    
    // recupera el usuario logueado y muéstralo
    echo "<p>Resultado del login:</p>";
    echo "<pre>";
    var_dump(Login::user());
    echo "</pre>";
   
    