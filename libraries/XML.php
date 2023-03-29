<?php
/* 
 * Clase para la manipulación de XML
 * Autor: Robert Sallent
 * Última revisión: 28/02/2022
 * 
 * */

class XML{
   
    // método que valida con XMLSchema
    public static function validateWithSchema(
        string $xml, 
        string $esquema
        
    ):bool{
        
        $dom = new DOMDocument();
        
        if(!@$dom->loadXML($xml)) // intenta cargar el XML
            throw new XMLException("XML mal formado.");

        return $dom->schemaValidate($esquema);
    }
    
    
    
    // convierte listas de cualquier tipo de objeto en XML.
    public static function encode(
        array  $lista = [],         // lista de elementos a codificar
        string $root = 'root',      // nombre del elemento raíz
        string $name = null,        // nombre para cada elemento
        string $namespace = 'http://ejemplo.xml.robertsallent.cat'
        
    ):string{
            
        // crea el documento XML con las opciones adecuadas
        $xml = new DOMDocument("1.0", "utf-8");
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
        
        $raiz = $xml->createElement($root); // crea el elemento raíz
        $raiz->setAttribute('xmlns', $namespace); // pone el namespace
        
        foreach($lista as $objeto){ // para cada objeto de la lista
            // crea un nuevo elemento con el nombre indicado
            // si no estaba indicado, usará el nombre de la clase en minúscula
            $nombre = $name ?? strtolower(get_class($objeto));
            $elemento = $xml->createElement($nombre);
            
            foreach($objeto as $campo=>$valor) // para cada propiedad del objeto...
                $elemento->appendChild($xml->createElement($campo, $valor));
                
            // añade el nuevo elemento al elemento raíz
            $raiz->appendChild($elemento);
        }
        
        // añade el elemento raíz al documento XML
        $xml->appendChild($raiz);
        
        // retorna el resultado a modo de string en formato XML
        return $xml->saveXML();
    }
    
    
    
    // Método que recupera objetos desde un XML
    public static function decode(
        string $origen,             // origen del XML
        string $clase = 'stdClass', // clase a la que se mapeará
        bool $fichero = true        // XML desde fichero?
        
    ):array{
        
        // cargamos el XML depediendo de si es de fichero o string
        $xml = $fichero?
        simplexml_load_file($origen):
        simplexml_load_string($origen);
        
        $lista = []; // lista de objetos
        
        // para cada objeto que encontremos en el XML...
        foreach($xml as $objetoXML){
            $objeto = new $clase(); // crea un nuevo objeto
            
            // mapea los datos del XML al objeto
            foreach($objetoXML as $campo=>$valor)
                $objeto->$campo = (string) $valor;
                
            $lista[]=$objeto; // añade el objeto recuperado a la lista
        }
        
        return $lista; // retorna la lista con los resultados
    }
}

