<?php

/** APIResponse
 *
 * Respuestas para las aplicaciones de tipo API.
 *
 * Última modificación: 10/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.1.0
 */


class APIResponse extends Response{
    
    /** @var int $results número de resultados */
    public int $results;
    
    /** @var string $message mensaje con información adicional */
    public string $message;

    /** @var array $data datos a enviar */
    public array $data;
       
    /** @var string $requestMethod método HTTP con el que se relizó la petición */
    protected string $requestMethod;

    
    
    
    /**
     * Constructor de APIResponse.
     */
    public function __construct(
        array  $data        = [],
        string $message     = '',
        string $contentType = 'text/plain',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){
        
        parent::__construct($contentType, $httpCode, $status);
        
        $this->data = $data;
        $this->message = $message;    
        $this->results = $data? sizeof($data) : 0;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }
        
    
    
    /**
     * Getter de la propiedad $data.
     * 
     * @return array
     */
    public function getData(){
        return $this->data;
    }
    
    
    
    /**
     * Setter de la propiedad $data
     * 
     * @param array $data
     */
    public function setData(array $data = []){
        $this->data = $data;
    }
    
    
    
    /**
     * Añade un elemento al final del array $data
     * 
     * @param mixed $value
     */
    public function addData(mixed $value){
        array_push($this->data, $value);
    }

    
    
    /**
     * Getter para la propiedad results
     * 
     * @return number
     */
    public function getResults(){
        return $this->results;
    }

    
    
    /**
     * Getter para la propiedad $message
     * 
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }
    
    
    
    /**
     * Setter para la propiedad $message
     * 
     * @param string $message
     */
    public function setMessage(string $message){
        $this->message = $message;
    }
    
    
    
    /**
     * Añade texto al final de $message
     * 
     * @param string $message
     */
    public function addMessage(string $message){
        $this->message = $this->message.'. '.$message;
    }
    
    
    
    /**
     * Setter para la propiedad $results
     * 
     * @param int $results
     */
    public function setResults(int $results){
        $this->results = $results;
    }
    
    
    
    /** Incrementa el número de resultados en uno */
    public function increaseResults(){
        $this->results++;
    }
    
    

    /**
     * Getter de la propiedad $requestMethod
     * 
     * @return string
     */
    public function getRequestMethod(){
        return $this->requestMethod;
    }


    
    /**
     * Convierte la respuesta a JSON.
     * 
     * @return string
     */
    public function __toString():string{
        $respuesta = "STATUS: $this->status".
                     "\nTIMESTAMP: $this->timestamp".
                     "\nRESULTS: $this->results".
                     "\nMESSAGE: ".htmlspecialchars($this->message).
                     "\nDATA: ".arrayToString($this->data, false, false);
        
        if(DEBUG && $this->debug)
            $respuesta.= "\nDEBUG: ".htmlspecialchars($this->debug ?? '').".";

        return $respuesta;
    }
    
}