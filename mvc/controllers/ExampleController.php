<?php

/** ExampleController
 *
 * Controlador para mostrar los ejemplos de maquetación
 * 
 * Los ejemplos se realizan en la carpeta examples por defecto y deben tener el nombre
 * del segundo parámetro de la URL.
 * 
 * Por ejemplo:
 * la URL /example/tables mostrará el fichero en mvc/views/examples/source/tables.php
 *
 * 
 * Última revisión: 03/12/2024
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * @since v1.4.0
 */
    
class ExampleController extends Controller{
    
    /**
     * Carga el example que llega por parámetro.
     * 
     * @param string $method operación a ejecutar (nombre del fichero en la carpeta example).
     * @param array $arguments parámetros adicionales, sin uso por el momento.
     */
    public function __call(
        string $method, 
        array $arguments = []  // sin uso por el momento
    ){
        
        // si se solicita la lista de ejemplos...
        if($method == "index"){
            
            // recupera los ficheros  en la carpeta para los ejemplos
            $examples = FileList::get(EXAMPLE_FOLDER, ['html']);
            
            // carga la vista del listado de ejemplos
            view('examples/index', ["examples" => $examples]);
            return;
        }
        
        // en caso contrario se está solicitando un ejemplo concreto...        
        // carga el índice o la vista que mostrará el resultado de ejecutar el test
        view('examples/frame', [
            "example"  => $method
        ]);
    }
    
}

