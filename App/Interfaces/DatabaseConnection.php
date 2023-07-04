<?php

/* Intarface DatabaseConnection
 *
 * Interfaz que deben implementar las clases para conectar con la BDD
 *
 * autor: Robert Sallent
 * última revisión: 08/03/2023
 *
 */

    interface DatabaseConnection{
        
        // método que recupera y retorna la conexión con la BDD
        public static function get():object;
        
        // método que realiza una consulta contra la BDD
        public static function query(string $consulta);
        
        // método para consultas de selección que retornan 1 resultado como máximo
        public static function select(string $consulta, string $class='stdClass'):?object;
        
        // alias de select() 
        public static function selectOne(string $consulta, string $class='stdClass'):?object;
        
        // método para consultas de selección que retornan más de un resultado
        public static function selectAll(string $consulta, string $class='stdClass'):array;
        
        // método para realizar consultas de inserción
        public static function insert(string $consulta):int;
        
        // método para realizar consultas de actualización
        public static function update(string $consulta):int;
        
        // método para realizar consultas de borrado
        public static function delete(string $consulta):int;
        
        // método para realizar consultas de totales
        public static function total(string $tabla, string $operacion='COUNT', string $campo='*');

        // método para escapar carácteres especiales
        public static function escape(string $texto, bool $entities = true):string;
        
    }

