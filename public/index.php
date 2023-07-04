<?php

/** index.php
 *
 *  Punto de entrada para todas las peticiones.
 * 
 * Carga el fichero de configuración, el autoload, las funciones helper
 * y arranca la aplicación Web o Api.
 *
 * Última revisión: 04/07/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since 0.1.0
 */

require '../config/config.php';         // carga el config
require '../App/autoload.php';    // carga el autoload
require '../App/Helpers/helpers.php';       // carga las funciones helper globales


$request = Request::create();           // crea el objeto Request 
$app = NULL;                            

// Crea una instancia de la aplicación, dependiendo de si el proyecto 
// es para una aplicación WEB o una API.
switch(strtoupper(APP_TYPE)){
    case 'WEB' : 
        $app = new App();
        break;
    
    case 'API' : 
        // cabeceras para el CORS
        header("Access-Control-Allow-Origin: ".ALLOW_ORIGIN);
        header("Access-Control-Allow-Methods: ".ALLOW_METHODS);
        header("Access-Control-Allow-Headers: ".ALLOW_HEADERS);
        header("Access-Control-Allow-Credentials: ".ALLOW_CREDENTIALS);
        
        $app = new Api();  
        break;
    
    default    : die('El proyecto solamente puede ser WEB o API.');
}
    
// Arranca la aplicación y le pasa la request
$app->start($request);


