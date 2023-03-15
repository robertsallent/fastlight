<?php

    echo "<h1>Test de Registro de errores en BDD</h1>";

    // registramos diversos errores de prueba
    AppError::create('/Test', 'NOTICE', 'Esto es un test');
    AppError::create('/Test/2', 'ERROR', 'Esto es otro test');
    AppError::create('/Test/3', 'DEPRECATED', 'El penúltimo test');
    AppError::create('/Test/4', 'TEST', "Esto ' <b>es</b> \' texto\n &nbsp; &gt; &lt; especial.");
    
    // recuperamos los errores y los mostramos
    $errores = AppError::get();
    
    // a modo de helpers tenemos un par de funciones interesantes:
    // - dump(): hace un var_dump() usando <pre>
    // - dd($variable, $mensaje): hace dump() and die() con el mensaje indicado. 
    dump($errores);

    // podemos borrar los errores de la BDD para que no se queden
    // foreach($errores as $error)
    //    $error->deleteObject();
    
    dd(AppError::get(), 'FIN DEL TEST');  // comprobamos
      
    