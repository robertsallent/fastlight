<?php
    
    /* Clase Filter
     *
     * Permite aplicar filtros que se guardarán en sesión.
     *
     * Última revisión: 23/03/2023
     *
     * */
    
    class Filter{
        
        // PROPIEDADES
        public string $text;                // texto a buscar
        public string $field;               // campo en el que buscar
        public string $orderField;          // campo para ordenar
        public string $order;               // sentido (ASC, DESC)
        
        // permite configurar el nombre de los campos de formulario
        // los valores en los pares de clave => valor son los nombres que deben tener los inputs
        protected static array $fields = [
            'filter'        => 'filtrar',       // nombre para una petición de nuevo filtro
            'removeFilter'  => 'quitarFiltro',  // nombre para una petición de quitar filtro
            'text'          => 'texto',         // nombre del input para el texto
            'field'         => 'campo',         // nombre del input para el campo 
            'orderField'    => 'campoOrden',    // nombre del input para el campo de ordenación
            'order'         => 'sentidoOrden'   // nombre del input para el campo de sentido
        ];
        
        // CONSTRUCTOR
        public function __construct(
            string $text        = '%',
            string $field       = 'id',
            string $orderField  = 'id',
            string $order       = 'DESC'
        ){
            $this->text         = $text;
            $this->field        = $field;
            $this->orderField   = $orderField;
            $this->order        = $order;            
        }
        
        // MÉTODOS
        
        // método que aplica o quita filtros
        public static function apply(
            string $name = 'generic' // nombre del filtro (para guardarlo en sesión)
        ){
            
            if(!empty($_POST[self::$fields['filter']])){ // si se pide aplicar un filtro
                                
                // preparamos el nuevo filtro             
                $filtro = new Filter(
                    (DB_CLASS)::escape($_POST[self::$fields['text']]),
                    (DB_CLASS)::escape($_POST[self::$fields['field']]),
                    (DB_CLASS)::escape($_POST[self::$fields['orderField']]),
                    (DB_CLASS)::escape($_POST[self::$fields['order']]),
                );
                
                Session::set("filter_$name", $filtro); // guarda el filtro en sesión
            }
            
            // si se pide quitar un filtro
            if(!empty($_POST[self::$fields['removeFilter']]))
                Session::forget("filter_$name");
                
            // Recuperar y retornar el filtro desde la variable de sesión
            return Session::has("filter_$name") ? Session::get("filter_$name") : NULL;        
        }   
        
        
        // MÉTODOS PARA USAR EN LAS VISTAS
        
        // método que muestra la información del filtro aplicado
        public function __toString():string{
            
            $texto = empty($this->text) ?
                "Sin filtro de texto. " :
                "Datos filtrados por <b>$this->field: '$this->text'</b>. ";
            
            $texto .= "Ordenado por $this->orderField ";
            
            $texto .= $this->order == 'ASC'?
                " ascendente. " :
                " descendente. ";
                    
           return $texto;
        }
    }
    
