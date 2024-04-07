<?php

/** JsonResponse
 *
 * Respuestas JSON para las aplicaciones de tipo API.
 *
 * Última modificación: 06/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.9
 */


class JsonResponse extends Response{
    
    /** @var int $results número de resultados */
    public int $results;
    
    /** @var string $message mensaje con información adicional */
    public string $message;

    /** @var array $data datos a enviar */
    public array $data;
       
    /** @var string $requestMethod método HTTP con el que se relizó la petición */
    protected string $requestMethod;

    /**
     * Constructor de JsonResponse.
     */
    public function __construct(
        array  $data        = [],
        string $message     = '',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){
        
        parent::__construct('application/json', $httpCode, $status);
        
        $this->data = $data;
        $this->message = $message;    
        $this->results = $data? sizeof($data) : 0;
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }
    
    
    
    
    
    
    /**
     * @return array
     */
    public function getData(){
        return $this->data;
    }

    /**
     * @return number
     */
    public function getResults(){
        return $this->results;
    }

    /**
     * @return string
     */
    public function getMessage(){
        return $this->message;
    }

    /**
     * @return string
     */
    public function getRequestMethod(){
        return $this->requestMethod;
    }


    /**
     * Retorna la respuesta en JSON.
     * 
     * @return string
     */
    public function __toString():string{
        return JSON::encode($this);
    }
    
}