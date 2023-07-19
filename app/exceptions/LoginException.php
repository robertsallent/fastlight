<?php

/** LoginException 
 *
 * Para distinguir las excepciones lanzadas por la clase Login 
 * cuando falla la autenticación de usuario.
 *
 * Última revisión: 19/07/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class LoginException extends Exception{
    
    public function __construct(
        string $message = 'Unauthorized',
        int $code = 401,
        Throwable $previous = NULL
    ){
        parent::__construct($message, $code, $previous);
        header($_SERVER['SERVER_PROTOCOL']." $code $message");
    }   
    
}

