<?php

/* Clase User
 *
 * Proveedor de usuarios por defecto para las aplicaciones
 *
 * Autor: Robert Sallent
 * Última revisión: 23/03/2023
 *
 */
    
    class User extends Model implements Authenticable{
        
        // usa el trait authorizable
        use Authorizable;
        
        // redefine el método del padre, que no recupera bien el campo JSON
        public static function getById(int $id = 0):?User{
    
            // invoca al getById() de Model    
            $usuario = parent::getById($id);
            
            // convierte los roles a array
            if($usuario)
                $usuario->roles = array_unique(json_decode($usuario->roles, JSON_OBJECT_AS_ARRAY));
            
            // retorna el usuario recuperado
            return $usuario;
        }
        
        
        
        // retorna un usuario a partir de un teléfono y un email 
        // (se usa en "olvidé mi password")
        public static function getByPhoneAndMail(
            string $phone,
            string $email
            
        ):?User{
            
            $consulta = "SELECT *  FROM users  
                         WHERE phone = '$phone' AND email = '$email' ";
            
            return (DB_CLASS)::select($consulta, self::class);
        }
        
                
        // MÉTODOS DE AUTHENTICABLE
        
        // método encargado de comprobar que el login es correcto y recuperar el usuario
        // permitiremos la identificación por email o teléfono.
        // si la identificación es correcta retorna el usuario, en caso contrario NULL
        
        public static function authenticate(
            string $emailOrPhone = '',      // email o teléfono
            string $password = ''           // debe llegar encriptado con MD5
                
        ):?User{
            
            // preparación de la consulta
            $consulta="SELECT *  FROM users
                       WHERE (email='$emailOrPhone' OR phone='$emailOrPhone') 
                       AND password='$password'";
            
            $usuario = (DB_CLASS)::select($consulta, self::class);
            
            // hay que pasar los roles a array
            if($usuario)
                $usuario->roles = array_unique(json_decode($usuario->roles, JSON_OBJECT_AS_ARRAY));
            
            return $usuario;
        }   
    }
    
    
