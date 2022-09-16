<?php
    class FileList{
        public $directory; // directorio donde buscar
        
        // constructor
        public function __construct(String $directory = '.'){
            $this->directory = $directory;
        }
        
        // método que recupera la lista de entradas en el directorio
        public function getEntries(String $regexp = "/.*/"):array{
            $all = scandir($this->directory);
                   
            $filtered = [];
            foreach($all as $entry)
                if(preg_match($regexp, $entry))
                    $filtered[] = "$this->directory/$entry";
            
            return $filtered;
        }
    }


