<?php

/** App
 *
 * Controlador frontal, núcleo de las aplicaciones web en FastLight.
 * 
 * El controlador frontal realiza las tareas de inicialización y arranque de la aplicación: 
 * gestión de sesiones, del sistema de identificación...
 
 * También actúa como un dispatcher que enruta la petición hacia el método y controlador adecuado.
 * 
 * Además trata los errores que se puedan producir, redirigiendo hacia la página de error y registrando
 * los mensajes en LOG y BDD (según lo configurado en el fichero config.php).
 *
 * Última revisión: 10/04/2024
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.1.0
 * @since v0.9.1 se ha cambiado el nombre de FrontController a App.
 */
 
class App extends Kernel{
    
    /**
     * Método principal del controlador frontal.
     * 
     * @throws NotFoundException en caso de no encontrar el controlador o método asociados a 
     * la operación solicitada.
     */
    public function boot(){
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
            // llamaremos al método del controlador pasando hasta tres parámetros
            // (podemos poner más), los que no se necesiten serán omitidos.
            switch(sizeof($url)){
                case 0 : $controlador->$m(); break;
                case 1 : $controlador->$m($url[0]); break;
                case 2 : $controlador->$m($url[0], $url[1]); break;
                case 3 : $controlador->$m($url[0], $url[1], $url[2]); break;
            }

            
        // si es un problema de usuario no identificado
        }catch(NotIdentifiedException $e){ 
            
            // no llevamos al usuario a error sino a login.
            Session::set('_pending_operation', '/'.self::$request->get('url'));
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
            if(DB_ERRORS){
                try{
                    AppError::new(get_class($t), $t->getMessage());
                    
                }catch(SQLException $e){
                    view('error', ['mensaje' => $e->getMessage()]); 
                    die();
                }
            }
            
            // crea una nueva respuesta de error.
            $response = new Response('text/html', 500, 'INTERNAL SERVER ERROR');
            
            // actualizar los datos de la respuesta en función del error
            $response->evaluateError($t);
            
            // genera una respuesta con la vista de error
            // intentará cargar una vista personalizada, en caso que no exista cargará la de error genérica
            $response->view(
                !DEBUG && USE_CUSTOM_ERROR_VIEWS && viewExists("http_errors/".$response->getHttpCode()) ? "http_errors/".$response->getHttpCode() : 'error',
                ['mensaje' => $mensaje]
            );
        } 
    }  
}


    