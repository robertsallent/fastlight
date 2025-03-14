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
 * - Si se produce algún error en la fase de arranque, carga una vista de  error genérica (código 500).
 * - Envia la Response final, invocando al método send().
 * 
 * Última revisión: 13/03/2025
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


// comprueba la versión de PHP (se configura en config.php)
if (CHECK_PHP_VERSION && version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) 
    die("ERROR: se requiere PHP ".MIN_PHP_VERSION." pero se detectó PHP ".PHP_VERSION.". Puedes actualizar la 
         versión de PHP en el servidor o modificar el parámetro MIN_PHP_VERSION en el fichero de configuración 
         (pero no se garantiza el correcto funcionamiento).");

 
// carga el autoload y las funciones helper globales
require '../app/autoload.php';          
require '../app/helpers/helpers.php';   


// ajusta el nombre y tiempo de sesión (se configura en config.php)
session_name(SESSION_NAME);
ini_set('session.gc_maxlifetime', SESSION_TIME);
session_set_cookie_params(SESSION_COOKIE_EXPIRE);


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
        
        // para las aplicaciones WEB
        // Crea la instancia del Kernel App y llama al método boot()
        case 'WEB' :  $response = (new App())->boot();
                      break;
        
        // para APIs
        // Crea la instancia del Kernel Api y llama al método boot()
        case 'API' : $response = (new Api())->boot();
                     
                     // cabeceras para CORS
                     $response->addHeader("Access-Control-Allow-Origin: ".ALLOW_ORIGIN);
                     $response->addHeader("Access-Control-Allow-Methods: ".ALLOW_METHODS);
                     $response->addHeader("Access-Control-Allow-Headers: ".ALLOW_HEADERS);
                     $response->addHeader("Access-Control-Allow-Credentials: ".ALLOW_CREDENTIALS);
                     break;
        
        // para cualquier otro tipo de aplicación...
        default: throw new BootException('El proyecto solamente puede ser WEB o API.');
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
    

