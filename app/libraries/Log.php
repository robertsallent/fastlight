<?php


/**  
 *   Clase Log
 *
 *   Herramientas para registro de errores y mensajes
 *
 *   Última mofidicación: 06/02/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *
 */
 
class Log{
    
    /** @var File objeto File referencia al fichero para LOG */
    private File $file; 
    
    /** @var int tamaño máximo para el fichero de LOG */
    private int $maxSize;
    
    
    /**
     * Constructor 
     * 
     * @param string $route ruta para el fichero de LOG
     * @param int $maxSize tamaño máximo (0 sin límite)
     */
    public function __construct(string $path, int $maxSize = 0){
        $this->file = new File($path);
        $this->maxSize = $maxSize;
    }
    
    
    /**
     * Cambia el fichero de LOG
     * 
     * @param string $path nueva ruta
     */
    public function setPath(string $path){
        $this->file = new File($path);
    }
    
    
    /**
     * Recupera la ruta del fichero de LOG
     * 
     * @return string
     */
    public function getPath():string{
        return $this->file->getPath();
    }
    
    
    /**
     * Recupera el objeto File que referencia al fichero de LOG.
     * 
     * @return ?File el fichero o null
     */
    public function getFile():File{
        return $this->file->exists()? $this->file : NULL;
    }
    
    
    /**
     * Setter de la propiedad $maxSize
     * 
     * @param int $maxSize tamaño máximo del fichero de LOG, 0 para ilimitado.
     */
    public function setMaxSize(int $maxSize = 0){
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
        return self::addMessage($this->getPath(), $level, $message, $addDate);
    } 
    
    
    
    /**
     * Retorna el tamaño del fichero de LOG en bytes.
     * 
     * @return int el tamaño en bytes
     */
    public function size():int{
        return $this->file->exists()? $this->file->size() : 0;
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
        
        $addDate? 
            $text = date("d/m/Y H:i:s")." - $level = $message":
            $text = "$level - $message";
        
        return (new File($route))->append($text);
    }   
}
