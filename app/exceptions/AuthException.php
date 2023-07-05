<?php

/** AuthException 
 *
 * Para distinguir las excepciones relacionadas con autorización.
 *
 * Última revisión: 05/04/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class AuthException extends Exception{
    
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

