<?php

    /* Fichero: config.php
     * 
     * Parámetros de configuración del proyecto
     * 
     * Autor: Robert Sallent
     * Última revisión: 10/03/2023
     * 
     */
    
    // directorios para el autoload (que no usa namespaces)
    $autoloadDirectories = [
        '../controllers',
        '../models',
        '../libraries',
        '../interfaces',
        '../templates',
        '../exceptions'
    ];
 
    // título de la aplicación
    define('APP_NAME','FastLight Framework');

    // controlador y método por defecto
    define('DEFAULT_CONTROLLER', 'Welcome');
    define('DEFAULT_METHOD', 'index');
    
    // carpeta para las vistas
    define('VIEWS_FOLDER', '../views');
    
    // modo debug y depuración
    define('DEBUG', true);                          // para depuración
    define('LOG_ERRORS', false);                    // guardar errores en log
    define('ERROR_LOG_FILE', '../logs/error.log');  // nombre del fichero de log
    
    // detalles a mostrar en la info de debug tras un error
    // OPCIONES: ['user', 'trace', 'post', 'get', 'session', 'cookie', 'client']
    $errorDetail = ['user', 'trace', 'post', 'get', 'session', 'cookie', 'client'];
    
    define('DB_ERRORS', false);                     // guardar errores en BDD
    define('ERROR_DB_TABLE', 'errors');             // nombre de la tabla para los errores
        
    // parámetros de configuración de la base de datos
    define('DB_HOST','localhost');  // host
    define('DB_USER','root');       // usuario
    define('DB_PASS','');           // password
    define('DB_NAME','fastlight');  // base de datos
    define('DB_PORT',  3306);       // puerto
    define('DB_CHARSET','utf8');    // codificación

    // clase para la conexión
    define('DB_CLASS','DBPDO');    // DB o DBPDO
    define('SGDB','mysql');        // driver que debe usar PDO (solo para DBPDO)
      
    // clase para los usuarios
    // la clase indicada debe implementar Autenticable y Autorizable
    define('USER_PROVIDER', 'User');
    
    
    
    
    
    