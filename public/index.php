<?php

/** index.php
 *
 * Punto de entrada para todas las peticiones.
 * 
 * Carga el fichero de configuración, el autoload, las funciones helper
 * y arranca la aplicación (WEB o API).
 * Si se produce algún error en la fase de arranque, carga una vista de 
 * error genérica (código 500).
 * 
 *
 * Última revisión: 12/02/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.1.0
 * @since v1.4.5 se puede comprobar que la versión de PHP sea la adecuada
 * @since v1.7.6 se gestiona el nombre y duración de la sesión
 */


/*
 * Tareas de inicialización: 
 * carga de ficheros necesarios y comprobación de versión de PHP
 */

// carga el fichero de configuración
require '../config/config.php';         


// ajusta el nombre y tiempo de sesión (se cofigura en config.php)
session_name(SESSION_NAME);
ini_set('session.gc_maxlifetime', SESSION_TIME);
session_set_cookie_params(SESSION_COOKIE_EXPIRE);


// comprueba la versión de PHP (se configura en config.php)
if (CHECK_PHP_VERSION && version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) 
    die("ERROR: se requiere PHP ".MIN_PHP_VERSION." pero se detectó PHP ".PHP_VERSION.". Puedes actualizar la 
         versión de PHP en el servidor o modificar el parámetro MIN_PHP_VERSION en el fichero de configuración 
         (esta opción no garantida el correcto funcionamiento).");

 
// carga el autoload y las funciones helper globales
require '../app/autoload.php';          
require '../app/helpers/helpers.php';   


// inicia la gestión de sesiones
session_start();                        


/*
 * A partir de este punto: 
 * 
 *  - Se crea una instancia del Kernel adecuada al tipo de aplicación.
 *  - Se llama al método boot() del Kernel, que retorna la Response a enviar al cliente.
 *  - Se envía la respuesta al cliente mediante el método send() de Response.
 *  - Se comprueba si se produjo algún error en el proceso.
 * 
 */

try{
    // Se comprueba si el proyecto es una WEB o una API.
    switch(strtoupper(APP_TYPE)){
        
        // para las aplicaciones web
        case 'WEB' :  $kernel   = new App(); // crea una instancia del Kernel App
                      $response = $kernel->boot();
                      break;
        
        // para Apis
        case 'API' : $kernel = new Api(); // crea una instancia del Kernel Api
                     $response = $kernel->boot();
                     
                     // cabeceras para el CORS
                     $response->addHeader("Access-Control-Allow-Origin: ".ALLOW_ORIGIN);
                     $response->addHeader("Access-Control-Allow-Methods: ".ALLOW_METHODS);
                     $response->addHeader("Access-Control-Allow-Headers: ".ALLOW_HEADERS);
                     $response->addHeader("Access-Control-Allow-Credentials: ".ALLOW_CREDENTIALS);
                     break;
        
        // para cualquier otro tipo de aplicación...
        default: die('El proyecto solamente puede ser WEB o API.');
    }
       
    // envía la respuesta al cliente.
    $response->send();   

    
// gestión de errores en el proceso de inicialización.
}catch(Throwable $t){
    
    // prepara el mensaje.
    $mensaje = DEBUG ? 
        'ERROR en el proceso de arranque: '.$t : 
        'Se produjo un error, contacte con el administrador '.ADMIN_EMAIL.' si es necesario.';
    
    // aborta, cargando la vista personalizada de error 500.
    abort(500, 'INTERNAL SERVER ERROR', $mensaje, $t)->send();
} 
    

