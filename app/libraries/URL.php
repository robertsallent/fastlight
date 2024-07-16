<?php

/** URL
 *
 * Clase con utilidades para trabajar con URLs y redirecciones.
 *
 * Última revisión: 21/05/2024
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.2.0 añadido el método estático beginsWith().
 */

 
class URL{
    
    
    /**
     * Recupera la URL actual
     * 
     * @return string la URL actual.
     */
    public static function get():string{
        return $_SERVER['REQUEST_URI'];
    }
    
    
    /**
     * Comprueba si la URL comienza por una cadena de texto determinada
     * 
     * @param string $url patrón buscado
     * 
     * @return bool cierto si la URL comienza por el patrón buscado
     */
    public static function beginsWith(string $url):bool{
        return strpos($_SERVER['REQUEST_URI'], $url) === 0;
    }
    
    
    
    /**
     * Redirige a la URL deseada
     * 
     * @param string $url URL a la que queremos redirigir.
     * 
     * @param int $delay retardo en segundos (por defecto 0).
     * @param bool $die si se debe finalizar la ejecución al redirigir (evita que puedan ejecutarse operaciones de más).
     */
    public static function redirect(
        string $url     = '/',           // URL donde redirigir
        int $delay      = 0,             // tiempo
        bool $die       = true           // detener ejecución tras redirección
    ){      
       (new Response())->redirect($url, $delay, $die);
    }  
}

