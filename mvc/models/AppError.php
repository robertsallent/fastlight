<?php

/** 
 * Clase AppError.
 *
 * Modelo responsable de guardar los errores en base de datos.
 *
 * @author: Robert Sallent <robert@juegayestudia.com>
 * 
 * Última revisión: 12/12/2024
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
     * 
     * @return void
     */
    public static function new(
        string $level = 'Error', 
        string $message = ''     
    ){
        // crea un nuevo objeto AppError
        $e = new self();
        
        // prepara el nivel y el mensaje de error
        $e->level   = $level;
        $e->message = (DB_CLASS)::escape($message);
        
        // recupera la URL, usuario e IP de la Request
        $request    = Request::take();
        $e->url     = $request->url;
        $e->user    = $request->user ? $request->user->email : NULL;
        $e->ip      = $request->ip;
        
        // guarda el error en base de datos
        $e->save();
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




