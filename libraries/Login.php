<?php 

    class Login{
        
    	// PROPIEDADES
    	// contiene el usuario identificado.
    	// es privada, solo podremos acceder mediante los métodos
    	private static $identificado = NULL; 
    
    	// METODOS
    	// recupera el usuario identificado desde la variable de sesión
    	// será usado desde el FrontController
    	public static function init(){
    	    if(!empty($_SESSION['usuario']))
    	        self::$identificado = unserialize($_SESSION['usuario']);
    	}
    	   	
    	// establece el usuario identificado
    	// se usará desde LoginController, método login()
    	public static function set(Usuario $u){
    	    self::$identificado = $u; 
    	    $_SESSION['usuario'] = serialize($u);
    	}
    	
    	// elimina el usuario identificado
    	// se usará desde LoginController, método logout()
    	public static function clear(){
    	    self::$identificado = NULL;
    	    unset($_SESSION['usuario']);
    	}
    	
    	// METODOS ÚTILES PARA NUESTRAS APLICACIONES
    	// recupera el usuario identificado (o NULL si no hay)
    	public static function get():?Usuario{
    	    return self::$identificado;
    	}
    	
    	// retorna si el usuario identificado es admin
    	public static function isAdmin():bool{
    	    return self::$identificado && self::$identificado->administrador;
    	}
    	
    	// retorna si el usuario tiene un nivel de privilegio determinado (o más)
    	public static function hasPrivilege(int $p):bool{
    	    return self::$identificado && (self::$identificado->privilegio >= $p);
    	}
    }
    
    
    
    