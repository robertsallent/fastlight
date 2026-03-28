<?php

/**
 * Clase de la que heredan las clases del núcleo como App o Api.
 * 
 * Última revisión: 28/03/2026
 * @author Robert Sallent <robert@fastlight.org>
 * @since v0.9.3
 * @since v1.5.2 ahora el objeto Request se guarda en Request::$request y no en el Kernel.
 * @since v2.6.0 método runPipeline() para la ejecución de middleware
 */

abstract class Kernel{
    
    /** Constructor del nucleo de la aplicación. */
    public function __construct(){
        Login::init();                          // inicializa el sistema de autenticación (login)
        Request::createFromGlobals();           // crea un objeto Request a partir de los datos de la petición del cliente
    }
    
    
    /**
     * Pipeline para la ejecución de middlewares
     * 
     * @param Request $request petición que llega desde el cliente
     * @param array $middlewares lista de middlewares a ejecutar
     * @param Closure $core función final a ejecutar
     * @return Response respuesta final que será retornada para enviar al cliente
     */
    protected function runPipeline(
        Request $request, 
        array $middlewares, 
        Closure $core
    ):Response{
        return array_reduce(
            array_reverse($middlewares),
            function ($next, $middleware) {
                return function ($request) use ($next, $middleware) {
                    return (new $middleware)->handle($request, $next);
                };
            },
            $core
        )($request);
    }
        
    /** Método de arranque que deben implementar obligatoriamente los núcleos App y Api. */
    public abstract function boot():Response; 
    
}

