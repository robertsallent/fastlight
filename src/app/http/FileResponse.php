<?php

/** FileResponse
 *
 * Respuestas con ficheros
 *
 * Última modificación: 06/02/2025
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.5.0
 */

class FileResponse extends Response{
        
    /** @var File $file fichero a descargar */
    protected File $file;
    
    /** @var bool $download a true descarga el fichero, a false lo lee */
    public bool $download;
   
    /**
     * Constructor de FileResponse
     * 
     * @param string $path ruta al fichero a enviar en la respuesta
     * @param bool $download indica si hay que descargar o abrir el fichero
     * @param int $httpCode código HTTP
     * @param string $status frase correspondiente al estado
     */
    public function __construct(
        string $path,
        bool $download      = true,
        int $httpCode       = 200,
        string $status      = 'OK'
    ){    
        
        $file = new File($path);
        
        // llama al constructor de la clase padre
        parent::__construct($file->getMime(), $httpCode, $status);
        
        // propiedades no heredadas
        $this->file = $file;  
        $this->download = $download;
    }
    
    
    /**
     * Getter de file
     *
     * @return File fichero
     */
    public function getFile():File{
        return $this->file;
    }
    
    
    /**
     * Setter de file
     *
     * @param File $file nuevo fichero 
     */
    public function setFile(File $file){
        $this->file = $file;
    }
    
       
    /**
     * Prepara y envía la respuesta al cliente
     */
    public function send(){           
        $this->prepare();  // añade las cookies y las cabeceras http a la respuesta
        
        echo $this->download ? 
            $this->file->download() :   // intenta forzar la descarga
            $this->file->read();        // o muestra el fichero
        
        die();             // finaliza la ejecución
    } 
}

