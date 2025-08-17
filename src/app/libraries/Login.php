<?php 

/** Login
  *
  * Autenticación de usuarios.
  * Implementa las operaciones de login/logout y también permite hacer comprobaciones
  * sobre los distintos roles de que dispone el usuario identificado. 
  *
  * Última revisión: 27/03/2024
  * 
  * @author Robert Sallent <robertsallent@gmail.com>
  */


class Login{
        
    /** @var $activeUser contiene el usuario identificado en la aplicación.
     *  No dispone de setter, así que es de solamente lectura.*/
    private static ?Authenticable $activeUser = NULL; 


    
    /** 
     * Tareas de inicialización del sistema de login.
     * 
     * - Recupera el usuario desde la variable de sesión. 
     * - Borra la operación pendiente. 
     * 
     * Este método es invocado desde el constructor del Kernel, no
     * es necesario usarlo explícitamente desde ningún otro lugar.
     */
    public static function init(){
        
        // recupera el usuario activo de la variable de sesión
        self::$activeUser = Session::get('user') ??  NULL;
                
        // Si hay operación pendiente pero no estamos en /Login, eliminaremos la operación pendiente.
        
        // Para los casos en los que el usuario no identificado no llega a identificarse al solicitar
        // una URL protegida y ser redirigido a login. 
        
        // Así evitamos que se haga la redirección en una identificación posterior
        
        // TODO: comprobar si esto también funciona correctamente para la API.
        if(Session::has('_pending_operation') && !URL::beginsWith('/Login')){
            Session::forget('_pending_operation');
        }
    }

    
    
    /**
     * Hace login, estableciendo el usuario.
     * 
     * Se usa desde LoginController::enter() y en principio no tendremos
     * necesidad de usarlo desde ningún otro lugar.
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
	 * Se invoca desde LogoutController::index().
	 * 
	 * Si implementamos la operación "baja de usuario", también debemos
	 * invocar a este método para garantizar que se "expulsa" al usuario
	 * una vez eliminado del sistema.
	 */
	public static function clear(){
	    self::$activeUser = NULL;
	    Session::destroy();  
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
	 * @param string $adminRole rol de administrador, por defecto ROLE_ADMIN.
	 * 
	 * @return bool true si el usuario identificado es administrador o false si no lo es o no hay usuario identificado.
	 */
	public static function isAdmin(string $adminRole = 'ROLE_ADMIN'):bool{
	    return self::$activeUser && self::$activeUser->hasRole($adminRole);
	}
	
	
	
	/**
	 * Comprueba si el usuario identificado tiene un rol determinado.
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
    
    