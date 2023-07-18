<?php

    echo "<h1>Test de Registro de errores en BDD</h1>";

    // registramos diversos errores de prueba
    echo "<h3>Creando algunos errores de prueba</h3>";
    AppError::new('NOTICE', 'Esto es un test');
    AppError::new('DEPRECATED', 'El penúltimo test');
    AppError::new('WARNING', "Esto '<b>es</b>\'texto\n&nbsp;&gt;&lt;especial.");
    
    // recuperamos los errores y los mostramos
    echo "<h3>Recuperando el listado completo de errores</h3>";
    $errores = AppError::get();
    
    // a modo de helpers tenemos un par de funciones interesantes:
    // - dump(): hace un var_dump() usando <pre>
    // - dd($variable, $mensaje): hace dump() and die() con el mensaje indicado. 
    dump($errores);

    echo "<h3>Borrando el último error...</h3>";
    echo "<p>Se han borrado ".AppError::clearLast()." errores.</p>";
    
    echo "<h3>Recuperando el listado completo de errores.</h3>";
    dump(AppError::get());  // comprobamos que se han borrado
    
    echo "<h3>Borrando todos los errores...</h3>";
    AppError::clear();
    
    echo "<h3>Recuperando el listado completo de errores.</h3>";
    dump(AppError::get());  // comprobamos que se han borrado
      
