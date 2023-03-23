<?php

/* Fichero: config.php
 * 
 * Parámetros de configuración del proyecto
 * 
 * Autor: Robert Sallent
 * Última revisión: 23/03/2023
 * 
 */
   
/* -------------------------------------------------------------
 * AUTOLOAD
 * -------------------------------------------------------------*/

    // directorios para el autoload (que no usa namespaces)
    $autoloadDirectories = [
        '../controllers',
        '../models',
        '../libraries',
        '../interfaces',
        '../templates',
        '../exceptions'
    ];
 
    
/* -------------------------------------------------------------
 * APLICACIÓN, TEMPLATE Y DIRECTORIOS
 * -------------------------------------------------------------*/
    
    // título de la aplicación
    define('APP_NAME','FastLight Framework');
    
    // controlador y método por defecto
    define('DEFAULT_CONTROLLER', 'Welcome');
    define('DEFAULT_METHOD', 'index');

    // Clase para el template
    define('TEMPLATE', 'Template'); // opciones: Template, RetroTemplate
    
    // carpetas
    define('VIEWS_FOLDER',      '../views');     // para las vistas
    define('TEST_FOLDER',       '../tests');     // para los test
    
    
/* -------------------------------------------------------------
 * HERRAMIENTAS DE DEPURACIÓN
 * -------------------------------------------------------------*/
    
    define('DEBUG', true);    // activa el modo debug                     
    
    // detalle a mostrar en la info de debug tras un error
    // OPCIONES: user, trace, post, get, session, cookie, client
    $errorDetail = ['user', 'trace', 'post', 'get', 'session', 'cookie', 'client'];
    
    define('LOG_ERRORS', true);                       // guardar errores en fichero de log
    define('ERROR_LOG_FILE', '../logs/error.log');    // nombre del fichero de log
    
    define('DB_ERRORS', true);                       // guardar errores en BDD
    define('ERROR_DB_TABLE', 'errors');               // nombre de la tabla para los errores
    
    define('LOG_LOGIN_ERRORS', true);                // guardar errores de login en fichero de log
    define('LOGIN_ERRORS_FILE', '../logs/login.log'); // nombre del fichero
    
    define('DB_LOGIN_ERRORS', true);                 // guardar errores de login en BDD

    
/* -------------------------------------------------------------
 * BASE DE DATOS
 * -------------------------------------------------------------*/
    
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
 
    
/* -------------------------------------------------------------
 * USUARIOS Y ROLES
 * -------------------------------------------------------------*/
    
    // clase para los usuarios
    // la clase indicada debe implementar Autenticable y usar Autorizable
    define('USER_PROVIDER', 'User');
    
    // roles para los usuarios
    $roles = ['ROLE_USER', 'ROLE_ADMIN', 'ROLE_EDITOR', 'ROLE_SUPERVISOR', 'ROLE_TEST'];
    
    // rol para el administrador (debería ser uno de los que están en la lista anterior)
    define('ADMIN_ROLE', 'ROLE_ADMIN');

    
/* -------------------------------------------------------------
 * REDIRECCIONES
 * -------------------------------------------------------------*/
    
    // redirección tras login
    define('REDIRECT_AFTER_LOGIN', '/');
    
    
/* -------------------------------------------------------------
 * PAGINADOR
 * -------------------------------------------------------------*/
    
    // para la paginación de resultados
    define('RESULTS_PER_PAGE', 10);
    
    
    
    