<?php

/* Intarface Autenticable
 *
 * Interfaz que deben implementar los USER_PROVIDERS como la clase User.
 *
 * autor: Robert Sallent
 * última revisión: 22/03/2023
 *
 */

    interface Authenticable{
        
        // método que permite identificar un autenticable mediante dos strings
        // este método debe retornar el autenticable identificado 
        // o NULL si no se puede autenticar
        public static function authenticate(
            string $name,       // nombre de usuario (puede ser email, name, phone...)
            string $password    // clave
        ):?Authenticable; 
        
    }

