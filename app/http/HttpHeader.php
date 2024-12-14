<?php

/**
 *   Clase HttpHeader
 *
 *   Facilita la tarea de enviar y recuperar cabeceras HTTP.
 *
 *   Última mofidicación: 15/07/2024
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.3.0
 *   @since v1.4.2 añadido el método all() que retorna un array con todas las cabeceras recibidas
 */
class HttpHeader{
    
    /**
     * Constructor
     * 
     * @param string $header
     * @param bool $replace
     * @param int $responseCode
     */
    public function __construct(
        private string $header,
        private bool $replace     = true,
        private int $responseCode = 0
    ){}
    

    
    /**
     * Recupera un encabezado HTTP
     * 
     * @param string $name nombre de la cabecera HTTP
     *
     * @return ?string valor recuperado o null si no existe
     */
    public static function get(string $name):?string{
        return apache_request_headers()[$name] ?? null;
    }
    
    
    
    /**
     * Recupera todos los encabezados HTTP
     *
     *
     * @return array lista de todas las cabeceras HTTP
     */
    public static function all():array{
        return apache_request_headers();
    }
    
    
    /**
     * Adjunta una cabecera HTTP
     */
    public function send(){
        header(
            $this->header,
            $this->replace,
            $this->responseCode
        );
    }
    
}


