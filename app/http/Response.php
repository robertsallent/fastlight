<?php

/** Response
 *
 * Respuestas HTTP
 *
 * Última modificación: 15/07/2024
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.13
 * @since v1.3.0 nuevo método abort()
 */


class Response{
        
    /** @var string $version versión HTTP a usar en la respuesta */
    protected string $version;
    
    /** @var string $contentType tipo MIME del contenido */
    protected string $contentType;
    
    /** @var int $httpCode código HTTP de la respuesta */
    protected int $httpCode;
    
    /** @var string $status mensaje o código de estado */
    public string $status = '';

    /** @var string $timestamp fecha y hora de la respuesta */
    public string $timestamp;  
    
    /** var string $debug información adicional para el modo debug */
    protected string $debug = '';
    
    
    
    /** @var HttpHeaderBag $headers cabeceras HTTP que se deben incluir en la respuesta */
    protected static ?HttpHeaderBag $headers = null;
    
    /** @var HttpCookieBag $cookies cookies para añadir en la respuesta */
    protected static ?HttpCookieBag $cookies = null;
    
    

    
    
    /**
     * Constructor de Response
     * 
     * @param string $contentType tipo de contenido
     * @param int $httpCode código HTTP
     * @param string $status frase correspondiente al estado
     * @param string $content contenido en el body de la respuesta
     */
    public function __construct(
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){    
        
        // propiedades básicas
        $this->version      = HTTP_VERSION;
        $this->contentType  = $contentType;
        $this->httpCode     = $httpCode;  
        $this->status       = $status;
        
        $this->timestamp    = date('Y-m-d H:i:s');

        // añade algunas cabeceras HTTP
        self::addHeader(
            "Content-type:$this->contentType; charset=".RESPONSE_CHARSET,
            $_SERVER['SERVER_PROTOCOL']." $this->httpCode $this->status"
        );
        
        self::addHeader("Framework: FastLight <fastlight@robertsallent.com>");
        self::addHeader("Author: Robert Sallent <robert@juegayestudia.com>");
    }
    
    
    
    /* ============================================================================
     * SETTERS Y GETTERS
     * ============================================================================
     */
    
    /**
     * Getter de version
     *
     * @return string $version
     */
    public function getVersion():string{
        return $this->version;
    }
    
    
    /**
     * Setter de version
     *
     * @param string $version versión HTTP de la respuesta
     */
    public function setVersion(string $version){
        $this->version = $version;
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

    
    
    
    /* ============================================================================
     * TRABAJANDO CON COOKIES Y ENCABEZADOS
     * ============================================================================ */
    
    /**
     * Crea una nueva cookie y la almacena en la bolsa de cookies que serán adjuntadas
     * a la Response.
     *
     * @param string $name nombre de la cookie
     * @param string $value valor de la cookie
     * @param int $expires tiempo de expiración, 0 para cookie de sesión.
     * @param string $path ruta para la que se debe adjuntar la cookie
     * @param string $domain dominio
     * @param bool $secure transmitir solo por https
     * @param bool $httponly accesible solo en el lado del servidor
     *
     */
    public static function addCookie(
        string $name,
        string $value   = "",
        int $expires    = 0,
        string $path    = "",
        string $domain  = "",
        bool $secure    = false,
        bool $httpOnly  = false
    ){
        // por si no se había creado la bolsa de cookies...
        self::$cookies = self::$cookies ?? new HttpCookieBag();
        
        // crea la cookie y la añade a una bolsa de cookies que se adjuntarán a la respuesta
        self::$cookies->push(
            new HttpCookie($name, $value, $expires, $path, $domain, $secure, $httpOnly)
        );
    }
    
    
    
    /**
     * Crea un nuevo encabezado y lo adjunta a la bolsa de encabezados que serán adjuntados en la Response
     *
     * @param string $header
     * @param bool $replace
     * @param int $responseCode
     *
     */
    public static function addHeader(
        string $header,
        bool $replace     = true,
        int $responseCode = 0
    ){
        // por si no se había creado la bolsa de headers...
        self::$headers = self::$headers ?? new HttpHeaderBag();
        
        // añade el header a la bolsa de headers que se adjuntarán con la Response
        self::$headers->push(
            new HttpHeader($header, $replace, $responseCode)
        );
    }
    
     
    
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
        // añade los encabezados a la respuesta
        if(self::$headers)
            foreach(self::$headers->getItems() as $header)
                $header->send();
            
        // anexa las cookies a la respuesta   
        if(self::$cookies)
            foreach(self::$cookies->getItems() as $cookie)
                $cookie->send();
          
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

        // añade las cookies y las cabeceras http a la respuesta
        $this->prepare();
        
        // añade el template
        $template = new (TEMPLATE);
        
        // carga la vista
        (new View($name, $parameters))->load();
        
        // finaliza la ejecución
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
        
        // añade las cookies y las cabeceras http a la respuesta
        $this->prepare();
        
        // carga la vista de error, dependiendo del código HTTP 
        View::loadHttpErrorView($this->httpCode, $parameters);
        
        // finaliza la ejecución
        die();
    }
    
  
    
    /**
     * Realiza una redirección HTTP
     * 
     * @param string $url url a la que redireccionar
     * @param int $delay retardo en la redirección
     * @return Response
     */
    public function redirect(
        string $url  = '/', 
        int $delay   = 0,
        bool $die    = true
    ){
        
        // añade el header para hacer una redirección HTTP
        self::addHeader("Refresh:$delay; URL=$url");
        
        // prepara la respuesta
        $this->prepare();
        
        // evita que se ejecuten otras operaciones
        if($die) die();
    }

    
    
    /**
     * Método estático que genera una respuesta y carga una vista en un solo paso
     *
     * @param string $contentType tipo MIME del contenido mostrado
     * @param int $httpCode código HTTP de estado
     * @param string $status mensaje HTTP de estado
     * @param string $name nombre de la vista a cargar
     * @param array $parameters array de parámetros para mostrar en la vista
     *
     */
    public static function withView(
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK',
        string $name    = '',
        array $parameters = []
    ){
        // crea la response y carga la vista
        (new self($contentType, $httpCode, $status))->view($name, $parameters);
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