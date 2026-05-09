<?php

/**
 *   Clase HttpHeader
 *
 *   Facilita la tarea de enviar y recuperar cabeceras HTTP.
 *
 *   Última mofidicación: 09/05/2026
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
     * @param ?int $responseCode
     */
    public function __construct(
        private string $header,
        private bool $replace      = true,
        private ?int $responseCode = null
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
    ): ?string {

        $headers = array_change_key_case(getallheaders() ?: [], CASE_LOWER);

        return $headers[strtolower($name)] ?? $default;
    }
    
    
    
    /**
     * Recupera todos los encabezados HTTP
     *
     *
     * @return array lista de todas las cabeceras HTTP
     */
    public static function all():array{
        return array_change_key_case(getallheaders() ?: [], CASE_LOWER);
    }
    
    
    /**
     * Adjunta una cabecera HTTP
     */
    public function send():void{

        if (headers_sent($file, $line)) {
            throw new HTTPException(
                "No se pueden enviar cabeceras HTTP. " .
                "La salida ya comenzó en {$file}:{$line}"
            );
        }

        if ($this->responseCode !== null)
            header($this->header, $this->replace, $this->responseCode);
        else
            header($this->header, $this->replace);
    }
}
