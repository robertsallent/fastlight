<?php
     
/* Clase DBPDO que trabaja con PDO
 * 
 * Simplifica la tarea de conexión y realización de consultas con la BDD
 * 
 * autor: Robert Sallent
 * última revisión: 04/09/2022
 * 
 */
    
    class DBPDO{ 
        
        // propiedad que guardará la conexión con BDD (objeto PDO)  
        private static $conexion = null; 
          
        // método que conecta o recupera la conexión con la BDD
        public static function get():PDO{
            
            // si no estábamos conectados a la base de datos...
            if(!self::$conexion){ 
                
                //conecta con la BDD, si no puede lanzará una PDOException
                $dsn=SGDB.':host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET;
                self::$conexion = new PDO($dsn, DB_USER, DB_PASS);
                
            }
            return self::$conexion; // retorna la conexión 
        } 
        
        
        // método que realiza la consulta a la BDD y evalúa si se produjeron errores
        public static function query(string $consulta){
            try{
                // recupera la conexión y realiza la consulta
                $resultado = self::get()->query($consulta);
                
                // lanza excepción si algo falla
                if($resultado === false) throw new Exception();
                
                return $resultado; // si todo fue bien, retorna el resultado de la consulta
                
            // si algo falla, pillamos la excepción y lanzamos otra con info personalizada
            }catch(Exception $e){
                if(DEBUG){
                    // error detallado (muestra la consulta y el mensaje que viene de la BDD)
                    $mensaje = "ERROR EN LA OPERACIÓN: "; 
                    $mensaje .= "<b>$consulta</b> ";    // mostrará la consulta
                    $mensaje .= self::get()->errorInfo()[2];  // mostrará el mensaje de error
                    throw new Exception($mensaje);
                }else
                    // muestra un error genérico (para no mostrar detalles en producción)
                    throw new Exception('ERROR al realizar la operación.');
            }
        }
                
        // Método para realizar consultas SELECT de un solo resultado
        public static function select(string $consulta, string $class='stdClass'){
            $resultado = self::query($consulta); // lanza la consulta

            $objeto = $resultado->fetchObject($class); // convertir el resultado a objeto
            return $objeto === false ? null : $objeto; // retorna el objeto (o null)
        }
        
        // Método para realizar consultas SELECT de múltiples resultados
        public static function selectAll(string $consulta, string $class='stdClass'):array{
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
    }

    
    