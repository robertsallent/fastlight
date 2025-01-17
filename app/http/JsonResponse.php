<?php

/** JsonResponse
 *
 * Respuestas JSON para las aplicaciones de tipo API.
 *
 * Última modificación: 12/01/2025.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.9
 */


class JsonResponse extends ApiResponse implements JsonSerializable{
       
    
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
    
    
    /** Envía la respuesta JSON */
    public function send(){
        $this->prepare();
        echo JSON::encode($this, true, true); // por motivos docentes, las respuestas se codifican "bonitas"
        die();
    }
    
}