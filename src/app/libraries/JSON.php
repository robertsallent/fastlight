<?php

/**
 *   Json
 *
 *   Herramientas para trabajar con JSON desde PHP.
 *
 *   Última mofidicación: 05/04/2024
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 */

class JSON{
    
    /**
     * Codifica objetos o arrays en JSON.
     *
     * @param mixed $objetos los datos a pasar a JSON.
     * @param bool $exceptions permite indicar si se deben lanzar excepciones ante un fallo o no.
     * @param bool $pretty permite indicar si queremos usar tabuladores y saltos de línea para una impresión amigable.
     * 
     * @return string el texto con los datos codificados en JSON.
     */
    public static function encode(
        $datos, 
        bool $exceptions = true, 
        bool $pretty = false 
    ):string{
        
        // FIXME: he quitado el JSON_NUMERIC_CHECK por problemas con los códigos postales, hay que comprobar si funciona bien todo lo demás
        return json_encode(
            $datos, 
            JSON_UNESCAPED_UNICODE |  JSON_UNESCAPED_SLASHES | ($exceptions ? JSON_THROW_ON_ERROR : 0) |  ($pretty ? JSON_PRETTY_PRINT : 0)
        );
    }
    
    
    /**
     * Decodifica JSON y lo convierte en una lista de objetos.
     *
     * @param string $json texto en JSON que queremos convertir a lista de objetos PHP.
     * @param string $class clase a la que queremos convertir los objetos de primer nivel de profindidad.
     * @param bool $exceptions permite indicar si se deben lanzar excepciones ante un fallo o no.
     *
     * @return array el listado de objetos recuperados.
     */
    
    public static function decode(
        string $json,  
        string $class = 'stdClass', 
        bool $exceptions = true       
    ):?array{
        
        $lista = json_decode($json, false, 512, $exceptions? JSON_THROW_ON_ERROR : 0);
        
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

