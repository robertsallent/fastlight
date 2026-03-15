<?php
     
/** Clase DB
 * 
 * Simplifica la tarea de conexión y realización de consultas con la BDD.
 * Utiliza la extensión PDO y recupera la configuración indicada en el fichero config.php.
 * 
 * Última revisión: 10/03/2026.
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.4.0 renovación de las clases DB
*/

class DB{ 
    
    /** @var ?PDO conexión con la Base de Datos. */
    protected static ?PDO $connection = null; 
       
    
    /**
     * Getter para la propiedad connection.
     *
     * @return ?PDO conexión con la base de datos
     */
    public static function getConnection():?PDO{
        return self::$connection;
    }
    
    
    /**
     * Método que conecta con la BDD o recupera la conexión si ya estaba establecida
     * con anterioridad.
     *
     * @throws DatabaseException si no se puede conectar o establecer el charset.
     * @return PDO la conexión con la BDD.
     */
    public static function get():PDO{
        
        // si no estábamos conectados a la base de datos...
        if(!self::$connection){ 
            
            //conecta con la BDD, si no puede lanzará una PDOException
            $dsn = SGDB.':host='.DB_HOST.':'.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET;
            try{
                self::$connection = new PDO($dsn, DB_USER, DB_PASS);
                
            }catch(Throwable $e){
                
                $message = "No se pudo conectar con la Base de datos. ";
                
                if(DEBUG)
                    $message .= "Revisa la configuración.
                                <br><b>DSN:</b>: $dsn
                                <br><b>USER:</b>: ".DB_USER."
                                <br><b>PASS:</b>: -- hidden --";
                
                throw new ConnectionException($message);
            }           
        }
        return self::$connection; // retorna la conexión 
    } 
    
    
    /**
     * Retorna el último mensaje de error producido en la BDD
     * 
     * @return ?string
     */
    public static function errorMessage():?string{
        return self::get()->errorInfo()[2];
    }
    
    // -------------------------------------------------------------
    // MÉTODOS QUE NO USAN SENTENCIAS PREPARADAS NI EL QUERY BUILDER
    // -------------------------------------------------------------
    
    /**
     * Realiza la consulta a la BDD y evalúa si se produjeron errores.
     * Es compatible con versiones anteriores a PHP 8.1
     *
     * @param string $consulta consulta SQL a realizar contra la BDD.
     * @throws SQLException si falla la ejecución de la consulta
     * @return mysqli_result|boolean
     */
    public static function query(string $consulta){
        try{
            // recupera la conexión y realiza la consulta
            $resultado = self::get()->query($consulta);
            
            // compatibilidad con PHP<8.1 lanza excepción si algo falla
            if($resultado === false) 
                throw new SQLException();
            
            return $resultado; // si todo fue bien, retorna el resultado de la consulta
            
        // si algo falla, pillamos la excepción y lanzamos otra con info personalizada
        }catch(Throwable $e){
            if(DEBUG){
                // error detallado (muestra la consulta y el mensaje que viene de la BDD)
                $mensaje = "<h3>ERROR EN LA CONSULTA</h3>"; 
                $mensaje .= "<p><b>$consulta</b></p>";    // mostrará la consulta
                $mensaje .= "<p>".(self::get()->errorInfo()[2])."</p>";  // mostrará el mensaje de error
                throw new SQLException($mensaje);
            }else
                // muestra un error genérico (para no mostrar detalles en producción)
                throw new SQLException("Error al realizar la operación sobre la base de datos.");
        }
    }
            
    
    
    /**
     * Método para realizar consultas SELECT que recuperan como máximo un resultado.
     *
     * @param string $consulta consulta SQL a realizar.
     * @param string $class tipo de entidad que queremos recuperar (opcional, por defecto stdClass).
     * @throws SQLException si se produce un error en la consulta.
     * @return ?object la entidad recuperada o NULL si no se encontró.
     */
    public static function select(
        string $consulta, 
        string $class = 'stdClass'
    ):?object{
        
        $resultado = self::query($consulta);        // lanza la consulta
        $objeto = $resultado->fetchObject($class);  // convierte el resultado a objeto
        return $objeto === false ? NULL : $objeto;  // retorna el objeto (o null)
    }
    
    
    /**
     * Realiza consultas que pueden retornar múltiples resultados y retorna un array
     * con las entidades del tipo deseado.
     *
     * @param string $consulta consulta SQL a realizar.
     * @param string $class tipo de entidad que queremos recuperar (opcional, por defecto stdClass).
     * @return array lista de resultados del tipo indicado
     */
    public static function selectAll(
        string $consulta, 
        string $class='stdClass'
    ):array{
        $resultados = self::query($consulta); // lanza la consulta
        $objetos = []; // preparamos un array 
        
        // convertimos cada resultado a un objeto y lo metemos en el array
        while($r = $resultados->fetchObject($class))
            $objetos[] = $r;
        
        return $objetos;
    }
           
    
    
    /**
     * Para realizar consultas de inserción.
     *
     * @param string $consulta consulta SQL a realizar.
     * @return int id autonumérico asignado en la base de datos.
     */
    public static function insert(string $consulta):int{
        self::query($consulta); 
        return self::get()->lastInsertId();
    }
    
    
    
    /**
     * Para realizar consultas de actualización.
     *
     * @param string $consulta consulta SQL a realizar.
     * @return int número de filas afectadas en la operación.
     */
    public static function update(string $consulta):int{
        $statement = self::query($consulta); 
        return $statement->rowCount();
    }
    
    
    
    /**
     * Para realizar consultas de borrado.
     *
     * @param string $consulta consulta SQL a realizar.
     * @return int número de filas afectadas en la operación.
     */
    public static function delete(string $consulta):int{
        $statement = self::query($consulta);
        return $statement->rowCount();                      
    }
        
    
    /**
     * Realiza consultas de totales sobre la tabla deseada.
     *
     * @param string $tabla tabla sobre la que queremos realizar la operación.
     * @param string $operacion operación a realizar.
     * @param string $campo campo sobre el que se realizará la operación.
     * @return mixed el resultado de la operación de total
     */
    public static function total(
        string $tabla,
        string $operacion   = 'COUNT',
        string $campo       = '*'
    ){
        $consulta = "SELECT $operacion($campo) AS total FROM $tabla";
        
        // ejecuta la consulta y retorna el resultado
        return self::select($consulta)->total;
    }
    
    
    /**
     * Realiza una consulta de totales con grupos sobre una sola tabla,
     *
     * Permite realizar operaciones de totales con grupos.
     * Se pueden indicar múltiples grupos y operaciones, pero con la limitación de que
     * se deben realizar sobre una misma tabla. Este método retorna una lista
     * de objetos de tipo stdClass con los campos de agrupado y los campos de totales,
     * que tienen el nombre compuesto en orden operacion y valor en minúsculas,
     * por ejemplo: idcount.
     *
     * @param string $tabla tabla donde realizar la operación
     * @param array $totales array asociativo con el listado de campos y totales, por ejemplo ['id' => 'COUNT'] para contar ID
     * @param array $agruparPor array indexado con la lista de campos para realizar el agrupado.
     * @return array de objetos stdClass con los resultados.
     */
    public static function groupBy(
        string $tabla,
        array $totales      = ['id' => 'COUNT'],
        array $agruparPor   = []
    ):array{
        $consulta = "SELECT ";                  // SELECT
        
        foreach($agruparPor as $grupo)          // SELECT poblacion,
            $consulta .= $grupo.', ';
            
        foreach($totales AS $campo=>$operacion) // SELECT poblacion, COUNT(id) AS idcount,
            $consulta .= strtoupper($operacion)."($campo) AS ".strtolower($campo.$operacion).", ";
            
        $consulta = rtrim($consulta, ', ');     // SELECT poblacion, COUNT(id) AS idcount
        
        $consulta .= " FROM {$tabla} GROUP BY ";  // SELECT poblacion, COUNT(id) AS idcount FROM socios GROUP BY
        
        foreach($agruparPor as $grupo)          // SELECT poblacion, COUNT(id) AS idcount FROM socios GROUP BY poblacion,
            $consulta .= $grupo.', ';
            
        $consulta = rtrim($consulta, ', ');     // SELECT poblacion, COUNT(id) AS idcount FROM socios GROUP BY poblacion
        
        // ejecuta la consulta y retorna el resultado
        return self::selectAll($consulta);
    }
    
    
    // -------------------------------------------------------------
    // MÉTODOS QUE SI USAN SENTENCIAS PREPARADAS Y EL QUERY BUILDER
    // -------------------------------------------------------------
    
    
    /**
     * Retorna una instancia de QueryBuilder que recupera todos los registros de una tabla.
     * 
     * @param string $tableName nombre de la tabla de la BDD que se quiere recuperar
     * @return QueryBuilder instancia de QueryBuilder sobre la que podremos seguir trabajando
     */
    public static function table(
        string $tableName
    ):QueryBuilder{       
        return QueryBuilder::select($tableName, self::$connection);
    }
    
    
    
    // TODO: implementar el resto de métodos que hacen uso del QueryBuilder
    
   
    
    /**
     * Escapa los caracteres especiales de una cadena de texto.
     * Evitará algunos ataques SQLInjections y XSS saneando las entradas.
     *
     * @param string $texto texto a sanear.
     * @param bool $entities convertir caracteres especiales a entidades HTML?
     *
     * @return string la cadena escapada.
     */
    public static function escape(
        string $texto,
        bool $entities = true
    ):string{
        
        $texto = self::get()->quote($texto);
        $texto = trim($texto, '\'');
        return $entities? htmlspecialchars($texto) : $texto;
    }
}


