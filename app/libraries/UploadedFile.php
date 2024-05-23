<?php

/** UploadedFile
 *
 * Para trabajar con ficheros subidos vía POST.
 *
 * Última mofidicación: 15/05/2024.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.1
 */

class UploadedFile extends File{
    
    /** @var int $error código de error. */
    public int $error;
    
    /** @var int $size tamaño del fichero subido en bytes. */
    public int $size;
    
    /** @var string $name nombre del fichero. */
    public string $name;
    
    /** @var string $tmp ruta temporal. */
    public string $tmp;
    
    /** @var string $mime tipo real del fichero, recuperado mediente la extensión finfo. */
    public string $mime;
   
    
    
    /**
     * Constructor
     * 
     * @param string $key clave de $_FILES a recuperar.
     * @param int $maxSize tamaño máximo del fichero (0 sin límite)
     * @param array $mimes lista de tipos MIME permitidos. Lista vacía para cualquier tipo de fichero.
     * 
     * @throws UploadException en caso de que no exista la clave.
     */

    public function __construct(
        string $key  = 'file', 
        int $maxSize = UPLOAD_MAX_SIZE,  // definido en config.php
        array $mimes = []
    ){
        
        if(empty($_FILES[$key]))
            throw new UploadException("No se ha recibido un fichero con clave $key.");
                
        parent::__construct($_FILES[$key]['tmp_name']);
            
        $this->size     = intval($_FILES[$key]['size']);
        $this->name     = $_FILES[$key]['name'];
        $this->tmp      = $_FILES[$key]['tmp_name'];   
        $this->error    = $_FILES[$key]['error'];
        $this->mime     = $_FILES[$key]['error'] ? '' : parent::mime($_FILES[$key]['tmp_name']);
        
        if($this->error)
            throw new UploadException("Se ha producido un error con código $this->error");

        // comprobar que el fichero no supera el tamaño máximo
        if($maxSize && $this->size > $maxSize)
            throw new UploadException("El fichero de $this->size bytes supera el tamaño permitido de $maxSize bytes.");
        
        // comprobar que el tipo MIME está entre los permitidos
        if($mimes && !in_array($this->mime, $mimes))
            throw new UploadException("El fichero es de tipo $this->mime, que no es ninguno de los aceptados: (".arrayToString($mimes, false, false).").");
    }
        
    
    
    /**
     * Comprueba si llega un determinado fichero.
     *
     * @param string $key clave de $_FILES a comprobar.
     * @return bool true si llega o false en caso contrario.
     */
     public static function check(string $key='file'):bool{
        return !empty($_FILES[$key]) && $_FILES[$key]['error']!=4;
     }
    
    
       
    /**
     * Guarda un fichero subido en su ubicación definitiva, generando un nombre único.
     * 
     * @param string $folder carpeta de destino.
     * @param string $prefix prefijo para el nombre del fichero en el servidor, en el caso de generar nombres únicos.
     * @param bool $returnFullRoute retornar ruta completa o solo el nombre del fichero?
     * 
     * @throws FileException si se puede mover el fichero a su ubicación definitiva.
     * 
     * @return string la ruta completa del fichero en el servidor o solamente el nombre.
     */
    public function store(
        string $folder = UPLOAD_FOLDER, // definido en config.php
        string $prefix = '',
        bool $returnFullRoute = false
        
    ):string{
              
        // calcular el nombre del fichero, dependiendo de si tiene que ser único o no
        $this->newName($prefix, File::extension($this->name));
        
        // calcular la ruta final
        $this->path = $folder."/".$this->name;
        
        // MOVER EL FICHERO A DESTINO
        if(!move_uploaded_file($this->tmp, $this->path))
            throw new UploadException("Error al mover el fichero a $this->path.");
            
        return $returnFullRoute ? $this->path : $this->name;
    }   
    
    
    /**
     * Guarda un fichero subido en su ubicación definitiva, con el nombre que queramos.
     *
     * @param string $folder carpeta de destino.
     * @param string $name nombre del fichero, NULL mantiene el nombre original.
     * @param bool $returnFullRoute permite seleccionar si el método debe retornar la ruta entera o solamente el nombre del fichero.
     *
     * @throws FileException si se puede mover el fichero a su ubicación definitiva.
     *
     * @return string la ruta completa del fichero en el servidor o solamente el nombre.
     */
    public function storeAs(
        string $folder = UPLOAD_FOLDER,   // definido en config.php
        string|NULL $name = NULL,
        bool $returnFullRoute = false
        
    ):string{
        
        // calcular el nuevo nombre
        $this->name = $name ?? $this->name;
        
        // calcular la ruta final
        $this->path = $folder."/".$this->name;
        
        // MOVER EL FICHERO A DESTINO
        if(!move_uploaded_file($this->tmp, $this->path))
            throw new UploadException("Error al mover el fichero a $this->path.");
            
        return $returnFullRoute ? $this->path : $this->name;
    }   
    
    /**
     * Genera un nuevo nombre para el fichero.  
     * 
     * @param sting $prefix prefijo para el nuevo nombre.
     * @param bool $moreEntropy añade más entropía al nombre generado.
     */
    public function newName(
        string $prefix='',
        string $extension = '',
        bool $moreEntropy = true
    ){     
        // genera el nombre único con un prefijo
        $this->name = uniqid($prefix, $moreEntropy).'.'.$extension;
        $this->path = $this->getFolder().'/'.$this->name;
    }
    
}