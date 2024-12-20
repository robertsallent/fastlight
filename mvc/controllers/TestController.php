<?php

/** TestController
 *
 * Controlador para realizar pruebas en la aplicación.
 * 
 * Los test se realizan en la carpeta de test y coinciden en nombre
 * con el segundo parámetro de la URL.
 * 
 * Por ejemplo:
 * la URL /test/usuarios  ejecutará el fichero en test/usuarios.php
 *
 * Se permite el uso de subcarpetas mediante guiones en la URL
 * 
 * Por ejemplo:
 * la URL /test/models-libro ejecutará el fichero en test/models/libro.php
 * 
 * Última revisión: 03/12/2024
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * @since v1.4.0 se ha eliminado el Template y el css específicos de test, ya no son necesarios
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
       Auth::oneRole(TEST_ROLES);
       
       
       // en el caso de que se solicite el índice de tests...
       if($method == "index"){
           // recupera la lista de tests
           $tests = FileList::get(TEST_FOLDER, ['php']);
           
           // carga la vista
           view('test/index', ["tests" => $tests]);
           
           return;
       }
       
       // en caso contrario se está solicitando un test concreto  
       
       // primero comprobaremos si existe y es legible
       $fileToLoad = new File(TEST_FOLDER."/".str_replace('-','/', $method).".php");
       
       if(!$fileToLoad->isReadable())
           throw new NotFoundException("No se encontró el test $method.");
           
       // y luego cargaremos la vista que mostrará el resultado de ejecutar el test
       view('test/frame', [
           "test" => $method,
           "file" => $fileToLoad
       ]);
    }    
}
