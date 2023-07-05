<?php

/** UploadedFile
 *
 * Para trabajar con ficheros subidos vía POST.
 *
 * Última mofidicación: 05/07/23.
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
     * 
     * @throws UploadException en caso de que no exista la clave.
     */
    public function __construct(string $key){
        
        if(empty($_FILES[$key]))
            throw new UploadException("No se ha recibido un fichero con clave $key.");
                
        parent::__construct($_FILES[$key]['name']);
            
        $this->size     = intval($_FILES[$key]['size']);
        $this->name     = $_FILES[$key]['name'];
        $this->tmp      = $_FILES[$key]['tmp_name'];   
        $this->error    = $_FILES[$key]['error'];
        $this->mime     = $_FILES[$key]['error'] ? '' : parent::mime($_FILES[$key]['tmp_name']);
    }
    

    /**
     * Comprueba errores y restrcciones sobre el fichero subido.
     * 
     * @param int $max tamaño máximo permitido en bytes, 0 para ilimitado.
     * @param string $mime tipo mime permitido, se permiten comodines, por ejemplo: image/* o application/pdf.
     *
     * @return array lista de errores producidos.
     */
    public function errors(
        int $max = 0,
        string $mime = '.'
        
    ):array{
        
        if($this->error)
            return ['upload' => "Se produjo un error $this->error al subir el fichero."];
            
        $errors = [];
                
        // comprobar que el fichero no supera el tamaño máximo
        if($max && $this->size > $max)
            $errors['size'] = "El fichero supera los $max bytes.";
            
        // comprobar el tipo MIME
        // retoques para que no falle la expresión regular en la comprobación
        $mimeTmp = str_replace('*', '', $mime); //quito el * (si lo tiene)
        $mimeTmp = preg_quote($mimeTmp, '/');      //escapo los caracteres especiales
        
        
        if(!preg_match("/^$mimeTmp/i", $this->mime))
            $errors['type'] = "El fichero no es de tipo $mime.";
        
        
        return $errors;
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
        string $folder = '', 
        string $prefix = '',
        bool $returnFullRoute = false
        
    ):string{
              
        // calcular el nombre del fichero, dependiendo de si tiene que ser único o no
        $this->newName();
        
        // calcular la ruta final
        $this->path = $folder."/".$this->name;
        
        // MOVER EL FICHERO A DESTINO
        if(!move_uploaded_file($this->tmp, $this->path))
            throw new FileException("Error al mover el fichero a $this->path.");
            
        return $returnFullRoute ? $this->path : $this->name;
    }   
    
    
    /**
     * Guarda un fichero subido en su ubicación definitiva, con el nombre que queramos.
     *
     * @param string $folder carpeta de destino.
     * @param string $name nombre del fichero, NULL mantiene el nombre original.
     *
     * @throws FileException si se puede mover el fichero a su ubicación definitiva.
     *
     * @return string la ruta completa del fichero en el servidor o solamente el nombre.
     */
    public function storeAs(
        string $folder = '',
        string|NULL $name = NULL,
        bool $returnFullRoute = false
        
    ):string{
        
        // calcular el nuevo nombre
        $this->name = $name ?? $this->name;
        
        // calcular la ruta final
        $this->path = $folder."/".$this->name;
        
        // MOVER EL FICHERO A DESTINO
        if(!move_uploaded_file($this->tmp, $this->path))
            throw new FileException("Error al mover el fichero a $this->path.");
            
        return $returnFullRoute ? $this->path : $this->name;
    }   
    
    /**
     * Genera un nuevo nombre para el fichero.  
     * 
     * @param sting $prefix prefijo para el nuevo nombre.
     * @param bool $moreEntropy añade más entropía al nombre generado.
     */
    private function newName(
        string $prefix='',
        bool $moreEntropy = true
    ){     
        // genera el nombre único con un prefijo
        $this->name = uniqid($prefix, $moreEntropy).'.'.$this->getExtension();
        $this->path = $this->getFolder().'/'.$this->name;
    }
    
}