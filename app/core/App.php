<?php

/** App
 *
 * Núcleo de las aplicaciones web en FastLight.
 * Realiza las tareas de inicialización y arranque de la aplicación.
 * También actúa como un dispatcher, que enruta la petición hacia el método 
 * y controlador adecuado.
 * 
 * Además trata los errores que se puedan producir, abortando hacia las páginas 
 * de error y registrando los mensajes en LOG y BDD (según lo configurado en config.php).
 *
 * Última revisión: 08/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.1.0
 * @since v0.9.1 se ha cambiado el nombre de FrontController a App.
 * @since v1.5.0 el método boot() retorna un objeto de tipo Response.
 */
 
class App extends Kernel{
    
    /**
     * Método principal del controlador frontal.
     * 
     * @throws NotFoundException en caso de no encontrar el controlador o método asociados a 
     * la operación solicitada.
     */
    public function boot():Response{
        try{
            // DISPATCHER: evalúa las peticiones y redirige al controlador adecuado
            // mira la url que llega por el parámetro url y la descompone en un array
            // por ejemplo: /libro/show/3 se convierte en ['libro','show','3']
            $url = self::$request->get('url') ?? NULL;
            $url = $url ? explode('/', rtrim($url, '/')) : [];
            
            
            // recupera el controlador a usar (primera posición del array)
            // si no existe, el controlador es Welcome (el indicado config.php)
            // EJ: si es libro, el controlador a usar será LibroController
            $c = empty($url[0]) ? 
                DEFAULT_CONTROLLER :  
                ucfirst(strtolower(array_shift($url))).'Controller';
     
            // recupera el método (segunda posición del array)
            // si no existe, el método es index (el indicado en config.php)
            // EJ: si llega create, el método a invocar es create()
            $m = empty($url[0]) ? 
                DEFAULT_METHOD :  
                strtolower(array_shift($url));
                        
            // crea una instancia del controlador correspondiente y le pasa la Request.
            if(!class_exists($c))
                throw new NotFoundException("La URL indicada no existe.");
            
            $controlador = new $c(self::$request);
            
            // comprueba si ese controlador tiene ese método y es llamable (visible) 
            if(!is_callable([$controlador, $m]))
                throw new NotFoundException("La operación indicada no existe.");
            
            // tras sacar controlador y método, lo que queda en $url son los parámetros.
            // llamaremos al método del controlador pasando los parámetros
            return $controlador->$m(...$url);

            
        // si es un problema de usuario no identificado
        }catch(NotIdentifiedException $e){ 
            
            // recordamos la operación que estaba intentando hacer...
            Session::set('_pending_operation', '/'.self::$request->get('url'));
            
            // ... y no llevamos a error sino a login (tras el login recuperaremos la operación pendiente).
            redirect('/Login');
      
        // si se produce algún otro tipo de error...
        }catch(Throwable $t){ 
            
            // en modo DEBUG, añade información adicional al mensaje
            $mensaje = DEBUG ?
                Debug::errorInformation($t, $c, $m, $url):
                $t->getMessage();
            
            // si está activado el LOG de errores:
            if(LOG_ERRORS)
                Log::addMessage(ERROR_LOG_FILE, get_class($t), $t->getMessage());
            
            // si está activada la opción de guardar errores en BDD
            // hay que vigilar si de nuevo se produce otra excepción
            if(DB_ERRORS){
                try{
                    AppError::new(get_class($t), $t->getMessage());
                }catch(Throwable $t){
                    abort(500, 'INTERNAL SERVER ERROR', $mensaje, $t);
                }
            }
            
            // aborta la ejecución y carga la vista de error
            abort(500, 'INTERNAL SERVER ERROR', $mensaje, $t);
        } 
    }  
}


    