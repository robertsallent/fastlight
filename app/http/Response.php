<?php

/** Response
 *
 * Respuestas HTTP
 *
 * Última modificación: 12/01/2025
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.13
 * @since v1.5.0 eliminados los métodos toXmlResponse y toJsonResponse (ya no son necesarios).
 * 
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

    }
    
    
    
    /* ============================================================================
     * SETTERS Y GETTERS
     * ============================================================================
     */
    
    /**
     * Getter de version
     *
     * @return string versión HTTP a usar en la respuesta
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
     *  Añade a la respuesta los encabezados y las cookies. 
     * 
     *  @return Response el mismo objeto Response.
     */
    protected function prepare():Response{
              
        // PREPARACIÓN DE LOS HEADERS  
        // añade la cabecera HTTP para content-type (con charset).
        self::addHeader("Content-type:$this->contentType; charset=".RESPONSE_CHARSET);
       
        // añade la cabecera con el código de respuesta y mensaje de estado
        self::addHeader($_SERVER['SERVER_PROTOCOL']." $this->httpCode $this->status");
                
        // añade unas cabeceras adicionales con informacion del framework
        self::addHeader("Framework: FastLight <fastlight@robertsallent.com>");
        self::addHeader("Author: Robert Sallent <robert@juegayestudia.com>");
               
        // ENVÍO DE LAS CABECERAS
        if(self::$headers)
            foreach(self::$headers->getItems() as $header)
                $header->send();
           
        // ENVÍO DE LAS COOKIES
        if(self::$cookies)
            foreach(self::$cookies->getItems() as $cookie)
                $cookie->send();
                
        
        return $this; // retorna la misma respuesta (para permitir chaining).
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
    
   
    /**
     * prepara y genera la respuesta
     */
    public function send(){
        $this->prepare();
        echo $this;
        die();
    }
    
 
    /**
     * @return string
     */
    public function __toString(){
        return $this->message ?? $this->status;
    }
    
    
}