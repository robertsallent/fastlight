<?php

/* Clase: TestController
 *
 * Controlador para realizar pruebas en la aplicación.
 * 
 * Los test se realizan en la carpeta test y deben tener el nombre
 * del segundo parámetro de la URL.
 * 
 * Por ejemplo:
 * la URL /Test/usuarios  ejecutará el fichero test/usuarios.php
 *
 * Autor: Robert Sallent
 * Última revisión: 07/03/2023
 *
 */
    
    class TestController{
        
        public function __call(string $method, array $arguments = []){
           // va a buscar el test solicitado a la carpeta test
           require "../tests/$method.php";
        }
        
    }
    
