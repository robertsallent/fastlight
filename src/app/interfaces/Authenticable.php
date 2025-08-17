<?php

/**
 * Interfaz que deben implementar los USER_PROVIDERS como la clase User.
 * 
 * Última revisión: 30/06/2023
 * @author Robert Sallent <robertsallent@gmail.com>
 *
 */

interface Authenticable{
    

    /**
     * Método que permite autenticar una entidad en la aplicación. 
     * Por defecto la única entidad autenticable es User. 
     * 
     * @param string $name nombre de usuario (o email, nombre, teléfono...)
     * @param string $password clave de identificación.
     * 
     * @return Authenticable|NULL la entidad autenticada o NULL si no se pudo autenticar.
     */
    public static function authenticate(
        string $name,       // nombre de usuario (puede ser email, name, phone...)
        string $password    // clave
    ):?Authenticable; 
    
}

