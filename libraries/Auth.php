<?php

    /*
        Clase: Auth
        Autor: Robert Sallent
        Última mofidicación: 22/03/2023

        Nos facilitará la tarea de comprobar autorizaciones

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
        public static function admin():bool{
            if(!Login::isAdmin())
                throw new AuthException("Se requieren privilegios de administrador.");
            
            return true;
        }
        
        // comprueba si el usuario tiene un rol determinado, en caso contrario lanza excepción
        public static function role(string $role):bool{
            $user = Login::user();
            
            if(!$user || !$user->hasRole($role))
                throw new AuthException(DEBUG ? "Se requiere rol de $role para continuar." : "No autorizado.");
            
            return true;
        }
        
        // comprueba si el usuario tiene todos los roles en una lista
        public static function allRoles(array $roles):bool{
            $user = Login::user();
            
            if(!$user || !$user->allRoles($roles))
                throw new AuthException( 
                    DEBUG ? 
                        "Se requieren los roles: ".arrayToString($roles)." para continuar." : 
                        "No autorizado."
                );
                
            return true;
        }
        
        // comprueba si el usuario tiene un rol de entre los indicados 
        public static function oneRole(array $roles):bool{
            $user = Login::user();
            
            if(!$user || !$user->oneRole($roles))
                throw new AuthException(
                    DEBUG ?
                        "Se requiere uno de estos roles: ".arrayToString($roles)." para continuar." :
                        "No autorizado."
                    );
                
            return true;
        }
    }


    
