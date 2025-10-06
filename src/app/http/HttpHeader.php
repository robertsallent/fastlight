<?php

/**
 *   Clase HttpHeader
 *
 *   Facilita la tarea de enviar y recuperar cabeceras HTTP.
 *
 *   Última mofidicación: 06/10/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.3.0
 *   @since v1.4.2 añadido el método all() que retorna un array con todas las cabeceras recibidas
 *   @since v2.1.0 añadido el parámetro $default al método get()
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
     * @param ?string $default valor por defecto
     *
     * @return ?string valor recuperado o null si no existe
     */
    public static function get(
        string $name,
        ?string $default = null    
    ):?string{
        return apache_request_headers()[$name] ?? $default;
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


