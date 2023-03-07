<?php
/**
 * FICHERO: /libraries/DBPS.php
 * CLASE: DBPS
 *
 * DESCRIPCION
 * Clase que simplifica la conexión con la BDD mediante PDO.
 * Realiza las consultas mediante sentencias preparadas
 * Conecta a partir de la configuración del fichero Config.php.
 *
 *  DEPENDENCIAS
 * - libraries/DBPDO.php
 * - app/config/Config.php
 *
 * @author Robert Sallent
 * @version 2019_11_07
 *
 */

    // CLASE DBPS QUE USA PDO con sentencias preparadas
    class DBPS extends DBPDO{ 
        
        //Método privado usado para ejecutar las sentencias preparadas.
        //Retorna el objeto PDOStatement tras preparar, vincular y ejecutar        
        private static function executeStatement(
                string $consulta, array $bindings=[]):PDOStatement{
            
            $stm=self::get()->prepare($consulta); //prepara la sentencia
            
            //vincula los parámetros
            for($i=0; $i<sizeof($bindings); $i++)
                $stm->bindParam($i+1, $bindings[$i]);
            
            $stm->execute(); //ejecuta la sentencia
            return $stm; //retorna el objeto PDOStatement
        }
               
        //Método para realizar consultas SELECT que retornan una fila
        public static function select(
                string $consulta, string $class='stdClass', array $bindings=[]){
            
            $stm = self::executeStatement($consulta, $bindings);
            return $stm->rowCount()? $stm->fetchObject($class): null;
        }
        
        //Método para realizar consultas SELECT que retornan múltiples filas
        public static function selectAll(
                string $consulta, string $class='stdClass', array $bindings=[]):array{
            
            $stm = self::executeStatement($consulta, $bindings);
            
            //procesa los resultados, preparando el array de objetos
            $objetos=[];
            while($r=$stm->fetchObject($class))
                $objetos[]=$r;
            
            return $objetos;
        }
        
        //Método para realizar consultas INSERT
        //retorna el id del último objeto insertado o false si falla
        public static function insert(string $consulta, array $bindings=[]){            
            self::executeStatement($consulta, $bindings);
            return self::get()->lastInsertId();
        }     
        //Método para realizar consultas UPDATE
        //retorna el número de filas afectadas, o false si falla
        public static function update(string $consulta, array $bindings=[]){
            $stm = self::executeStatement($consulta, $bindings);
            return $stm? $stm->rowCount(): false;
        }
        //Método para realizar consultas DELETE
        //retorna el número de filas afectadas, o false si falla
        public static function delete(string $consulta, array $bindings=[]){
            $stm = self::executeStatement($consulta, $bindings);
            return $stm? $stm->rowCount(): false;
        }
    }
    
    
    