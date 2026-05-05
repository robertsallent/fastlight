<?php

/** URL
 *
 * Clase con utilidades para trabajar con URLs y redirecciones.
 *
 * Última revisión: 05/05/2026
 *
 * @author Robert Sallent <robert@fastlight.org>
 * 
 * @since v1.2.0 añadido el método estático beginsWith().
 * @since v2.9.0 añadidos los métodos scheme(), host() y uri().
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
     * Busca una cadena de texto en la url.
     *
     * @param string $url cadena de texto a buscar.
     * @return bool si la url contiene la cadena de texto buscada.
     */
    public static function has(string $url):bool{
        return str_contains(self::get(), $url);
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
     * Obtiene el protocolo usado: http o https
     *
     * @return string http o https
     */
    public static function scheme(): string{
        if (
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
            ($_SERVER['SERVER_PORT'] ?? null) == 443
            ) {
                return 'https';
            }
            return 'http';
    }
    
    
    
    /**
     * Retorna el nombre de host para el servidor
     *
     * @return string
     */
    public static function host(): string{
        return $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';
    }
    
   
    
    /**
     * Recupera la URI completa
     * 
     * @return string
     */
    public static function uri(): string{
        return self::scheme() . '://' . self::host() . self::get();
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
        string $url       = '/',
        int $delay        = 0,
        int $httpCode     = 302,
        string $status    = 'FOUND'
        
    ):RedirectResponse{       
        return new RedirectResponse($url, $delay, $httpCode, $status);
    }
    
}

