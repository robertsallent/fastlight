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
 * Última revisión: 20/05/24
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since 0.1.0
 * @since 1.0.0 se pueden configurar las vistas de error personalizadas
 * @since 1.1.5 añadidos los parámetros de configuración de subida de ficheros
 * @since 1.2.2 se puede configurar el mensaje de "aceptar cookies"
 */
   

/* -------------------------------------------------------------
 * AUTOLOAD
 * -------------------------------------------------------------*/

// direcotrios para el autoload (no PSR-4) 
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
define('APP_NAME','FastLight Framework'); // Título de la aplicación.
define('APP_TYPE', 'WEB');                // Tipo de aplicación: WEB o API.

define('HTTP_VERSION', '1.1'); // versión de HTTP usada.

// Controlador y método por defecto (solamente para APP_TYPE WEB).
define('DEFAULT_CONTROLLER', 'WelcomeController');
define('DEFAULT_METHOD', 'index');
   
// Email del administrador, para la operación de "contacto"
define('ADMIN_EMAIL', 'robert@juegayestudia.com');

// ¿Deben las cadenas vacías ser convertidas a NULL? 
// se aplica all recuperar los datos de la petición mediante el objeto Request,
// tanto si llegan por GET, POST, COOKIE...
define('EMPTY_STRINGS_TO_NULL', true);

// Charset para las respuestas HTTP
define('RESPONSE_CHARSET', 'utf-8');



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
 * LOGIN
 * -------------------------------------------------------------*/

define('REDIRECT_AFTER_LOGIN', '/');                // Redirección tras login.

define('LOG_LOGIN_ERRORS', false);                 // Guardar errores de login en fichero de log.
define('LOGIN_ERRORS_FILE', '../logs/login.log');  // Nombre del fichero para los errores de login.

define('DB_LOGIN_ERRORS', false);                  // Guardar errores de login en la base de datos.



/* -------------------------------------------------------------
 * VISTAS Y TEMPLATES
 * -------------------------------------------------------------*/

define('VIEWS_FOLDER', '../mvc/views');     // Carpeta para las vistas.

// Template a usar en las vistas (en la carpeta templates).
// Las opciones disponibles por defecto son Base, Dark, Neon o Retro.
define('TEMPLATE', 'Base');



/* -------------------------------------------------------------
 * PAGINADOR
 * -------------------------------------------------------------*/

define('RESULTS_PER_PAGE', 10);  // Número de resultados por página



/* -------------------------------------------------------------
 * SUBIDA DE FICHEROS
 * -------------------------------------------------------------*/

define('UPLOAD_FOLDER', '../storage'); // carpeta por defecto para las subidas de ficheros
define('UPLOAD_MAX_SIZE', 0);          // tamaño máximo para las subidas, en bytes (0 sin límite)



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
// por defecto un día, 0 para que tenga duración de sesión
define('ACCEPT_COOKIES_EXPIRATION', time()+86400); 



/* -------------------------------------------------------------
 * HERRAMIENTAS DE DEPURACIÓN (PARA APP_TYPE WEB)
 * -------------------------------------------------------------*/
    
define('DEBUG', true); // Activa el modo debug.   

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

// usar vistas personalizadas de error 401, 403...
// se deben colocar en el directorio de vistas en la subcarpeta httperrors y el nombre
// del fichero debe ser el código del error, por ejemplo 404.php
// solamente se muestran si no estamos en modo DEBUG
define('USE_CUSTOM_ERROR_VIEWS', true);


/* -------------------------------------------------------------
 * TESTS
 * -------------------------------------------------------------*/

define('TEST_FOLDER', '../test');  // Carpeta para los test.
define('BEAUTIFUL_TEST', true);    // ¿Usar template en los tests?
define('TEST_TEMPLATE', 'Test');   // Ubicación del template para los tests.

   
/* -------------------------------------------------------------
 * API
 * -------------------------------------------------------------*/

// Cabeceras CORS:
define('ALLOW_ORIGIN', 'http://localhost');          // Orígenes aceptados para peticiones.
define('ALLOW_METHODS', 'POST, GET, PUT, DELETE');   // Métodos aceptados para peticiones.
define('ALLOW_HEADERS', 'csrf_token');               // Encabezados permitidos.
define('ALLOW_CREDENTIALS', 'true');                 // ¿Se permite el envío de credenciales?

define('API_AUTHENTICATION', 'COOKIE'); // puede ser COOKIE (implementado) o KEY (no implementado aún)

    
    