<?php

/* Fichero: index.php
 *
 * Punto de entrada para todas las peticiones
 * 
 * - Carga el fichero de configuración.
 * - Carga el autoload.
 * - Invoca al controlador frontal.
 *
 * Autor: Robert Sallent
 * Última revisión: 05/04/2023
 * Desde: 0.7.0
 *
 */

    // Fichero index.php
    // por aquí pasan todas las peticiones
    require '../config/config.php';         // carga el config
    require '../libraries/autoload.php';    // carga el autoload
    require '../helpers/helpers.php';       // carga las funciones helper globales
    
    // invocar al controlador frontal
    // dependerá de si el proyecto es para una aplicación o una API.
    switch(strtoupper(APP_TYPE)){
        case 'APP' : 
            (new FrontController())->start(); 
            break;
        
        case 'API' : 
            // cabeceras para el CORS
            header("Access-Control-Allow-Origin: ".ALLOW_ORIGIN);
            header("Access-Control-Allow-Methods: ".ALLOW_METHODS);
            header("Access-Control-Allow-Headers: ".ALLOW_HEADERS);
            header("Access-Control-Allow-Credentials: ".ALLOW_CREDENTIALS);
            
            (new ApiController())->start();  
            break;
        
        default    : die('El proyecto solamente puede ser APP o API.');
    }
        
    
