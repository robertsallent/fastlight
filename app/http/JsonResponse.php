<?php

/** JsonResponse
 *
 * Respuestas JSON para las aplicaciones de tipo API.
 *
 * Última modificación: 16/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.9
 */


class JsonResponse extends APIResponse implements JsonSerializable{
       
    
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
     * {@inheritDoc}
     * @see JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize() {
        $info = [
            'status'    => $this->status,
            'timestamp' => $this->timestamp,
            'results'   => $this->results,
            'message'   => $this->message,
            'data'      => $this->data
        ];
        
        if(DEBUG && $this->debug)
            $info['debug'] = $this->debug;
        
        return $info;
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