<?php

    // Fichero index.php
    // por aquí pasan todas las peticiones
    
    // para cuando trabajemos con sesiones
    session_start();

    // cargar recursos
    require_once '../config/config.php';
    require_once '../libraries/autoload.php';
    
    // invocar al controlador frontal
    FrontController::main();
    
