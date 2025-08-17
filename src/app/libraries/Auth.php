<?php

/**
 *   Auth
 *   
 *   Herramienta para comprobar autorización.
 *    
 *   Última mofidicación: 13/07/2023
 *   
 *   @author Robert Sallent <robertsallent@gmail.com>
*/

class Auth{
    
    
    
    /**
     * Recupera el usuario identificado.
     * Es una alternativa a Login::user() o Login::get().
     * 
     * @return Authenticable el usuario identificado.
     */
    
    public static function user():Authenticable{
        return Login::user();
    }
    
    
    
    /**
     * Comprueba si hay alguien identificado.
     * 
     * @throws NotIdentifiedException en caso de no haber nadie identificado.
     */
    public static function check(){
        if(!Login::check())
            throw new NotIdentifiedException("Debes estar identificado.");
    }
    
    
    
    /**
     * Comprueba si no hay nadie identificado.
     * 
     * @throws AuthException si hay alguien identificado
     */
    public static function guest(){
        if(!Login::guest())
            throw new AuthException("Solo para usuarios no identificados.");
    }
    
    
    
    /**
     * Comprueba que el usuario que está utilizando la aplicación sea administrador.
     * 
     * @param string $adminRole nombre del rol de administrador, por defecto ROLE_ADMIN.
     *
     * @throws AuthException si no hay usuario identificado o no es administrador.
     */
    public static function admin(string $adminRole = 'ROLE_ADMIN'){
        
        self::check(); 
        
        if(!Login::isAdmin($adminRole))
            throw new AuthException(
                DEBUG ? 
                    "Se requiere privilegio de administrador ($adminRole)." : 
                    "No estás autorizado a realizar esta operación."
            );
    }
    
    
    
    /**
     * Comprueba si el usuario que utiliza la aplicación tiene un determinado rol.
     * 
     * @param string $role rol que debe tener el usuario.
     * 
     * @throws AuthException en caso de no tener el rol indicado.
     */
    public static function role(string $role){
        
        self::check();
        
        if(!Login::role($role))
            throw new AuthException(
                DEBUG ? 
                    "Se requiere rol de $role para continuar." : 
                    "No estás autorizado a realizar esta operación."
            );
    }
    
    
    
    /**
     * Comprueba si el usuario que usa la aplicación tiene todos los roles de una lista.
     * 
     * @param array $roles lista de roles a comprobar.
     * 
     * @throws AuthException en caso de que no tenga todos los roles indicados.
     */
    public static function allRoles(array $roles){
        
        self::check();
        
        if(!Login::allRoles($roles))
            throw new AuthException( 
                DEBUG ? 
                    "Se requieren los roles: ".arrayToString($roles, false, false)." para continuar." : 
                    "No estás autorizado a realizar esta operación."
            );
    }
    
    
    
    /**
     * Comprueba si el usuario tiene un rol entre los indicados en una lista.
     * 
     * @param array $roles lista de roles a comprobar.
     * 
     * @throws AuthException en caso de que el usuario no tenga al menos uno de los roles indicados.
     */
    public static function oneRole(array $roles){
        
        self::check();
        
        if(!Login::oneRole($roles))
            throw new AuthException(
                DEBUG ?
                    "Se requiere uno de estos roles: ".arrayToString($roles, false, false)." para continuar." :
                    "No estás autorizado a realizar esta operación."
                );
    }
}



