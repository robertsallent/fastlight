<?php

/* Trait Authorizable
 *
 * Implementa los métodos para las clases que permitan autorización.
 *
 * autor: Robert Sallent
 * última revisión: 23/03/2023
 *
 */

    trait Authorizable{
        
        // retorna la lista de roles
        public function getRoles(): array{
            $this->roles[] = 'ROLE_USER';     // garantiza que al menos tenga el ROLE_USER
            $this->roles = array_unique($this->roles);
            return $this->roles;
        }
        
        // añade uno o más roles
        // OJO: si el usuario está identificado, no tendrá el rol disponible hasta que cierre la sesión y acceda de nuevo
        public function addRole(string ...$roles):array{
            $this->roles = array_unique(array_merge($this->roles ?? [], $roles));   // añade los roles eliminando duplicados 
            return $this->roles; 
        }
               
        // elimina uno o más roles
        // OJO: si el usuario está identificado, no se eliminará hasta que cierre la sesión y acceda de nuevo
        public function removeRole(string ...$roles):array{
            $this->roles = array_diff($this->roles, $roles);
            return array_unique($this->roles);
        }
        
        // comprueba si un usuario tiene un determinado rol
        public function hasRole(string $role):bool{
            return in_array($role, $this->roles);
        }
        
        // comprueba si el usuario tiene todos los roles en una lista
        public function allRoles(array $roles):bool{
            foreach($roles as $role)
                if(!$this->hasRole($role))
                    return false;
                    
            return true;
        }
        
        // comprueba si el usuario tiene un rol de entre los indicados
        public function oneRole(array $roles):bool{
            foreach($roles as $role)
                if($this->hasRole($role))
                    return true;
                    
             return false;
        }
        
        // retorna si el usuario es admin
        public function isAdmin(string $adminRole = 'ROLE_ADMIN'):bool{
            return $this->hasRole($adminRole);
        }    
  
    }

