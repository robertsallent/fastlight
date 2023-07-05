<?php

    /* Clase URL
     *
     * Herramientas para URLs y redirecciones
     *
     * Autor: Robert Sallent
     * Última revisión: 15/02/2023
     *
     */
     
    class URL{
        
        // método estático para redirigir a la URL deseada
        public static function redirect(
            string $url     = '/',           // URL donde redirigir
            int $delay      = 0,             // tiempo
            bool $die       = true           // detener ejecución tras redirección
        ){
            
            header("Refresh:$delay; URL=$url");
            if($die) die();
        }  
    }