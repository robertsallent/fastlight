<?php

/* Intarface Autenticable
 *
 * Interfaz que deben implementar las clases que permitan trabajar con autorización.
 *
 * autor: Robert Sallent
 * última revisión: 03/03/2023
 *
 */

    interface Autorizable{
        
        public function hasRole(string $role):bool;
        
        public function addRole(string $role);
        
        public function removeRole(string $role);
        
        public function getRoles():array;
        
        public function isAdmin():bool;
        
    }

