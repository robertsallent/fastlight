<?php

/* Clase LoginException 
 *
 * Para distinguir las excepciones lanzadas por la clase Login
 *
 * autor: Robert Sallent
 * última revisión: 07/03/2023
 *
 */

    class LoginException extends Exception{
        
        public function __construct(
            string $message = 'Unauthorized',
            string $responseMessage = 'Unauthorized',
            int $code = 401,
            Throwable $previous = NULL
            ){
                parent::__construct($message, $code, $previous);
                header("HTTP/1.1 $code $responseMessage");
        }   
        
    }
    
    