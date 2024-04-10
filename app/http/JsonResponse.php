<?php

/** JsonResponse
 *
 * Respuestas JSON para las aplicaciones de tipo API.
 *
 * Última modificación: 10/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.9
 */


class JsonResponse extends APIResponse{
       
    
    /**
     * Constructor de JsonResponse.
     */
    public function __construct(
        array  $data        = [],
        string $message     = '',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){        
        parent::__construct($data, $message, 'application/json', $httpCode, $status);
    }
        
    
    /**
     * Convierte la respuesta a JSON.
     * 
     * @return string
     */
    public function __toString():string{
        return JSON::encode($this);
    }
    
}