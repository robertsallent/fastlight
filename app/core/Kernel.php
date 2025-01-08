<?php

/**
 * Clase de la que heredan las clases del núcleo como App o Api.
 * 
 * Última revisión: 08/01/25
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.3
 */

abstract class Kernel{
    
    /** @var Request petición realizada por el cliente */
    protected static Request $request; 
   
    
    /** Constructor del nucleo de la aplicación. */
    public function __construct(Request $request){
        Login::init();                      // inicializa el sistema de autenticación (login)      
        self::$request = $request;     // prepara y guarda el objeto Request
    }
    
    
    /** Getter de la propiedad $request. */
    public static function getRequest(){
        return self::$request;
    }
    
    
    /** Método de arranque que deben implementar obligatoriamente los núcleos App y Api. */
    public abstract function boot():Response; 
    
}

