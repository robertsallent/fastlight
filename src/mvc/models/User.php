<?php

/** Clase User
 *
 * Modelo para los usuarios en FastLight.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * Última revisión: 15/10/2025
 */

class User extends Model{

    
    /** @var array $jsonFields lista de campos JSON que deben convertirse en array PHP. */
    protected static $jsonFields = ['roles'];
    
    
    /** @var array $fillable lista de campos permitidos para asignaciones masivas usando el método create() */
    protected static $fillable = ['displayname', 'email', 'phone', 'password', 'picture'];

    
    /**
     * Retorna un usuario a partir de un teléfono y un email. Lo usaremos
     * en la opción "olvidé mi password".
     * 
     * @param string $phone número de teléfono.
     * @param string $email email.
     * 
     * @return User|NULL el usuario recuperado o null si no existe la combinación de email y teléfono.
     */
    public static function getByPhoneAndMail(
        string $phone,
        string $email
    ):?User{
        
        // prepara la consulta
        $consulta = "SELECT * FROM users WHERE phone = '$phone' AND email = '$email' ";
        
        // ejecuta la consulta
        if($usuario = (DB_CLASS)::select($consulta, self::class))
            $usuario->parseJsonFields();
         
        // retorna el usuario
        return $usuario;
    }
    
         
    /**
     * Método encargado de comprobar que el login es correcto y recuperar el usuario.
     * 
     * Permitiremos la identificación por email, teléfono o cualquiera de los dos, esto
     * se configura en el fichero de configuración.
     * 
     * Se podrían usar otros campos, pero deben ser únicos y se debe permitir expresamente 
     * en el fichero de configuración (por seguridad)
     * 
     * @param string $user nombre de usuario (email, teléfono o el campo que vayamos a usar)
     * @param string $password clave del usuario.
     * 
     * @return User|NULL si la identificación es correcta retorna el usuario, en caso contrario NULL.
     */
    public static function authenticate(
        string $user        = '',      
        string $password    = ''    // debe llegar encriptado con MD5           
    ):?User{
        
        // toma el campo para login del ficheroo de configuración
        $field = defined('LOGIN_FIELD')? LOGIN_FIELD : 'email';
        
        // comienza a preparar la consulta
        $consulta = "SELECT * FROM users WHERE ";
        
        switch(strtolower($field)){
            case 'email':   $consulta .= "email='{$user}' "; break;
            case 'phone':   $consulta .= "phone='{$user}' "; break;
            case 'both':    $consulta .= "(email='{$user}' OR phone='{$user}') "; break;
            default:        
                if(!ALLOW_OTHER_LOGIN_FIELD)
                    throw new ConfigException("Para permitir otros campos de login, que no sean 'email', 'phone' o 'both', hay que indicarlo expresamente en el fichero de configuración.");
                    
                $consulta .= "{$field}='{$user}' ";
        }
        
        // preparación de la consulta
        $consulta .= "AND password='$password'";
        
        // ejecución de la consulta
        $usuario = (DB_CLASS)::select($consulta, self::class);
        
        if($usuario)
            $usuario->parseJsonFields();
        
        return $usuario;
    }   
    
    
    
    /**
     * Método que obtiene la lista de roles de un usuario.
     * 
     * Siempre retornará una lista con al menos un rol: el ROLE_USER
     * 
     * @return array lista de roles
     */
    public function getRoles(): array{
        $this->roles[] = 'ROLE_USER';     // garantiza que al menos tenga el ROLE_USER
        $this->roles = array_unique($this->roles);
        return $this->roles;
    }
    

    
    /**
     * Añade uno o más roles al usuario.
     * 
     * Si el usuario está identificado, no tendrá el rol disponible hasta que 
     * cierre la sesión y acceda de nuevo
     * 
     * @param string ...$roles roles a añadir
     * 
     * @return User usuario al que se le acaban de añadir los roles
     */
    public function addRole(string ...$roles):User{
        $this->roles = array_unique(array_merge($this->roles ?? [], $roles));   // añade los roles eliminando duplicados
        return $this;
    }
    
    
    /**
     * Elimina uno o más roles.
     * 
     * Si el usuario está identificado, no apreciará los cambios hasta que 
     * cierre la sesión y acceda de nuevo
     * 
     * @param string ...$roles roles a quitar
     * 
     * @return User el usuario al que se le acaban de quitar los roles
     */
    public function removeRole(string ...$roles):User{
        $this->roles = array_diff($this->roles, $roles);
        return $this;
    }
    
    /**
     * Comprueba si un usuario tiene un determinado rol
     * 
     * @param string $role rol a comprobar
     * 
     * @return bool true si lo tiene o false si no lo tiene
     */
    public function hasRole(string $role):bool{
        return in_array($role, $this->roles);
    }
    
    
    
    /**
     * Comprueba si el usuario tiene todos los roles de una lista
     * 
     * @param array $roles lista de roles a comprobar
     * 
     * @return bool true si tiene todos los roles o false si no tiene alguno de ellos
     */
    public function allRoles(array $roles):bool{
        foreach($roles as $role)
            if(!$this->hasRole($role))
                return false;
                
                return true;
    }
    
    
    
    /**
     * Comprueba si el usuario tiene uno de los roles indicados en una lista
     * 
     * @param array $roles lista de roles a comprobar
     * 
     * @return bool true si tiene alguno de los roles indicados en la lista o false si no tiene ninguno
     */
    public function oneRole(array $roles):bool{
        foreach($roles as $role)
            if($this->hasRole($role))
                return true;
                
                return false;
    }
    
    
    
    /**
     * Permite saber si el usuario es administrador o no
     * 
     * @param string $adminRole nombre del rol de administrador, por defecto ROLE_ADMIN
     * 
     * @return bool true si el usuario está identificado y es administrador, false en caso contrario
     */
    public function isAdmin(string $adminRole = 'ROLE_ADMIN'):bool{
        return $this->hasRole($adminRole);
    }
}