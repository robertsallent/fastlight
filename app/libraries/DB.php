<?php
     
/** Clase DB
 * 
 * Clase abstracta, de la que deben heredar las clases que implementen los mecanismos
 * de conexión con BDD.
 * 
 * Define como abstractos los métodos que deben ser implementados por las clases
 * herederas, mientras que implementa algunos métodos comunes, que pueden ser
 * útiles en las subclases.
 * 
 * Última revisión: 26/02/2025.
 * 
 * @author Robert Sallent
 * @since v0.1.0
 * @since v1.7.0 la clase DB ahora es abstracta y se ha trasladado su código anterior a la clase DBMysqli
 */
    
abstract class DB{ 
    
    /** @var ?object conexión con la Base de Datos. */
    private static $conexion = null; 
      
    
    // MÉTODOS ABSTRACTOS
    // deben ser implementados por las clases hijas, para garantizar que podemos
    // sustituir una por otra y que todo siga funcionando correctamente.
    
    /** Establece o recupera la conexión*/
    public abstract static function get():object;
    
    /** Recupera el último mensaje de error*/
    public abstract static function errorMessage():string;
      
    /** Realiza la consulta a la BDD y evalúa si se produjeron errores. */
    public abstract static function query(string $consulta);
            
    /** Método para realizar consultas SELECT que recuperan como máximo un resultado.  */
    public abstract static function select(string $consulta, string $class = 'stdClass'):?object;    
    
    /** Para consultas SELECT con múltiples resultados */
    public abstract static function selectAll(string $consulta, string $class='stdClass'):array;
    
    /** Consultas INSERT */
    public abstract static function insert(string $consulta):int;
    
    /** Consultas UPDATE */
    public abstract static function update(string $consulta):int;
    
    /** Consultas DELETE */
    public abstract static function delete(string $consulta):int;
    
    /** Saneamiento de entradas */
    public abstract static function escape(string $texto, bool $entities = true):string;

    
    // MÉTODOS COMUNES PARA SER HEREDADOS
    // son métodos que tienen implementaciones idénticas para Mysqli o PDO.
    
    /**
     * Realiza consultas de totales sobre la tabla deseada.
     *
     * @param string $tabla tabla sobre la que queremos realizar la operación.
     * @param string $operacion operación a realizar.
     * @param string $campo campo sobre el que se realizará la operación.
     *
     * @return mixed el resultado de la operación de total
     */
    public static function total(
        string $tabla,
        string $operacion   = 'COUNT',
        string $campo       = '*'
    ){
        $consulta = "SELECT $operacion($campo) AS total FROM $tabla";
        return get_called_class()::select($consulta)->total;
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
     *
     * @return array de objetos stdClass con los resultados.
     */
    public static function groupBy(
        string $tabla,
        array $totales = ['id' => 'COUNT'],
        array $agruparPor  = []
    ):array{
        $consulta = "SELECT ";                  // SELECT 
        
        foreach($agruparPor as $grupo)          // SELECT poblacion, 
            $consulta .= $grupo.', ';
            
        foreach($totales AS $campo=>$operacion) // SELECT poblacion, COUNT(id) AS idcount, 
            $consulta .= strtoupper($operacion)."($campo) AS ".strtolower($campo.$operacion).", ";
        
        $consulta = rtrim($consulta, ', ');     // SELECT poblacion, COUNT(id) AS idcount
        
        $consulta .= " FROM $tabla GROUP BY ";  // SELECT poblacion, COUNT(id) AS idcount FROM socios GROUP BY
        
        foreach($agruparPor as $grupo)          // SELECT poblacion, COUNT(id) AS idcount FROM socios GROUP BY poblacion, 
            $consulta .= $grupo.', ';
            
        $consulta = rtrim($consulta, ', ');     // SELECT poblacion, COUNT(id) AS idcount FROM socios GROUP BY poblacion
                
        return get_called_class()::selectAll($consulta);
    }
    
    
    /** 
     * Alias de select()
     * 
     * @deprecated since v1.7.0
     * 
     * @param string $consulta consulta SQL a realizar.
     * @param string $class tipo de entidad que queremos recuperar.
     * 
     * @return object|NULL la entidad recuperada o NULL si no se encontró.
     */
    public static function selectOne(
        string $consulta, 
        string $class = 'stdClass'
    ):?object{
        return get_called_class()::select($consulta, $class);
    }
}

    
    