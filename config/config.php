<?php

    // FICHERO config.php
    
    // PARÁMETROS DE CONFIGURACIÓN DEL AUTOLOAD
    $classmap = ['../controller','../model', '../libraries']; 
    
    // TÍTULO DE LA APP
    define('APP_TITLE','');

    // PARÁMETROS DE CONFIGURACION DE LA BDD   
    define('DB_HOST','localhost');  // host
    define('DB_USER','');       // usuario
    define('DB_PASS','');           // password
    define('DB_NAME',''); // base de datos
    define('DB_CHARSET','utf8');    // codificación

    // conector que debe usar PDO,solamente si hemos visto PDO además de mysqli
    // (dependerá del curso)
    define('DB_CLASS','DBPDO'); // clase que usará el modelo (DB o DBPDO)
    define('SGDB','mysql');     // driver que debe usar PDO (solo para DBPDO)
  
    // CONTROLADOR Y METODO POR DEFECTO
    define('DEFAULT_CONTROLLER', 'Welcome');
    define('DEFAULT_METHOD', 'index');
    
    // OTROS PARAMETROS
    define('DEBUG', true); // para depuración
    
    
    
    