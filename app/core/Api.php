<?php

/** Api
 *
 * Núcleo para el desarrollo de APIs Restful en FastLight
 *
 * Última revisión: 17/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * @since v1.5.0 el método boot() retorna un objeto de tipo Response.
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
     * Este método es llamado desde el index.php y:
     * - Actúa como dispatcher, evaluando la URL y método HTTP e invocando al controlador y método adecuado según la petición.
     * - Comprueba que el método HTTP esté permitido según la política CORS.
     * - Controla las excepciones que se puedan producir, generando las respuestas de error en el formato adecuado.
     * - Debe retornar siempre una Response.
     * 
     * @return Response la respuesta que será enviada al cliente.
     */
    public function boot():Response{
        try{     
            
            // Evalua la URL de la petición y la convierte en un array
            // Por ejemplo: /xml/libro/3 se convierte en ['xml','libro','3']
            $this->url  = self::$request->get('url') ?? '';
            $url        = $this->url ? explode('/', rtrim($this->url, '/')) : [];
            
            // El controlador a usar será combinación de la primera y segunda 
            // posición de la URL, por ejemplo para /xml/libro sería XmlLibroController
            // si no llegan estos parámetros finalizaremos la ejecución.
            
            // si no se ha indicado el formato...
            if(empty($url[0]))
                throw new ApiException("No se indicó el formato (JSON, XML o CSV) en la URL.");
            
            // en caso contrario, toma el formato    
            $this->formato = ucfirst(strtolower(array_shift($url)));
             
            // si no se ha indicado la entidad...
            if(empty($url[0]))
                throw new ApiException("No se indicó la entidad en la URL.");
            
            $this->entidad = ucfirst(strtolower(array_shift($url)));
            
            // en caso contrario, toma la entidad
            $c =  $this->formato.$this->entidad.'Controller';
             
            // Comprueba que el controlador (XmlLibroController por ejemplo) existe.
            // En caso de que no exista, se lanza una excepción.
            if(!is_readable("../mvc/controllers/$c.php"))
                throw new NotFoundException("No existe ENDPOINT para $this->entidad en $this->formato.");
            
            // si existe, crea una instancia del controlador y le pasa la Request
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
                return new ApiResponse();
            }
            
            // para otros métodos que no sean options...
            // comprueba si el controlador tiene ese método y es llamable (visible)
            $metodo = strtolower($this->metodo); 
            
            if(!is_callable([$controlador, $metodo]))
                throw new MethodNotAllowedException("La operación $this->metodo para $this->entidad en $this->formato no existe.");
            
            // tras sacar formato y entidad, lo que queda en $url son los parámetros.
            // llamaremos al método del controlador pasando los parámetros
            return $controlador->$metodo(...$url);

            
            
        // EVALUACIÓN DE ERROES Y EXCEPCIONES
        }catch(Throwable $t){ 
            
            // prepara los datos para la response
            $code    = 500;
            $status  = 'INTERNAL SERVER ERROR';
            $message = $t->getMessage();
           
            // miramos el formato de la petición para enviar errores en formato correcto
            // si queremos permitir más formatos, los tendremos que añadir.
            switch(strtoupper($this->formato)){
                
                // JSON: generar JSONResponse y enviarla
                case 'JSON': $response = new JsonResponse([], $message , $code, $status);
                             break;
                
                // XML: generar XmlResponse y enviarla
                case 'XML':  $response = new XmlResponse([], $message, $code, $status);
                             break;
                                           
                // CSV: generar CsvResponse y enviarla
                case 'CSV':  $response = new CsvResponse([], ",", "\n", false, $code, $status);
                             break;
                                        
                // Otro formato: respuesta en text/plain             
                default:    $response = new ApiResponse([], $message, 'text/plain', $code, $status);
                            break;
            }
            
            // retorna la respuesta de error
            return $response->evaluateError($t);
        }
    }  
}


    