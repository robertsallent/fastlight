<?php

/** NotFoundException 
 *
 * Para distinguir las excepciones de recurso no encontrado.
 *
 * Última revisión: 05/04/2023.
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class NotFoundException extends Exception{
    
    public function __construct(
        string $message = 'Not Found', 
        int $code = 404, 
        Throwable $previous = NULL
    ){
        parent::__construct($message, $code, $previous);
        header("HTTP/1.1 $code $message");
    }   
    
}
    
    