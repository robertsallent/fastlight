<?php

    // recupera un usuario
    $u = (USER_PROVIDER)::identificar('admin@fastlight.com', md5('1234'));
    
    if(!$u)
        throw new Exception('Identificación incorrecta');
        
    // haz login
    Login::set($u);
    
    // recupera el usuario logueado y muéstralo
    echo "<p>Resultado del login:</p>";
    echo "<pre>";
    echo var_dump(Login::user());
    echo "</pre>";
   
    