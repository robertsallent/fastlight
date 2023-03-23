<?php 

/*
    Clase: Upload
    Autor: Robert Sallent
    Última mofidicación: 23/02/2023

    Nos facilitará la tarea de subir ficheros
    haciendo todas las comprobaciones necesarias

*/
        
    class Upload{
        
        // método para comprobar si llega un fichero
        public static function arrive(string $key='file'):bool{
            return !empty($_FILES[$key]) && $_FILES[$key]['error']!=4;
        }
        
        // método que genera nombres únicos
        public static function uniqueName(
            string $extension='',    // extensión del fichero
            string $prefix=''       // prefijo para el nombre único
                
        ):string{
            // genera el nombre único con un prefijo
            $nombre = uniqid($prefix);
            // retorna el nuevo nombre con la extensión (si se indicó)
            return $extension ? "$nombre.$extension" : $nombre;
        }
        
        // procesa la subida de un fichero y hace todas las comprobaciones
        public static function save(
            string $key = 'file',  // clave de $_FILES (nombre del input)
            string $folder = '',   // carpeta de destino
            bool $unique = true,   // generar nombre único?
            int $max = 0,          // tamaño max del fichero (0 ilimitado)
            string $mime = '.',    // tipo MIME (image/jpeg, image/*, etc)
            string $prefix = '',   // prefijo para el nombre del fichero
            bool $returnFullRoute = false  // retorna la ruta final completa o solo el nombre del fichero
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
                             self::uniqueName(pathinfo($file['name'], PATHINFO_EXTENSION), $prefix) :
                             $file['name'];
            
            // calcular la ruta final 
            $ruta = $folder."/".$nombreFichero;
                        
            // MOVER EL FICHERO A DESTINO
            if(!move_uploaded_file($rutaTmp, $ruta)) 
                throw new UploadException("Error al mover de $rutaTmp a $ruta");
            
            return $returnFullRoute ? $ruta : $nombreFichero;
        }   
    }
    
 
