<?php

/**
 * Clase para construir y ejecutar consultas SQL mediante PDO y sentencias preparadas.
 * 
 * Permite crear consultas SELECT, INSERT, UPDATE, DELETE y CALL con parámetros.
 * Facilita la construcción de consultas complejas con cláusulas WHERE, ORDER BY y LIMIT.
 * 
 * Aún en desarrollo, faltan muchas cosas por implementar que de momento se suplen mediante
 * los métodos de la clase DB.
 * 
 * DEPENDENCIAS: helpers.php
 * Última modificación: 12/03/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.4.0
 */
class QueryBuilder{
    
    /* Tipos de consulta soportados */
    const SELECT   = 1; 
    const INSERT   = 2;
    const UPDATE   = 3;  
    const DELETE   = 4;
    const CALL     = 5;
    
    /** @var int $type Tipo de consulta (SELECT, INSERT, UPDATE, DELETE, CALL) */
    protected int $type     = self::SELECT;

    /** @var string $table Nombre de la tabla o procedimiento almacenado */
    protected string $table = ''; 
    
    /** @var array $fields Campos a seleccionar o modificar */
    protected array $fields = [];

    /** @var array $values Valores para los campos o parámetros */
    protected array $values = [];
    
    /** @var array $where Condiciones WHERE */
    protected array $where  = [];

    /** @var array $groups Grupos para el GROUP BY */
    protected array $group = [];

    /** @var array $order Cláusulas ORDER BY */
    protected array $order  = [];

    /** @var int $limit Límite de filas a retornar */
    protected int $limit    = 0; 

    /** @var int $offset Desplazamiento para el límite */
    protected int $offset   = 0;

    /** @var PDOStatement|null $pdoStatement Sentencia preparada */
    protected ?PDOStatement $pdoStatement   = null;

    /** @var PDO|null $pdo Conexión PDO */
    protected ?PDO $pdo = null;



    // ---------------------------------------------------------------------------
    // CONSTRUCCIÓN DE INSTANCIAS DEL QueryBuilder
    // ---------------------------------------------------------------------------
    
    /** Constructor de la clase 
     * 
     * @param int $type tipo de consulta
     * @param sring $table tabla sobre la que ejecutar la consulta
     * @param PDO|null $pdo conexión PDO (opcional)
    */
    public function __construct(
        int $type, 
        string $table, 
        ?PDO $pdo = null
    ){
        $this->type  = $type;
        $this->table = $table;
        $this->pdo   = $pdo;
    }
     
    
    // Métodos estáticos para creación sencilla de sentencias
    
    /**
     * Crea una instancia del QueryBuilder para una consulta SELECT
     * 
     * @param string $table tabla sobre la que trabajar
     * @param PDO $pdo conexión PDO a usar
     * 
     * @return QueryBuilder
     */
    public static function select(
        string $table,
        ?PDO $pdo = null
    ){
        return new QueryBuilder(self::SELECT, $table, $pdo);
    }
    
    
    /**
     * Crea una instancia del QueryBuilder para una consulta INSERT
     *
     * @param string $table tabla sobre la que trabajar
     * @param PDO $pdo conexión PDO a usar
     *
     * @return QueryBuilder
     */
    public static function insert(
        string $table,
        ?PDO $pdo = null
    ){
        return new QueryBuilder(self::INSERT, $table, $pdo);
    }


    /**
     * Crea una instancia del QueryBuilder para una consulta UPDATE
     *
     * @param string $table tabla sobre la que trabajar
     * @param PDO $pdo conexión PDO a usar
     *
     * @return QueryBuilder
     */
    public static function update(
        string $table,
        ?PDO $pdo = null
    ){
        return new QueryBuilder(self::UPDATE, $table, $pdo);
    }
    
    
    /**
     * Crea una instancia del QueryBuilder para una consulta DELETE
     *
     * @param string $table tabla sobre la que trabajar
     * @param PDO $pdo conexión PDO a usar
     *
     * @return QueryBuilder
     */
    public static function delete(
        string $table,
        ?PDO $pdo = null
    ){
        return new QueryBuilder(self::DELETE, $table, $pdo);
    }
    

    // ---------------------------------------------------------------------------
    // SETTERS Y GETTERS
    // ---------------------------------------------------------------------------

    /** Establece la conexión PDO
     * 
     * @param PDO $pdo Conexión PDO
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function setPDO(PDO $pdo): QueryBuilder{
        $this->pdo = $pdo;
        return $this;
    }

    /** Obtiene la conexión PDO
     * 
     * @return PDO|null La conexión PDO o null si no está establecida
    */
    public function getPDO(): ?PDO{
        return $this->pdo;
    }

    /** Obtiene la sentencia preparada
     * 
     * @return PDOStatement|null La sentencia preparada o null si no está preparada
    */
    public function getPDOStatement(): ?PDOStatement{
        return $this->pdoStatement;
    }

    
    /** Cambia la tabla de trabajo
     *
     * @param string $table tabla a usar
     * @return QueryBuilder La instancia actual para encadenamiento
     */
    public function setTable(sring $strable): QueryBuilder{
        $this->table = $table;
        return $this;
    }
    
    /** Obtiene la tabla de trabajo
     *
     * @return string La tabla sobre la que trabajará la sentencia
     */
    public function getTable(): string{
        return $this->table;
    }
    
    
    /**
     * Recupera los valores a enlazar
     * 
     * @return array lista de valores a enlazar cuando se realicen los bindings
     */
    public function getValues():array{
        return $this->values;
    }


    // ---------------------------------------------------------------------------
    // MÉTODOS PARA LA CREACIÓN DE LA CONSULTA
    // ---------------------------------------------------------------------------

    /** Añade un campo y su valor (si aplica) a la consulta
     * 
     * @param string $field Nombre del campo
     * @param mixed|null $value Valor del campo (opcional, solo para INSERT, UPDATE y CALL)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function field(string $field, $value = null): QueryBuilder{
        $this->fields[] = $field;
        if($value !== null && ($this->type === self::INSERT || $this->type === self::UPDATE || $this->type === self::CALL)){     
            $this->values[] = $value;
        }
        return $this;
    }


    /** Añade varios campos a la consulta
     * 
     * @param array $fields Array de nombres de campos
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function fields(array $fields): QueryBuilder{
        foreach($fields as $field){
            $this->field($field);
        }
        return $this;
    }
    
    // TODO: plantear el fields() también para el INSERT o UPDATE, añadiendo los values
    

    /** Añade una condición WHERE a la consulta
     * 
     * @param string $condition Condición SQL (puede incluir ? para parámetros)
     * @param mixed|null $value Valor para el parámetro (opcional)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function where(
        string $condition, 
        mixed $value = null
    ): QueryBuilder{
        $this->where[] = $condition;
        if($value !== null){
            $this->values[] = $value;
        }
        return $this;
    }

      
    /** Añade una condición WHERE con AND a la consulta
     * 
     * @param string $condition Condición SQL (puede incluir ? para parámetros)
     * @param mixed|null $value Valor para el parámetro (opcional)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function whereAnd(string $condition, $value = null): QueryBuilder{
        return $this->where($condition, $value);
    }


    /** Añade una condición WHERE con OR a la consulta
     * 
     * @param string $condition Condición SQL (puede incluir ? para parámetros)
     * @param mixed|null $value Valor para el parámetro (opcional)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function whereOr(string $condition, $value = null): QueryBuilder{
        if(empty($this->where)){
            return $this->where($condition, $value);
        }

        $lastCondition = array_pop($this->where);
        $newCondition = "($lastCondition OR $condition)";
        $this->where[] = $newCondition;
        $this->values[] = $value;

        return $this;
    }


    /** Añade una condición WHERE con LIKE a la consulta
     * 
     * @param string $field Campo sobre el que aplicar LIKE
     * @param string $pattern Patrón de búsqueda (puede incluir % y _)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function whereLike(string $field, string $pattern): QueryBuilder{
        return $this->where("$field LIKE ?", $pattern);
    }
    
    
    /** Añade una condición de expresión regular a la consulta
     *
     * @param string $field Campo sobre el que aplicar REGEXP
     * @param string $regexp Expresión regular
     * @return QueryBuilder La instancia actual para encadenamiento
     */
    public function whereRegExp(string $field, string $regexp): QueryBuilder{
        return $this->where("$field REGEXP ?", $regexp);
    }
    

    /**
     * Consulta con condición de rango de valores. Los valores de los extremos
     * están incluidos.
     * 
     * @param string $field campo sobre el que aplicar la condición
     * @param mixed $value1 valor mínimo
     * @param mixed $value2 valor máximo
     * 
     * @return QueryBuilder la isntancia del QueryBuilder
     */
    public function whereBetween(
        string $field, 
        mixed $value1,
        mixed $value2
    ): QueryBuilder {
        $this->where[] = "$field BETWEEN ? AND ?";
        $this->values[] = $value1;
        $this->values[] = $value2;
        return $this;
    }

    
    /**
     * Consulta con NOT BETWEEN en el WHERE
     * 
     * @param string $field campo sobre el que realizar la comprobación
     * @param mixed $value1 valor mínimo
     * @param mixed $value2 valor máximo
     * 
     * @return QueryBuilder la instancia de QueryBuilder para permitir la concatenación
     */
    public function whereNotBetween(
        string $field, 
        mixed $value1,
        mixed $value2
    ): QueryBuilder {
        $this->where[] = "$field NOT BETWEEN ? AND ?";
        $this->values[] = $value1;
        $this->values[] = $value2;
        return $this;
    }

    
    /**
     * Consultas con WHERE IN
     * 
     * @param string $field campo sobre el que realizar la comprobación
     * @param array $values lista de valores a comprobar
     * 
     * @return QueryBuilder la propia instancia, para permitir concatenación
     */
    public function whereIn(
        string $field, 
        array $values
    ): QueryBuilder {
        if (empty($values)) {
            // Si el array está vacío, hacemos que la condición nunca se cumpla
            $this->where[] = "1 = 0";
            return $this;
        }

        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $this->where[] = "$field IN ($placeholders)";
        foreach ($values as $v) {
            $this->values[] = $v;
        }
        return $this;
    }

    
    /**
     * Consultas con WHERE NOT IN
     * 
     * @param string $field campo sobre el que realizar la comprobación
     * @param array $values lista de valores
     * 
     * @return QueryBuilder la propia instancia, para permitir la concatenación
     */
    public function whereNotIn(
        string $field, 
        array $values
    ): QueryBuilder {
        if (empty($values)) {
            // Si está vacío, la condición siempre será cierta
            $this->where[] = "1 = 1";
            return $this;
        }

        $placeholders = implode(', ', array_fill(0, count($values), '?'));
        $this->where[] = "$field NOT IN ($placeholders)";
        foreach ($values as $v) {
            $this->values[] = $v;
        }
        return $this;
    }


    /** Añade una cláusula ORDER BY a la consulta
     * 
     * @param string $field Campo por el que ordenar
     * @param string $direction Dirección de ordenación (ASC o DESC)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function order(string $field, string $direction = 'ASC'): QueryBuilder{
        $this->order[] = "$field $direction";

        return $this;
    }


    // TODO: orders()
    
    
    /** Establece el límite y desplazamiento de la consulta
     * 
     * @param int $limit Número máximo de filas a retornar
     * @param int $offset Desplazamiento desde el inicio (opcional, por defecto 0)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function limit(int $limit, int $offset = 0): QueryBuilder{
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }


    /** Configura la consulta para contar filas
     * 
     * @param string|array $options Funciones de agragegado, si es un string se separan por pipe |
     * @param string|array $fields campos sobre los que aplicar las funciones, si es un string se separan por pipe |
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function total(
        string|array $options = ['COUNT'], 
        string|array $fields  = ['*']
    ): QueryBuilder{

        if(gettype($options) == 'string')
            $options = explode('|', $options); 

        if(gettype($fields) == 'string')
            $fields = explode('|', $fields);

        for($i = 0; $i < count($options); $i++){
            $fieldName = trim($fields[$i]) == '*' ? 'all' : $fields[$i];
            $this->fields[] = "{$options[$i]}({$fields[$i]}) AS ".snakeToCamelCase($fieldName).ucfirst(strtolower($options[$i]));
        }
        return $this;
    }

    
    /** Configura la consulta para agrupar resultados
     * 
     * @param array $group grupos
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function group(
        string|array $group  = []
    ): QueryBuilder{
        $this->group[] = $group;
        return $this;
    }   


    /** Añade varios grupos a la consulta
     * 
     * @param array $groups Array de nombres de grupos
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function groups(array $groups): QueryBuilder{
        foreach($groups as $group){
            $this->group($group);
        }
        return $this;
    }

        
    // TODO: having
    
    // TODO: JOINS

    
    /** Genera la consulta SQL completa
     * 
     * @return string La consulta SQL generada
    */
    public function getSQL(): string{
        $sql = '';

        switch($this->type){
            case self::SELECT:
                $fields = empty($this->fields) ? '*' : implode(', ', $this->fields);
                $sql = "SELECT $fields FROM {$this->table}";
                break;

            case self::INSERT:
                $fields = implode(', ', $this->fields);
                $placeholders = rtrim(str_repeat('?, ', count($this->fields)), ', ');
                $sql = "INSERT INTO {$this->table} ($fields) VALUES ($placeholders)";
                break;

            case self::UPDATE:
                $setClauses = [];
                foreach($this->fields as $field){
                    $setClauses[] = "$field = ?";
                }
                $setString = implode(', ', $setClauses);
                $sql = "UPDATE {$this->table} SET $setString";
                break;

            case self::DELETE:
                $sql = "DELETE FROM {$this->table}";
                break;

            case self::CALL:
                $placeholders = rtrim(str_repeat('?, ', count($this->fields)), ', ');
                $sql = "CALL {$this->table}($placeholders)";    
        }

        if(!empty($this->where)){
            $whereClause = implode(' AND ', $this->where);
            $sql .= " WHERE $whereClause";
        }

        if(!empty($this->group)){
            $groupClause = implode(', ', $this->group);
            $sql .= " GROUP BY $groupClause";
        }

        if(!empty($this->order)){
            $orderClause = implode(', ', $this->order);
            $sql .= " ORDER BY $orderClause";
        }

        if($this->limit > 0){
            $sql .= " LIMIT {$this->limit}";
            if(isset($this->offset)){
                $sql .= " OFFSET {$this->offset}";
            }
        }

        return $sql;
    }

    
    // ---------------------------------------------------------------------------
    // PREPARACIÓN DE LA SENTENCIA, VINCULACIÓN DE PARÁMETROS Y EJECUCIÓN 
    // --------------------------------------------------------------------------- 
     
    
    /** Prepara la consulta SQL
     * 
     * Si se le pasa una instancia de PDO, la anterior es reemplazada (si la hubiera)
     * 
     * @param PDO $pdo Conexión PDO
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function prepare(?PDO $pdo = null): QueryBuilder{
        $stm = $pdo ? 
            $pdo->prepare($this->getSQL()) : 
            $this->pdo->prepare($this->getSQL());

        $this->pdoStatement = $stm;
        return $this;
    }


    /** Vincula los parámetros a la sentencia preparada
     * 
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function bindParams(): QueryBuilder{
        foreach($this->values as $index => $value){
            switch(gettype($value)){
                case 'NULL':
                    $paramType = PDO::PARAM_NULL;
                    break;
                case 'boolean':
                    $paramType = PDO::PARAM_BOOL;
                    break;
                case 'integer':
                    $paramType = PDO::PARAM_INT;
                    break;
                case 'double': // para float se trata como cadena
                case 'string':
                default:
                    $paramType = PDO::PARAM_STR;
            }
            $this->pdoStatement->bindValue($index + 1, $value, $paramType);
        }
        return $this;
    }

    
    /** Ejecuta la consulta preparada
     * 
     * @return PDOStatement La sentencia ejecutada
    */
    public function execute(): PDOStatement{
        $this->pdoStatement->execute();
        return $this->pdoStatement;
    }


    // FORMAS ABREVIADAS DE PREPARACIÓN Y EJECUCIÓN
    /** Prepara y ejecuta la consulta con los parámetros vinculados
     * 
     * @return PDOStatement La sentencia ejecutada
    */
    public function executeWithBindings(): PDOStatement{
        $this->pdoStatement->execute($this->values);
        return $this->pdoStatement;
    }

    
    /** Prepara y ejecuta la consulta en un solo paso
     * 
     * Si se le pasa una instancia de PDO, la anterior es reemplazada (si la hubiera)
     * 
     * @param PDO|null $pdo Conexión PDO (opcional si ya está establecida)
     * @return PDOStatement La sentencia ejecutada
    */
    public function get(?PDO $pdo = null): PDOStatement{
        return $this->prepare($pdo ?? $this->pdo)->executeWithBindings();
    }
    
    
    /** Prepara y ejecuta consultas de INSERCION en un solo paso
     *
     * Si se le pasa una instancia de PDO, la anterior es reemplazada (si la hubiera)
     *
     * @param PDO|null $pdo Conexión PDO (opcional si ya está establecida)
     * @return int el identificador autonumérico asignado en la base de datos
     */
    public function store(?PDO $pdo = null): int{
        $this->prepare($pdo ?? $this->pdo)->executeWithBindings();
        return $this->pdo->lastInsertId();
    }
    
    
    /** Prepara y ejecuta consultas de ACTUALIZACION en un solo paso
     *
     * Si se le pasa una instancia de PDO, la anterior es reemplazada (si la hubiera)
     *
     * @param PDO|null $pdo Conexión PDO (opcional si ya está establecida)
     * @return int el número de filas afectadas
     */
    public function edit(?PDO $pdo = null): int{
        return $this->prepare($pdo ?? $this->pdo)->executeWithBindings()->rowCount();
    }
    
    
    /** Prepara y ejecuta consultas de BORRADO en un solo paso
     *
     * Si se le pasa una instancia de PDO, la anterior es reemplazada (si la hubiera)
     *
     * @param PDO|null $pdo Conexión PDO (opcional si ya está establecida)
     * @return int el número de filas afectadas
     */
    public function destroy(?PDO $pdo = null): int{
        return $this->prepare($pdo ?? $this->pdo)->executeWithBindings()->rowCount();
    }

    
    
    // ---------------------------------------------------------------------------
    // MAPEO DE DATOS POST-EJECUCIÓN
    // ---------------------------------------------------------------------------
    
    
    /**
     * Mapea los resultados de PDOStatement a un objeto del tipo deseado
     *
     * @param string $className tipo deseado, por defecto stdClass
     *
     * @return ?object
     */
    public function fetch(string $className = 'stdClass'):?object{
        return $this->pdoStatement->fetchObject($className) ?: null;
    }
    
    
    
    /**
     * Mapea los resultados de PDOStatement a un array de objetos del tipo deseado
     * 
     * @param string $className tipo deseado, por defecto stdClass
     * 
     * @return array
     */
    public function fetchAll(string $className = 'stdClass'):array{
        return $this->pdoStatement->fetchAll(PDO::FETCH_CLASS, $className);
    }
    
        
    
    /**
     * Hace todos los pasos y recupera el resultado a modo de objeto del tipo deseado.
     * 
     * Ideal para consultas de recuperación de datos (SELECT) con uno o cero resultados.
     *
     * @param string $className (opcional) tipo deseado, por defecto stdClass
     * @param PDO $pdo (opcional) instancia de PDO a usar
     *
     * @return ?object
     */
    public function getAndFetch(
        string $className = 'stdClass', 
        ?PDO $pdo = null
    ):?object{
        return $this->get($pdo)->fetchObject($className) ?: null;
    }
    
    
    
    /**
     * Hace todos los pasos y recupera el resultado a modo de objeto del tipo deseado.
     *
     * Ideal para consultas de recuperación de datos (SELECT) con uno o cero resultados.
     *
     * @param string $className (opcional) tipo deseado, por defecto stdClass
     * @param PDO $pdo (opcional) instancia de PDO a usar
     *
     * @return ?object
     */
    public function getAndFetchAll(
        string $className = 'stdClass',
        ?PDO $pdo = null
    ):array{
        return $this->get($pdo)->fetchAll(PDO::FETCH_CLASS, $className);
    }
    
    
    // ---------------------------------------------------------------------------
    // OTROS MÉTODOS
    // ---------------------------------------------------------------------------
 
    
    /** Convierte la consulta a una cadena SQL
     * 
     * @return string La consulta SQL generada
    */
    public function __toString(): string{
        return $this->getSQL();
    }
}