<?php

/** Response
 *
 * Respuestas HTTP
 *
 * Última modificación: 06/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.13
 */


class Response{
    
    /** @var string $contentType tipo MIME del contenido */
    protected string $contentType;
    
    /** @var int $httpCode código HTTP de la respuesta */
    protected int $httpCode;
    
    /** @var string $status mensaje o código de estado */
    public string $status = '';

    /** @var string $timestamp fecha y hora de la respuesta */
    public string $timestamp;
    
    
    /**
     * Constructor de Response
     * 
     * @param string $contentType
     * @param int $httpCode
     * @param string $status
     */
    public function __construct(
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK'    
    ){    
        $this->contentType = $contentType;
        $this->httpCode    = $httpCode;  
        $this->status      = $status;
        
        $this->timestamp = date('Y-m-d H:i:s');
    }
    
     
    /**
     * prepara los encabezados y el código de la respuesta.
     */
    protected function prepare(){
        // TODO: añadir otros encabezados
        header("Content-type:$this->contentType; charset=utf-8");
        header($_SERVER['SERVER_PROTOCOL']." $this->httpCode $this->status");
    }
    
    /**
     * Setter de status
     * 
     * @param string $status mensaje de estado
     */
    public function setStatus(string $status){
        $this->status = $status;
    }
    
    
    
    /**
     * Setter de httpCode
     * 
     * @param int $httpCode el código HTTP de estado
     */
    public function setHttpCode(int $httpCode){
        $this->httpCode = $httpCode;
    }
    
    

    
    
    
    /**
     * Setter de contentType
     * 
     * @param string $contentType el tipo MIME del contenido
     */
    public function setContentType(string $contentType){
        $this->contentType = $contentType;
    }
    
        
    /**
     * genera la respuesta
     */
    public function send(){
        $this->prepare();
        echo $this;
    }
    
    
    /**
     * Genera una respuesta y carga una vista
     * 
     * @param string $name nombre de la vista a cargar
     * @param array $parameters array de parámetros para mostrar en la vista
     * @param string $contentType tipo MIME del contenido mostrado
     * @param int $httpCode código HTTP de estado
     * @param string $status mensaje HTTP de estado
     */
    public static function view(
        string $name,
        array $parameters = [],
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){
        $response = new self($contentType, $httpCode, $status);
        $response->prepare();
        view($name, $parameters);
    }
    
    
    
    /**
     * @return string
     */
    public function __toString(){
        return $this->message ?? $this->status;
    }
    
    
}