<?php

/**CsrfException 
 *
 * Para distinguir las excepciones de token CSRF
 *
 * Última revisión: 19/07/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.7.3
 */

class CsrfException extends Exception{
    
    public function __construct(
        string $message = 'Page Expired', 
        int $code = 419, 
        Throwable $previous = NULL
    ){
        parent::__construct($message, $code, $previous);
        header($_SERVER['SERVER_PROTOCOL']." $code $message");
    }   
    
}

