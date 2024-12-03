<?php
/**
 * Clase FileList
 *
 * Permite hacer listados de directorio y búsqueda de ficheros por extensión
 * o por nombre de forma muy simple.
 *
 * Última mofidicación: 02/12/2023.
 *
 * @author Robert Sallent
 *
 */
   
    class FileList{
        /** @var string $directory directorio de búsqueda */
        private $directory; 
        
        
        
        /**
         * Constructor 
         * 
         * @param string $directory directorio de trabajo, por defecto el directorio actual
         */
        public function __construct(string $directory = '.'){
            $this->directory = $directory;
        }
        
        
        
        /**
         * Setter para la propiedad directory
         * 
         * @param string $directory directorio al que queremos cambiar
         */
        public function setDirectory(string $directory){
            $this->directory = $directory;
        }
        
        
        /**
         * Getter para la propiedad directory
         * 
         * @return string directorio de trabajo actual
         */
        public function getDirectory():string{
            return $this->directory;
        }
        
        
        
        /**
         * Recupera la lista de entradas en el directorio de trabajo 
         * Para filtrar, puede recibir una expresión regular o un listado de extensiones
         * 
         * @param string|array $matches expresión regular o lista de extensiones
         * @param bool $specialEntries permite indicar si queremos que aparezcan el . y el ..
         * 
         * @return array listado de entradas de directorio coincidentes con los filtros aplicados, ordenadas alfabéticamente
         */
        public function getEntries(
            string|array|NULL $matches   = "/.*/",
            bool $specialEntries         = false
        ):array{
            
            $all = scandir($this->directory);
            
            // si no se habilita $specialEntries, quitamos el . y el ..
            if(!$specialEntries)
                $all = array_diff($all, ['.', '..']);
            
            // prepara la REGEXP y el array para los resultados
            $filter = !empty($matches) ? $matches : "/\.*/";
            $filtered = []; 
            
            // si nos pasan un array de extensiones, cambiamos la expresión regular
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
           
                    
            // si las specialEntries estaban habilitadas y había filtros,
            // al aplicar filtros se habrán quitado de los resultados
            if($specialEntries && $filter != "/\.*/")
                array_push($filtered, '.', '..');
            
            // ordena alfabéticamente
            sort($filtered);
            
            return $filtered;
        }

        
        
        
        /**
         * Método estático que permite recuperar el listado de directorio con o sin filtros.
         * Es una alternativa más simple al uso del método de objeto getEntries().
         * 
         * @param string $directorio directorio de trabajo
         * @param array|string $matches expresión regular o array de extensiones
         * @param bool $specialEntries permite indicar si queremos que aparezcan el . y el ..
         * 
         * @return array lista de entradas coincidentes
         */ 
        public static function get(
            string $directorio          = ".",        
            array|string|NULL $matches  = "/.*/",   
            bool $specialEntries        = false
        ):array{
                
            return (new FileList($directorio))->getEntries($matches, $specialEntries);
        }
    }


