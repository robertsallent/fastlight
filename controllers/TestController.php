<?php

/* Clase: TestController
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
 * Autor: Robert Sallent
 * Última revisión: 29/03/2023
 *
 */
    
    class TestController extends Controller{
        
        public function __call(
            string $method, 
            array $arguments = []
            
        ){
           // va a buscar el test solicitado a la carpeta test
           @require TEST_FOLDER."/".str_replace('-','/', $method).".php";
        }
        
    }
    
