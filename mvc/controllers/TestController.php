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
 * Última revisión: 10/06/2024
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
        
       // solamente podrá lanzar test el administrador o un usuario con ROLE_TEST
       Auth::oneRole([ADMIN_ROLE, "ROLE_TEST"]);
        
       // Usa el template de test para que el resultado se vea "bonito"
       if(BEAUTIFUL_TEST){
            $template = new (TEST_TEMPLATE);
            echo $template->top($method);
       }
       
       // va a buscar el test solicitado a la carpeta test
       @require TEST_FOLDER."/".str_replace('-','/', $method).".php";
       
       // Usa el template de test para que el resultado se vea "bonito"
       if(BEAUTIFUL_TEST){
           echo $method != 'index' ? $template->end($method) : $template->bottom();
       }
    }
    
}

