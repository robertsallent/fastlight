<?php

/* Intarface Autenticable
 *
 * Interfaz que deben implementar las clases que permitan trabajar con autorización.
 *
 * autor: Robert Sallent
 * última revisión: 22/03/2023
 *
 */

    interface Authorizable{
        
        // método que comprueba si un autorizable tiene un rol determinado
        public function hasRole(string $role):bool;

        // método que permite añadir un nuevo rol
        public function addRole(string $role);
        
        // método que permite quitar un rol
        public function removeRole(string $role);
        
        // método que recupera la lista completa de roles
        public function getRoles():array;

        // método que indica si un autorizable tiene rol de admin
        public function isAdmin():bool;    
    }

