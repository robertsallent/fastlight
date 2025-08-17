<?php

/** ApiResponse
 *
 * Respuestas para las aplicaciones de tipo API.
 *
 * Última modificación: 12/01/2025.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.1.0
 * @since v1.5.0 se ha cambiado la visibilidad de las propiedades a protected. Se han eliminado algunos setters innecesarios.
 */


class ApiResponse extends Response{
    
    /** @var int $results número de resultados */
    protected int $results;
    
    /** @var string $message mensaje con información adicional */
    protected string $message;

    /** @var array $data colección de datos a enviar */
    protected array $data;
       
    /** @var string $requestMethod método HTTP con el que se relizó la petición */
    protected string $requestMethod;

    
    
    
    /**
     * Constructor de ApiResponse.
     */
    public function __construct(
        array  $data        = [],
        string $message     = '',
        string $contentType = 'text/plain',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){
        // llamada al constructor de la clase padre
        parent::__construct($contentType, $httpCode, $status);
        
        // inicialización de las propiedades no heredadas
        $this->data             = $data;
        $this->message          = $message;    
        $this->results          = $data ? sizeof($data) : 0;
        $this->requestMethod    = $_SERVER['REQUEST_METHOD'];
    }
        
    
    
    /**
     * Getter de la propiedad $data.
     * 
     * @return array
     */
    public function getData():array{
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
        $this->results++;
    }

    
    
    /**
     * Getter para la propiedad results
     * 
     * @return int
     */
    public function getResults():int{
        return $this->results;
    }
           
    
    /**
     * Getter para la propiedad $message
     * 
     * @return string
     */
    public function getMessage():string{
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
     * Getter de la propiedad $requestMethod
     * 
     * @return string
     */
    public function getRequestMethod(){
        return $this->requestMethod;
    }


    
    /** Envía la respuesta como texto llano */
    public function send(){
        $this->prepare();      // añade las cookies y las cabeceras http a la respuesta
        
        // Prepara una cadena de texto con la respuesta
        $respuesta = "STATUS: $this->status".
                     "\nTIMESTAMP: $this->timestamp".
                     "\nRESULTS: $this->results".
                     "\nMESSAGE: ".htmlspecialchars($this->message).
                     "\nDATA:\n".arrayToString($this->data, false, false, "\n");
        
        // en modo debug, añade información adicional
        if(DEBUG && $this->debug)
            $respuesta.= "\nDEBUG: ".htmlspecialchars($this->debug ?? '').".";

        echo $respuesta;
        die();
    }
    
}