<?php

/* Clase: FrontController
 *
 * Controlador frontal para la aplicación
 *
 * Autor: Robert Sallent
 * Última revisión: 07/02/2022
 * 
 */
 
    class FrontController{
        
        // método principal del controlador frontal
        public static function main(){
            try{
                
                // inicia el trabajo con sesiones
                session_start();
                
                // detección del usuario identificado
                Login::init();
                
                // GESTIÓN DE PETICIONES 
                // mira la url que llega por el parámetro url y la descompone en un array
                // por ejemplo: /libro/show/3 se convierte en ['libro','show','3']
                $url = $_GET['url'] ?? '';
                $url = explode('/', rtrim($url, '/'));
                

                // recupera el controlador a usar (primera posición del array)
                // si no existe, el controlador es Welcome (el indicado config.php)
                // EJ: si es libro, el controlador a usar será LibroController
                $c = empty($url[0]) ? 
                    DEFAULT_CONTROLLER :  ucfirst(strtolower(array_shift($url))).'Controller';
         
                // recupera el método (segunda posición del array)
                // si no existe, el método es index (el indicado en config.php)
                // EJ: si llega create, el método a invocar es create()
                $m = empty($url[0]) ? 
                    DEFAULT_METHOD :  strtolower(array_shift($url));
                            
                // crea una instancia del controlador correspondiente
                $controlador = new $c();
                
                // comprueba si ese controlador tiene ese método y es llamable (visible) 
                if(!is_callable([$controlador, $m]))
                    throw new Exception("La operación indicada no existe.");
                
                // tras sacar controlador y método, lo que queda en $url son los parámetros.
                // llamaremos al método del controlador pasando hasta tres parámetros
                // (podemos poner más), los que no se necesiten serán omitidos.
                $controlador->$m(
                    $url[0] ?? false, 
                    $url[1] ?? false, 
                    $url[2] ?? false
                );
            
            // si se produce algún error...
            }catch(Throwable $e){ 
                $mensaje = $e->getMessage();   // recupera el mensaje del error
                
                if(DEBUG){  // si estamos en modo DEBUG, añade información al mensaje
                    $mensaje .= "<h3>Información adicional para depuración:</h3>";
                    $mensaje .= "<p>Ruta: <b>".$_GET['url']."</b></p>";
                    $mensaje .= $c ? "<p>Controlador: <b>$c</b></p>" : '';
                    $mensaje .= $m ? "<p>Método: <b>$m()</b></p>" : '';
                    $mensaje .= $url ? "<p>Parámetros: <b>".implode(', ',$url)."</b></p>" : '';
                    
                    $mensaje .= "<p>En fichero: <b>".$e->getFile()."</b></p>";
                    $mensaje .= "<p>En la línea: <b>".$e->getLine()."</b></p>";
                }          
                require '../views/error.php';    // carga la vista de error
            } 
        }  
    }
    

    