<?php

/* Fichero: config.php
 * 
 * Parámetros de configuración del proyecto
 * 
 * Autor: Robert Sallent
 * Última revisión: 13/04/2023
 * Desde: 0.0.1
 * 
 */
   
/* -------------------------------------------------------------
 * AUTOLOAD
 * -------------------------------------------------------------*/

    // directorios para el autoload (que no usa namespaces)
    define('AUTOLOAD_DIRECTORIES',  [
        '../controllers',
        '../models',
        '../libraries',
        '../interfaces',
        '../templates',
        '../exceptions'
    ]);
 
    
/* -------------------------------------------------------------
 * APLICACIÓN, TEMPLATE Y DIRECTORIOS
 * -------------------------------------------------------------*/
    
    // título de la aplicación
    define('APP_NAME','FastLight Framework');
    
    // tipo de aplicación
    define('APP_TYPE', 'APP'); // puede ser APP o API
    
    // PARA PROYECTOS API
    // cabeceras CORS
    define('ALLOW_ORIGIN', 'http://localhost');          // orígenes aceptados para peticiones
    define('ALLOW_METHODS', 'POST, GET, PUT, DELETE');   // métodos aceptados para peticiones
    define('ALLOW_HEADERS', 'csrf_token');               // encabezados permitidos
    define('ALLOW_CREDENTIALS', 'true');                 // se permite el envío de credenciales?
    
    define('API_AUTHENTICATION', 'COOKIE'); // puede ser COOKIE o KEY (no implementado aún)
    
    
    // PARA PROYECTOS APP
    // controlador y método por defecto (para tipo proyecto)
    define('DEFAULT_CONTROLLER', 'WelcomeController');
    define('DEFAULT_METHOD', 'index');

    // Clase para el template
    define('TEMPLATE', 'Template'); // opciones: Template, RetroTemplate
    
    // carpetas
    define('VIEWS_FOLDER',      '../views');     // para las vistas
    define('TEST_FOLDER',       '../tests');     // para los test
    
    
/* -------------------------------------------------------------
 * HERRAMIENTAS DE DEPURACIÓN (PARA TIPO APP)
 * -------------------------------------------------------------*/
    
    define('DEBUG', true);    // activa el modo debug                     
    
    // detalle a mostrar en la info de debug tras un error
    // OPCIONES: user, trace, post, get, session, cookie, client
    define('DEBUG_INFO', [
        'user', 'trace', 'post', 'get', 'session', 'cookie', 'client'
    ]);
    
    define('LOG_ERRORS', true);                       // guardar errores en fichero de log
    define('ERROR_LOG_FILE', '../logs/error.log');    // nombre del fichero de log
    
    define('DB_ERRORS', false);            // guardar errores en BDD
    define('ERROR_DB_TABLE', 'errors');   // nombre de la tabla para los errores
    
    define('LOG_LOGIN_ERRORS', false);                 // guardar errores de login en fichero de log
    define('LOGIN_ERRORS_FILE', '../logs/login.log'); // nombre del fichero
    
    define('DB_LOGIN_ERRORS', false);                  // guardar errores de login en BDD

    
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
    define('USER_ROLES', [
        'Usuario'       => 'ROLE_USER',
        'Administrador' => 'ROLE_ADMIN',
        'Supervisor'    => 'ROLE_SUPERVISOR',
        'Editor'        => 'ROLE_EDITOR',
        'Test'          => 'ROLE_TEST',
        'API'           => 'ROLE_API'
    ]);
    
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
    
    
    
    