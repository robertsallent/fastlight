<?php

/** 
 * Clase AppError.
 *
 * Modelo responsable de guardar los errores en base de datos.
 *
 * @author: Robert Sallent <robert@juegayestudia.com>
 * @version: 23.03.24
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
         * @param string $url       url donde se produjo el error      
         * @param string $level     nivel de severidad
         * @param string $message   mensaje
         * @return void
         */
        public static function create(
            ?string $url,            // URL donde se produjo el error
            string $level = 'ERROR', // nivel de severidad
            string $message = ''     // mensaje del error
        ){
            $error = new self();
            
            $error->level = $level;
            $error->url = $url ?? '';
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
        // vacía la tabla de errores de la BDD
        public static function clear():int{
            $consulta = "DELETE FROM ".ERROR_DB_TABLE;
            return (DB_CLASS)::delete($consulta);
        }
    }
    
    
    
    
    