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
 * Última revisión: 07/03/2023
 *
 */

    // Fichero index.php
    // por aquí pasan todas las peticiones
    // cargar recursos
    require '../config/config.php';
    require '../libraries/autoload.php';
    
    // invocar al controlador frontal
    FrontController::main();
    
