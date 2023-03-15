<?php

    /*
        Clase: Auth
        Autor: Robert Sallent
        Última mofidicación: 15/03/2023

        Nos facilitará la tarea de comprobar autorizaciones

    */

    class Auth{
        
        // retorna el usuario identificado
        public static function user():Autenticable{
            return Login::get();
        }
        
        // comprueba si hay alguien identificado, sino  lanza excepción
        public static function userLogged():bool{
            if(!Login::check())
                throw new AuthException("Debes estar identificado.");
            
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
            
            $user = Login::get();
            
            if(!$user || !$user->hasRole($role))
                throw new AuthException(DEBUG ? "Se requiere rol de $role para continuar." : "No autorizado.");
            
            return true;
        }
        
        // comprueba si el usuario tiene todos los roles en una lista
        public static function allRoles(array $roles):bool{
            
            self::userLogged();
            
            $user = Login::get();
           
            foreach($roles as $role)
                if(!$user->hasRole($role))
                    throw new AuthException(DEBUG ? "Se requieren los roles: ".arrayToString($roles, false) : "No autorizado");
                
            return true;
        }
        
        // comprueba si el usuario tiene un rol de entre los indicados 
        public static function oneRole(array $roles):bool{
            
            self::userLogged();
            
            $user = Login::get();
            
            foreach($roles as $role)
                if($user->hasRole($role))
                    return true;
                    
            throw new AuthException(DEBUG ? "Se requiere uno de estos los roles: ".arrayToString($roles, false) : "No autorizado"); 
        }
    }


    
