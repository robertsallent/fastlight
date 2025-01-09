<?php

/**
 * Clase File
 *
 * Facilita el trabajo con ficheros. Dispone de métodos interesantes
 * para trabajar con ficheros y para comprobar tipos MIME.
 *
 * Última mofidicación: 09/01/2025.
 * 
 * @author Robert Sallent
 * @since v1.1.4 añadidos métodos para copiar y mover ficheros.
 * @since v1.3.7 añadido el método getSize() y su alias size().
 * 
 */

    class File{
        
        /** @var string $path ruta al fichero */
        protected string $path;
        
        
        /**
         * Constructor de File
         * 
         * @param string $path ruta donde se encuentra el fichero
         */
        public function __construct(string $path){
            $this->path = $path;
        }
        
        
        /**
         * Getter de la propiedad $path
         * 
         * @return string
         */
        public function getPath():string{
            return $this->path;
        }     
        
        
        
        /**
         * Comprueba si el fichero existe.
         * 
         * @return bool true si existe o false en caso contrario.
         */
        public function exists():bool{
            return file_exists($this->path);
        }
        
        
        
        /**
         * Comprueba si el fichero es legible.
         * 
         * @return bool true si es legible o false en caso contrario
         */
        public function isReadable():bool{
            return is_readable($this->path);
        }
        
        
        /**
         * Recupera la extensión del fichero.
         * 
         * @return string la extensión del fichero
         */
        public function getExtension():string{
            return pathinfo($this->path, PATHINFO_EXTENSION);
        }
        
        
        /**
         * Recupera el tamaño del fichero en bytes.
         *
         * @return int|false el número de bytes que ocupa el fichero
         */
        public function getSize():string{
            return filesize($this->path);
        }
        
        
        /**
         * alias de getSize()
         *
         * @return int|false el número de bytes que ocupa el fichero
         */
        public function size():string{
            return $this->getSize();
        }
        
        
        /**
         * Método estático para recuperar la extensión de un fichero
         * a partir de una ruta.
         * 
         * @param string $path ruta al fichero.
         * 
         * @return string extensión del fichero.
         */
        public static function extension(string $path = ''):string{
            return pathinfo($path, PATHINFO_EXTENSION);
        }
        
        
        /**
         * Recupera el nombre base del fichero.
         *
         * @return string el nombre base del fichero
         */
        public function getBaseName():string{
            return pathinfo($this->path, PATHINFO_BASENAME);
        }
        
        
        /**
         * Método estático para recuperar el nombre base de un fichero
         * a partir de una ruta.
         *
         * @param string $path ruta al fichero.
         *
         * @return string nombre base del fichero.
         */
        public static function baseName(string $path = ''):string{
            return pathinfo($path, PATHINFO_BASENAME);
        }
        
        
        /**
         * Recupera el nombre del fichero.
         *
         * @return string el nombre del fichero
         */
        public function getName():string{
            return pathinfo($this->path, PATHINFO_FILENAME);
        }
        
        
        /**
         * Método estático para recuperar el nombre de un fichero
         * a partir de una ruta.
         *
         * @param string $path ruta al fichero.
         *
         * @return string nombre del fichero.
         */
        public static function name(string $path = ''):string{
            return pathinfo($path, PATHINFO_FILENAME);
        }
        
        
        /**
         * Recupera el directorio del fichero.
         *
         * @return string el nombre del fichero
         */
        public function getFolder():string{
            return pathinfo($this->path, PATHINFO_DIRNAME);
        }
        
        
        /**
         * Método estático para recuperar el directorio de un fichero
         * a partir de una ruta.
         *
         * @param string $path ruta al fichero.
         *
         * @return string directorio del fichero.
         */
        public static function folder(string $path = ''):string{
            return pathinfo($path, PATHINFO_DIRNAME);
        }
        
        
        
        /**
         * Muestra el contenido de un fichero (o lo descarga)
         * 
         * @throws FileException si no encuentra el fichero
         */
        public function read(){
            
            // comprueba si el fichero existe
            if(!$this->exists())
               throw new FileException("No se encontró el fichero $this->path.");
                
            // imprime el contenido del fichero
            echo file_get_contents($this->path);    
        }
        
        
        /**
         * Fuerza la descarga de un fichero
         * 
         * @param ?string $fileName nombre con el que se descargará el fichero. NULL para el nombre original del fichero.
         * @throws FileException si no encuentra el fichero
         */ 
        public function download(?string $fileName    = NULL){
            
            // comprueba si el fichero existe
            if(!$this->exists())
                throw new FileException("No se encontró el fichero $this->path.");
            
            // calcula el nombre del fichero a descargar
            $fileName = $fileName ?? $this->getBaseName();
            
            // añade una cabecera para intentar forzar la descarga
            header("Content-disposition: attachment; filename=$fileName"); 
            
            // imprime el contenido del fichero
            echo file_get_contents($this->path); 
        }
        
  
        /**
         * Copia un fichero
         * 
         * @param string $path ruta de destino
         * @param bool $exception se deben lanzar excepciones?
         * @param bool $warnings se deben mostrar los warnings?
         * 
         * @return File un objeto File que referencia al nuevo fichero creado (la copia)
         */
        public function copy(
            string $path, 
            bool $exception = false,
            bool $warnings = false
        ):File{
            $done = $warnings ? copy($this->path, $path) : @copy($this->path, $path);
       
            if(!$done && $exception)
                throw new FileException("No se pudo copiar el fichero $this->path en $path");
            
            return new File($path);
        }
        
        
        
        /**
         * Mueve un fichero
         *
         * @param string $path ruta de destino
         * @param bool $exception se deben lanzar excepciones?
         * @param bool $warnings se deben mostrar los warnings?
         *
         * @return bool si lo ha conseguido o no
         */
        public function move(
            string $path,
            bool $exception = false,
            bool $warnings = false
        ):bool{
            $done = $warnings ? rename($this->path, $path) : @rename($this->path, $path);
                
            if(!$done && $exception)
                throw new FileException("No se pudo mover el fichero $this->path a $path");
              
            // al mover el fichero hay que actualizar el path    
            $this->path = $path;
            
            return $done;
        }
        
        
        
        /**
         * Elimina un fichero
         * 
         * Método de objeto para eliminar el fichero actual
         * 
         * @param bool $exception permite indicar si queremos lanzar excepciones en caso de error
         * @param bool $warnings permite indicar si queremos mostrar advertencias en caso de que las hubiera
         * 
         * @return bool
         */
        public function delete(
            bool $exception = false,    // lanzar excepción si no puede borrar?
            bool $warnings = false      // mostrar warnings?
        ):bool{
            $done = $warnings ? unlink($this->path) : @unlink($this->path);
            
            if(!$done && $exception)
                throw new FileException("No se pudo eliminar el fichero.");
                
            return $done;
        }
        
        /**
         * Elimina un fichero
         * 
         * Método estático que elimina un fichero del sistema de ficheros del servidor.
         * 
         * @param string $path ruta donde se encuentra el fichero a eliminar
         * @param bool $exception permite indicar si queremos lanzar excepciones en caso de error
         * @param bool $warnings permite indicar si queremos mostrar advertencias en caso de que las hubiera
         * 
         * @throws FileException si no se puede eliminar el fichero
         * 
         * @return bool
         */
        public static function remove(
            string $path,              // ubicación del fichero
            bool $exception = false,    // lanzar excepción si no puede borrar?
            bool $warnings = false      // mostrar warnings?
        ):bool{
            
            $done = $warnings ? unlink($path) : @unlink($path);
            
            if(!$done && $exception)
                throw new FileException("No se pudo eliminar el fichero.");
            
            return $done;
        }
        
        
        
        /**
         * Recupera el tipo MIME
         *
         * Recupera el tipo MIME del fichero usando la extensión finfo de PHP
         *
         * @return string
         */
        public function getMime():string{
            return (new finfo(FILEINFO_MIME_TYPE))->file($this->path);
        }
        
        /**
         * Recupera el tipo MIME
         * 
         * Este método estático recupera el tipo MIME de un fichero, usando la 
         * extensión finfo de PHP.
         * 
         * @param string $path ruta donde se encuentra ubicado el fichero
         * 
         * @return string tipo MIME detectado
         */
        public static function mime(string $path){
            return (new finfo(FILEINFO_MIME_TYPE))->file($path);
        }
        
        
        /**
         * Comprueba el tipo MIME
         *
         * Este método sirve para comprobar si el tipo MIME del fichero
         * coincide con el que le indiquemos por parámetro.
         *
         * @param string $mime tipo mime deseado
         *
         * @return bool true si el fichero es del tipo indicado, false en caso contrario
         */
        public function is(string $mime):bool{
            return self::mime($this->path) == $mime;
        }
        
        /**
         * Comprueba el tipo MIME
         * 
         * Este método estático sirve para comprobar si el tipo MIME del fichero
         * coincide con el que le indiquemos por parámetro.
         * 
         * @param string $path ruta en la que se encuentra el fichero
         * @param string $mime tipo mime deseado
         * 
         * @return bool true si el fichero es del tipo indicado, false en caso contrario
         */
        public static function isMime(string $path, string $mime):bool{
           return self::mime($path) == $mime;
        }
        
        
        
        /**
         * Comprueba el tipo MIME mediante expresión regular
         *
         * Este método comprueba si un fichero es de un tipo MIME que coincida
         * con la expresión regular indicada por parámetro.
         *
         * @param string $regexp expresión regular que usaremos para hacer match
         *
         * @return bool true si el tipo de fichero valida la expresión regular, false en caso contrario
         */
        public function checkMime(string $regexp):bool{
            return preg_match($regexp, $this->getMime());
        }
        
        /**
         * Comprueba el tipo MIME mediante expresión regular
         * 
         * Este método estático comprueba si un fichero es de un tipo MIME que coincida
         * con la expresión regular indicada por parámetro.
         * 
         * @param string $path ruta en la que se encuentra el fichero
         * @param string $regexp expresión regular que usaremos para hacer match
         * 
         * @return bool true si el tipo de fichero valida la expresión regular, false en caso contrario
         */
        public static function mimeCheck(string $path, string $regexp):bool{
            return preg_match($regexp, self::mime($path));
        }
        
        
        /**
         * Comprueba el tipo MIME y lo busca en un listado
         *
         * Comprueba si el tipo MIME de un fichero está en un array de tipos 
         * indicados por parámetro
         *
         * @param array $mimes lista de tipos MIME a comprobar
         * @return bool true si encuentra el tipo MIME del fichero en la lista, 
         * false en caso contrario
         */
        public function has(array $mimes):bool{
            return in_array($this->getMime(), $mimes);
        }
        
        /**
         * Comprueba el tipo MIME y lo busca en un listado
         * 
         * Este método estático comprueba si el tipo MIME de un fichero 
         * está en un array de tipos indicados por parámetro
         * 
         * @param string $path ruta en la que se encuentra el fichero
         * @param array $mimes lista de tipos MIME a comprobar
         * @return bool true si encuentra el tipo MIME del fichero en la lista, false en caso contrario
         */
        public static function hasMime(string $path, array $mimes):bool{
            return in_array(self::mime($path), $mimes);
        }
        
        
        
        /**
         * Método __toString()
         * 
         * @return string
         */
        public function __toString():string{
            return $this->path;
        }
        
    }


