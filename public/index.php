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
    require '../config/config.php';         // carga el config
    require '../libraries/autoload.php';    // carga el autoload
    require '../helpers/helpers.php';       // carga las funciones helper globales
    
    // invocar al controlador frontal
    (new FrontController())->start();
    
