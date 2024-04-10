<?php

/** XMLResponse
 *
 * Respuestas XML para las aplicaciones de tipo API.
 *
 * Última modificación: 10/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.0.4
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
    public function __toString():string{
        $respuesta = "<respuesta>\n
                        \t<status>$this->status</status>\n
                        \t<message>".htmlspecialchars($this->message)."</message>\n
                        \t<results>$this->results</results>\n
                        \t<data>".arrayToString($this->data, false, false)."</data>\n";
                        
        if(DEBUG)
            $respuesta.= "\t<more>".htmlspecialchars($this->more ?? '')."</more>\n";
         
        $respuesta .= "</respuesta>";

        return $respuesta;
    }
    
}