<?php

/** index.php
 *
 *  Punto de entrada para todas las peticiones.
 * 
 * Carga el fichero de configuración, el autoload, las funciones helper
 * y arranca la aplicación (WEB o API).
 *
 * Última revisión: 08/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since 0.1.0
 * @since 1.4.5 se puede comprobar que la versión de PHP sea la adecuada
 */


/*
 * Tareas de inicialización: 
 * carga de ficheros necesarios y comprobación de versión de PHP
 */

require '../config/config.php';         // carga el fichero de configuración


// comprueba la versión de PHP (si está indicado en la configuración)
if (CHECK_PHP_VERSION && version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) 
    die("ERROR: se requiere PHP ".MIN_PHP_VERSION." pero se detectó PHP ".PHP_VERSION.". Puedes actualizar la 
         versión de PHP en el servidor o modificar el parámetro MIN_PHP_VERSION en el fichero de configuración 
         (esta opción no garantida el correcto funcionamiento).");

    
require '../app/autoload.php';          // carga el autoload
require '../app/helpers/helpers.php';   // carga las funciones helper globales

session_start();                        // inicia la gestión de sesiones


/*
 * A partir de este punto: 
 * 
 * Se crea una instancia del Kernel adecuado a partir de la Request y llama al método boot() 
 * que le retorna la Response.
 * 
 * Finalmente, se llama al método send() para enviar la respuesta al cliente.
 * 
 */

$request = new Request();   // crea un objeto Request a partir de los datos en la petición

// Se comprueba si el proyecto es una WEB o una API.
switch(strtoupper(APP_TYPE)){
    
    // para las aplicaciones web
    case 'WEB' :  $kernel = new App($request); // crea una instancia del Kernel App
                  $response = $kernel->boot();
                  break;
    
    // para Apis
    case 'API' : $kernel = new Api($request); // crea una instancia del Kernel Api
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

$response->send();   // envía la respuesta al cliente


    

