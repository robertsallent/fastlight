<?php

/*
 * Autoload a partir de espacios de nombres
 * 
 * Última mofidicación: 24/02/2023
 *
 * Permitirá la carga de clases automática a partir de un espacio de nombres
 *
 * Aún no se aplica, ya veremos si se usa más adelante o no. Por motivos docentes
 * de momento no se incluyen namespaces en FastLight.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
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

    