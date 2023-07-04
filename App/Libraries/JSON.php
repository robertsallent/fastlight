<?php

/*
 * Clase para la manipulación de JSON
 * Autor: Robert Sallent
 * Última revisión: 30/03/2023
 *
 * */


class JSON{
    
    // codifica objetos en JSON (tanto listas como objetos sueltos)
    public static function encode(
        $objetos,                   // datos a codificar en JSON
        bool $exceptions = true,    // indica si se deben lanzar excepciones ante un error
        bool $pretty = false        // impresión "bonita"
        
    ):string{
        
        return json_encode(
                    $objetos, 
                    JSON_UNESCAPED_UNICODE | 
                    JSON_UNESCAPED_SLASHES | 
                    JSON_NUMERIC_CHECK |
                    ($exceptions ? JSON_THROW_ON_ERROR : 0) |
                    ($pretty ? JSON_PRETTY_PRINT : 0)
                );
    }
    
    
    
    // decodifica un JSON en una lista de objetos
    public static function decode(
        string $json,                   // datos a decodificar
        string $class = 'stdClass', // tipo de los objetos recuperados
        bool $exceptions = true     // indica si se deben lanzar excepciones ante un error
        
    ):array{
        
        $lista = $exceptions ? 
                    json_decode($json, false, 99, JSON_THROW_ON_ERROR):
                    json_decode($json);
        
        // si hay error de sintaxis y no había que lanzar excepciones...
        if(json_last_error()) return NULL;
        
        // siempre recuperaremos una lista de objetos (por uniformidad)
        // si lo recuperado no es un array, lo metemos en uno
        $lista = is_array($lista) ? $lista : [$lista];
        
        // si nos piden un array de stdClass, ya podemos devolver la lista
        if($class == 'stdClass') return $lista;
        
        // en caso contrario, mapearemos los objetos al tipo deseado
        $nuevaLista = []; 
        
        // para cada objeto stdClass de la lista
        foreach($lista as $objeto){
            $nuevoObjeto = new $class(); // nuevo objeto del tipo indicado
            
            foreach($objeto as $propiedad => $valor) // volcar propiedades y valores
                 $nuevoObjeto->$propiedad = $valor;  
            
            $nuevaLista[] = $nuevoObjeto; // añade a la lista
        }
        return $nuevaLista; // retorna la lista de objetos del tipo indicado
    }  
}

