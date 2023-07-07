<?php 

/** Login
  *
  * Autenticación de usuarios.
  * Implementa las operaciones de login/logout y también permite hacer comprobaciones
  * sobre los distintos roles de que dispone el usuario identificado. 
  *
  * Última revisión: 07/07/2023
  * 
  * @author Robert Sallent <robertsallent@gmail.com>
  */


class Login{
        
    /** @var $activeUser contiene el usuario identificado en la aplicación.
     *  No dispone de setter, así que es de solamente lectura.*/
    private static ?Authenticable $activeUser = NULL; 


    
    /** Recupera el usuario desde la variable de sesión. */
    public static function init(){
        self::$activeUser = Session::get('user') ??  NULL;
    }

    
    
    /**
     * Hace login, estableciendo el usuario.
     * Se usa desde LoginController::login().
     * 
     * @param Authenticable $user
     */
    public static function set(Authenticable $user){
        self::$activeUser = $user; 
	    Session::set('user', $user);
	}
	
	
	
	/**
	 * Hace logout olvidando el usuario, limpiando la sesión, eliminando
	 * la cookie de sesión y destruyendo los datos del servidor.
	 * 
	 * Se usa desde LoginController::logout().
	 */
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
	
	
	
	/**
	 * Recupera el usuario identificado.
	 * 
	 * @return Authenticable|NULL el usuario identificado o NULL si no hay nadie identificado.
	 */
	public static function user():?Authenticable{
	    return self::$activeUser;
	}
	
	
	
	/**
	 * Alias de Login::user()
	 * 
	 * @return Authenticable|NULL el usuario identificado o NULL si no hay nadie identificado.
	 */
	public static function get():?Authenticable{
	    return self::user();
	}
	
	
	
	/**
	 * Comprueba si hay alguien identificado.
	 * 
	 * @return bool true si hay alguien identificado o false en caso contrario.
	 */
	public static function check():bool{
	    return !empty(self::user());
	}
	
	
	
	/**
	 * Comprueba si no hay nadie identificado.
	 * 
	 * @return bool true si no hay nadie identificado o false si sí lo hay.
	 */
	public static function guest():bool{
	    return empty(self::user());
	}
	  	
	
	
	/**
	 * Comprueba si se encuentra identificado un usuario administrador.
	 * 
	 * @param string $adminRole rol de administrador, por defecto el que se encuentre configurado en el fichero config.php.
	 * 
	 * @return bool true si el usuario identificado es administrador o false si no lo es o no hay usuario identificado.
	 */
	public static function isAdmin(string $adminRole = ADMIN_ROLE):bool{
	    return self::$activeUser && self::$activeUser->hasRole($adminRole);
	}
	
	
	
	/**
	 * Comrueba si el usuario identificado tiene un rol determinado.
	 * 
	 * @param string $role rol a comprobar.
	 * 
	 * @return bool true si el usuario tiene ese rol, false en caso contrario.
	 */
	public static function role(string $role):bool{
	    return self::user() && self::user()->hasRole($role);
	}
	
	
	
	/**
	 * Comprueba si el usuario identificado tiene todos los roles en una lista.
	 * 
	 * @param array $roles lista de roles a comprobar.
	 * 
	 * @return bool true si el usuario tiene todos los roles de la lista, false en cualquier otro caso.
	 */
	public static function allRoles(array $roles):bool{
	    return self::user() && self::user()->allRoles($roles);
	}
	
	
	
	/**
	 * Comprueba si el usuario identificado tiene alguno de los roles indicados en una lista.
	 * 
	 * @param array $roles lista de roles a comprobar.
	 * 
	 * @return bool true si el usuario identificado tiene alguno de los roles indicados, false en cualquier otro caso.
	 */
	public static function oneRole(array $roles):bool{
	    return self::user() && self::user()->oneRole($roles);
    }

}
    
    