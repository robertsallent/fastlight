<?php

/* Intarface Autenticable
 *
 * Interfaz que deben implementar los USER_PROVIDERS como la clase User.
 *
 * autor: Robert Sallent
 * última revisión: 03/03/2023
 *
 */

    interface Autenticable{
        
        public static function identificar(string $name, string $password):?Autenticable; 
        
    }

