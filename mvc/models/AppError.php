<?php

/** 
 * Clase AppError.
 *
 * Modelo responsable de guardar los errores en base de datos.
 *
 * @author: Robert Sallent <robert@juegayestudia.com>
 * 
 * Última revisión: 16/04/2024
 */

#[\AllowDynamicProperties]
class AppError extends Model{
    
    /** @var string $table nombre de la tabla en la base de datos */ 
    protected static string $table = ERROR_DB_TABLE;
    
    /**
     * Permite crear un nuevo objeto AppError y guardarlo en base de datos.
     * 
     * @static  
     * @param string $level     nivel de severidad o tipo de error
     * @param string $message   mensaje
     * @return void
     */
    public static function new(
        string $level = 'Error', 
        string $message = ''     
    ){
        $error = new self();
        
        $error->level = $level;
        $error->url = $_SERVER['REQUEST_URI'];
        $error->message = (DB_CLASS)::escape($message);
        $error->user = Login::user() ? Login::user()->email : NULL;
        $error->ip = $_SERVER['REMOTE_ADDR'];
        
        // guarda el error en base de datos
        $error->save();
    }    
    
    /**
     * Vacía la tabla de errores en la base de datos.
     *
     * @return int número de errores borrados.
     */
    public static function clear():int{
        return (DB_CLASS)::delete("DELETE FROM ".ERROR_DB_TABLE);
    }
    
    /**
     * Elmina los últimos errores.
     * 
     * @param int $limit número de errores a eliminar.
     * 
     * @return int número de errores que ha podido eliminar.
     */
    public static function clearLast(int $limit = 1):int{
        
        $query = "SELECT * FROM ".ERROR_DB_TABLE." ORDER BY id DESC LIMIT $limit";    
        $errors = (DB_CLASS)::selectAll($query, self::class);

        foreach($errors as $error)
            $error->deleteObject();

        return sizeof($errors);
    }
}




