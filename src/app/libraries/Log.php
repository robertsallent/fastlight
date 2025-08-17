<?php


/**  
 *   Clase Log
 *
 *   Herramientas para registro de errores y mensajes
 *
 *   Última mofidicación: 07/02/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.7.5 control del tamaño máximo del fichero de LOG.
 */
 
class Log extends File{
    
    /** @var int tamaño máximo para el fichero de LOG */
    protected int $maxSize;
    
    
    /**
     * Constructor 
     * 
     * @param string $route ruta para el fichero de LOG
     */
    public function __construct(string $path){
        parent::__construct($path);
        
        // el tamaño máximo lo toma de la constante LOG_MAX_SIZE en el fichero config.php
        // si no existe, lo tomará como ilimitado (lo podemos cambiar con setMaxSize())
        $this->setMaxSize(defined('LOG_MAX_SIZE')? LOG_MAX_SIZE : 0);
    }
    
    
   
    /**
     * Setter de la propiedad maxSize, nos permite cambiar el tamaño máximo del fichero de LOG. 
     * 
     * @param int $maxSize tamaño máximo del fichero de LOG, 0 para ilimitado.
     */
    public function setMaxSize(int $maxSize = 0){
        if($maxSize < 0)
            throw new FileException("El tamaño del fichero de LOG no puede ser negativo.");
        
        $this->maxSize = $maxSize;
    }
    
    
    
    /**
     * Getter de la propiedad maxSize
     * 
     * @return int
     */
    public function getMaxSize():int{
        return $this->maxSize;
    }
    
    
    
    /**
     * Método que elimina la primera línea del fichero de LOG. Se usa
     * cuando el tamaño del fichero alcanza el fichero máximo.
     * 
     */
    protected function removeFirstLine(){
        // FIXME: optimizar este método
        
        // recupera las líneas en un array
        $lines = file($this->path, FILE_SKIP_EMPTY_LINES);    
        
        // saca la primera
        array_shift($lines);     
                
        // junta las líneas en un string
        $text = implode($lines);    
        
        // escribe de nuevo el fichero
        file_put_contents($this->path, $text); 
                
        // limpia el caché de files para que getSize() pueda recuperar el nuevo tamaño
        clearstatcache();
    }
    
    
    
    /**
     * Método de objeto que graba una nueva línea en el fichero de LOG.
     *
     * @param string $level nivel del error, por ejemplo NOTICE, WARNING, ERROR
     * @param string $message mensaje adjunto
     * @param bool $addDate permite indicar si queremos añadir la fecha en la línea
     * 
     * @return int el número de bytes escrito.
     */
    
    public function add(
        string $level       = 'ERROR',
        string $message     = 'se ha producido un error',
        bool $addDate       = true
    ){
        $addDate?
            $text = date("d/m/Y H:i:s")." - $level - $message":
            $text = "$level - $message";
        
        $bytes  = $this->append($text);
        
        // limpia el caché de files para que getSize() pueda recuperar el nuevo tamaño
        clearstatcache(); 
        
        // control del tamaño máximo del fichero
        if($this->maxSize && $this->getSize() > $this->maxSize){
            $this->removeFirstLine();
        }
     
        return $bytes;   
    } 
    
    
     
    /**
     * Método estático que graba una nueva línea en el fichero de LOG. 
     * 
     * @param string $route ruta al fichero de log 
     * @param string $level nivel del error, por ejemplo NOTICE, WARNING, ERROR
     * @param string $message mensaje adjunto
     * @param bool $addDate permite indicar si queremos añadir la fecha en la línea
     * 
     * @return int el número de bytes escrito.
     */
    public static function addMessage(
        string $route   = '../logs/error.log',
        string $level   = 'ERROR',
        string $message = 'se ha producido un error',
        bool $addDate   = true
    ):int{       
       return (new Log($route))->add($level, $message, $addDate);
    }   
}
