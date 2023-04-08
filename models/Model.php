<?php
    
    /* 
     * Clase Model, padre para todos los modelos
     * 
     * implementa las operaciones genéricas del CRUD y el __toString()
     * también dispone de métodos para recuperar las entidades relacionadas 1 a N
     *
     * Automatiza las tareas del CRUD, permitiendo que los modelos estén vacíos
     *
     * autor: Robert Sallent
     * última revisión: 07/03/2023
     */
    
    class Model{
        
        // recupera el nombre de la tabla, que será el nombre indicado en la propiedad
        // estática $table de la clase hija. En caso de no existir esta propiedad, 
        // la tabla será el nombre de la clase en minúsculas con una s al final
        // Ejemplo: Libro --> libros
        protected static function getTable():string{
            return get_called_class()::$table ?? strtolower(get_called_class()).'s';
        }
        
        
        // método para recuperar un array con todos los objetos.
        public static function get(
            int $limit = 0,    // límite de resultados (para paginación)
            int $offset = 0    // desplazamiento (para paginación)
        ):array{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            // prepara la consulta y la ejecuta
            $consulta = "SELECT * FROM $tabla ";
            $consulta .= $limit? "LIMIT $limit OFFSET $offset" :"";
            
            return (DB_CLASS)::selectAll($consulta, get_called_class());
        }
        
        
        // método para recuperar un objeto a partir de su ID (null si no lo encuentra)
        public static function getById(int $id = 0):?object{
           
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            $consulta = "SELECT * FROM $tabla WHERE id=$id";
            return (DB_CLASS)::select($consulta, get_called_class());
        }
        
        
        // recuperar todo con un orden concreto
        public static function orderBy(
            string $orden = 'id',    // orden de los resultados
            string $sentido = 'ASC', // sentido
            int $limit = 0,          // límite de resultados (para paginación)
            int $offset = 0          // desplazamiento (para paginación)
        ):array{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            $consulta = "SELECT *
                         FROM $tabla
                         ORDER BY $orden $sentido ";
    
            $consulta .= $limit? "LIMIT $limit OFFSET $offset" :"";
            
            return (DB_CLASS)::selectAll($consulta, get_called_class());
        }
        
        
        // recuperar objetos con un filtro 
        public static function getFiltered(
            string $campo = 'id',    // campo para el filtro
            string $valor = '',      // valor buscado
            string $orden = 'id',    // orden de los resultados
            string $sentido = 'ASC'  // sentido
        ):array{
                
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            $consulta="SELECT *
                       FROM $tabla
                       WHERE $campo LIKE '%$valor%'
                       ORDER BY $orden $sentido";
            
            return (DB_CLASS)::selectAll($consulta, get_called_class());
        }
        
        
        // recuperar objetos a partir de un objeto Filter
        // se combina con la paginación gracias a los parámetros limit y offset
        public static function filter(
            Filter $filtro,                 // objeto filtro
            int $limit = RESULTS_PER_PAGE,  // resultados por página
            int $offset = 0                 // desplazamiento          
        ):array{
                
                $tabla = self::getTable(); // recupera el nombre de la tabla
                
                $consulta="SELECT *
                           FROM $tabla
                           WHERE $filtro->field LIKE '%$filtro->text%'
                           ORDER BY $filtro->orderField $filtro->order 
                           LIMIT $limit 
                           OFFSET $offset ";
                
                return (DB_CLASS)::selectAll($consulta, get_called_class());
        }
        
        // calcula el total de resultados a partir de un objeto filter
        public static function filteredResults(Filter $filtro):int{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            $consulta="SELECT COUNT(*) AS total
                           FROM $tabla
                           WHERE $filtro->field LIKE '%$filtro->text%'
                           ORDER BY $filtro->orderField $filtro->order ";
            
            return ((DB_CLASS)::select($consulta))->total;
        }
        
        // recuperar objetos con múltiples filtros
        public static function where(
            array $condiciones = [],    // array asociativo con campo => valor
            string $orden = 'id',    // orden de los resultados
            string $sentido = 'ASC'  // sentido
        ):array{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            $consulta="SELECT * FROM $tabla ";
            
            if(sizeof($condiciones)){
                $consulta .= "WHERE ";
                
                foreach($condiciones as $campo => $valor)
                    $consulta .= " $campo LIKE '%$valor%' AND ";
                    
                $consulta = substr($consulta, 0, strlen($consulta)-4);
            }
            
            $consulta .= "ORDER BY $orden $sentido";
           
            return (DB_CLASS)::selectAll($consulta, get_called_class());
        }
        
        
        
        // método para guardar un nuevo objeto en la BDD
        public function save():int{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            // prepara la consulta de inserción (esta es más compleja)
            $consulta="INSERT INTO $tabla (";
            
            // nombres de los campos
            foreach($this as $propiedad=>$valor)
                $consulta .= "$propiedad, ";
                
            $consulta = rtrim($consulta, ', '); // quita la última coma
            $consulta .= ") VALUES (";
            
            // valores
            foreach($this as $valor)
                // pone comillas en el SQL solo para los string
                // también controla los valores nulos
                switch(gettype($valor)){
                    case "string" : $consulta .= "'$valor', "; break;
                    case "NULL"   : $consulta .= "NULL, "; break;
                    case "array"  : $consulta .= "'".json_encode($valor)."', "; break;  
                    default       : $consulta .= "$valor, ";
            }
            
            $consulta = rtrim($consulta, ', '); // quita la última coma
            $consulta .= ")";
            
            $this->id = (DB_CLASS)::insert($consulta); // guarda el nuevo objeto
            
            // retorna el id del nuevo objeto
            return $this->id;
        }
        
        // método que actualiza un objeto en la base de datos
        public function update():int{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            // prepara la consulta
            $consulta="UPDATE $tabla SET ";
            
            // pone comillas en el SQL solo para los string
            foreach($this as $propiedad=>$valor)
                switch(gettype($valor)){
                    case "string" : $consulta .= "$propiedad='$valor', "; break;
                    case "NULL"   : $consulta .= "$propiedad=NULL, "; break;
                    case "array"  : $consulta .= "$propiedad='".json_encode($valor)."', "; break;  
                    default       : $consulta .= "$propiedad=$valor, ";
            }
            
            $consulta = rtrim($consulta, ', '); // quita la última coma
            $consulta .= " WHERE id=$this->id";
    
            // lanza la consulta y retorna el número de filas afectadas
            return (DB_CLASS)::update($consulta);
        }
        
            
        // método estático que borra un objeto de la base de datos
        public static function delete(int $id):int{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            $consulta="DELETE FROM $tabla WHERE id=$id";
            return (DB_CLASS)::delete($consulta);
        }
        
        // método de objeto para borrar
        public function deleteObject():int{
            return self::delete($this->id);
        }
        
        // método que realiza consultas de totales
        public static function total(
            string $operacion = 'COUNT',
            string $campo = '*'
        ){
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            return (DB_CLASS)::total($tabla, $operacion, $campo);
        }
        
        
        
        // método que sanea todos todas las propiedades string de un modelo
        public function saneate(bool $entities = true){
            
            foreach($this as $propiedad => $valor)
                if(gettype($propiedad) == 'string')
                    $this->$propiedad = (DB_CLASS)::escape($valor, $entities);
        }
        
        
        // método que recupera objetos relacionados en relación 1 a N
        // $propietario->hasMany(string $entidad, string $foranea, string $local):array
        
        // por ejemplo para recuperar préstamos de un socio sería:
        // $socio->hasMany('Prestamo', 'idsocio', 'id')
        
        // - si la clave foranea respeta el nombre 'id' + entidad, no hace falta indicarla
        // - si la clave local (primaria) se llama 'id', no hace falta indicarla
        // el ejemplo anterior también funcionará como $socio->hasMany('Prestamo');
        
        public function hasMany(
            string $related,            // clase (entidad) relacionada
            string $foreignKey = null,  // clave foránea
            string $localKey = 'id'     // clave local
        ):array{
            
            $tabla = $related::$table ?? strtolower($related).'s';   // cálculo del nombre de la tabla
            
            $foreignKey = $foreignKey ?? 'id'.strtolower(get_called_class());  // cálculo foranea
            
            $consulta = "SELECT * FROM $tabla WHERE $foreignKey = ".$this->$localKey; // consulta
            return (DB_CLASS)::selectAll($consulta, $related);
        }
        
        
        // método que recupera objetos relacionados en relación 1 a N de forma inversa
        
        // por ejemplo para recuperar el socio de un préstamo sería
        // $prestamo->belongsTo('Socio', 'idsocio', 'id')
        
        // - si la clave foranea respeta el nombre 'id' + entidad, no hace falta indicarla
        // - si la clave del propietario se llama 'id', no hace falta indicarla
        // el ejemplo anterior también funciona como $prestamo->belongsTo('Socio');
        
        public function belongsTo(
            string $related,
            string $foreignKey = null,
            string $ownerKey = 'id'
        ):?object{
            
            $tabla = $related::$table ?? strtolower($related).'s';   // cálculo del nombre de la tabla
            
            $foreignKey = $foreignKey ?? 'id'.strtolower($related);  // cálculo  foranea
            
            $consulta="SELECT * FROM $tabla WHERE $ownerKey = ".$this->$foreignKey;
            return (DB_CLASS)::select($consulta, $related);
        }
        
        
        // el método __toString(), lo usaremos principalmente en test
        public function __toString():string{
            
            $texto = '';
            
            foreach($this as $propiedad => $valor){
                $texto .= is_array($valor) ? 
                    "$propiedad: [ ".implode(', ',$valor)." ]" :
                    "$propiedad: <b>$valor</b>, ";
            }
            return rtrim($texto, ', '); // quita la última coma
        }
    }
    
    
