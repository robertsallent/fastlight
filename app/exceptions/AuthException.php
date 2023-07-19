<?php

/** AuthException 
 *
 * Para distinguir las excepciones relacionadas con autorización.
 *
 * Última revisión: 19/07/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class AuthException extends Exception{
    
    public function __construct(
        string $message = 'Unauthorized',
        int $code = 401, 
        Throwable $previous = NULL
    ){
        parent::__construct($message, $code, $previous);
        header($_SERVER['SERVER_PROTOCOL']." $code $message");
    }   
    
}

