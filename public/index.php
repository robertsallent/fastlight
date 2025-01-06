<?php

/** index.php
 *
 *  Punto de entrada para todas las peticiones.
 * 
 * Carga el fichero de configuración, el autoload, las funciones helper
 * y arranca la aplicación Web o Api.
 *
 * Última revisión: 03/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since 0.1.0
 * @since 1.4.5 se puede comprobar que la versión de PHP sea la adecuada
 */

require '../config/config.php';         // carga el config

// comprueba la versión de PHP si está indicado en la configuración
if (CHECK_PHP_VERSION && version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) 
    die("ERROR: se requiere PHP ".MIN_PHP_VERSION." pero se detectó PHP ".PHP_VERSION.". Puedes actualizar la 
         versión de PHP en el servidor o modificar el parámetro MIN_PHP_VERSION en el fichero de configuración 
         (esta opción no garantida el correcto funcionamiento).");


require '../app/autoload.php';          // carga el autoload
require '../app/helpers/helpers.php';   // carga las funciones helper globales

session_start();            // inicia el trabajo con sesiones

// crea una instancia de la aplicación y la arranca.
// El proceso es distinto dependiendo de si el proyecto es una WEB o una API.
switch(strtoupper(APP_TYPE)){
    
    // para las aplicaciones web
    case 'WEB' : 
        (new App())->boot();  // arranca la App
        break;
    
    // para Apis
    case 'API' : 
        // cabeceras para el CORS
        header("Access-Control-Allow-Origin: ".ALLOW_ORIGIN);
        header("Access-Control-Allow-Methods: ".ALLOW_METHODS);
        header("Access-Control-Allow-Headers: ".ALLOW_HEADERS);
        header("Access-Control-Allow-Credentials: ".ALLOW_CREDENTIALS);
        
        (new Api())->boot();  // arranca la Api
        break;
    
    default    : die('El proyecto solamente puede ser WEB o API.');
}
    

