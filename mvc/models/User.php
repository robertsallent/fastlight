<?php

/** Clase User
 *
 * Proveedor de usuarios por defecto para las aplicaciones de FastLight.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * Última revisión: 03/02/2025
 */

class User extends Model implements Authenticable{

    use Authorizable; // usa el trait authorizable
    
    /** @var array $jsonFields lista de campos JSON que deben convertirse en array PHP. */
    protected static $jsonFields = ['roles'];
    
    

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
        
        $consulta = "SELECT *  
                     FROM users  
                     WHERE phone = '$phone' 
                        AND email = '$email' ";
        
        if($usuario = (DB_CLASS)::select($consulta, self::class))
            $usuario->parseJsonFields();
        
        
        return $usuario;
    }
    
            
    // MÉTODOS DE AUTHENTICABLE
    
    /**
     * Método encargado de comprobar que el login es correcto y recuperar el usuario.
     * Permitiremos la identificación por email o teléfono.
     * 
     * @param string $emailOrPhone email o teléfono.
     * @param string $password clave del usuario.
     * 
     * @return User|NULL si la identificación es correcta retorna el usuario, en caso contrario NULL.
     */
    public static function authenticate(
        string $emailOrPhone = '',      // email o teléfono
        string $password = ''           // debe llegar encriptado con MD5
            
    ):?User{
        
        // preparación de la consulta
        $consulta="SELECT *  FROM users
                   WHERE (email='$emailOrPhone' OR phone='$emailOrPhone') 
                   AND password='$password'
                   AND blocked_at IS NULL";
        
        $usuario = (DB_CLASS)::select($consulta, self::class);
        
        if($usuario)
            $usuario->parseJsonFields();
        
        return $usuario;
    }   
}
    
    
