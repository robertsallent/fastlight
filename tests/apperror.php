<?php

    echo "<h1>Test de Registro de errores en BDD</h1>";

    // registramos diversos errores de prueba
    AppError::create('/Test', 'NOTICE', 'Esto es un test');
    AppError::create('/Test', 'DEPRECATED', 'El penúltimo test');
    AppError::create('/Test', 'WARNING', "Esto '<b>es</b>\'texto\n&nbsp;&gt;&lt;especial.");
    
    // recuperamos los errores y los mostramos
    $errores = AppError::get();
    
    // a modo de helpers tenemos un par de funciones interesantes:
    // - dump(): hace un var_dump() usando <pre>
    // - dd($variable, $mensaje): hace dump() and die() con el mensaje indicado. 
    dump($errores);

    // foreach($errores as $error) // podemos borrar los registros tras el test (descomentar)
       // $error->deleteObject();
    
    // dump(AppError::get());  // comprobamos que se han borrado
      
