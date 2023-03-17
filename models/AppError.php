<?php

/* Clase AppError
 *
 * Permite guardar los errores en BDD
 *
 * Autor: Robert Sallent
 * Última revisión: 14/03/2023
 *
 */

    class AppError extends Model{
        
        // nombre de la tabla en la BDD (config)
        protected static string $table = ERROR_DB_TABLE;
        
        // crea un nuevo AppError y lo guarda en BDD
        public static function create(
            string $url,             // URL donde se produjo el error
            string $level = 'ERROR', // nivel de severidad
            string $message = ''     // mensaje del error
        ){
            $error = new self();
            
            $error->level = $level;
            $error->url = $url;
            $error->message = (DB_CLASS)::escape($message);
            $error->user = Login::user() ? Login::user()->email : NULL;
            $error->ip = $_SERVER['REMOTE_ADDR'];
            
            // guarda el error en base de datos
            $error->save();
        }    
        
        // vacía la tabla de errores de la BDD
        public static function clear():int{
            $consulta = "DELETE FROM ".ERROR_DB_TABLE;
            return (DB_CLASS)::delete($consulta);
        }
    }
    
    
    
    
    