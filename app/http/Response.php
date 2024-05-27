<?php

/** Response
 *
 * Respuestas HTTP
 *
 * Última modificación: 24/05/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.13
 * @since c1.3.0 nuevo método abort()
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
    
    /** @var array $headers cabeceras HTTP que se deben incluir en la respuesta */
    protected array $headers;

    /** @var array $cookies cookies para añadir en la respuesta */
    protected array $cokies;
    
    /** var string $string información adicional para el modo debug */
    protected string $debug = '';
    
    //TODO: response body?
    
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

        $this->headers      = [
            "Content-type:$this->contentType; charset=".RESPONSE_CHARSET,
            $_SERVER['SERVER_PROTOCOL']." $this->httpCode $this->status"
        ];
        
        $this->cookies      = [];
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
     * Permite añadir cabeceras adicionales a la respuesta
     *
     * @param string $header el header a añadir
     */
    public function addHeader(string $header){
        $this->headers[] = $header;
    }
    
    
    
    // TODO: addCookie() que añade objetos de tipo Cookie
    
    
    
/* ============================================================================
 * PREPARACIÓN DE LAS RESPUESTAS
 * ============================================================================
 */
      
    /**
     *  Añade a la respuesta los encabezados adicionales y las cookies. 
     * 
     *  @return Response el mismo objeto Response.
     */
    protected function prepare():Response{
        // añade los encabezados
        foreach($this->headers as $header)
            header($header);
          
        // TODO: anexar las cookies    
        /*
        foreach($this->cookies as $cookie)
            set_cookie();
        */
        
        // retorna la misma respuesta para permitir chaining
        return $this;
    }
    
    
    
    /**
     * Actualiza el código HTTP y el estado de la Response en función de un error.
     * Este método es invocado por las clases App y Api.
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
    

   /* ============================================================================
    * MÉTODOS QUE CARGAN VISTAS (y finalizan la ejecución)
    * ============================================================================
    */
    
    
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
        (new View($name, $parameters))->load();
        die();
    }
    
    
    
    /**
     * Prepara una respuesta de error y trata de cargar una vista de 
     * error personalizada.
     * 
     * @param array $parameters lista de parámetros para pasar a la vista.
     */
    public function abort(
        array $parameters = []
    ){
        $this->prepare();
        View::loadHttpErrorView($this->httpCode, $parameters);
        die();
    }
    
    
    /**
     * Método estático que genera una respuesta y carga una vista en un solo paso
     *
     * @param string $contentType tipo MIME del contenido mostrado
     * @param int $httpCode código HTTP de estado
     * @param string $status mensaje HTTP de estado
     * @param string $viewName nombre de la vista a cargar
     * @param array $viewParameters array de parámetros para mostrar en la vista
     *
     */
    public static function withView(
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK',
        string $viewName    = '',
        array $viewParameters = []
        ){
            // crea la response
            (new self($contentType, $httpCode, $status))->view($viewName, $viewParameters);
    }
    
    

    
    
    // TODO: revisar este método, en principio está pensado para APIs
    /**
     * prepara y genera la respuesta
     */
    public function send(){
        $this->prepare();
        echo $this;
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
        return new JsonResponse($data, strip_tags($message), $this->httpCode, $this->status);
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
        return new XMLResponse($data, strip_tags($message), $this->httpCode, $this->status);
    }
    
    
       
    
    /**
     * @return string
     */
    public function __toString(){
        return $this->message ?? $this->status;
    }
    
    
}