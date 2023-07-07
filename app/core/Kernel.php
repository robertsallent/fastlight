<?php

/**
 * Clase de la que heredan las clases del núcleo como App o Api.
 * 
 * Última revisión: 06/07/23
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.3
 */

abstract class Kernel{
    
    /** @var Request */
    protected static Request $request; 
   
    
    
    /**
     * Constructor
     * 
     * @param Request $request petición realizada a la aplicación.
     */
    public function __construct(Request $request){
        self::$request = $request;  
        Login::init();              // inicializa el sistema de login
    }
    
    
    
    /** Getter de la propiedad $request. */
    public static function getRequest(){
        return self::$request;
    }
    
    
    
    /** Método que arranca la aplicación. */
    public abstract function boot(); 
    
}

