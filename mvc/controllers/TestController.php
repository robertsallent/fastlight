<?php

/** TestController
 *
 * Controlador para realizar pruebas en la aplicación.
 * 
 * Los test se realizan en la carpeta test y deben tener el nombre
 * del segundo parámetro de la URL.
 * 
 * Por ejemplo:
 * la URL /Test/usuarios  ejecutará el fichero en test/usuarios.php
 *
 * Se permite el uso de subcarpetas mediante guiones en la URL
 * 
 * Por ejemplo:
 * la URL /Test/models-libro ejecutará el fichero en test/models/libro.php
 * 
 * Última revisión: 22/06/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */
    
class TestController extends Controller{
    
    /**
     * Carga el test que llega por parámetro.
     * 
     * @param string $method operación a ejecutar (nombre del fichero en la carpeta tests).
     * @param array $arguments parámetros adicionales, sin uso por el momento.
     */
    public function __call(
        string $method, 
        array $arguments = []  // sin uso por el momento
    ){
          
       // Usa el template de test para que el resultado se vea "bonito" 
       if(BEAUTIFUL_TEST) 
           echo (TEST_TEMPLATE)::top($method);
        
       // va a buscar el test solicitado a la carpeta test
       @require TEST_FOLDER."/".str_replace('-','/', $method).".php";
       
       
       // Usa el template de test para que el resultado se vea "bonito"
       if(BEAUTIFUL_TEST){
           if($method != 'index')
               echo (TEST_TEMPLATE)::end($method);
           echo (TEST_TEMPLATE)::bottom();
       }
    }
    
}

