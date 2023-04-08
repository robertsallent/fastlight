<?php

/* Clase CsrfException 
 *
 * Para distinguir las excepciones de token CSRF
 *
 * autor: Robert Sallent
 * última revisión: 08/04/2023
 * desde: 0.7.3
 *
 */

    class CsrfException extends Exception{
        
        public function __construct(
            string $message = '', 
            int $code = 419, 
            Throwable $previous = NULL
        ){
            parent::__construct($message, $code, $previous);
            header("HTTP/1.1 419 Page Expired");
        }   
        
    }
    
    