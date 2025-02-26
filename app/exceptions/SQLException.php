<?php

/** SQLException 
 *
 * Permite distinguir las excepciones producidas al realizar 
 * consultas SQL contra la base de datos.
 *
 * Última revisión: 26/02/2025.
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * @since v1.8.0 nuevo método errorMessage()
 */

class SQLException extends Exception{
    
    /**
     * Recupera el último mensaje de error a través de la conexión con la BDD.
     * 
     * @return string el mensaje enviado por el SGDB.
     */
    public function errorMessage():string{
        return (DB_CLASS)::errorMessage();
    }
}
    
    