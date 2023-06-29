<?php

    /*
        Clase: FileList
        Autor: Robert Sallent
        Última mofidicación: 21/06/2023

        Nos facilitará la tarea de realizar listados de directorio

    */

    class FileList{
        // propiedades
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
        // permite filtrado mediante expresión regular o array de extensiones
        public function getEntries(string|array $matches = "/.*/"):array{
            
            $all = scandir($this->directory);
            
            $filter = $matches ? $matches : "/\.$/";
            $filtered = [];
            
            // si nos pasan un array de extensiones, preparamos la expresión regular
            if(gettype($matches) == 'array'){
                
                $filter = "/\.(";
                
                foreach($matches as $extension)
                    $filter .= "$extension|";
                
                $filter = rtrim($filter, '|').')$/i';
            }
           
            // filtra las entradas del directorio aplicando la expresión regular
            foreach($all as $entry)
                if(preg_match($filter, $entry))
                    $filtered[] = "$this->directory/$entry";
           
            return $filtered;
        }

        
        
        // método estático (simplifica la tarea)
        public static function get(
            string $directorio = ".",        // directorio de trabajo
            array|string $matches = "/.*/"     // expresión regular o array de extensiones
                
        ):array{
            return (new FileList($directorio))->getEntries($matches);
        }
    }


