<?php

/** FastLightException 
 *
 * Clase de la que heredan las excepciones propias de FastLight.
 * 
 * Es responsable de guardar los mensajes de error en base de datos y 
 * ficheros de LOG.
 *
 * Última revisión: 23/03/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.9.0
 */

class FastLightException extends Exception{
    
    /**@var string $name Tipo original de la excepción o error producidos  */
    public string $type;
    
    /**
     * Constructor 
     * 
     * Cada vez que se crea una FastLightException o una derivada, se guarda en
     * la base de datos y fichero de LOG de forma automática, siempre y cuando
     * se haya indicado en la configuración.
     * 
     * @param string $message
     * @param int $code
     * @param Throwable $previous
     * @param String $type tipo original del error producido
     * 
     */
    public function __construct(
        string $message         = "", 
        int $code               = 0, 
        ?Throwable $previous    = null,
        string $type            = null
    ){
        
        // llama al constructor de la clase padre
        parent::__construct($message, $code, $previous);
  
        // recuerda el tipo de error original que se produjo. Esto es útil cuando
        // creamos estas excepciones a partir de objeto Throwable y queremos mostrar
        // el tipo original en los detalles de depuración.
        $this->type = $type ?? get_called_class();
         
        // si está activado el LOG de errores, añade el error al fichero de LOG
        if(LOG_ERRORS) 
            $this->saveToLog();
   
        // Si está activada la opción de guardar errores en BDD, lo guarda.
        if(DB_ERRORS) 
            $this->saveToDatabase();            
    }
    
    
    
    /**
     * Crea una FastLightException a partir de un Throwable.
     * 
     * Se usa desde los núcleos App y Api. Cuando se detecta un error genérico de PHP,
     * es convertido automáticamente a una FastLightException para poder mostrarlo con 
     * detalle mediante las herramientas de depuración y guardarlo en BDD y LOG.
     * 
     * @param Throwable $t el objeto Throwable con la excepción o error original.
     * 
     * @return FastLightException la FastLightException creada a partir de ese error o excepción.
     */
    public static function fromThrowable(Throwable $t):self{
        
        // En caso de no estar en modo DEBUG
        // recorta el mensaje para evitar guardar en BDD o en LOG detalles 
        // sobre la estructura de ficheros (pueden contener IDs de usuario del hosting)
        $message = $t->getMessage();
        
        if(!DEBUG && $pos = strpos($message, ", called in"))
            $message = substr($message, 0, $pos);
        
        // crea una instancia de FstLightExcepcion a partir de los datos del Throwable
        $fe = new self($message, $t->getCode(), $t->getPrevious(), get_class($t));
                
        // toma la línea y fichero correctos, para los mensajes de depuración
        $fe->line = $t->getLine();
        $fe->file = $t->getFile();
               
        // retorna la FastLightException creada a partir del objeto Throwable
        return $fe;
    }
    
    
    
    /**
     * Guarda un error en la base de datos.
     */
    protected function saveToDatabase(){
        AppError::new($this->type, $this->message);
    }
    
    
    
    /**
     * Guarda un error en el fichero de LOG.
     */
    protected function saveToLog(){
        Log::addMessage(ERROR_LOG_FILE, $this->type, $this->message);
    }
        
}
    
    