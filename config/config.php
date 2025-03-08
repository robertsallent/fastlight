<?php

/** config.php
 * 
 * Parámetros de configuración del proyecto.
 * Secciones:
 * - Autoload
 * - Aplicación
 * - Base de datos
 * - Usuarios y roles
 * - Login
 * - Sesión
 * - Vistas y templates
 * - Paginador
 * - Subida de ficheros
 * - Mensaje de "aceptar cookies"
 * - Herramientas de depuración (web)
 * - Tests
 * - API
 * 
 * Todas las directivas se encuentran documentadas en el mismo fichero config.php.
 * 
 * Última revisión: 25/02/25
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.1.0
 * @since v1.0.0 se pueden configurar las vistas de error personalizadas
 * @since v1.1.5 añadidos los parámetros de configuración de subida de ficheros
 * @since v1.2.2 se puede configurar el mensaje de "aceptar cookies"
 * @since v1.4.2 se pueden configurar los roles que pueden ver test, errores y ejemplos HTML y se puede indicar la versión de la aplicación.
 * @since v1.4.5 se puede indicar que queremos que se compruebe la versión de PHP del servidor
 * @since v1.6.0 se han quitado algunas opciones de depuración (demasiadas opciones)
 * @since v1.7.5 se puede limitar el tamaño máximo del fichero de LOG.
 * @since v1.7.6 añadidas SESSION_NAME, SESSION_TIME y SESSION_COOKIE_EXPIRE
 * @since v1.8.3 añadida la posibilidad de indicar la carpeta para las fotos de perfil de usuario y su imagen por defecto.
 * @since v1.8.3 eliminada la constante ADMIN_ROLE, no aportaba nada y complicaba la comprensión del código
 * @since v1.8.4 añadida la constante BLOCKED_MESSAGE con el mensaje a mostrar cuando haga login un usuario bloqueado
 * @since v1.8.4 añadida la constante BLOCKED_REDIRECT para configurar la redirección cuando haga login un usuario bloqueado
 */
   

/* -------------------------------------------------------------
 * AUTOLOAD
 * -------------------------------------------------------------*/

// listado de directorios para que el el autoload busque clases (no PSR-4) 
define('AUTOLOAD_DIRECTORIES',  [
    '../app/core',          // core 
    '../app/http',          // peticiones y respuestas 
    '../app/libraries',     // librerías
    '../app/interfaces',    // interfaces
    '../mvc/controllers',   // controladores
    '../mvc/models',        // modelos 
    '../templates',         // plantillas para las vistas
    '../app/exceptions'     // excepciones
]);
 
    
    
/* -------------------------------------------------------------
 * APLICACIÓN
 * -------------------------------------------------------------*/

define('APP_NAME', 'FastLight Framework');   // Título de la aplicación.
define('APP_TYPE', 'WEB');                   // Tipo de aplicación: WEB o API.

define('APP_VERSION', '1.8.6');  // versión actual del framework o aplicación desarrollada
define('SHOW_VERSION', true);     // muestra la versión de la app en el footer (templates/Base.php)


// Controlador y método por defecto (solamente para APP_TYPE WEB).
define('DEFAULT_CONTROLLER', 'WelcomeController');
define('DEFAULT_METHOD', 'index');
   
// Email del administrador, para la operación de "contacto".
// Esta operación no está implementada de serie en FastLight,
// la implementamos en clase.
define('ADMIN_EMAIL', 'robert@fastlight.org');

// ¿Deben las cadenas vacías ser convertidas a NULL? 
// se aplica al recuperar los datos de la petición mediante el objeto Request,
// tanto si llegan por GET, POST, COOKIE...
define('EMPTY_STRINGS_TO_NULL', true);



/* -------------------------------------------------------------
 * VERSIONES DE PHP Y HTTP
 * -------------------------------------------------------------*/

// versión de PHP necesaria para ejecutar el framework o aplicación
// podría funcionar en versiones anteriores pero no se garantiza que lo haga
define('MIN_PHP_VERSION', '8.2.0');  

// comprobación de la versión de PHP del servidor
// si está a true impide que se ejecute la aplicación en servidores con versiones
// de PHP anteriores a MIN_PHP_VERSION.
define('CHECK_PHP_VERSION', true);


define('HTTP_VERSION', '1.1');       // versión de HTTP a usar en las respuestas
define('RESPONSE_CHARSET', 'utf-8'); // charset para las respuestas HTTP



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

define('DB_CLASS','DBPDO');     // Clase a usar, puede ser DBMysqli (mysqli) o DBPDO (PDO).
define('SGDB','mysql');         // Driver que debe usar PDO (solamente para PDO).



/* -------------------------------------------------------------
 * USUARIOS Y ROLES
 * -------------------------------------------------------------*/

// Proveedor de usuarios para autenticación.
//  - Debe implementar la interfaz Autenticable.
//  - Debe usar el trait Autorizable.
// La única opción incluida actualmente es User (no lo cambiéis).
define('USER_PROVIDER', 'User');

// Roles para los usuarios. Podemos crear o eliminar roles según las necesidades.
define('USER_ROLES', [
    'Usuario'       => 'ROLE_USER',
    'Administrador' => 'ROLE_ADMIN',
    'Supervisor'    => 'ROLE_SUPERVISOR',
    'Editor'        => 'ROLE_EDITOR',
    'Test'          => 'ROLE_TEST',
    'API'           => 'ROLE_API',
    'Estudiante'    => 'ROLE_STUDENT',
    'Bloqueado'     => 'ROLE_BLOCKED'
]);

// mensaje que se mostrará al usuario bloqueado cuando intenta hacer Login
define('BLOCKED_MESSAGE', "Has sido bloqueado por un administrador, si consideras 
                           que es un error puedes contactar mediante el formulario de contacto.");

// redirección tras el intento de Login del usuario bloqueado
define('BLOCKED_REDIRECT', '/');

// carpeta para las imágenes de los usuarios
define('USER_IMAGE_FOLDER','/images/users');

// imagen por defecto para los usuarios que no tengan
define('DEFAULT_USER_IMAGE', 'default.png');



/* -------------------------------------------------------------
 * LOGIN
 * -------------------------------------------------------------*/

define('REDIRECT_AFTER_LOGIN', '/');                // Redirección tras login.

define('LOG_LOGIN_ERRORS', false);                 // Guardar errores de login en fichero de log.
define('LOGIN_ERRORS_FILE', '../logs/login.log');  // Nombre del fichero para los errores de login.

define('DB_LOGIN_ERRORS', false);                  // Guardar errores de login en la base de datos.



/* -------------------------------------------------------------
 * SESIÓN
 * -------------------------------------------------------------*/

// nombre de la sesión (y de la cookie de sesión)
define('SESSION_NAME', 'FASTLIGHTSESSID');   

// tiempo (en segundos) antes de marcar los datos de sesión como basura
define('SESSION_TIME', 1440);           

// tiempo de expiración de la cookie de sesión (0 cuando se reinicie el navegador)
define('SESSION_COOKIE_EXPIRE', 0); 


/* -------------------------------------------------------------
 * VISTAS Y TEMPLATES
 * -------------------------------------------------------------*/

// Carpeta para las vistas.
define('VIEWS_FOLDER', '../mvc/views');     

// Template a usar en las vistas 
// Las plantillas que se incluyen son: Base, Dark, Neon y Retro.
// Se pueden crear nuevas en la carpeta templates.
define('TEMPLATE', 'Base');



/* -------------------------------------------------------------
 * PAGINADOR
 * -------------------------------------------------------------*/

define('RESULTS_PER_PAGE', 10);  // Número de resultados por página



/* -------------------------------------------------------------
 * SUBIDA DE FICHEROS
 * -------------------------------------------------------------*/

// carpeta por defecto para la subida de ficheros
define('UPLOAD_FOLDER', '../storage'); 

// tamaño máximo para los ficheros subidos en bytes (0 sin límite)
define('UPLOAD_MAX_SIZE', 0);          



/* -------------------------------------------------------------
 * MENSAJE DE "ACEPTAR COOKIES"
 * -------------------------------------------------------------*/

define('ACCEPT_COOKIES', true);    // habilita el mensaje de "aceptar cookies"

// mensaje que aparece en el formulario de "aceptar cookies"
// los saltos de línea en el mensaje se convertirán en cambio de párrafo
define(
    'ACCEPT_COOKIES_MESSAGE', 
    "Para visitar este sitio debes aceptar las cookies. 
     Este cuado de diálogo se puede configurar para que aparezca o no en el fichero config.php."
);

// nombre de la cookie que se guardará para saber que nos han aceptado las cookies
define('ACCEPT_COOKIES_NAME', 'accept-cookies');    

// tiempo que durará la cookie de "aceptar cookies" en segundos.
// por defecto una semana, 0 para que tenga duración de sesión
define('ACCEPT_COOKIES_EXPIRATION', time()+604800); 



/* -------------------------------------------------------------
 * HERRAMIENTAS DE DEPURACIÓN (PARA APP_TYPE WEB)
 * -------------------------------------------------------------*/
    
define('DEBUG', true); // Activa el modo debug.   

// Detalles que queremos mostrar en modo debug en la página de error
// OPCIONES: user, trace, request, session
define('DEBUG_INFO', [
    'user',     // Muestra información del usuario y cliente.
    'trace',    // Muestra traza del error.
    'request',  // Muestra información de la Request y datos recibidos.
    'session',  // Muestra las variables de sesión.   
]);

define('LOG_ERRORS', true);                        // Guardar errores en fichero de log.
define('ERROR_LOG_FILE', '../logs/error.log');     // Nombre del fichero de log.
define('LOG_MAX_SIZE', 8388608);                   // tamaño máximo del fichero de LOG en Bytes (0 ilimitado)

define('DB_ERRORS', true);                         // Guardar errores en la base de datos.
define('ERROR_DB_TABLE', 'errors');                // Nombre de la tabla en la BDD para los errores.

// usuarios que tienen acceso al listado de errores
define('ERROR_ROLES', ['ROLE_ADMIN', 'ROLE_TEST']);

// usar vistas personalizadas de error 401, 403...
// se deben colocar en el directorio de vistas en la subcarpeta httperrors y el nombre
// del fichero debe ser el código del error, por ejemplo 404.php
// solamente se muestran si no estamos en modo DEBUG
define('USE_CUSTOM_ERROR_VIEWS', true);


/* -------------------------------------------------------------
 * TESTS Y EJEMPLOS
 * -------------------------------------------------------------*/

// Carpeta para los test.
define('TEST_FOLDER', '../test');  

// roles que tienen autorización para ver y ejecutar test
define('TEST_ROLES', ['ROLE_ADMIN', 'ROLE_TEST']); 

// Carpeta para los ejemplos de maquetación.
define('EXAMPLE_FOLDER', '../mvc/views/examples/source'); 
   

/* -------------------------------------------------------------
 * ESTADÍSTICAS DE VISITAS
 * -------------------------------------------------------------*/

// Si queremos guardar estadísticas del número de visitas de cada URL
define('SAVE_STATS', false);

// nombre de la tabla para las estadísticas de visitas en la BDD
define('STATS_TABLE', 'stats');

// roles que tienen autorización para ver las estadísticas
define('STATS_ROLES', ['ROLE_ADMIN', 'ROLE_TEST']);



/* -------------------------------------------------------------
 * API
 * -------------------------------------------------------------*/

// Cabeceras CORS:
define('ALLOW_ORIGIN', 'http://localhost');          // Orígenes aceptados para peticiones.
define('ALLOW_METHODS', 'POST, GET, PUT, DELETE');   // Métodos aceptados para peticiones.
define('ALLOW_HEADERS', 'csrf_token');               // Encabezados permitidos.
define('ALLOW_CREDENTIALS', 'true');                 // ¿Se permite el envío de credenciales?

define('API_AUTHENTICATION', 'COOKIE'); // puede ser COOKIE (implementado) o KEY (no implementado aún)

    
    