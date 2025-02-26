<?php
     
/** Clase DBPDO
 * 
 * Simplifica la tarea de conexión y realización de consultas con la BDD.
 * Utiliza la extensión PDO.
 * 
 * Última revisión: 26/02/2025.
 * 
 * @author Robert Sallent
 * @since v0.1.0
 * @since v1.7.0 la clase DBPDO hereda de la clase abstracta DB
 * @since v1.8.0 nuevo método estático lastErrorMessage()
*/

class DBPDO extends DB{ 
    
    /** @var ?PDO conexión con la Base de Datos. */
    private static $conexion = null;
    
    
    /**
     * Método que conecta con la BDD o recupera la conexión si ya estaba establecida
     * con anterioridad.
     *
     * @throws DatabaseException si no se puede conectar o establecer el charset.
     *
     * @return PDO la conexión con la BDD.
     */
    public static function get():object{
        
        // si no estábamos conectados a la base de datos...
        if(!self::$conexion){ 
            
            //conecta con la BDD, si no puede lanzará una PDOException
            $dsn = SGDB.':host='.DB_HOST.':'.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET;
            try{
                self::$conexion = new PDO($dsn, DB_USER, DB_PASS);
                
            }catch(Throwable $e){
                
                $message = "No se pudo conectar con la Base de datos. ";
                
                if(DEBUG)
                    $message .= "Revisa la configuración: ".$dsn;
                
                throw new DatabaseException($message);
            }
            
        }
        return self::$conexion; // retorna la conexión 
    } 
    
    
    /**
     * Retorna el último mensaje de error producido en la BDD
     * 
     * @return string
     */
    public static function errorMessage():string{
        return self::get()->errorInfo()[2];
    }
    
    
    /**
     * Realiza la consulta a la BDD y evalúa si se produjeron errores.
     * Es compatible con versiones anteriores a PHP 8.1
     *
     * @param string $consulta consulta SQL a realizar contra la BDD.
     *
     * @throws SQLException para versiones anteriores a PHP 8.0
     *
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
                $mensaje = "ERROR EN LA CONSULTA: "; 
                $mensaje .= "<p><b>$consulta</b></p>";    // mostrará la consulta
                $mensaje .= "<p>".(self::get()->errorInfo()[2])."</p>";  // mostrará el mensaje de error
                throw new SQLException($mensaje);
            }else
                // muestra un error genérico (para no mostrar detalles en producción)
                throw new SQLException('ERROR al realizar la operación.');
        }
    }
            
    
    
    /**
     * Método para realizar consultas SELECT que recuperan como máximo un resultado.
     *
     * @param string $consulta consulta SQL a realizar.
     * @param string $class tipo de entidad que queremos recuperar.
     *
     * @throws SQLException si se produce un error en la consulta.
     * @return object|NULL la entidad recuperada o NULL si no se encontró.
     */
    public static function select(
        string $consulta, 
        string $class='stdClass'
    ):?object{
        
        $resultado = self::query($consulta); // lanza la consulta

        $objeto = $resultado->fetchObject($class); // convertir el resultado a objeto
        
        return $objeto === false ? NULL : $objeto; // retorna el objeto (o null)
    }
    
    
    /**
     * Realiza consultas que pueden retornar múltiples resultados y retorna un array
     * con las entidades del tipo deseado.
     *
     * @param string $consulta consulta SQL a realizar.
     * @param string $class tipo de entidad que queremos recuperar.
     *
     * @return array lista de resultados
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
        
        return $objetos;     // retornamos el resultado
    }
           
    
    
    /**
     * Para realizar consultas de inserción.
     *
     * @param string $consulta consulta SQL a realizar.
     *
     * @return int id autonumérico asignado en la base de datos.
     */
    public static function insert(string $consulta):int{
        self::query($consulta);         // ejecuta la consulta
        return self::get()->lastInsertId(); // retorna el id
    }
    
    
    
    /**
     * Para realizar consultas de actualización.
     *
     * @param string $consulta consulta SQL a realizar.
     *
     * @return int número de filas afectadas en la operación.
     */
    public static function update(string $consulta):int{
        $statement = self::query($consulta);              // ejecuta la consulta
        return $statement->rowCount();   // retorna el número de filas afectadas
    }
    
    
    
    /**
     * Para realizar consultas de borrado.
     *
     * @param string $consulta consulta SQL a realizar.
     *
     * @return int número de filas afectadas en la operación.
     */
    public static function delete(string $consulta):int{
        $statement = self::query($consulta);             // ejecuta la consulta
        return $statement->rowCount();  // retorna el número de filas afectadas
    }
        
   

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


