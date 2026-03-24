<?php

/** App
 *
 * Núcleo para el desarrollo de aplicaciones web en FastLight.
 *
 * Última revisión: 24/03/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v0.1.0
 * @since v0.9.1 se ha cambiado el nombre de FrontController a App.
 * @since v1.5.0 el método boot() retorna un objeto de tipo Response.
 * @since v1.5.2 el método boot() usa el helper request() para mejor tolerancia a los cambios.
 * @since v2.5.0 se aceptan URLs en kebab-case, convirtiendo a camelCase.
 */
 
class App extends Kernel{
    
    /**
     * Método principal del controlador frontal.
     * 
     * Es invocado desde el index.php y realiza las tareas de inicialización y arranque de la aplicación.
     * Actúa como un dispatcher, que enruta la petición hacia el método y controlador adecuado.
     * Además trata los errores que se puedan producir, abortando hacia las páginas 
     * de error y registrando los mensajes en LOG y BDD (según lo configurado en config.php).
     * 
     * @return Response la respuesta que será enviada al cliente.
     */
    public function boot():Response{
        try{
            
            // Evalua la URL de la petición y la convierte en un array
            // por ejemplo: /libro/show/3 se convierte en ['libro','show','3']
            $url = request()->get('url') ?? NULL;
            $url = $url ? explode('/', rtrim($url, '/')) : [];
            
            
            // Recupera el controlador a usar, es la primera posición del array.
            // Si no fue indicado, el controlador es WelcomeController (DEFAULT_CONTROLLER en config.php)
            
            // SE DEBE USAR KEBAB CASE, QUE SERA CONVERTIDO A PASCAL CASE
            // EJEMPLO: la URL /libro       => controlador LibroController
            // EJEMPLO: la URL /test-suite  => controlador TestSuiteController
            
            $controller = empty($url[0]) ? 
                DEFAULT_CONTROLLER : 
                kebabToCamel(array_shift($url),true).'Controller';
     
                
            // Recupera el método a invocar, que se corresponde con la segunda posición del array.
            // Si no se indicó, el método es index() (DEFAULT_METHOD en config.php)
            
            // SE DEBE USAR KEBAB CASE, QUE SERA CONVERTIDO A CAMEL CASE
            // EJEMPLO: para la URL /libro/create       => método create()
            // EJEMPLO: para la URL /libro/add-ejemplar => método addEjemplar()
            $method = empty($url[0]) ? 
                DEFAULT_METHOD : 
                kebabToCamel(array_shift($url));         
                
            // si el controlador calculado anteriormente no existe...
            if(!class_exists($controller))
                throw new NotFoundException("La URL indicada no existe.");
            
            // crea una instancia del controlador.
            $controllerInstance = new $controller();
            
            // comprueba si ese controlador tiene ese método y éste puede ser invocado
            if(!is_callable([$controllerInstance, $method]))
                throw new NotFoundException("La operación indicada no existe.");
            
            // Tras sacar controlador y método, lo que queda en el array $url son los parámetros.
            // Invoca el método del controlador pasándole los parámetros.
            return $controllerInstance->$method(...$url);

        
        // EVALUACIÓN DE ERROES Y EXCEPCIONES 
        // si es un problema de identificación...
        }catch(NotIdentifiedException $e){ 
            
            // recuperamos la operación para la redirección tras login, que puede ser (por orden de prioridad):
            // - la indicada en la excepción
            // - la operación que se estaba intentando hacer
            // - lo que diga el fichero de config
            // - la portada del sitio
            $redirectUrl = $e->getUrl() ?? request()->get('url') ?? REDIRECT_AFTER_LOGIN ?? '/';
            
            // guardamos en sesión la operación a la que queramos redirigir tras login
            Session::set('_pending_operation', "/{$redirectUrl}");
            
            // ... y redirigimos a login (tras el login recuperaremos la operación pendiente).
            return redirect('/Login');
      
            
        // si se produce algún otro tipo de error...
        }catch(Throwable $t){ 
            
            // lo convertimos a una excepción de FastLight (si no lo era ya)
            if(!($t instanceof FastLightException))
                $t = FastLightException::fromThrowable($t);
            
            // Prepara el mensaje de error en formato HTML.
            // En modo DEBUG, se añade información adicional al mensaje de error.
            $message = DEBUG ||  user() && user()->hasRole('ROLE_DEBUG')? 
                (new DebugInformation($t, $controller, $method, $url))->toHtml() :
                "No se pudo realizar la operación solicitada.";
            
            // retorna una respuesta de error (ViewErrorResponse)
            return abort(500, 'INTERNAL SERVER ERROR', $message, $t);
        } 
    }  
}


    