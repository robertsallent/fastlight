<?php


/** Session
 *
 * Herramientas para manejo de variables de sesión y flasheo de mensajes
 *
 * Última revisión: 08/03/2023
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class Session{

     
    /**
     * Flashea un mensaje en sesión.
     * 
     * @param string $categoria categoría o tipo del mensaje.
     * @param string $mensaje mensaje a flashear.
     */  
    public static function flash(
        string $categoria = 'message',  // categoria, por ejemplo success o error
        string $mensaje = ''            // mensaje a flashear
    ){
        $_SESSION['flash_'.$categoria] = $mensaje;            
    }
    
    
    
    /**
     * Recupera un mensaje flasheado y lo borra de la sesión.
     * 
     * @param string $categoria categoría o tipo del mensaje.
     * @return string|NULL retorna el mensaje si existe o null si no existe.
     */
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
    
    
    
    /**
     * Forma abreviada de flashear un mensaje de éxito.
     * 
     * @param string $mensaje el mensaje a flashear.
     */
    public static function success(string $mensaje){
        self::flash('success', $mensaje);
    }
    
    
    
    /**
     * Forma abreviada de flashear un mensaje de warning.
     *
     * @param string $mensaje el mensaje a flashear.
     */
    public static function warning(string $mensaje){
        self::flash('warning', $mensaje);
    }
    
    
    
    /**
     * Forma abreviada de flashear un mensaje de error.
     *
     * @param string $mensaje el mensaje a flashear.
     */
    public static function error(string $mensaje){
        self::flash('error', $mensaje);
    }
    
    
    
    /**
     * Establece una nueva variable de sesión.
     * 
     * @param string $name nombre de la variable.
     * 
     * @param mixed $value valor de la variable.
     */
    public static function set(
        string $name,    // nombre de la variable de sesión a crear
        $value           // valor a guardar
    ){
        $_SESSION[$name] = $value;
    }
    
    
    
    /**
     * Recupera una variable de sesión.
     * 
     * @param string $name nombre de la variable a recuperar
     * 
     * @return NULL|mixed el valor de la variable recuperada o NULL si no existe.
     */
    public static function get(string $name){
        return $_SESSION[$name] ?? NULL;
    }
    
    
    
    /**
     * Retorna el array de sesión completo.
     * 
     * @return array 
     */
    public static function all(){
        return $_SESSION;
    }
    
        
    
    /**
     * Comprueba si existe una variable de sesión.
     * 
     * @param string $name nombre de la variable buscada.
     * 
     * @return bool true si existe false si no.
     */
    public static function has(string $name):bool{
        return isset($_SESSION[$name]) ;
    }
    
   
    
    /**
     * Olvida una variable de sesión.
     * 
     * @param string $name nombre de la variable a olvidar.
     */
    public static function forget(string $name){
        unset($_SESSION[$name]);
    }
    
   
    
    /**
     * Elimina todas las variables de sesión.
     */
    public static function clear(){
        $_SESSION = [];
    } 
    
    /**
     * Limpia la sesión, eliminando
     * la cookie de sesión y destruyendo los datos en el servidor.
     */
    public static function destroy(){
        
        self::clear();   // borra todas las variables de sesión
        
        $parametrosCookie = session_get_cookie_params();
        
        setcookie(              // manda una cookie caducada
            session_name(),                 // nombre de la cookie
            '',                             // valor
            time()-3600,                    // tiempo (expirada)
            $parametrosCookie['path'],      // ruta
            $parametrosCookie['domain'],    // dominio
            $parametrosCookie['secure'],    // http o https?
            $parametrosCookie['httponly'],  // accesible desde JS?
        );
        
        session_destroy();      // cierra y elimina el fichero
    }
}

