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
        string $method   = 'index', 
        array $arguments = []  // sin uso por el momento
    ){
        
       // solamente podrá lanzar test el administrador o un usuario con ROLE_TEST
       Auth::oneRole([ADMIN_ROLE, "ROLE_TEST"]);
        
       // carga el índice o la vista que mostrará el resultado de ejecutar el test
       view($method == "index" ? 'test/index' : 'test/frame', ["test" => $method]);
    }
    
}

