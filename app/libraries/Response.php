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
    
    
    /** @var string $body información de retorno que contiene la respuesta */
    protected string $body;
    
    /** @var string $contentType tipo MIME del contenido */
    protected string $contentType;
    
    /** @var int $httpCode código HTTP de la respuesta */
    protected int $httpCode;
    
    /** @var string $status mensaje o código de estado */
    protected string $status = '';

    /** @var string $timestamp fecha y hora de la respuesta */
    protected string $timestamp;
    
    
    /**
     * Constructor de Response
     * 
     * @param string $body
     * @param string $contentType
     * @param int $httpCode
     * @param string $status
     */
    public function __construct(
        string $body        = '',
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK'
        
    ){    
        $this->body        = $body;
        $this->contentType = $contentType;
        $this->httpCode    = $httpCode;  
        $this->status      = $status;
        
        $this->timestamp = date('Y-m-d H:i:s');
    }
    
    
    /**
     * Coloca el encabezado "Content-type" a la respuesta.
     */
    public function setResponseHeaders(){
        // TODO: añadir otros encabezados
        header("Content-type:$this->contentType; charset=utf-8");
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
     * Setter para los datos 
     * 
     * @param string $body datos de la respuesta
     */
    public function setBody(string $body){
        $this->body = $body;
    }
    
    
    
    /**
     * genera la respuesta
     */
    public function send(){
        $this->setResponseHeaders();
        echo $this;
    }
    
    
    
    /**
     * @return string
     */
    public function __toString():string{
        return $this->body();
    }
    
}