<?php

/* Clase: Controller
 *
 * Clase base para los controladores.
 *
 * Autor: Robert Sallent
 * Última revisión: 27/03/2023
 *
 */

    abstract class Controller{
        
        // los controladores dispondrán de un objeto Request
        protected ?Request $request = null;
        
        // SETTER para la Request
        public function setRequest(Request $request){
            $this->request = $request;
        }
        
        // GETTER para la Request
        public function getRequest(){
            return $this->request;
        }
        
        
        // método que compara el token que se le pasa con el guardado en sesión
        public function checkCsrfToken(string $token){
            
            if(!Session::has('csrf_token'))
                throw new AuthException("No se recibió el token CSRF");
                
            if($token != Session::get('csrf_token'))
                throw new CsrfException("No se pudo validar el token CSRF");
                    
        }
        
        
        // Método para cargar una vista desde un controlador
        public function loadView(
            string $name,           // nombre del fichero (sin extensión)
            array $parameters = []  // array asociativo de parámetros para la vista
        ){

            // crea las variables a partir de las claves del array en este ámbito
           foreach($parameters as $variable => $valor)
                $$variable = $valor;
            
            // carga la vista indicada desde el directorio de vistas
            try{
                require VIEWS_FOLDER."/$name.php";
                
            }catch(Throwable $e){
                $message = DEBUG ? 
                    "<p>ERROR en la vista <b>".VIEWS_FOLDER."/$name.php</b>.</p>
                     <p>INFORMACIÓN ADICIONAL: ".$e->getMessage()."</p>" :
                     "Error al cargar la página.";
                
                throw new ViewException($message);
            }
        }
        
    }

