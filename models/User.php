<?php

/* Clase User
 *
 * Proveedor de usuarios por defecto para las aplicaciones
 *
 * Autor: Robert Sallent
 * Última revisión: 07/03/2023
 *
 */

class User extends Model implements Autenticable, Autorizable{
    
    
    // redefine el método del padre, que no recupera bien el campo JSON
    public static function getById(int $id = 0):?User{

        // invoca al getById() de Model    
        $usuario = parent::getById($id);
        
        // convierte los roles a array
        if($usuario)
            $usuario->roles = json_decode($usuario->roles);
        
        // retorna el usuario recuperado
        return $usuario;
    }
    
    
    
    // MÉTODOS DE AUTENTICABLE
    // método encargado de comprobar que el login es correcto y recuperar el usuario
    // permitiremos la identificación por email o teléfono.
    // si la identificación es correcta retorna el usuario, en caso contrario NULL.
    public static function identificar(
        string $emailOrPhone = '',      // email o teléfono
        string $password = ''           // debe llegar encriptado con MD5
    ):?User{
        
        // preparación de la consulta
        $consulta="SELECT * 
                   FROM users
                   WHERE (email='$emailOrPhone' OR phone='$emailOrPhone') 
                   AND password='$password'";
        
        $usuario = DB::select($consulta, self::class);
        
        // hay que pasar los roles a array
        if($usuario)
            $usuario->roles = json_decode($usuario->roles);
        
        return $usuario;
    }
    
    
    
    // MÉTODOS DE AUTORIZABLE
    // retorna la lista de roles
    public function getRoles(): array{
        $this->roles[] = 'ROLE_USER';     // garantiza que al menos tenga el ROLE_USER
        return array_unique($this->roles);
    }
    
    // añade un rol
    // OJO: si el usuario está identificado, no tendrá el rol disponible hasta que cierre la sesión y acceda de nuevo
    public function addRole(string $role = 'ROLE_USER'){
        $this->roles[] = $role;                    // añade el rol
        $this->roles = array_unique($this->roles); // elimina duplicados
    }
    
    // elimina un rol
    // OJO: si el usuario está identificado, no se eliminará hasta que cierre la sesión y acceda de nuevo
    public function removeRole(string $role){
        $this->roles = array_diff($this->roles, [$role]);
        return array_unique($this->roles);
    }
    
    // comprueba si un usuario tiene un determinado rol
    public function hasRole(string $role):bool{
        return in_array($role, $this->roles);
    } 
    
    // retorna si el usuario es admin
    public function isAdmin(string $adminRole = 'ROLE_ADMIN'):bool{
        return $this->hasRole($adminRole);
    }    
}


