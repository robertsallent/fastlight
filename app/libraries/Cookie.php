<?php

/**
 *   Clase Cookie
 *
 *   Facilita la tarea de enviar y recuperar cookies.
 *
 *   Última mofidicación: 29/05/2024
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.2.2
 */
class Cookie{
    
    
    /**
     * Crea una nueva cookie utilizando setCookie().
     * 
     * @param string $name nombre de la cookie
     * @param string $value valor de la cookie
     * @param int $expires tiempo de expiración, 0 para cookie de sesión.
     * @param string $path ruta para la que se debe adjuntar la cookie
     * @param string $domain dominio
     * @param bool $secure transmitir solo por https
     * @param bool $httponly accesible solo en el lado del servidor
     * 
     * @return bool
     */
    public static function set(
        string $name, 
        string $value   = "", 
        int $expires    = 0, 
        string $path    = "",
        string $domain  = "", 
        bool $secure    = false,   
        bool $httponly  = false
    ):bool{
        return setcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }
    
    
    /**
     * Recupera el valor de una cookie,
     * 
     * @param string $name nombre de la cookie a recuperar
     * 
     * @return string|NULL valor recuperado o null si no existe la cookie
     */
    public static function get(
        string $name        // nombre de la cookie
    ): ?string{
        return Kernel::getRequest()->cookie($name);
    }

}


