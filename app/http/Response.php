<?php

/** Response
 *
 * Respuestas HTTP
 *
 * Última modificación: 16/04/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.13
 */


class Response{
    
    /** @var string $contentType tipo MIME del contenido */
    protected string $contentType;
    
    /** @var int $httpCode código HTTP de la respuesta */
    protected int $httpCode;
    
    /** @var string $status mensaje o código de estado */
    public string $status = '';

    /** @var string $timestamp fecha y hora de la respuesta */
    public string $timestamp;  
    
    /** var string $string información adicional para el modo debug */
    protected string $debug = '';
    
    /**
     * Constructor de Response
     * 
     * @param string $contentType tipo de contenido
     * @param int $httpCode código HTTP
     * @param string $status frase correspondiente al estado
     */
    public function __construct(
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK'    
    ){    
        $this->contentType  = $contentType;
        $this->httpCode     = $httpCode;  
        $this->status       = $status;
        $this->timestamp    = date('Y-m-d H:i:s');
    }
    
     
    /**
     * prepara los encabezados y el código de la respuesta.
     *  
     * @param array $headers lista de encabezados adicionales a añadir a la respuesta
     */
    protected function prepare(array $headers = []){
        
        header("Content-type:$this->contentType; charset=utf-8");
        header($_SERVER['SERVER_PROTOCOL']." $this->httpCode $this->status");
        
        foreach($headers as $header)
            header($header);
    }
    
    
    /**
     * Getter de status
     * 
     * @return string $status
     */
    public function getStatus():string{
        return $this->status;
    }
    
    
    /**
     * Setter de status
     * 
     * @param string $status mensaje de estado
     */
    public function setStatus(string $status){
        $this->status = $status;
    }
    
    
    /**
     * Getter de httpCode
     *
     * @return int $httpCode
     */
    public function getHttpCode():string{
        return $this->httpCode;
    }
    
      
    /**
     * Setter de httpCode
     * 
     * @param int $httpCode el código HTTP de estado
     */
    public function setHttpCode(int $httpCode){
        $this->httpCode = $httpCode;
    }
    
    
    /**
     * Getter de contentType
     *
     * @return string $contentType
     */
    public function getContentType():string{
        return $this->contentType;
    }
    
    /**
     * Setter de contentType
     * 
     * @param string $contentType el tipo MIME del contenido
     */
    public function setContentType(string $contentType){
        $this->contentType = $contentType;
    }
        
       
    /**
     * prepara y genera la respuesta
     */
    public function send(){
        $this->prepare();
        echo $this;
    }
    
    
    /**
     * Método estático que genera una respuesta y carga una vista en un solo paso
     * 
     * @param string $name nombre de la vista a cargar
     * @param array $parameters array de parámetros para mostrar en la vista
     * @param string $contentType tipo MIME del contenido mostrado
     * @param int $httpCode código HTTP de estado
     * @param string $status mensaje HTTP de estado
     * 
     * @return Response la respuesta creada
     */
    public static function withView(
        string $name,
        array $parameters = [],
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK'
        
    ):Response{
        $response = new self($contentType, $httpCode, $status);
        $response->view($name, $parameters);
        
        return $response;
    }
    
    
    
    /**
     * Carga una vista
     * 
     * @param string $name
     * @param array $parameters
     */
    public function view(
        string $name,
        array $parameters = []
    ){
        $this->prepare();
        view($name, $parameters);
    }
    
    
    /**
     * Actualiza el código HTTP y el estado en función del error
     * 
     * @param Throwable $t la excepción o error producidos
     * 
     * @return Response retorna la propia response, para permitir el chaining
     */
    public function evaluateError(Throwable $t):Response{
        
        // Prepara el código y status en función del tipo de error
        switch(get_class($t)){
            
            case 'JsonException':
            case 'ApiException':        $this->httpCode = 400;
                                        $this->status = 'BAD REQUEST';
                                        break;

            case 'LoginException':
            case 'AuthException':       $this->httpCode = 401;
                                        $this->status = 'NOT AUTHORIZED';
                                        break;
            
            case 'NotIdentifiedException':
            case 'ForbiddenException':  $this->httpCode = 403;
                                        $this->status = 'FORBIDDEN';
                                        break;
            
            case 'NothingToFindException':
            case 'NotFoundException':   $this->httpCode = 404;
                                        $this->status = 'NOT FOUND';
                                        break;
            
            case 'MethodNotAllowedException':  $this->httpCode = 405;
                                        $this->status = 'METHOD NOT ALLOWED';
                                        break;
            
            case 'CsrfException':       $this->httpCode = 419;
                                        $this->status = 'PAGE EXPIRED';
                                        break;
            
            case 'ValidationException': $this->httpCode = 422;
                                        $this->status = 'UNPROCESSABLE ENTITY';
                                        break;
            
            default:                    $this->httpCode = 500;
                                        $this->status = 'INTERNAL SERVER ERROR';
        }
        
                
        // en modo DEBUG se anexa más información
        if(DEBUG) 
            $this->debug = " En fichero ".$t->getFile()." línea ".$t->getLine();
        
        // retorna la propia respuesta, para permitir chaining
        return $this;
    }
    

    /**
     * Retorna una JsonResponse a partir de la Response actual
     * 
     * @param array $data
     * @param string $message
     * @return JsonResponse
     */
    public function toJsonResponse(
        array $data     = [], 
        string $message = ''
        
    ):JsonResponse{
        return new JsonResponse($data, $message, $this->httpCode, $this->status);
    }
    
    
    
    /**
     * Retorna una XMLResponse a partir de la Response actual
     *
     * @param array $data
     * @param string $message
     * @return XMLResponse
     */
    public function toXMLResponse(
        array $data     = [],
        string $message = ''
        
    ):XMLResponse{
        return new XMLResponse($data, $message, $this->httpCode, $this->status);
    }
    
    
    
    /**
     * @return string
     */
    public function __toString(){
        return $this->message ?? $this->status;
    }
    
    
}