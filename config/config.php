<?php

/** config.php
 * 
 * Parámetros de configuración del proyecto
 * 
 * Última revisión: 04/07/23
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since 0.1.0
 */
   

/* -------------------------------------------------------------
 * AUTOLOAD
 * -------------------------------------------------------------*/

// direcotrios para el autoload (no PSR-4) 
define('AUTOLOAD_DIRECTORIES',  [
    '../mvc/controllers',   // controladores
    '../mvc/models',        // modelos 
    '../app/libraries',     // librerías       
    '../app/interfaces',    // interfaces
    '../app/core',          // core 
    '../templates',         // plantillas para las vistas
    '../app/exceptions'     // excepciones
]);
 
    
    
/* -------------------------------------------------------------
 * APLICACIÓN
 * -------------------------------------------------------------*/
define('APP_NAME','FastLight Framework'); // Título de la aplicación.
define('APP_TYPE', 'WEB');                // Tipo de aplicación: WEB o API.

// Controlador y método por defecto (solamente para APP_TYPE WEB).
define('DEFAULT_CONTROLLER', 'WelcomeController');
define('DEFAULT_METHOD', 'index');
    
   
    
/* -------------------------------------------------------------
 * VISTAS
 * -------------------------------------------------------------*/
    
define('VIEWS_FOLDER', '../mvc/views');     // Carpeta para las vistas.
 
// Clase para el template a usar en las vistas.
// Las opciones disponibles por defecto son Template o RetroTemplate.
define('TEMPLATE', 'Template'); 



/* -------------------------------------------------------------
 * TESTS
 * -------------------------------------------------------------*/
    
define('TEST_FOLDER', '../test');          // Carpeta para los test.
define('BEAUTIFUL_TEST', true);             // ¿Usar template en los tests?
define('TEST_TEMPLATE', 'TestTemplate');    // Ubicación del template para los tests.

    
    
/* -------------------------------------------------------------
 * HERRAMIENTAS DE DEPURACIÓN (PARA APP_TYPE WEB)
 * -------------------------------------------------------------*/
    
define('DEBUG', true);    // Activa el modo debug.                     

// Detalles que queremos mostrar en modo debug en la página de error
// OPCIONES: user, trace, post, get, session, cookie, client
define('DEBUG_INFO', [
    'user',     // Muestra información y roles del usuario identificado.
    'trace',    // Muestra traza del error.
    'post',     // Muestra los datos que llegaron por POST.
    'get',      // Muestra los datos que llegaron por GET.
    'session',  // Muestra las variables de sesión.
    'cookie',   // Muestra las cookies recibidas.
    'client'    // Muestra información del navegador del cliente.
]);

define('LOG_ERRORS', true);                        // Guardar errores en fichero de log.
define('ERROR_LOG_FILE', '../logs/error.log');     // Nombre del fichero de log.

define('DB_ERRORS', true);                        // Guardar errores en la base de datos.
define('ERROR_DB_TABLE', 'errors');                // Nombre de la tabla en la BDD para los errores.

define('LOG_LOGIN_ERRORS', false);                 // Guardar errores de login en fichero de log.
define('LOGIN_ERRORS_FILE', '../logs/login.log');  // Nombre del fichero para los errores de login.

define('DB_LOGIN_ERRORS', false);                  // Guardar errores de login en la base de datos.



/* -------------------------------------------------------------
 * BASE DE DATOS
 * -------------------------------------------------------------*/
    
// Parámetros de configuración de la base de datos:
define('DB_HOST','localhost');  // Host.
define('DB_USER','root');       // Usuario.
define('DB_PASS','');           // Password.
define('DB_NAME','fastlight');  // Nombre de la base de datos.
define('DB_PORT',  3306);       // Puerto.
define('DB_CHARSET','utf8');    // Codificación de caracteres.


define('DB_CLASS','DB');        // Clase a usar, puede ser DB (mysqli) o DBPDO (PDO).
define('SGDB','mysql');         // Driver que debe usar PDO (solamente para PDO).

    
/* -------------------------------------------------------------
 * USUARIOS Y ROLES
 * -------------------------------------------------------------*/

// Clase del modelo para trabajar con usuarios.
//  - Debe implementar la interfaz Autenticable.
//  - Debe usar el trait Autorizable.

define('USER_PROVIDER', 'User');   // La única opción incluida es User.

// Roles para los usuarios. Podemos crear o eliminar roles según las necesidades.
define('USER_ROLES', [
    'Usuario'       => 'ROLE_USER',
    'Administrador' => 'ROLE_ADMIN',
    'Supervisor'    => 'ROLE_SUPERVISOR',
    'Editor'        => 'ROLE_EDITOR',
    'Test'          => 'ROLE_TEST',
    'API'           => 'ROLE_API'
]);

// Rol para el administrador (debe ser uno de los que están en la lista anterior).
define('ADMIN_ROLE', 'ROLE_ADMIN');

    

/* -------------------------------------------------------------
 * REDIRECCIONES
 * -------------------------------------------------------------*/
    
define('REDIRECT_AFTER_LOGIN', '/'); // Redirección tras login.
    
    
/* -------------------------------------------------------------
 * PAGINADOR
 * -------------------------------------------------------------*/
    
define('RESULTS_PER_PAGE', 10);  // Número de resultados por página
    
    
    
/* -------------------------------------------------------------
 * API
 * -------------------------------------------------------------*/

// Cabeceras CORS:
define('ALLOW_ORIGIN', 'http://localhost');          // Orígenes aceptados para peticiones.
define('ALLOW_METHODS', 'POST, GET, PUT, DELETE');   // Métodos aceptados para peticiones.
define('ALLOW_HEADERS', 'csrf_token');               // Encabezados permitidos.
define('ALLOW_CREDENTIALS', 'true');                 // ¿Se permite el envío de credenciales?

define('API_AUTHENTICATION', 'COOKIE'); // puede ser COOKIE (implementado) o KEY (no implementado aún)

    
    