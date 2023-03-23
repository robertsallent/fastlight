<?php

    /*
        Clase: FileList
        Autor: Robert Sallent
        Última mofidicación: 24/02/2023

        Nos facilitará la tarea de realizar listados de directorio

    */

    class FileList{
        private $directory; // directorio donde buscar
        
        // constructor
        // recibe la ruta al directorio de trabajo, por defecto el actual
        public function __construct(string $directory = '.'){
            $this->directory = $directory;
        }
        
        // setters y getters
        public function setDirectory(string $directory){
            $this->directory = $directory;
        }
        
        public function getDirectory(){
            return $this->directory;
        }
        
        
        
        // método que recupera la lista de entradas en el directorio
        // permite filtrado mediante expresión regular
        public function getEntries(string $regexp = "/.*/"):array{
            $all = scandir($this->directory);
                   
            $filtered = [];
            foreach($all as $entry)
                if(preg_match($regexp, $entry))
                    $filtered[] = "$this->directory/$entry";
            
            return $filtered;
        }

        
        
        // método estático (simplifica la tarea)
        public static function get(
            string $directorio = ".",   // directorio de trabajo
            string $regexp = "/.*/"     // expresión regular
                
        ):array{
            return (new FileList($directorio))->getEntries($regexp);
        }
    }


