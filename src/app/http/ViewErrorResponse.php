<?php

/** ViewErrorResponse
 *
 * Respuestas de error HTTP con vistas
 *
 * Última modificación: 08/01/2025
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.5.0
 */

class ViewErrorResponse extends ViewResponse{
        
   
    /**
     * Constructor de ViewErrorResponse
     * 
     * @param Throwable $t error o excepción que produjo la aplicación
     * @param int $httpCode código HTTP
     * @param string $status frase correspondiente al estado
     * @param string $message mensaje personalizado, que susituiría al que viene con la excepción
     */
    public function __construct(
        Throwable $t        = null, 
        int $httpCode       = 500,
        string $status      = 'INTERNAL SERVER ERROR',
        string $message     = null
    ){    
        // llama al constructor de la clase padre
        parent::__construct(
            'error',   // vista de error por defecto
            ['message' => $message ?? $t->getMessage()],    
            $httpCode, 
            $status
        );
        
        // si se le pasa el error o excepción producido actualiza los códigos HTTP, 
        // el mensaje de estado y la vista en función de su tipo
        if($t){
            // modifica la Response a partir de los datos de la excepción
            $this->evaluateError($t);

            // calcula el nombre de la nueva vista de error personalizada a cargar (si es necesario)
            $name = (USE_CUSTOM_ERROR_VIEWS && View::exists("httperrors/".$this->httpCode)) ? "httperrors/".$this->httpCode : 'error';

            // cambia la vista a cargar
            $this->view->setName($name);            
        }  
    }
}

