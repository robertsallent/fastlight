<?php 

/* Clase Login
 *
 * Simplifica la tarea de login/logout y el trabajo con sesiones de usuario
 *
 * autor: Robert Sallent
 * última revisión: 07/03/2023
 *
 */

    class Login{
        
        // Propiedad que contendrá el usuario identificado en la aplicación.
        // Es privada, se puede recuperar mediante el método Login::get().
        // Como no hay setter será de solo lectura.
        private static ?Autenticable $activeUser = NULL; 
    
    	// METODOS
    	// método que recupera el usuario desde la variable de sesión
        // hay que invocarlo para que funcione el sistema de login.
        public static function init(){
            self::$activeUser = Session::get('user') ??  NULL;
        }
    	   	
    	// establece el usuario identificado
    	// se usará desde LoginController, método login()
        public static function set(Autenticable $user){
            self::$activeUser = $user; 
    	    Session::set('user', $user);
    	}
    	
    	// elimina el usuario identificado
    	// se usará desde LoginController, método logout()
    	public static function clear(){
    	    self::$activeUser = NULL;
    	    
    	    Session::clear();   // borra todas las variables de sesión
    	    
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
    	
    	// METODOS ÚTILES PARA NUESTRAS APLICACIONES
    	// recupera el usuario identificado (o NULL si no hay)
    	public static function user():?Autenticable{
    	    return self::$activeUser;
    	}
    	
    	// alias de Login::user()
    	public static function get():?Autenticable{
    	    return self::user();
    	}
    	
    	// comprueba si hay alguien identificado
    	public static function check():bool{
    	    return !empty(self::user());
    	}
    	
    	// comprueba si no hay nadie identificado
    	public static function guest():bool{
    	    return empty(self::user());
    	}
    	  	
    	// retorna si el usuario está identificado y es admin
    	public static function isAdmin():bool{
    	    return self::$activeUser && self::$activeUser->hasRole('ROLE_ADMIN');
    	}    	
    }
    
    
    
    