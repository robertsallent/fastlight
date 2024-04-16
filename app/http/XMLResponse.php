<?php

/** XMLResponse
 *
 * Respuestas XML para las aplicaciones de tipo API.
 *
 * Última modificación: 10/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.1.0
 */


class XMLResponse extends APIResponse{
       
    
    /**
     * Constructor de XMLResponse.
     */
    public function __construct(
        array  $data        = [],
        string $message     = '',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){        
        parent::__construct($data, $message, 'text/xml', $httpCode, $status);
    }
        
    
    /**
     * Convierte la respuesta a XML.
     * 
     * @return string
     */
    
    // TODO: arreglar este método para que lo haga bien a partir de XML::encode()
    public function __toString():string{
        
        $respuesta = "<?xml version='1.0' encoding='utf-8'>\n
                      <respuesta>\n
                        \t<status>$this->status</status>\n
                        \t<timestamp>$this->timestamp</timestamp>\n
                        \t<results>$this->results</results>\n
                        \t<message>".htmlspecialchars($this->message)."</message>\n
                        \t<data>".arrayToString($this->data, false, false)."</data>\n";
                        
        if(DEBUG)
            $respuesta.= "\t<debug>".htmlspecialchars($this->debug ?? '')."</debug>\n";
         
        $respuesta .= "</respuesta>";

        return $respuesta;
    }
    
}