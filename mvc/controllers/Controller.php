<?php

/** Controller
 *
 * Clase base de la que heredarán los controladores de nuestras aplicaciones.
 *
 *
 * Última revisión: 27/03/2023
 * @author Robert Sallent <robertsallent@gmail.com>
 */
abstract class Controller{
    
    /** @var Request|null $request objeto Request con los datos de la petición. */
    protected ?Request $request = null;
    
    
    
    /**
     * Constructor.
     * 
     * @param Request $request petición.
     */
    public function __construct(Request $request){
        $this->request = $request;
        
        // si hay que almacenar estadísticas de visitas para las URLs
        if(SAVE_STATS)
            Stat::saveOrIncrement($request->url);   
    }
    
    
    
    /**
     * Setter para la propiedad $request
     * 
     * @param Request $request
     */
    public final function setRequest(Request $request){
        $this->request = $request;
    }
    
    
    
    /**
     * Getter para la propiedad Request
     * 
     * @return Request 
     */
    public final function getRequest():?Request{
        return $this->request;
    }
    
    
    
    /**
     * Compara el token CSRF que recibe con el guardado en sesión.
     * 
     * @param string $token token CSRF.
     */
    public function checkCsrfToken(string $token = null){
        CSRF::check($token);   
    }
    
    
    
   /**
    * Carga una vista.
    * 
    * @param string $name nombre del fichero (sin extensión).
    * @param array $parameters array de parámetros a pasarle a la vista.
    * @param string $contentType tipo MIME del contenido mostrado
    * @param int $httpCode código HTTP de estado
    * @param string $status mensaje HTTP de estado
    *
    */
    public function loadView(
        string $name,  
        array $parameters = [], 
        string $contentType = 'text/html',
        int $httpCode       = 200,
        string $status      = 'OK'
    ){
        Response::withView($contentType, $httpCode, $status, $name, $parameters);
    }
    
    
    
    /**
     * Retorna el usuario identificado
     * 
     * @return ?Authenticable usuario identificado
     */
    public function getUser():?Authenticable{
        return Login::user();
    }
    
    
}

