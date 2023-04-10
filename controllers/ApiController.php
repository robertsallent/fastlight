<?php

/* Clase: ApiController
 *
 * Controlador frontal para el desarrollo de Apis Restful
 *
 * Autor: Robert Sallent
 * Última revisión: 10/04/2023
 * 
 */
 
    class ApiController extends Controller{
        
        // propiedades
        private string $formato = 'PLAINTEXT';  // formato de trabajo (XML, JSON...)
        private string $entidad = '';           // entidad deseada (Libro, Socio, Coche...)
        private string $url     = '';           // URL de la petición
        private string $metodo  = 'GET';        // Método de la petición
        
        
        // método principal del controlador frontal
        public function start(){
            try{     
                
                // inicia el trabajo con sesiones
                session_start();
                
                // detección del usuario identificado
                Login::init();
                
                // crea un objeto Request
                $request = Request::create();
                
                // DISPATCHER: evalúa las peticiones y redirige al controlador adecuado.
                // /xml/libro/3 se convierte en ['xml','libro','3']
                $this->url = $request->get('url') ?? '';
                $url = explode('/', rtrim($this->url, '/'));
                
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
                if(!is_readable("../controllers/$c.php"))
                    throw new ApiException("No existe ENDPOINT para $this->entidad en $this->formato.");
                
                // crea una instancia del controlador correspondiente
                $controlador = new $c();
                $controlador->setRequest($request);
                
                // analizamos el método HTTP (será el método a invocar en el controlador)
                $metodo = strtoupper($_SERVER['REQUEST_METHOD']);
                $this->metodo = $metodo;
                               
                // comprueba si ese controlador tiene ese método y es llamable (visible) 
                if(!is_callable([$controlador, $this->metodo]))
                    throw new ApiException("La operación $this->metodo para $this->entidad en $this->formato no existe.");
                
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
                
                // miramos si la petición fue XML o JSON para enviar errores en formato correcto
                // si queremos permitir más formatos, los tendremos que añadir.
                switch(strtoupper($this->formato)){
                    case 'XML':  header('Content-type:text/xml; charset=utf-8');
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
                    
                    case 'JSON': header('Content-type:application/json; charset=utf-8');
                                 $respuesta = new stdClass();
                                 $respuesta->status = "ERROR";
                                 $respuesta->message = $t->getMessage();
                                 $respuesta->data = NULL;
                                 
                                 if(DEBUG){
                                     $respuesta->message .= " En fichero ".$t->getFile()." línea ".$t->getLine();
                                     $respuesta->method = $this->metodo;
                                     $respuesta->url = '/'.$this->url;
                                 }
                                 echo JSON::encode($respuesta);
                                 break;
                    
                    default: header('Content-type:text/plain; charset=utf-8');
                                 echo "ERROR: ".$t->getMessage();
                }
            }
        }  
    }
    

    