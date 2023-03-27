<?php

/* Clase: Controller
 *
 * Clase base para los controladores.
 *
 * Autor: Robert Sallent
 * Última revisión: 09/03/2023
 *
 */

    abstract class Controller{
          
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

