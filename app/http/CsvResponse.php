<?php

/** CsvResponse
 *
 * Respuestas CSV para las aplicaciones de tipo API.
 *
 * Última modificación: 14/01/2025.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.5.1
 */


class CsvResponse extends ApiResponse{
    
    /** @var string $fieldSeparator separador de campos */
    protected string $fieldSeparator;
    
    /** @var string */
    protected string $entitySeparator;
    
    /** @var bool */
    protected bool $columnHeaders;
    
    /**
     *  Constructor de CSVResponse
     *  
     * @param array $data datos a enviar
     * @param string $fieldSeparator separador de campos
     * @param string $entitySeparator separador de entidades
     * @param bool $columnHeaders columnas con cabeceras
     * @param int $httpCode código HTTP de la respuesta
     * @param string $status mensaje de estado para la respuesta
     */
    public function __construct(
        array  $data                = [],
        string $fieldSeparator      = ",",
        string $entitySeparator     = "\n",
        bool $columnHeaders         = true, 
        int $httpCode               = 200,
        string $status              = 'OK'
    ){        
        // llamada al constructor de la clase padre
        parent::__construct($data, '', 'text/csv', $httpCode, $status);
        
        // propiedades no heredadas
        $this->fieldSeparator = $fieldSeparator;
        $this->entitySeparator = $entitySeparator;
        $this->columnHeaders = $columnHeaders;
       
    }
       
    
       
    /** envía la respuesta con el contenido en CSV */
    public function send(){
        $this->prepare();
        echo CSV::encode($this->data, $this->fieldSeparator, $this->entitySeparator, $this->columnHeaders);
        die();
    }
    
}