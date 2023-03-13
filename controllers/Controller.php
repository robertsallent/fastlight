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
          
        public function loadView(
            string $name,           // nombre del fichero (sin extensión)
            array $parameters = []  // array asociativo de parámetros para la vista
        ){

            // crea las variables a partir de las claves del array en este ámbito
           foreach($parameters as $variable => $valor)
                $$variable = $valor;
            
            // carga la vista indicada desde el directorio de vistas
            try{
                @require VIEWS_FOLDER."/$name.php";
            }catch(Error $e){
                throw new Exception("No se encontró la vista ".VIEWS_FOLDER."/$name.php");
            }
        }
        
    }

