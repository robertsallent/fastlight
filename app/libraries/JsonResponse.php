<?php

/** JsonResponse
 *
 * Respuestas JSON para las aplicaciones de tipo API.
 *
 * Última modificación: 03/09/2023.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.9
 */


class JsonResponse{
    
    /** @var string $status mensaje o código de estado */
    public string $status = '';
    
    /** @var ?array $data información de retorno que contiene la respuesta */
    public ?array $data = NULL;
    
    /** @var int $results número de resultados */
    public int $results = 0;
    
    /** @var string $message mensaje */
    public string $message = '';
    
    
    
    /**
     * Constructor de JsonApiResponse.
     */
    public function __construct(
        string $status,
        ?array $data = NULL,
        string $message = ''
    ){
        $this->status = $status;
        $this->data = $data;
        $this->results = $data? sizeof($data) : 0;
        $this->message = $message;          
    }
    
    
    
    /**
     * Retorna la respuesta en JSON.
     * 
     * @return string
     */
    public function __toString():string{
        header('Content-type:application/json; charset=utf-8');
        return JSON::encode($this);
    }
    
}