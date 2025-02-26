<?php
     
/** Clase DBMysqli
 * 
 * Simplifica la tarea de conexión y realización de consultas con la BDD 
 * mediante la extensión mysqli.
 * 
 * Última revisión: 26/02/2025.
 * 
 * @author Robert Sallent
 * @since v0.1.0
 * @since v1.7.0 cambia de nombre de DB a DBMysqli y hereda de la clase abastracta DB
 * @since v1.8.0 nuevo método estático lastErrorMessage()
 */
    
class DBMysqli extends DB{ 
      
    /** @var ?mysqli conexión con la Base de Datos. */
    private static $conexion = null;
    
    /**
     * Método que conecta con la BDD o recupera la conexión si ya estaba establecida
     * con anterioridad.
     * 
     * @throws DatabaseException si no se puede conectar o establecer el charset.
     * 
     * @return mysqli la conexión con la BDD.
     */
    public static function get():object{

        // si no estábamos conectados a la base de datos...
        if(!self::$conexion){ 
            
            try{
                // conecta a la BDD. En PHP>=8.1 si algo falla se lanza una excepción 
                self::$conexion = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT); 
                
                // por compatibilidad con versiones PHP<8.1, que no lanzan excepciones
                if(self::$conexion->connect_errno)
                    throw new DatabaseException("Conexión fallida: ".(self::$conexion->connect_error));
           
            }catch(Throwable $e){
                
                $message = "No se pudo conectar con la Base de datos. ";
                
                if(DEBUG)
                    $message .= "Revisa la configuración: ".DB_HOST.', '.DB_USER.', *******, '.DB_NAME.', '.DB_PORT;
                    
                throw new DatabaseException($message);
            }
            
            try{
                
                // establece el charset (el if es por compatibilidad con PHP<8.1)
                if(!self::$conexion->set_charset(DB_CHARSET))
                    throw new DatabaseException("No se pudo establecer el charset ".DB_CHARSET.", comprueba que está correctamente escrito."); 
                
            }catch(Throwable $e){
                
                throw new DatabaseException("No se pudo establecer el charset ".DB_CHARSET.", comprueba que está correctamente escrito.");
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
        return self::get()->error;
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

            // por compatibilidad con PHP<8.1 que no lanza excepciones si algo falla
            if($resultado === false) 
                throw new SQLException();
            
            return $resultado; // si todo fue bien, retorna el resultado de la consulta
            
        // si algo falla, pillamos la excepción y lanzamos otra con info personalizada
        }catch(Throwable $e){
            
            if(DEBUG){
                // error detallado (muestra la consulta y el mensaje que viene de la BDD)
                $mensaje = "<p>ERROR EN LA CONSULTA:</p>"; 
                $mensaje .= "<p><b>$consulta</b></p>";           // mostrará la consulta
                $mensaje .= "<p>".self::get()->error."</p>";     // mostrará el error mysqli
                throw new SQLException($mensaje);
            }else
                // muestra un error genérico (para no mostrar detalles en producción)
                throw new SQLException('ERROR al realizar la operación sobre la base de datos.');
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
        string $class = 'stdClass'
    ):?object{
        $resultado = self::query($consulta); // lanza la consulta
        
        if($resultado->num_rows > 1)
            throw new SQLException("El método select() o selectOne() solamente se debe usar para consultas con un único resultado.");
        
        // si todo fue bien...
        $objeto = $resultado->fetch_object($class); // convertir el resultado a objeto

        $resultado->free();                         // liberar memoria
        return $objeto;                             // retorna el objeto recuperado (o null)
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
       
        // lanza la consulta
        $resultados = self::query($consulta);
        
        // si todo fue bien...
        $objetos = []; // preparamos un array 
        
        // convertimos cada resultado a un objeto y lo metemos en el array
        while($r = $resultados->fetch_object($class))
            $objetos[] = $r;
        
        $resultados->free(); // liberamos memoria
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
        return self::get()->insert_id;  // retorna el insert_id
    }

    
    
    /**
     * Para realizar consultas de actualización.
     * 
     * @param string $consulta consulta SQL a realizar.
     * 
     * @return int número de filas afectadas en la operación.
     */
    public static function update(string $consulta):int{
        self::query($consulta);              // ejecuta la consulta
        return self::get()->affected_rows;   // retorna el número de filas afectadas
    }
    
    
    
    /**
     * Para realizar consultas de borrado.
     * 
     * @param string $consulta consulta SQL a realizar.
     * 
     * @return int número de filas afectadas en la operación.
     */
    public static function delete(string $consulta):int{
        self::query($consulta);             // ejecuta la consulta
        return self::get()->affected_rows;  // retorna el número de filas afectadas
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
        
        $texto = self::get()->real_escape_string($texto);
        return $entities? htmlspecialchars($texto) : $texto;
    }
}
  