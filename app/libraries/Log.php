<?php


/* Clase Log
 *
 * Herramientas para registro de errores y mensajes
 *
 * Autor: Robert Sallent
 * Última revisión: 09/03/2023
 *
 */
 
class Log{
    
    // TODO: limitar el tamaño de los ficheros
    
    // método estático para guardar mensajes de error
    public static function addMessage(
        string $route   = '../logs/error.log',          // ruta completa del fichero de error
        string $level   = 'ERROR',                      // nivel del error (NOTICE, WARNING, ERROR)
        string $message = 'se ha producido un error'    // mensaje
    ){
        
        $file = fopen($route, 'a');
        $date = date("d/m/Y H:i:s");
        
        fprintf($file, "%s: %s - %s\n", $level, $date, $message);
        
        fclose($file);
    }   
}
