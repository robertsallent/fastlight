<?php

/** ConnectionException 
 *
 * Excepción que se produce cuando no se puede conectar con la base de datos.
 * Si se produce una excepción de este tipo, no se puede guardar el error en
 * BDD puesto que no se ha conseguido conectar.
 *
 * Última revisión: 30/04/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.9.4
 */

class ConnectionException extends Exception{}
    
    