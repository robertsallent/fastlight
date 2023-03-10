<?php
     
/* Clase DBPDO que trabaja con PDO
 * 
 * Simplifica la tarea de conexión y realización de consultas con la BDD
 * 
 * autor: Robert Sallent
 * última revisión: 08/03/2023
 * 
 */
    
    class DBPDO implements DatabaseConnection{ 
        
        // propiedad que guardará la conexión con BDD (objeto PDO)  
        private static $conexion = null; 
          
        // método que conecta o recupera la conexión con la BDD
        public static function get():PDO{
            
            // si no estábamos conectados a la base de datos...
            if(!self::$conexion){ 
                
                //conecta con la BDD, si no puede lanzará una PDOException
                $dsn = SGDB.':host='.DB_HOST.':'.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHARSET;
                self::$conexion = new PDO($dsn, DB_USER, DB_PASS);
                
            }
            return self::$conexion; // retorna la conexión 
        } 
        
        
        // método que realiza la consulta a la BDD y evalúa si se produjeron errores
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
                
        // Método para realizar consultas SELECT de un solo resultado
        public static function select(
            string $consulta, 
            string $class='stdClass'
        ):?object{
            
            $resultado = self::query($consulta); // lanza la consulta

            $objeto = $resultado->fetchObject($class); // convertir el resultado a objeto
            
            return $objeto === false ? NULL : $objeto; // retorna el objeto (o null)
        }
        
        
        // alias de select()
        public static function selectOne(
            string $consulta,
            string $class='stdClass'
        ):?object{
            return self::select($consulta);
        }
        
        
        // Método para realizar consultas SELECT de múltiples resultados
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
               
        // Método para realizar consultas INSERT
        // retorna el valor del ID autonumérico asignado en la BDD
        public static function insert(string $consulta):int{
            self::query($consulta);         // ejecuta la consulta
            return self::get()->lastInsertId(); // retorna el id
        }
        
        // Método para realizar consultas UPDATE
        // retorna el número de filas afectadas
        public static function update(string $consulta):int{
            $statement = self::query($consulta);              // ejecuta la consulta
            return $statement->rowCount();   // retorna el número de filas afectadas
        }
        
        // Método para realizar consultas DELETE
        // retorna el número de filas afectadas
        public static function delete(string $consulta):int{
            $statement = self::query($consulta);             // ejecuta la consulta
            return $statement->rowCount();  // retorna el número de filas afectadas
        }
            
        // Método que ejecuta una consulta de totales sobre la tabla deseada
        public static function total(
                string $tabla, 
                string $operacion='COUNT',
                string $campo='*'
        ){
            $consulta = "SELECT $operacion($campo) AS total FROM $tabla";
            return self::select($consulta)->total;
        }
        
        
        // escapa los caracteres especiales
        public static function escape(
            string $texto,
            bool $entities = true
        ):string{
            
            $texto = self::get()->quote($texto);
            $texto = trim($texto, '\'');
            return $entities? htmlspecialchars($texto) : $texto;
        }
    }

    
    