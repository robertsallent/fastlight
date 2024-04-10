<?php

/** Api
 *
 * Controlador frontal para el desarrollo de Apis Restful
 *
 * Última revisión: 10/04/2024
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class Api extends Kernel{
    
    /** @var string $formato formato de trabajo para la petición/respuesta (XML, JSON...) */
    private string $formato = 'PLAINTEXT';
    
    /** @var string $entidad entidad de trabajo (Libro, Socio, Coche...) */
    private string $entidad = '';
    
    /** @var string $url url de la petición */
    private string $url     = ''; 
    
    /** @var string $metodo método http usado en la petición */
    private string $metodo  = 'GET';
    
    
    /**
     * Método principal del controlador frontal para la API.
     * 
     * @throws ApiException si se produce algún error.
     * @throws NotFoundException si no existe la operación indicada
     */
    public function boot(){
        try{     
            // DISPATCHER: evalúa las peticiones y redirige al controlador adecuado.
            // /xml/libro/3 se convierte en ['xml','libro','3']
            $this->url = self::$request->get('url') ?? '';
            $url = $this->url ? explode('/', rtrim($this->url, '/')) : [];
            
            // El controlador a usar será combinación de la primera y segunda 
            // posición de la URL, por ejemplo para xml/libro sería XmlLibroController
            // si no llegan estos parámetros finalizaremos la ejecución.
            if(empty($url[0]))
                throw new ApiException("No se indicó el formato (XML o JSON) en la URL.");
            
            $this->formato = ucfirst(strtolower(array_shift($url)));
                
            if(empty($url[0]))
                throw new ApiException("No se indicó la entidad en la URL.");
            
            $this->entidad = ucfirst(strtolower(array_shift($url)));
            
            $c =  $this->formato.$this->entidad.'Controller';
             
            // comprueba que el controlador XmlLibroController (por ejemplo) existe
            if(!is_readable("../mvc/controllers/$c.php"))
                throw new ApiException("No existe ENDPOINT para $this->entidad en $this->formato.");
            
            // crea una instancia del controlador correspondiente y le pasa la Request
            $controlador = new $c(self::$request);
            
            // analiza el método HTTP (será el método a invocar en el controlador)
            $this->metodo = strtoupper(self::$request->method());
            
            // si el método no está permitido por CORS, lanzaremos una excepción
            // que retornará 405 METHOD NOT ALLOWED
            if(!self::$request->allowedByCors())
                throw new MethodNotAllowedException("Esta petición será bloqueada según la política CORS.");
            
            // si el método es OPTIONS retornamos ya las opciones disponibles
            if(strtoupper($this->metodo) == 'OPTIONS'){
                header('Allow: '.ALLOW_METHODS);
                return;
            }
            
            // para otros métodos que no sean options...
            // comprueba si el controlador tiene ese método y es llamable (visible)
            $metodo = strtolower($this->metodo); 
            
            if(!is_callable([$controlador, $metodo]))
                throw new MethodNotAllowedException("La operación $this->metodo para $this->entidad en $this->formato no existe.");
            
            // tras sacar formato y entidad, lo que queda en $url son los parámetros.
            // llamaremos al método del controlador pasando hasta tres parámetros
            // (podemos poner más), los que no se necesiten serán omitidos.
            
            switch(sizeof($url)){
                case 0 : $controlador->$metodo(); break;
                case 1 : $controlador->$metodo($url[0]); break;
                case 2 : $controlador->$metodo($url[0], $url[1]); break;
                case 3 : $controlador->$metodo($url[0], $url[1], $url[2]); break;
            }

        // si se produce algún otro error...
        }catch(Throwable $t){ 
            
            // crea una nueva respuesta de error.
            $response = new APIResponse([], '', 'text/plain', 500, 'INTERNAL SERVER ERROR');
            
            // miramos si la petición fue XML o JSON para enviar errores en formato correcto
            // si queremos permitir más formatos, los tendremos que añadir.
            switch(strtoupper($this->formato)){
                
                // XML: generar XMLResponse y enviarla
                case 'XML':  $response->toXMLResponse([], $t->getMessage())
                                      ->evaluateError($t)
                                      ->send();
                             break;
                                   
                // JSON: convertimos la respuesta a JsonResponse y la enviamos            
                case 'JSON': $response->toJsonResponse([], $t->getMessage())
                                      ->evaluateError($t)
                                      ->send();
                             break;
                        
                // Otro formato: respuesta en text/plain             
                default:    $response->setMessage($t->getMessage());
                            $response->evaluateError($t)->send();
            }
        }
    }  
}


    