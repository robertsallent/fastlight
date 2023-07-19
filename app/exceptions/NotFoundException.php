<?php

/** NotFoundException 
 *
 * Para distinguir las excepciones de recurso no encontrado.
 *
 * Última revisión: 19/07/2023.
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class NotFoundException extends Exception{
    
    /**
     * Constructor de la clase.
     * 
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     */
    public function __construct(
        string $message = 'Not Found', 
        int $code = 404, 
        Throwable $previous = NULL
    ){
        parent::__construct($message, $code, $previous);
        header($_SERVER['SERVER_PROTOCOL']." $code $message");
    }   
    
}
    
    