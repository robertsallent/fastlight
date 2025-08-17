<?php

/*
 * 
 * Fichero: autoloadNS.php
 * Autor: Robert Sallent
 * Última mofidicación: 24/02/2023
 *
 * Permitirá la carga de clases automática a partir de un espacio de nombres
 *
 * Aún no se aplica, se usará más adelante cuando se actualicen los NS de las clases
 * y se reestructure el sistema de carpetas y ficheros del framework.
 *
 */

// al usar namespaces, llegará el nombre plenamente cualificado,
// esto es el namespace y el nombre de la clase.
function load(string $clase = ''){
   
    // reemplaza las contrabarras por barras y añade la extensión
    $ruta = str_replace('\\', '/', $clase).'.php';
   
    // comprueba si el fichero existe e intenta cargarlo 
    if(is_readable($ruta)) 
        require_once $ruta; // carga la clase
}

// registrar los autoloaders
spl_autoload_register("load");  

    