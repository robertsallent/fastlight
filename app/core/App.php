<?php

/** App
 *
 * Núcleo para el desarrollo de aplicaciones web en FastLight.
 *
 * Última revisión: 20/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.1.0
 * @since v0.9.1 se ha cambiado el nombre de FrontController a App.
 * @since v1.5.0 el método boot() retorna un objeto de tipo Response.
 * @since v1.5.2 el método boot() usa el helper request() para mejor tolerancia a los cambios.
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
            
            
            // Recupera el controlador a usar, que se corresponde con la primera posición del array.
            // Si no fue indicado en la URL, el controlador a usar es WelcomeController (DEFAULT_CONTROLLER en config.php)
            // EJ: si la URL comenzaba por /libro, el controlador a usar será LibroController
            $controller = empty($url[0]) ? 
                DEFAULT_CONTROLLER : 
                ucfirst(strtolower(array_shift($url))).'Controller';
     
            // recupera el método a invocar, que se corresponde con la segunda posición del array.
            // Si no existe, el método a invocar es index() (DEFAULT_METHOD en config.php)
            // EJ: si llega create, el método a invocar es create()
            $method = empty($url[0]) ? 
                DEFAULT_METHOD : 
                strtolower(array_shift($url));         
                
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
            
            // recordamos la operación que estaba intentando hacer...
            Session::set('_pending_operation', '/'.request()->get('url'));
            
            // ... y redirigimos a login (tras el login recuperaremos la operación pendiente).
            return redirect('/Login');
      
        // si se produce algún otro tipo de error...
        }catch(Throwable $t){ 

            // Prepara el mensaje de error en formato HTML.
            // En modo DEBUG, se añade información adicional al mensaje de error.
            $mensaje = DEBUG ? 
                (new DebugInformation($t, $controller, $method, $url))->toHtml() :
                "No se pudo realizar la operación solicitada.";
            
            // si está activado el LOG de errores, añadimos el mensaje al fichero de LOG
            if(LOG_ERRORS)
                Log::addMessage(ERROR_LOG_FILE, get_class($t), $t->getMessage());
            
            // Si está activada la opción de guardar errores en BDD, lo guardamos.
            if(DB_ERRORS)
                AppError::new(get_class($t), $t->getMessage());
            
            // retorna una respuesta de error (ViewErrorResponse)
            return abort(500, 'INTERNAL SERVER ERROR', $mensaje, $t);
        } 
    }  
}


    