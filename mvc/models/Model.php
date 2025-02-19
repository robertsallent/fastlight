<?php

/**
 * Model
 * 
 * Clase base para todos los modelos. Implementa las operaciones 
 * genéricas del CRUD y el método __toString().
 * También dispone de métodos para recuperar las entidades relacionadas 1 a N
 * y automatiza las tareas del CRUD, permitiendo que los modelos estén vacíos.
 * 
 * Las propiedades de configuración para los modelos son:
 * protected static string $table: para configurar el nombre de la tabla en la BDD.
 * protected static array $jsonFields: para indicar los campos JSON que se deben 
 * convertir automáticamente en arrays PHP.
 *
 * Última revisión 18/02/25
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.1.0
 * @since v0.9.2 añadido belongsToAny() y hasAny()
 * @since v1.4.1 añadido el método whereExactMatch()
 * @since v1.7.0 añadido el método groupBy()
 * @since v1.7.3 añadido el método clear()
 * @since v1.7.8 el método getTable() pasa a ser público
 * @since v1.7.8 añadido el método isNotNull()
 */


abstract class Model{
         
 
    /**
     * Retorna el nombre de la tabla, que será el nombre indicado en la propiedad
     * estática $table de la clase hija. En caso de no existir esta propiedad, 
     * será el nombre de la clase en lowercase con una s al final
     * Ejemplo: Libro --> libros
     * 
     * @return string nombre de la tabla correspondiente con el modelo actual.
     */
    public static function getTable():string{
        return get_called_class()::$table ?? strtolower(get_called_class()).'s';
    }
    
    
    
    /**
     * Retorna la lista de campos de tipo JSON definidos en el modelo.
     *  
     * @return array lista de campos JSON.
     */
    protected static function getJsonFields():array{
        return get_called_class()::$jsonFields ?? [];
    }
    
    
    
    /**
     * Convierte los campos JSON en arrays.
     * Se utiliza, por ejemplo, para recuperar correctamente
     * los roles de los usuarios desde la BDD, convirtiéndolos de string
     * a un array de roles.
     * 
     * @return object el mismo objeto sobre el que se aplica el método.
     */
    public function parseJsonFields():object{
        
        $properties = self::getJsonFields();
                    
        foreach($properties as $property)
            $this->$property = array_unique(json_decode($this->$property, JSON_OBJECT_AS_ARRAY));
        
        return $this;
    }
    
    
    
    
    /**
     * Permite crear una entidad a partir de un array asociativo y la guarda en BDD. 
     * Es peligroso si se usa en combinación con alguno de los métodos que recuperan 
     * los inputs de la Request en un array.
     * 
     * Si hacemos User::create($request->posts()) crearemos un usuario a partir de los campos
     * del formulario de registo que llegan por POST en un solo paso. Sin embargo, nos exponemos a que 
     * inyecten un campo "roles" con valor "ROLE_ADMIN" y que esa persona que se estaba
     * registrando se convierta en administrador. 
     * 
     * Un uso adecuado, en un controlador, podría ser:
     * 
     * Perro::create([
     *      'nombre' => request()->post('nombre'),
     *      'raza'   => request()->post('nombre'),
     *      'peso'   => floatval(request()->post('peso'));
     * ]);
     * 
     * @param array $data lista de propiedades de la entidad a modo de array asociativo.
     * @return int identificador único asignado en la BDD.
     */
    public static function create(array $data):int{
        $class = get_called_class();
        $entity = new $class();
        
        foreach($data as $property => $value)
            $entity->$property = $value;
        
        return $entity->save();
    }
    
    
    
    /**
     * Recupera todas las entidades y las retorna en un array.
     * 
     * @param int $limit límite de resultados (para paginación).
     * @param int $offset desplazamiento (para paginación).
     * 
     * @return array lista de todas las entidades
     */
    public static function all(
        int $limit = 0,    
        int $offset = 0    
    ):array{
        
        $table = self::getTable(); // recupera el nombre de la tabla
        
        // prepara la consulta y la ejecuta
        $query = "SELECT * FROM $table ";
        $query .= $limit? "LIMIT $limit OFFSET $offset" :"";
        
        $entities = (DB_CLASS)::selectAll($query, get_called_class());
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
        
        return $entities;
    }
    
      
    
    /**
     * Alias de all(). 
     * 
     * @deprecated en la versión 0.8.7. Se mantiene por compatibilidad con versiones anteriores.
     * 
     * @param int $limit límite de resultados (para paginación).
     * @param int $offset desplazamiento (para paginación).
     *
     * @return array lista de todas las entidades.
     */
    public static function get(
        int $limit = 0,
        int $offset = 0
    ):array{
        return get_called_class()::all($limit, $offset);
    }
    
    
    
    /**
     * Recupera una entidad concreta a partir de su identificador único.
     *  
     * @param int $id identificador único de la entidad a recuperar.
     * 
     * @return object|NULL un objeto del tipo entidad o NULL si no lo encuentra.
     */
    public static function find(int $id = 0):?object{
        $table = self::getTable(); // recupera el nombre de la tabla
        
        $query = "SELECT * FROM $table WHERE id=$id";
        $entity = (DB_CLASS)::select($query, get_called_class());
        
        if($entity)
            $entity->parseJsonFields();
        
        return $entity;
    }
    

    
    /**
     * Alias de find().
     * 
     * @deprecated en la versión 0.8.7. Se mantiene por compatibilidad con versiones anteriores.
     * 
     * @param int $id identificador único de la entidad a recuperar.
     * 
     * @return object|NULL un objeto del tipo entidad o NULL si no lo encuentra.
     */
    public static function getById(int $id = 0):?object{
         return get_called_class()::find($id);
    }
    
    
    
    /**
     * 
     * Recupera una entidad a partir de su identificador único o falla.
     * 
     * @param int $id identificador único de la entidad a recuperar.
     * @param string $message texto a mostrar en caso de no encontrar la entidad con ese identificador. 
     * 
     * @throws NotFoundException si no encuentra la entidad con ese identificador.
     * @return object la entidad recuperada.
     */
    public static function findOrFail(
        int $id = 0,
        ?string $message = NULL
    ):object{
        
        if(!$id)
            throw new NothingToFindException("No se recibió el identificador.");
            
        $entity = get_called_class()::find($id);
        
        if(!$entity)
            throw new NotFoundException($message ?? "No se encontró la entidad buscada.");
            
        return $entity;
    }
    
    /**
     * Recupera entidades con un orden concreto.
     * 
     * @param string $orderField orden deseado para los resultados.
     * @param string $order sentido ascendente o descendente.
     * @param int $limit límite de resultados para paginación.
     * @param int $offset desplazamiento para paginación.
     * 
     * @return array lista de entidades recuperadas.
     */
    public static function orderBy(
        string $orderField = 'id',    
        string $order = 'ASC', 
        int $limit = 0,          
        int $offset = 0          
    ):array{
        
        $table = self::getTable(); // recupera el nombre de la tabla
        
        $query = "SELECT *
                  FROM $table
                  ORDER BY $orderField $order ";

        $query .= $limit? "LIMIT $limit OFFSET $offset" :"";
        
        $entities = (DB_CLASS)::selectAll($query, get_called_class());
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    

    /**
     * Recupera entidades a partir de un filtro.
     * 
     * @param string $field campo para el filtro.
     * @param string $value valor buscado.
     * @param string $orderField orden de los resultados.
     * @param string $order sentido ascendente o descendente para el orden.
     * 
     * @return array lista de entidades con el filtro aplicado.
     */
    public static function getFiltered(
        string $field = 'id',    
        string $value = '',      
        string $orderField = 'id',    
        string $order = 'ASC'  
    ):array{
            
        $table = self::getTable(); // recupera el nombre de la tabla
        
        $consulta="SELECT *
                   FROM $table
                   WHERE $field LIKE '%$value%'
                   ORDER BY $orderField $order";
        
        $entities = (DB_CLASS)::selectAll($consulta, get_called_class());
        
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    
    
    /**
     * Recupera entidades que tienen un campo concreto a NULL
     * 
     * @param string $field campo en el que buscar valores nulos
     * @param string $orderField campo para ordenar resultados
     * @param string $order sentido del orden (ASC o DESC)
     * 
     * @return array la lista de entidades con ese campo a NULL
     */
    public static function isNull(
        string $field,
        string $orderField = 'id',
        string $order = 'ASC'
    ):array{
        
        $table = self::getTable(); // recupera el nombre de la tabla
        
        $consulta="SELECT *
                   FROM $table
                   WHERE $field IS NULL
                   ORDER BY $orderField $order";
        
        $entities = (DB_CLASS)::selectAll($consulta, get_called_class());
        
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    
    
    
    /**
     * Recupera entidades que tienen un campo concreto con valor NO NULO
     *
     * @param string $field campo en el que buscar valores no nulos
     * @param string $orderField campo para ordenar resultados
     * @param string $order sentido del orden (ASC o DESC)
     *
     * @return array la lista de entidades con ese campo no nulo
     */
    public static function isNotNull(
        string $field,
        string $orderField = 'id',
        string $order = 'ASC'
    ):array{
        
        $table = self::getTable(); // recupera el nombre de la tabla
        
        $consulta="SELECT *
               FROM $table
               WHERE $field IS NOT NULL
               ORDER BY $orderField $order";
        
        $entities = (DB_CLASS)::selectAll($consulta, get_called_class());
        
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    
    
    
    
    
    /**
     * Recupera entidades a partir de un objeto Filter. Se combina con la paginación
     * gracias a los parámetros limit y offset.
     * 
     * @param Filter $filtro filtro a aplicar.
     * @param int $limit número de resultados por página.
     * @param int $offset desplazamiento.
     * 
     * @return array lista de entidades con el filtro aplicado.
     */
    public static function filter(
        Filter $filtro,                 
        int $limit = RESULTS_PER_PAGE,  
        int $offset = 0                         
    ):array{
            
            $tabla = self::getTable(); // recupera el nombre de la tabla
            
            $consulta="SELECT *
                       FROM $tabla
                       WHERE $filtro->field LIKE '%$filtro->text%'
                       ORDER BY $filtro->orderField $filtro->order 
                       LIMIT $limit 
                       OFFSET $offset ";
            
            $entities = (DB_CLASS)::selectAll($consulta, get_called_class());
            
            foreach($entities as $entity)
                $entity->parseJsonFields();
                
            return $entities;
    }
    
    
    /**
     * Calcula el total de resultados a partir de un objeto filter.
     * 
     * @param Filter $filtro filtro a aplicar.
     * 
     * @return int total de resultados tras aplicar el filtro.
     */
    public static function filteredResults(Filter $filtro):int{
        
        $tabla = self::getTable(); // recupera el nombre de la tabla
        
        $consulta="SELECT COUNT(*) AS total
                       FROM $tabla
                       WHERE $filtro->field LIKE '%$filtro->text%'
                       ORDER BY $filtro->orderField $filtro->order ";
        
        $total = ((DB_CLASS)::select($consulta))->total;
            
        return $total;
    }
    
    
    /**
     * Recupera entidades a partir de múltiples condiciones de filtrado.
     * 
     * @param array $condiciones array asociativo campo => valor con las condiciones.
     * @param string $orden orden para los resultados.
     * @param string $sentido sentido ascendente o descendente.
     * 
     * @return array lista de entidades con los filtros aplicados.
     */
    public static function where(
        array $condiciones = [],    
        string $orden = 'id',    
        string $sentido = 'ASC'  
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
       
        $entities = (DB_CLASS)::selectAll($consulta, get_called_class());
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    
    
    /**
     * Recupera entidades a partir de múltiples condiciones de filtrado. Búsqueda exacta.
     *
     * @param array $condiciones array asociativo campo => valor con las condiciones.
     * @param string $orden orden para los resultados.
     * @param string $sentido sentido ascendente o descendente.
     *
     * @return array lista de entidades con los filtros aplicados.
     */
    public static function whereExactMatch(
        array $condiciones = [],
        string $orden = 'id',
        string $sentido = 'ASC'
    ):array{
            
        $tabla = self::getTable(); // recupera el nombre de la tabla
        
        $consulta="SELECT * FROM $tabla ";
        
        if(sizeof($condiciones)){
            $consulta .= "WHERE ";
            
            foreach($condiciones as $campo => $valor)
                $consulta .= " $campo='$valor' AND ";
                
                $consulta = substr($consulta, 0, strlen($consulta)-4);
        }
        
        $consulta .= "ORDER BY $orden $sentido";
        
        $entities = (DB_CLASS)::selectAll($consulta, get_called_class());
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    
    
    /**
     * Guarda una entidad en la base de datos.
     * 
     * @return int el autonumérico asignado en la base de datos o 0 si la tabla no dispone de autonumérico.
     */
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
    
    
    /**
     * Actualiza los datos de una entidad en la base de datos.
     * 
     * @return int el número de filas afectadas.
     */
    public function update():int{
        
        $tabla = self::getTable(); // recupera el nombre de la tabla
        
        unset($this->updated_at);  // para que se actualice automáticamente el "updated_at" en la BDD, no le podemos enviar 'null'.
        
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
    
        
    /**
     * Elimina una entidad de la base de datos a partir de su identificador único.
     * 
     * @param int $id el identificador único de la entidad.
     * 
     * @return int el número de filas afectadas.
     */
    public static function delete(int $id):int{
        
        $tabla = self::getTable(); // recupera el nombre de la tabla
        
        $consulta="DELETE FROM $tabla WHERE id=$id";
        return (DB_CLASS)::delete($consulta);
    }
    
    
    /**
     * Elimina una entidad de la base de datos.
     * 
     * @return int el número de filas afectadas.
     */
    public function deleteObject():int{
        return self::delete($this->id);
    }
    
    
    /**
     * Elimina los últimos registros de una tabla en la BDD. En caso
     * de no indicar el número de registros a borrar, los borra todos: PELIGROSO!.
     *
     * @param int $number número de errores a borrar.
     * @param string $orderField orden a considerar.
     * @param string $order ascendente o descendente.
     * 
     * @return int número de errores borrados.
     */
    public static function clear(
        ?int $numero        = null,
        string $orderField  = 'id',
        string $order       = 'DESC'
    ):int{
        
        $tabla = self::getTable(); // recupera el nombre de la tabla
        
        // prepara la consulta
        $consulta = "DELETE FROM $tabla";
        
        if($numero)
            $consulta .= " ORDER BY $orderField $order LIMIT $numero";
        
        // ejecuta la consulta
        return (DB_CLASS)::delete($consulta);
    }
    
    
    /**
     * Realiza consultas de totales.
     * 
     * @param string $operacion operación deseada.
     * @param string $campo campo sobre el que realizar la operación.
     * 
     * @return mixed el resultado 
     */
    public static function total(
        string $operacion = 'COUNT',
        string $campo = '*'
    ){
        $tabla = self::getTable(); // recupera el nombre de la tabla
        
        return (DB_CLASS)::total($tabla, $operacion, $campo);
    }
    
    
    /**
     * Realiza una consulta de totales con grupos.
     * 
     * Realiza una consulta de totales con grupos, pudiendo aplicar varios totales
     * a la vez y agrupando por múltiples campos. Tiene la limitación de que solamente
     * se pueden aplicar sobre una única tabla, no permite relaciones.
     * 
     * @param array $totales array asociativo en pares de campo => total a aplicar.
     * @param array $agruparPor array indexado con los nombres de los campos para el agrupado.
     * 
     * @return array con los resultados a modo de objetos stdClass
     */
    public static function groupBy(
        array $totales      = ['id' => 'COUNT'],
        array $agruparPor   = []
    ){
        $tabla = self::getTable(); // recupera el nombre de la tabla
        
        return (DB_CLASS)::groupBy($tabla, $totales, $agruparPor);
    }
    
    
    /**
     * Sanea las propiedades de tipo string de un modelo
     * 
     * @param bool $entities convertir entidades HTML.
     * @return mixed el modelo con los strings saneados.
     */
    public function saneate(bool $entities = true):mixed{
        
        foreach($this as $propiedad => $valor)
            if(gettype($valor) == 'string')
                $this->$propiedad = (DB_CLASS)::escape($valor, $entities);
           
        return $this;
    }
    

    /**
     * Quita espacios en blanco al inicio y final de las propiedades de tipo string.
     * 
     * @return mixed el modelo con los strings sin espacios en blanco al inicio o final.
     */
    public function trim():mixed{
        
        foreach($this as $propiedad => $valor){
            if(gettype($valor) == 'string')
                $this->$propiedad = trim($valor);
        }
        
        return $this;
    }
    
    
    
    /**
     * Recupera entidades relacionadas en relaciones 1 a N.
     * EJEMPLO: $propietario->hasMany(string $entidad, string $foranea, string $local):array
     *
     * por ejemplo para recuperar préstamos de un socio sería:
     * $socio->hasMany('Prestamo', 'idsocio', 'id');
     * 
     * Si la clave foranea respeta el nombre 'id' + entidad, no hace falta indicarla.
     * Si la clave local (primaria) se llama 'id', no hace falta indicarla.
     * el ejemplo anterior también funcionará como $socio->hasMany('Prestamo');
     * 
     * @param string $related tipo de entidad (clase) relacionada.
     * @param string $foreignKey clave foránea.
     * @param string $localKey clave local.
     * 
     * @return array lista de entidades relacionadas
     */
    public function hasMany(
        string $related, 
        string $foreignKey = null,
        string $localKey = 'id'
    ):array{
        
        $tabla = $related::$table ?? strtolower($related).'s';   // cálculo del nombre de la tabla
        
        $foreignKey = $foreignKey ?? 'id'.strtolower(get_called_class());  // cálculo foranea
        
        $consulta = "SELECT * FROM $tabla WHERE $foreignKey = ".$this->$localKey; // consulta
        $entities =  (DB_CLASS)::selectAll($consulta, $related);
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    
    
    /**
     * Comprueba si una entidad tiene relacionadas entidades de otro
     * tipo en una relación 1 a N.
     * 
     * @param string $related tipo de entidad (clase) relacionada.
     * @param string $foreignKey clave foránea.
     * @param string $localKey clave local.
     * 
     * @return bool true si existen entidades relacionadas, false en caso contrario.
     */
    public function hasAny(
        string $related,
        string $foreignKey = null,
        string $localKey = 'id'
    ):bool{
        
        $table = $related::$table ?? strtolower($related).'s';   // cálculo del nombre de la tabla
        
        $foreignKey = $foreignKey ?? 'id'.strtolower(get_called_class());  // cálculo foranea
        
        $query = "SELECT COUNT(*) AS total
                     FROM $table 
                     WHERE $foreignKey = ".$this->$localKey; // consulta
        
        $result =  (DB_CLASS)::select($query);
        
        return $result->total;
    }
    
    

    /**
     * Método que recupera objetos relacionados en relación 1 a N de forma inversa.
     * por ejemplo para recuperar el socio de un préstamo sería
     * $prestamo->belongsTo('Socio', 'idsocio', 'id');
     * 
     * Si la clave foranea respeta el nombre 'id' + entidad, no hace falta indicarla.
     * Si la clave del propietario se llama 'id', no hace falta indicarla.
     * 
     * El ejemplo anterior también funciona como $prestamo->belongsTo('Socio');
     * 
     * @param string $related tipo de entidad (clase) relacionada.
     * @param string $foreignKey nombre de la clave foránea
     * @param string $ownerKey nombre de la clave primaria en la tabla del lado 1.
     * 
     * @return object|NULL la entidad relacionada en el lado 1. 
     */
    public function belongsTo(
        string $related,
        string $foreignKey = null,
        string $ownerKey = 'id'
    ):?object{
        
        $tabla = $related::$table ?? strtolower($related).'s';   // cálculo del nombre de la tabla
        
        $foreignKey = $foreignKey ?? 'id'.strtolower($related);  // cálculo  foranea
        
        $consulta="SELECT * FROM $tabla WHERE $ownerKey = ".($this->$foreignKey ?? 'NULL');
        $entity = (DB_CLASS)::select($consulta, $related);
        
        if($entity)
            $entity->parseJsonFields();
        
        return $entity;
    }
    
    
    
    /**
     * Indica si una entidad que participa en una relación en el lado N está
     * relacionada con otra entidad en el lado 1.
     * 
     * @param string $related tipo de entidad (clase) relacionada.
     * @param string $foreignKey nombre de la clave foránea
     * @param string $ownerKey nombre de la clave primaria en la tabla del lado 1.
     * 
     * @return bool true si la entidad está vinculada a otra, false en caso contrario.
     */
    public function belongsToAny(
        string $related,
        string $foreignKey = null,
        string $ownerKey = 'id'
    ):bool{
            
        $table = $related::$table ?? strtolower($related).'s';   // cálculo del nombre de la tabla
        
        $foreignKey = $foreignKey ?? 'id'.strtolower($related);  // cálculo  foranea
        
        $query="SELECT COUNT(*) AS total
                   FROM $table 
                   WHERE $ownerKey = ".($this->$foreignKey ?? 'NULL');
        
        $result = (DB_CLASS)::select($query);
        
        return $result->total;
    }
    
    
    
    /**
     * Recupera las entidades relacionadas en una relación N a N
     * 
     * Este método calcula automáticamente:
     * 
     * - El nombre de la tabla intermedia, mediante la unión de los nombres de las tablas 
     *   correspondientes a las entidades implicadas, en lower snake case y ordenadas alfabéticamente.
     *   Por ejemplo, para las entidades Libro y Tema, buscará la tabla libros_temas.
     * - Los nombres de las tablas de las entidades de los extremos, siguiendo los mismos criterios 
     *   que los otros métodos de esta clase.
     * - Las claves foráneas, haciendo id concatenado con el nombre de la entidad en minúsculas. 
     * - Las claves primarias se llamarán por defecto id. 
     * 
     * Este comportamiento se puede cambiar mediante parámetros del método.
     *
     * 
     * @param string $related entidad relacionada
     * @param string $intermediateTable nombre de la tabla intermedia
     * @param string $foreign1 nombre de la clave foránea relacionada con la entidad actual
     * @param string $foreign2 nombre de la clave foránea relacionada con la entidad externa
     * @param string $owner1 nombre de la clave primaria de la entidad actual
     * @param string $owner2 nombre de la clave primaria de la entidad externa
     * 
     * @return array lista de entidades externas relacionadas
     */
    public function belongsToMany(
        string $related,
        string $intermediateTable = NULL,
        string $foreign1 = NULL,
        string $foreign2 = NULL,
        string $owner1 = 'id',
        string $owner2 = 'id'
    ):array{
        // cálculo de los nombres de la tablas
        $tabla1 = self::getTable();
        $tabla2 = $related::$table ?? strtolower($related).'s';
        
        // cálculo del nombre de la tabla intermedia
        // es la unión de los nombres de las tablas ordenadas alfabéticamente y en
        // snake case.
        $tablas = [$tabla1, $tabla2];
        sort($tablas);
        $intermedia = $intermediateTable ?? $tablas[0]."_".$tablas[1];
        
        // cálculo de las foráneas
        $foreign1 = $foreign1 ?? 'id'.strtolower(get_called_class());
        $foreign2 = $foreign2 ?? 'id'.strtolower($related);
        
        // preparación de la consulta
        $consulta="SELECT $tabla2.* FROM $tabla2
                    INNER JOIN $intermedia ON $tabla2.$owner2 = $intermedia.$foreign2
                    INNER JOIN $tabla1 ON $intermedia.$foreign1 = $tabla1.$owner1
                WHERE $tabla1.$owner1 = ".$this->$owner1;
        
        // ejecución de la consulta
        $entities =  (DB_CLASS)::selectAll($consulta, $related);
        
        foreach($entities as $entity)
            $entity->parseJsonFields();
            
        return $entities;
    }
    
    
    
    /**
     * Método __toString()
     * 
     * @return string
     */
    public function __toString():string{
        
        $texto = '';
        
        foreach($this as $propiedad => $valor){
            $texto .= is_array($valor) ? 
                "$propiedad: [ ".implode(', ',$valor)." ]" :
                "$propiedad: $valor, ";
        }
        return rtrim($texto, ', '); // quita la última coma
    }
}


