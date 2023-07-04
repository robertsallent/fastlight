<?php

/** ValidationException 
  *
  * Para distinguir las excepciones producidas en los procesos
  * de validación de datos.
  *
  * Última revisión: 05/04/2023.
  * 
  * @author Robert Sallent <robertsallent@gmail.com>
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

    