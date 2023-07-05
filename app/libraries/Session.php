<?php


/* Clase Session
 *
 * Herramientas para manejo de variables de sesión y flasheo de mensajes
 *
 * Autor: Robert Sallent
 * Última revisión: 08/03/2023
 *
 */
 
    class Session{
  
        // método para flashear mensajes  
        public static function flash(
            string $categoria = 'message',  // categoria, por ejemplo success o error
            string $mensaje = ''            // mensaje a flashear
        ){
            $_SESSION['flash_'.$categoria] = $mensaje;            
        }
        
        // método que recupera un mensaje flasheado
        public static function getFlash(
            string $categoria = 'message'  // categoria, por ejemplo success o error
        ):?string{
            
            // recupera el mensaje o null
            $mensaje = $_SESSION['flash_'.$categoria] ?? NULL;
            
            // elimina la variable dde sesión asociada
            if($mensaje) 
                unset($_SESSION['flash_'.$categoria]);
                
            // retorna el mensaje
            return $mensaje;
        }
        
        
        // métodos abreviados para flashear mensajes de éxito, error o warning
        public static function success(string $mensaje){
            self::flash('success', $mensaje);
        }
        
        public static function warning(string $mensaje){
            self::flash('warning', $mensaje);
        }
        
        public static function error(string $mensaje){
            self::flash('error', $mensaje);
        }
        
        
        // metodo que guarda una variable de sesión
        public static function set(
            string $name,    // nombre de la variable de sesión a crear
            $value           // valor a guardar
        ){
            $_SESSION[$name] = $value;
        }
        
        // método que recupera una variable de sesión
        public static function get(string $name){
            return $_SESSION[$name] ?? NULL;
        }
        
        // método que comprueba si existe una variable de sesión
        public static function has(string $name){
            return isset($_SESSION[$name]) ;
        }
        
        // método que elimina una variable de sesión
        public static function forget(string $name){
            unset($_SESSION[$name]);
        }
        
        // método que elimina todas las variables de sesión
        public static function clear(){
            $_SESSION = [];
        }
        
    }