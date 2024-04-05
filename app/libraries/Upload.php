<?php 

/**
  *  Upload
  *  
  *  Nos facilitará la tarea de subir ficheros haciendo todas las comprobaciones necesarias.
  *  
  *  Esta clase ha sido marcada como obsoleta en el Framework FastLight porque desde la
  *  versión 0.9.1 usa la combinación de las clases Request y UploadedFile para realizar 
  *  las operaciones aquí presentes.
  *  
  *  Aún así se mantiene esta clase para la realización de distintos ejemplos docentes 
  *  en los cursos de PHP y desarrollo de aplicaciones web.
  *  
  *  Última mofidicación: 05/04/24
  *  
  *  @author Robert Sallent <robertsallent@gmail.com>
  *  @since v0.1.0
  *  @deprecated
  */
        

class Upload{       
    
    /**
     * Comprueba si llega un determinado fichero.
     * 
     * @param string $key clave de $_FILES a comprobar.
     * @return bool true si llega o false en caso contrario.
     */
    public static function arrive(string $key='file'):bool{
        return !empty($_FILES[$key]) && $_FILES[$key]['error']!=4;
    }
    
   
    
    /**
     * Genera nombres únicos para ficheros.
     * 
     * @param string $extension extensión a añadir al nombre calculado.
     * @param string $prefix prefijo a añadir al nombre calculado.
     * @param bool $moreEntropy más entropía?
     * 
     * @return string el nombre calculado con el prefijo y la extensión.
     */
    public static function uniqueName(
        string $extension='',
        string $prefix='',
        bool $moreEntropy = false    
    ):string{
        
        // genera el nombre único con un prefijo
        $nombre = uniqid($prefix, $moreEntropy);
        // retorna el nuevo nombre con la extensión (si se indicó)
        return $extension ? "$nombre.$extension" : $nombre;
    }
    
    
    /**
     * Procesa la subida de un fichero y hace todas las comprobaciones necesarias.
     * 
     * @param string $key clave de $_FILES (nombre del input).
     * @param string $folder carpeta de destino.
     * @param bool $unique generar nombre único?.
     * @param int $max tamaño max del fichero (0 ilimitado).
     * @param string $mime tipo MIME (image/jpeg, image/*, etc).
     * @param string $prefix prefijo para el nombre del fichero.
     * @param bool $returnFullRoute retornar la ruta final completa o solo el nombre del fichero.
     * 
     * @return string nombre final del fichero o ruta completa en la que queda ubicado.
     */
    public static function save(
        string $key = 'file', 
        string $folder = '', 
        bool $unique = true, 
        int $max = 0,
        string $mime = '.',
        string $prefix = '',
        bool $returnFullRoute = false 
    ):string{
        
        // comprobar que llega algo con la clave indicada
        if(!self::arrive($key))
            throw new UploadException("No se recibió fichero con la clave $key");
            
        $file = $_FILES[$key]; // recupera la info del fichero
        
        // comprobar que no se ha producido un error en la subida
        if($e = $file['error'])
            throw new UploadException("Error en la subida del fichero con código $e");

        // comprobar que el fichero no supera el tamaño máximo    
        if($max && $file['size']>$max)
            throw new UploadException("El fichero supera los $max bytes");
            
        $rutaTmp = $file['tmp_name']; // ruta temporal
        
        // COMPROBACION DEL TIPO DE FICHERO
        // recupera el tipo MIME
        $tipo = (new finfo(FILEINFO_MIME_TYPE))->file($rutaTmp);
        
        // retoques para que no falle la expresión regular en la comprobación 
        $mimetmp = str_replace('*','',$mime); //quito el * (si lo tiene)
        $mimetmp = preg_quote($mimetmp,'/');  //escapo los caracteres especiales
        
        // comprobación del tipo mediante regexp
        if(!preg_match("/^$mimetmp/i",$tipo)) 
            throw new UploadException("El fichero no es de tipo $mime");

        // calcular el nombre del fichero, dependiendo de si tiene que ser único o no
        $nombreFichero = $unique ? 
                         self::uniqueName(pathinfo($file['name'], PATHINFO_EXTENSION), $prefix, true) :
                         $file['name'];
        
        // calcular la ruta final 
        $ruta = $folder."/".$nombreFichero;
                    
        // MOVER EL FICHERO A DESTINO
        if(!move_uploaded_file($rutaTmp, $ruta)) 
            throw new UploadException("Error al mover de $rutaTmp a $ruta");
        
        return $returnFullRoute ? $ruta : $nombreFichero;
    }       
}


