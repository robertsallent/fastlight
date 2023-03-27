<?php

/** 
 * Clase AppError.
 *
 * Modelo responsable de guardar los errores en base de datos.
 *
 * @author: Robert Sallent <robert@juegayestudia.com>
 * @version: 27.03.24
 */

class AppError extends Model{
    
    /** @staticvar string $table nombre de la tabla en la base de datos */ 
    protected static string $table = ERROR_DB_TABLE;
    
    /**
     * Create
     *
     * Permite crear un nuevo objeto AppError y guardarlo en base de datos.
     * 
     * @static  
     * @param string $level     nivel de severidad o tipo de error
     * @param string $message   mensaje
     * @return void
     */
    public static function create(
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
     * Clear
     *
     * Vacía la tabla de errores en la base de datos.
     *
     * @static
     * @return int
     */
    public static function clear():int{
        return (DB_CLASS)::delete("DELETE FROM ".ERROR_DB_TABLE);
    }
}




