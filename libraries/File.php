<?php

/* Clase: File
 * 
 * Nos facilitará el trabajo con ficheros
 * 
 * Autor: Robert Sallent
 * Última mofidicación: 21/03/2023
 * 
 */

    class File{
        
        // muestra o descarga un fichero de texto
        public static function openTextFile(
            string $route,                      // ubicación del fichero
            string $fileName = 'file.txt',      // nombre para la descarga
            string $contentType = 'text/plain', // tipo de fichero
            bool $download = true               // descargar ?
        ){
                
            if(!is_readable($route))
                throw new FileException("No se encontró el fichero $route.");
                
            header("Content-Type: $contentType");
            
            if($download)
                header("Content-disposition: attachment; filename=$fileName");
                
            echo file_get_contents($route);
        }
        
        
        // método que elimina un fichero
        public static function remove(
            string $route,              // ubicación del fichero
            bool $exception = false,    // lanzar excepción si no puede borrar?
            bool $warnings = false      // mostrar warnings?
        ):bool{
            
            $ok = $warnings? unlink($route) : @unlink($route);
            
            if(!$ok && $exception)
                throw new FileException("No se pudo eliminar el fichero.");
            
            return $ok;
        }
        
    }


