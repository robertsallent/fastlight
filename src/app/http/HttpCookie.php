<?php

/**
 *   Clase HttpCookie
 *
 *   Facilita la tarea de enviar y recuperar cookies.
 *
 *   Última mofidicación: 26/02/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.2.2
 */
class HttpCookie{
    
    /**
     * Constructor
     * 
     * @param string $name nombre de la cookie 
     * @param string $value valor de la cookie
     * @param int $expires tiempo de expiración (0 para cookie de sesión)
     * @param string $path ruta para la que es válida la cookie en el servidor
     * @param string $domain dominio
     * @param bool $secure si solamente se puede transferir por https
     * @param bool $httpOnly si no debe ser modificada en el lado del cliente
     */
    public function __construct(
        private string $name,
        private string $value   = "",
        private int $expires    = 0,
        private string $path    = "",
        private string $domain  = "",
        private bool $secure    = false,
        private bool $httpOnly  = false
    ){}
    
     
    
    /**
     * Envía una cookie haciendo uso del método setcookie() de PHP
     * 
     * TODO: hacerlo mediante cabeceras HTTP
     * 
     * @return bool
     */
    public function send():bool{
        return setcookie(
                    $this->name,
                    $this->value,
                    $this->expires,
                    $this->path,
                    $this->domain,
                    $this->secure,
                    $this->httpOnly
                );
    }
    
    
    
    
    /**
     * Recupera el valor de una cookie,
     * 
     * @param string $name nombre de la cookie a recuperar
     * 
     * @return string|NULL valor recuperado o null si no existe la cookie
     */
    public static function get(string $name):?string{
            
        $data = filter_input(INPUT_COOKIE, $name, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if(!$data || EMPTY_STRINGS_TO_NULL && trim($data === ''))
            return NULL;
            
        return trim($data);
    }
    
    
    
    /**
     * Retorna un array con todas las entradas de $_COOKIE saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_COOKIE y los valores saneados
     */
    public static function all():array{
        $all = [];
        
        foreach($_COOKIE as $property => $value){
            
            $value = filter_input(INPUT_COOKIE, $property, FILTER_SANITIZE_SPECIAL_CHARS);
            
            // si hay que pasar la cadena vacía a NULL...
            if(!$value || EMPTY_STRINGS_TO_NULL && trim($value) === ''){
                $all[$property] = NULL;
                continue;
            }
            
            $all[$property] =  trim($value);
        }
        
        return $all;
    }
      
}

