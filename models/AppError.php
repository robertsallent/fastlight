<?php

/* Clase AppError
 *
 * Permite guardar los errores en BDD
 *
 * Autor: Robert Sallent
 * Última revisión: 15/02/2023
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
        ):int{
            $error = new self();
            
            $error->level = $level;
            $error->url = $url;
            $error->message = htmlspecialchars($message);
            $error->user = Login::user() ? Login::user()->email : NULL;
            $error->ip = $_SERVER['REMOTE_ADDR'];
            
            return $error->save();
        }    
    }
    