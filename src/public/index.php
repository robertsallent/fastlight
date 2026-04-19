<?php

/** index.php
 *
 * Punto de entrada para todas las peticiones.
 * 
 * - Carga el fichero de configuración.
 * - Comprueba la versión de PHP en el servidor.
 * - Carga el autoload y las funciones helper.
 * - Inicializa los parámetros de la sesión.
 * - Inicializa la sesión.
 * - Arranca la aplicación (WEB o API).
 * - Envia la Response final, invocando al método send().
 * - Si se produce algún error en la fase de arranque, carga una vista de  error genérica (código 500).
 * 
 * Última revisión: 19/04/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * 
 * @since v0.1.0
 * @since v1.4.5 se puede comprobar que la versión de PHP sea la adecuada
 * @since v1.7.6 se gestiona el nombre y duración de la sesión
 * @since v2.0.7 se añaden parámetros de seguridad a la cookie de sesión
 * @since v2.6.0 se incorpora la carga del fichero de configuración del middleware
 * @since v2.8.0 se separa la creacion de APIs RESTFUL al proyecto FastLightAPI
 */


/* -------------------------------------------------------------------------------------
 * INICIALIZACIÓN 
 * -------------------------------------------------------------------------------------*/

// carga el fichero de configuración
require  '../config/config.php';    

// si no se deben mostrar errores sobre la web, asegura que estén desactivados
// si está configurado a true (en config.php), los mostrará o no dependiendo de la configuración del servidor 
if(!DISPLAY_ERRORS)
    ini_set('display_errors', 0);
    
// comprueba la versión de PHP (según lo especificado en config.php)
if (CHECK_PHP_VERSION && version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) 
    die("ERROR: se requiere PHP ".MIN_PHP_VERSION." pero se detectó PHP ".PHP_VERSION.". Puedes actualizar la 
         versión de PHP en el servidor o modificar el parámetro MIN_PHP_VERSION en el fichero de configuración 
         (pero no se garantiza el correcto funcionamiento).");

// carga la configuración de los middlewares (si existiera)
@include '../config/middleware.php'; 
    
// carga el autoload y las funciones helper globales
require '../app/autoload.php';          
require '../app/helpers/helpers.php';   

    
/*
 * A partir de este punto: 
 * 
 *  - Se ajustan los parámetros de sesión.
 *  - Se crea una instancia del Kernel adecuada al tipo de aplicación.
 *  - Se llama al método boot() del Kernel, que retorna la Response a enviar al cliente.
 *  - Se envía la respuesta al cliente mediante el método send() de Response.
 *  - Se comprueba si se produjo algún error en el proceso.
 * 
 */
try{
    
    // ajusta el nombre y tiempo de sesión (se configura en config.php)
    session_name(SESSION_NAME);
    ini_set('session.gc_maxlifetime', SESSION_TIME);
    
    
    // parámetros de la cookie de sesión (se configuran en config.php)
    session_set_cookie_params([
        'lifetime'  => SESSION_COOKIE_EXPIRE,   // duración de la cookie
        'path'      => '/',                     // disponible en todo el dominio
        'domain'    => '',                      // por defecto el dominio actual
        'secure'    => SESSION_COOKIE_SECURE,   // solo sobre HTTPS
        'httponly'  => SESSION_COOKIE_HTTPONLY, // no accesible desde JavaScript
        'samesite'  => 'Lax'                    // evita el envío en peticiones cross-site
    ]);
    
    // inicia la gestión de sesiones
    session_start();
     
    // Crea la instancia del Kernel App y llama al método boot()
    $response = (new App())->boot();
    

// gestión de errores de esta parte.
}catch(Throwable $t){
    
    // prepara el mensaje de error.
    $mensaje = DEBUG ? 
        'Error en el proceso de incialización, el mensaje es: '.$t->getMessage() : 
        'Se produjo un error, contacte con el administrador '.ADMIN_EMAIL.' si lo considera necesario.';
    
    // prepara la respuesta de error.
    $response = abort(500, 'INTERNAL SERVER ERROR', $mensaje, $t);
   

}finally{
    
    // tanto si hay error como si no, se envía la respuesta al cliente
    $response->send();
}
    

