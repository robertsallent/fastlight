<?php

/**
 * Clase de la que heredan las clases del núcleo como App o Api.
 * 
 * Última revisión: 20/01/25
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.3
 * @since v1.5.2 ahora el objeto Request se guarda en Request::$request y no en el Kernel.
 */

abstract class Kernel{
    
    /** Constructor del nucleo de la aplicación. */
    public function __construct(){
        Login::init();                          // inicializa el sistema de autenticación (login)
        Request::createFromGlobals();           // crea un objeto Request a partir de los datos de la petición del cliente
    }
        
    /** Método de arranque que deben implementar obligatoriamente los núcleos App y Api. */
    public abstract function boot():Response; 
    
}

