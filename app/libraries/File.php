<?php

/**
 * Clase File
 *
 * Facilita el trabajo con ficheros. Dispone de métodos 
 * para trabajar con ficheros y para comprobar tipos MIME.
 *
 * @author Robert Sallent
 * 
 */

    class File{
        
        /**
         * @var string $path ruta al fichero
         */
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
         * Setter de la propiedad $path
         * 
         * @param string $path
         */
        public function setPath(string $path){
            $this->path = $path;
        }
        
        
        
        /**
         * Recupera la extensión del fichero.
         * 
         * @return string la extensión del fichero
         */
        public function getExtension():string{
            return self::extension($this->path);
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
            return self::baseName($this->path);
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
            return self::name($this->path);
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
            return self::folder($this->path);
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
         * Muestra el contenido del fichero
         * 
         * Muestra o descarga el contenido del fichero.
         * 
         * @param string $file nombre con el que se descargará el fichero
         * @param string $contentType tipo de fichero
         * @param bool $download permite indicar si queremos forzar la descarga del fichero
         */
        public function readFile(
            string $fileName = 'file.txt',      // nombre para la descarga
            string $contentType = 'text/plain', // tipo de fichero
            bool $download = true               // descargar ?
        ){
            self::openTextFile($this->path, $fileName, $contentType, $download);
        }
        
        
        /**
         * Método estático para mostrar el contenido de ficheros.
         * 
         * Abre un fichero de texto para mostrar o descargar su contenido. 
         *
         *
         * @param string $route ruta del fichero
         * @param string $file nombre con el que se descargará el fichero
         * @param string $contentType tipo de fichero
         * @param bool $download permite indicar si queremos forzar la descarga del fichero
         * 
         * @return void
         */
        public static function openTextFile(
            string $route,                      // ubicación del fichero
            string $fileName = 'file.txt',      // nombre para la descarga
            string $contentType = 'text/plain', // tipo de fichero
            bool $download = true               // descargar ?
        ){
                
            if(!is_readable($route))
                throw new FileException("No se encontró el fichero $route.");
                
            header("Content-Type: $contentType");
            
            if($download)
                header("Content-disposition: attachment; filename=$fileName");
                
            echo file_get_contents($route);
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
                return self::remove($this->path, $exception, $warnings);
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
            
            $ok = $warnings ? unlink($path) : @unlink($path);
            
            if(!$ok && $exception)
                throw new FileException("No se pudo eliminar el fichero.");
            
            return $ok;
        }
        
        
        
        /**
         * Recupera el tipo MIME
         *
         * Recupera el tipo MIME del fichero usando la extensión finfo de PHP
         *
         * @return string
         */
        public function getMime():string{
            return self::mime($this->path);
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
            return preg_match($regexp, self::mime($this->path));
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
            return in_array(self::mime($this->path), $mimes);
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
        
    }


