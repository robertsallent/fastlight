<?php

/** URL
 *
 * Clase con utilidades para trabajar con URLs y redirecciones.
 *
 * Última revisión: 23/02/2025
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * @since v1.2.0 añadido el método estático beginsWith().
 * 
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
     * @param string $url URL a la que queremos redireccionar.
     * @param int $delay retardo en la redirección.
     * @param int $httpCode código HTTP
     * @param string $status frase de estado HTTP
     * @param string $contentType tipo MIME de la respuesta
     * @param bool $die finalizar la ejecución tras la redirección?
     * 
     * @return RedirectResponse
     */
    public static function redirect(
         string $url        = '/',
        int $delay          = 0,
        int $httpCode       = 302,
        string $status      = 'FOUND'
        
    ):RedirectResponse{
        
        return new RedirectResponse($url, $delay, $httpCode, $status);
    }
    
}

