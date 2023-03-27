<?php

/*
 * Fichero: autoload.php
 * Autor: Robert Sallent
 * Última mofidicación: 24/02/2023
 *
 * Permitirá la carga de clases automática a partir de un listado de directorios
 * 
 */
    
    // función usada para buscar las clases
    function load(string $clase){ 
    
        // para cada directorio de la lista
        foreach(AUTOLOAD_DIRECTORIES as $directorio){
            
           $ruta="$directorio/$clase.php";  // calcula la ruta
          
           if(is_readable($ruta)){          // si es legible...
                require_once $ruta;         // carga la clase
                break;                      // ahorra iteraciones
           }
        }
    }
    
    // registrar la función de autoload anterior
    spl_autoload_register("load");  
    
