<?php


/** Session
 *
 * Herramientas para manejo de variables de sesión y flasheo de mensajes
 *
 * Última revisión: 22/05/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * 
 */

class Session{

    /** @var string prefijo para las variables flasheadas   */
    private const FLASH_PREFIX = '_flash_';
     
    
    
    /**
     * Flashea un mensaje en sesión.
     * 
     * @param string $categoria categoría o tipo del mensaje.
     * @param string $mensaje mensaje a flashear.
     */  
    public static function flash(
        string $categoria = 'message',  // categoria, por ejemplo success o error
        string $mensaje = ''            // mensaje a flashear
    ):void{
        $_SESSION[self::FLASH_PREFIX.$categoria] = $mensaje;            
    }
    
    
    
    /**
     * Recupera un mensaje flasheado y lo borra de la sesión.
     * 
     * @param string $categoria categoría o tipo del mensaje.
     * @return string|NULL retorna el mensaje si existe o null si no existe.
     */
    public static function getFlash(
        string $categoria = 'message'
    ): ?string {
        
        // determina la variable de sesión a recuperar
        $key = self::FLASH_PREFIX.$categoria;
        
        // recupera el mensaje flasheado
        $mensaje = $_SESSION[$key] ?? null;
        
        // si existe la variable de sesión la elimina
        if(isset($_SESSION[$key]))
            unset($_SESSION[$key]);
            
        // retorna el mensaje recuperado o null
        return $mensaje;
    }
    
    
    
    /**
     * Forma abreviada de flashear un mensaje genérico.
     *
     * @param string $mensaje el mensaje a flashear.
     */
    public static function message(string $mensaje):void{
        self::flash('message', $mensaje);
    }
    
    
    
    /**
     * Forma abreviada de flashear un mensaje de éxito.
     * 
     * @param string $mensaje el mensaje a flashear.
     */
    public static function success(string $mensaje):void{
        self::flash('success', $mensaje);
    }
    
    
    
    /**
     * Forma abreviada de flashear un mensaje de warning.
     *
     * @param string $mensaje el mensaje a flashear.
     */
    public static function warning(string $mensaje):void{
        self::flash('warning', $mensaje);
    }
    
    
    
    /**
     * Forma abreviada de flashear un mensaje de error.
     *
     * @param string $mensaje el mensaje a flashear.
     */
    public static function error(string $mensaje):void{
        self::flash('error', $mensaje);
    }
    
    
    /**
     * Forma abreviada de flashear un mensaje de peligro.
     *
     * @param string $mensaje el mensaje a flashear.
     */
    public static function danger(string $mensaje):void{
        self::flash('danger', $mensaje);
    }
    
    
    
    /**
     * Establece una nueva variable de sesión.
     * 
     * @param string $name nombre de la variable.
     * @param mixed $value valor de la variable.
     */
    public static function set(
        string $name,    // nombre de la variable de sesión a crear
        mixed $value     // valor a guardar
    ):void{
        $_SESSION[$name] = $value;
    }
    
    
    
    /**
     * Recupera una variable de sesión.
     * 
     * @param string $name nombre de la variable a recuperar
     * 
     * @return mixed el valor de la variable recuperada o NULL si no existe.
     */
    public static function get(string $name):mixed{
        return $_SESSION[$name] ?? null;
    }
    
    
    
    /**
     * Retorna el array de sesión completo.
     * 
     * @return array 
     */
    public static function all():array{
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
    public static function forget(string $name):void{
        unset($_SESSION[$name]);
    }
    
   
    
    /**
     * Elimina todas las variables de sesión.
     */
    public static function clear():void{
        $_SESSION = [];
    } 
    
    /**
     * Limpia la sesión, eliminando
     * la cookie de sesión y destruyendo los datos en el servidor.
     */
    public static function destroy():void{
        
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

