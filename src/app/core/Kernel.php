<?php

/**
 * Clase de la que heredan las clases del núcleo como App o Api.
 * 
 * Última revisión: 31/05/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * 
 * @since v0.9.3
 * @since v2.6.0 método runPipeline() para la ejecución de middleware
 * @since v2.11.1 se guarda una referencia a la Request.
 * @since v2.11.1 el método boot() se ha renombrado a handle()
 */

abstract class Kernel{
    
    /** @var Request instancia de la petición*/
    protected Request $request;
    
    /** Constructor del nucleo de la aplicación. */
    public function __construct(){
        // crea un objeto Request a partir de los datos de la petición del cliente
        $this->request = Request::createFromGlobals();           
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
        
    
    /** 
     * Manejador del núcleo. 
     * 
     * @return Response
     * */
    public abstract function handle():Response;    
}
