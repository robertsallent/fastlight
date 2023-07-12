<?php

/** NotIdentifiedException 
 *
 * Para distinguir las excepciones de usuario no identificado. Útil para derivar
 * al usuario a la vista de login cuando intenta realizar una operación que requiere estar
 * identificado.
 *
 * Última revisión: 05/04/2023.
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class NotIdentifiedException extends Exception{
    
    public function __construct(
        string $message = 'Unauthorized',
        int $code = 401, 
        Throwable $previous = NULL
    ){
        parent::__construct($message, $code, $previous);
        header("HTTP/1.1 $code $message");
    }   
    
}
    
    