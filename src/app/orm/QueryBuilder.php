<?php

/**
 * Clase para construir y ejecutar consultas SQL mediante PDO y sentencias preparadas.
 * 
 * Permite crear consultas SELECT, INSERT, UPDATE, DELETE y CALL con parámetros.
 * Facilita la construcción de consultas complejas con cláusulas WHERE, ORDER BY y LIMIT.  
 * 
 * @author 
 * @author Robert Sallent
 * 
 */
class QueryBuilder{
    
    /* Tipos de consulta soportados */
    const SELECT        = 1; 
    const INSERT        = 2;
    const UPDATE        = 3;  
    const DELETE        = 4;
    const CALL          = 5;
    
    /** @var int $type Tipo de consulta (SELECT, INSERT, UPDATE, DELETE, CALL) */
    public int $type     = self::SELECT;

    /** @var string $table Nombre de la tabla o procedimiento almacenado */
    public string $table = ''; 
    
    /** @var array $fields Campos a seleccionar o modificar */
    public array $fields = [];

    /** @var array $values Valores para los campos o parámetros */
    public array $values = [];
    
    /** @var array $where Condiciones WHERE */
    public array $where  = [];

    /** @var array $groups Grupos para el GROUP BY */
    public array $group = [];

    /** @var array $order Cláusulas ORDER BY */
    public array $order  = [];

    /** @var int $limit Límite de filas a retornar */
    public int $limit    = 0; 

    /** @var int $offset Desplazamiento para el límite */
    public int $offset   = 0;

    /** @var PDOStatement|null $pdoStatement Sentencia preparada */
    private ?PDOStatement $pdoStatement   = null;

    /** @var PDO|null $pdo Conexión PDO */
    private ?PDO $pdo = null;



    // CONSTRUCTOR
    /** Constructor de la clase 
     * 
     * @param int $type tipo de consulta
     * @param sring $table tabla sobre la que ejecutar la consulta
     * @param PDO|null $pdo conexión PDO (opcional)
    */
    public function __construct(int $type, string $table, ?PDO $pdo = null){
        $this->type = $type;
        $this->table = $table;
        $this->pdo = $pdo;
    }



    // SETTERS Y GETTERS

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



    // MÉTODOS PARA CONSTRUIR LA CONSULTA

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

    /** Añade una condición WHERE a la consulta
     * 
     * @param string $condition Condición SQL (puede incluir ? para parámetros)
     * @param mixed|null $value Valor para el parámetro (opcional)
     * @return QueryBuilder La instancia actual para encadenamiento
    */
    public function where(string $condition, $value = null): QueryBuilder{
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
                $this->fields[] = "{$options[$i]}({$fields[$i]}) AS ".strtolower("{$options[$i]}{$fields[$i]}");
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

    
    // PREPARACIÓN Y EJECUCIÓN DE LA CONSULTA
    /** Prepara la consulta SQL
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
     * @param PDO|null $pdo Conexión PDO (opcional si ya está establecida)
     * @return PDOStatement La sentencia ejecutada
    */
    public function get(?PDO $pdo = null): PDOStatement{
        return $this->prepare($pdo ?? $this->pdo)->executeWithBindings();
    }

    
    /** Convierte la consulta a una cadena SQL
     * 
     * @return string La consulta SQL generada
    */
    public function __toString(): string{
        return $this->getSQL();
    }
}