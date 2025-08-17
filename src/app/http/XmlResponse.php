<?php

/** XmlLResponse
 *
 * Respuestas XML para las aplicaciones de tipo API.
 *
 * Última modificación: 12/01/2025.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.1.0
 */


class XmlResponse extends ApiResponse{
       
    
    /**
     * Constructor de XmlResponse.
     */
    public function __construct(
        array  $data        = [],
        string $message     = '',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){        
        parent::__construct($data, $message, 'text/xml', $httpCode, $status);
    }
        
    
    /** Envía la respuesta XML */
    
    // TODO: arreglar este método para que lo haga bien a partir de XML::encode()
    public function send(){
        $this->prepare();
        
        $respuesta = "<?xml version='1.0' encoding='utf-8'?>\n
                      <respuesta>\n
                        \t<status>$this->status</status>\n
                        \t<timestamp>$this->timestamp</timestamp>\n
                        \t<results>$this->results</results>\n
                        \t<message>".htmlspecialchars($this->message)."</message>\n
                        \t<data>".arrayToString($this->data, false, false, "; ")."</data>\n";
                        
        if(DEBUG)
            $respuesta.= "\t<debug>".htmlspecialchars($this->debug ?? '')."</debug>\n";
         
        $respuesta .= "</respuesta>";

        echo $respuesta;
        die();
    }
    
}