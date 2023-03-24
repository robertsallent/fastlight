<?php

/*
 *   Clase: Auth
 *   Autor: Robert Sallent
 *   Última mofidicación: 23/03/2023
 *
 *   Nos facilitará la tarea de comprobar autorizaciones
*/

    class Auth{
        
        // retorna el usuario identificado (alias de Login::user() o Login::get())
        public static function user():Authenticable{
            return Login::user();
        }
        
        // comprueba si hay alguien identificado, sino  lanza excepción
        public static function check():bool{
            if(!Login::check())
                throw new AuthException("Debes estar identificado.");
            
            return true;
        }
        
        // comprueba si hay alguien identificado, sino  lanza excepción
        public static function guest():bool{
            if(!Login::guest())
                throw new AuthException("Solo para usuarios no identificados.");
                
            return true;
        }
        
        // comprueba si el usuario es admin, en caso contrario lanza excepción
        public static function admin(string $adminRole = ADMIN_ROLE):bool{
            if(!Login::isAdmin($adminRole))
                throw new AuthException(
                    DEBUG ? 
                        "Se requiere privilegio de administrador ($adminRole)." : 
                        "No estás autorizado a realizar esta operación."
                );
            return true;
        }
        
        // comprueba si el usuario tiene un rol determinado, en caso contrario lanza excepción
        public static function role(string $role):bool{
            if(!Login::role($role))
                throw new AuthException(
                    DEBUG ? 
                        "Se requiere rol de $role para continuar." : 
                        "No estás autorizado a realizar esta operación."
                );
            return true;
        }
        
        // comprueba si el usuario tiene todos los roles en una lista
        public static function allRoles(array $roles):bool{
            if(!Login::allRoles($roles))
                throw new AuthException( 
                    DEBUG ? 
                        "Se requieren los roles: ".arrayToString($roles)." para continuar." : 
                        "No estás autorizado a realizar esta operación."
                );
            return true;
        }
        
        // comprueba si el usuario tiene un rol de entre los indicados 
        public static function oneRole(array $roles):bool{
            if(!Login::oneRole($roles))
                throw new AuthException(
                    DEBUG ?
                        "Se requiere uno de estos roles: ".arrayToString($roles)." para continuar." :
                        "No estás autorizado a realizar esta operación."
                    );
            return true;
        }
    }


    
