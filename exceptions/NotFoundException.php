<?php

/* Clase NotFoundException 
 *
 * Para distinguir las excepciones de no encontrado
 *
 * autor: Robert Sallent
 * última revisión: 13/04/2023
 *
 */

    class NotFoundException extends Exception{
        
        public function __construct(
            string $message = 'Not Found', 
            string $responseMessage = 'Not Found',
            int $code = 404, 
            Throwable $previous = NULL
        ){
            parent::__construct($message, $code, $previous);
            header("HTTP/1.1 $code $responseMessage");
        }   
        
    }
    
    