<?php

/* Clase: FrontController
 *
 * Controlador frontal para la aplicación
 *
 * Autor: Robert Sallent
 * Última revisión: 27/03/2022
 * 
 */
 
    class FrontController extends Controller{
        
        // método principal del controlador frontal
        public function start(){
            try{

                // inicia el trabajo con sesiones
                session_start();
                
                // detección del usuario identificado
                Login::init();
                
                // crea un objeto Request
                $request = Request::create();
                
                // TODO: separar el dispatcher a un componente aparte? implementar un router?
                // DISPATCHER (evalúa las peticiones y redirige al controlador adecuado)
                // mira la url que llega por el parámetro url y la descompone en un array
                // por ejemplo: /libro/show/3 se convierte en ['libro','show','3']
                $url = $request->get('url') ?? '';
                $url = explode('/', rtrim($url, '/'));
                

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
                            
                // crea una instancia del controlador correspondiente
                $controlador = new $c();
                $controlador->setRequest($request);
                
                // comprueba si ese controlador tiene ese método y es llamable (visible) 
                if(!is_callable([$controlador, $m]))
                    throw new Exception("La operación indicada no existe.");
                
                // tras sacar controlador y método, lo que queda en $url son los parámetros.
                // llamaremos al método del controlador pasando hasta tres parámetros
                // (podemos poner más), los que no se necesiten serán omitidos.
                switch(sizeof($url)){
                    case 0 : $controlador->$m(); break;
                    case 1 : $controlador->$m($url[0]); break;
                    case 2 : $controlador->$m($url[0], $url[1]); break;
                    case 3 : $controlador->$m($url[0], $url[1], $url[2]); break;
                }
 
            // si se produce algún error...
            }catch(Throwable $error){ 
                
                // en modo DEBUG, añade información adicional al mensaje
                $mensaje = DEBUG ?
                    Debug::errorInformation($error, $c, $m, $url):
                    $error->getMessage();
                
                // si está activado el LOG de errores:
                if(LOG_ERRORS)
                    Log::addMessage(ERROR_LOG_FILE, get_class($error), $error->getMessage());
                
                // si está activada la opción de guardar errores en BDD
                if(DB_ERRORS){
                    try{
                        AppError::create(get_class($error), $error->getMessage());
                        
                    }catch(SQLException $e){
                        $this->loadView('error', ['mensaje' => $e->getMessage()]); 
                        die();
                    }
                }
                    
                // carga la vista de error y le pasa los datos a mostrar
                $this->loadView('error', ['mensaje' => $mensaje]);    
            } 
        }  
    }
    

    