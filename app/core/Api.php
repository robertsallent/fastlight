<?php

/** Api
 *
 * Controlador frontal para el desarrollo de Apis Restful
 *
 * Última revisión: 03/09/2023
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
            $this->metodo   = strtoupper(self::$request->method());
            $metodo         = strtolower($this->metodo); 
                           
            // comprueba si ese controlador tiene ese método y es llamable (visible) 
            if(!is_callable([$controlador, $metodo]))
                throw new NotFoundException("La operación $this->metodo para $this->entidad en $this->formato no existe.");
            
            // tras sacar formato y entidad, lo que queda en $url son los parámetros.
            // llamaremos al método del controlador pasando hasta tres parámetros
            // (podemos poner más), los que no se necesiten serán omitidos.
            
            switch(sizeof($url)){
                case 0 : $controlador->$metodo(); break;
                case 1 : $controlador->$metodo($url[0]); break;
                case 2 : $controlador->$metodo($url[0], $url[1]); break;
                case 3 : $controlador->$metodo($url[0], $url[1], $url[2]); break;
            }

        // si se produce algún error...
        }catch(Throwable $t){ 
            
            // evalúa el tipo de error producido para preparar correctamente la respuesta HTTP y la vista de error personalizada.
            //FIXME: pasar esto, que está repetido en App y Api (salvo ApiException) a un método de Response
            switch(get_class($t)){
                case 'NothingToFindException':
                case 'NotFoundException':   $httpCode = 404;
                                            $status = 'Not Found';
                                            break;
                
                case 'AuthException':       $httpCode = 401;
                                            $status = 'Not Authorized';
                                            break;
                                            
                case 'ApiException':       $httpCode = 400;
                                            $status = 'Bad Request';
                                            break;
                
                case 'CsrfException':       $httpCode = 419;
                                            $status = 'Page Expired';
                                            break;
                
                case 'LoginException':      $httpCode = 401;
                                            $status = 'Not Authorized';
                                            break;
                
                case 'ValidationException': $httpCode = 422;
                                            $status = 'Unprocessable Entity';
                                            break;
                
                default:                    $httpCode = 500;
                                            $status = 'Internal Server Error';
            }
            
            // miramos si la petición fue XML o JSON para enviar errores en formato correcto
            // si queremos permitir más formatos, los tendremos que añadir.
            switch(strtoupper($this->formato)){
                
                // TODO: mejorar XMLResponse y rehacer este código (como en el caso JSON)
                // si la operación era XML
                case 'XML':  header('Content-type:text/xml; charset=utf-8');
                             http_response_code($httpCode);
                             $respuesta = "<respuesta>\n
                                            \t<status>ERROR</status>\n
                                            \t<message>".htmlspecialchars($t->getMessage())."</message>\n
                                            \t<data></data>\n";
                            
                             if(DEBUG){
                                $respuesta.= "
                                                \t<method>".htmlspecialchars($this->metodo)."</method>\n
                                                \t<url>/".htmlspecialchars($this->url)."</url>\n";
                             }
                            
                             $respuesta .= "</respuesta>";
                             echo $respuesta;
                             break;
                
                             
                             
                // si la operación era JSON , preparamos una nueva JsonResponse            
                case 'JSON': $response = new JsonResponse([], $t->getMessage(), $httpCode, $status);

                             if(DEBUG) // en modo DEBUG se anexa más información
                                 $response->more = " En fichero ".$t->getFile()." línea ".$t->getLine();
                             
                             $response->send();
                             break;
                
                             
                             
                // si la operación era con otro formato             
                default:    $response = new Response(
                                'text/plain',
                                $httpCode,
                                $status
                            );
                            
                            $response->message = $t->getMessage();
                            $response->send();
            }
        }
    }  
}


    