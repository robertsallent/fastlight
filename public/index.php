<?php

/** index.php
 *
 *  Punto de entrada para todas las peticiones.
 * 
 * Carga el fichero de configuración, el autoload, las funciones helper
 * y arranca la aplicación Web o Api.
 *
 * Última revisión: 06/07/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since 0.1.0
 */

require '../config/config.php';         // carga el config
require '../app/autoload.php';          // carga el autoload
require '../app/helpers/helpers.php';   // carga las funciones helper globales

session_start();            // inicia el trabajo con sesiones

// crea una instancia de la aplicación y la arranca.
// El proceso es distinto dependiendo de si el proyecto es una WEB o una API.
switch(strtoupper(APP_TYPE)){
    
    // para las aplicaciones web
    case 'WEB' : 
        (new App(new Request()))->boot();  // arranca la App
        break;
    
    // para Apis
    case 'API' : 
        // cabeceras para el CORS
        header("Access-Control-Allow-Origin: ".ALLOW_ORIGIN);
        header("Access-Control-Allow-Methods: ".ALLOW_METHODS);
        header("Access-Control-Allow-Headers: ".ALLOW_HEADERS);
        header("Access-Control-Allow-Credentials: ".ALLOW_CREDENTIALS);
        
        (new Api(new Request()))->boot();  // arranca la Api
        break;
    
    default    : die('El proyecto solamente puede ser WEB o API.');
}
    

