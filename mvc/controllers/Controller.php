<?php

/** Controller
 *
 * Clase base de la que heredarán los controladores de nuestras aplicaciones.
 *
 *
 * Última revisión: 08/01/2025
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
}

