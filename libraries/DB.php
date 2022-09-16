<?php
     
    /* Clase DB que trabaja con mysqli
     * 
     * Simplifica la tarea de conexión y realización de consultas con la BDD
     * 
     * autor: Robert Sallent
     * última revisión: 11/05/2022 (v.22.05)
     * 
     */
    
    class DB{ 
        // Propiedad que guardará la conexión con BDD (objeto mysqli)  
        private static $conexion = null; 
          
        // Método que conecta o recupera la conexión con la BDD
        public static function get():mysqli{
            
            // si no estábamos conectados a la base de datos...
            if(!self::$conexion){ 
                // conecta a la BDD. En PHP>=8.1 si algo falla se lanza una excepción 
                self::$conexion = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
    
                // por compatibilidad con versiones PHP<8.1, que no lanzan excepciones
                if(self::$conexion->connect_errno)
                    throw new Exception("Conexión fallida: ".$conexion->connect_error);
    
                // si todo fue bien, establece el charset
                self::$conexion->set_charset(DB_CHARSET); 
            }
            return self::$conexion; // retorna la conexión 
        } 
        
        
        // método que realiza la consulta a la BDD y evalúa si se produjeron errores
        // en PHP>=8.1, mysqli::query() también lanza excepciones si algo falla
        public static function query(string $consulta){
            try{
                // recupera la conexión y realiza la consulta
                $resultado = self::get()->query($consulta);
                
                // por compatibilidad con PHP<8.1 que no lanza excepciones si algo falla
                if($resultado === false) throw new Exception();
                
                return $resultado; // si todo fue bien, retorna el resultado de la consulta
                
            // si algo falla, pillamos la excepción y lanzamos otra con info personalizada
            }catch(Exception $e){
                if(DEBUG){
                    // error detallado (muestra la consulta y el mensaje que viene de la BDD)
                    $mensaje = "ERROR EN LA OPERACIÓN: "; 
                    $mensaje .= "<b>$consulta</b> ";    // mostrará la consulta
                    $mensaje .= self::get()->error;     // mostrará el error mysqli
                    throw new Exception($mensaje);
                }else
                    // muestra un error genérico (para no mostrar detalles en producción)
                    throw new Exception('ERROR al realizar la operación.');
            }
        }
                
        // Método para realizar consultas SELECT de un solo resultado
        public static function select(string $consulta, string $class='stdClass'){
           
            $resultado = self::query($consulta); // lanza la consulta
            
            // si todo fue bien...
            $objeto = $resultado->fetch_object($class); // convertir el resultado a objeto
            $resultado->free();                         // liberar memoria
            return $objeto;                             // retorna el objeto recuperado (o null)
        }
        
        
        // Método para realizar consultas SELECT de múltiples resultados
        public static function selectAll(string $consulta, string $class='stdClass'):array{
           
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
               
        // Método para realizar consultas INSERT
        // retorna el valor del ID autonumérico asignado en la BDD
        public static function insert(string $consulta):int{
            self::query($consulta);         // ejecuta la consulta
            return self::get()->insert_id;  // retorna el insert_id
        }
        
        // Método para realizar consultas UPDATE
        // retorna el número de filas afectadas
        public static function update(string $consulta):int{
            self::query($consulta);              // ejecuta la consulta
            return self::get()->affected_rows;   // retorna el número de filas afectadas
        }
        
        // Método para realizar consultas DELETE
        // retorna el número de filas afectadas
        public static function delete(string $consulta):int{
            self::query($consulta);             // ejecuta la consulta
            return self::get()->affected_rows;  // retorna el número de filas afectadas
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
        
        // Método para escapar caracteres especiales
        // evitará ataques mediante SQLInjections (no todos) e inyección de scripts
        // si entities es true, se convertirán los caracteres especiales a entidades
        public static function escape(string $texto, bool $entities = true):string{
            $texto = self::get()->real_escape_string($texto);
            return $entities? htmlspecialchars($texto) : $texto;
        }
    }

    
    