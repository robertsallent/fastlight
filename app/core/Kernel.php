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
     * Constructordel nucleo de la aplicación.
     * 
     * @param Request $request petición realizada a la aplicación.
     */
    public function __construct(Request $request){
        
        // guarda el objeto Request en la propiedad estática $request.
        self::$request = $request;  
        
        // inicializa el sistema de login
        Login::init();              
    }
    
    
    
    /** Getter de la propiedad $request. */
    public static function getRequest(){
        return self::$request;
    }
    
    
    
    /** Método que arranca la aplicación. */
    public abstract function boot(); 
    
}

