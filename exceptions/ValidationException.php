<?php

/* Clase ValidationException 
 *
 * Para distinguir las excepciones de validación
 *
 * autor: Robert Sallent
 * última revisión: 05/04/2023
 *
 */

    class ValidationException extends Exception{
        
        public function __construct(
            string $message = 'Unprocessable entity',
            string $responseMessage = 'Unprocessable entity',
            int $code = 422,
            Throwable $previous = NULL
        ){
            parent::__construct($message, $code, $previous);
            header("HTTP/1.1 $code $responseMessage");
        }  
        
    }
    
    