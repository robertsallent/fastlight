<?php

/** FileResponse
 *
 * Respuestas con ficheros
 *
 * Última modificación: 25/03/2025
 *
 * @author Robert Sallent <robert@fastlight.org>
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
     * Prepara y envía la respuesta al cliente.
     *
     * Se puede indicar que el fichero sea eliminado tras el envío, esto es útil por ejemplo
     * cuando preparamos y enviamos backups en SQL o ZIP de la base de datos y no queremos
     * que el fichero se quede en el servidor tras el envío.
     *
     * @param bool $deleteAfterSend si está a true, borra el fichero tras descargarlo.
     * @return void
     */
    public function send(bool $deleteAfterSend = false){
        $this->prepare();  // añade las cookies y las cabeceras http a la respuesta
        
        echo $this->download ?
        $this->file->download() :   // intenta forzar la descarga
        $this->file->read();        // o muestra el fichero
        
        if($deleteAfterSend)
            $this->file->delete();
            
        die();             // finaliza la ejecución
    }
}

