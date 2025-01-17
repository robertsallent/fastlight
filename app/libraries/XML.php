<?php

/**
 *   XML
 *
 *   Herramientas para trabajar fácilmente con XML desde PHP.
 *
 *   Última mofidicación: 14/01/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 */

class XML{
   
    /**
     * Valida un XML a partir de un XMLSchema
     *
     * @param string $xml XML a validar.
     * @param string $schema esquema contra el que se quiere realizar la validación.
     *
     * @return bool true si valida o false si no lo hace.
     * 
     * @throws XMLException si no se puede cargar el XML.
     */
    
    // TODO: arreglar este método para que sea recursivo y genere un XML en condiciones
    public static function validateWithSchema(
        string $xml, 
        string $schema   
    ):bool{
        
        $dom = new DOMDocument();
        
        if(!@$dom->loadXML($xml)) // intenta cargar el XML
            throw new XMLException("XML mal formado.");

        return $dom->schemaValidate($schema);
    }
    
    
    
    /**
     * Convierte listas de elementos a XML.
     * 
     * @param array $lista lista de elementos a convertir.
     * @param string $root nombre para el elemento raíz.
     * @param string $name nombre para cada uno de los elementos contenidos directamente dentro del elemento raíz.
     * @param string $namespace espacio de nombres a usar.
     * 
     * @return string el XML con el resultado.
     */
    public static function encode(
        array  $list     = [],
        string $root      = 'root',
        string $name      = null,
        string $namespace = "https://xml.robertsallent.com"       
    ):string{
           
        // crea el documento XML con las opciones adecuadas
        $xml = new DOMDocument("1.0", "utf-8");
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;
     
        $raiz = $xml->createElement($root); // crea el elemento raíz
        $raiz->setAttribute('xmlns', $namespace); // pone el namespace

        foreach($list as $objeto){ // para cada objeto de la lista
            // crea un nuevo elemento con el nombre indicado
            // si no estaba indicado, usará el nombre de la clase en minúscula
            $nombre = $name ?? strtolower(get_class($objeto));
            $elemento = $xml->createElement($nombre);
            
            foreach($objeto as $campo => $valor){ // para cada propiedad del objeto...
               
                // corrección para que funcionen los campos JSON con arrays
                if(is_array($valor))
                    $valor = arrayToString($valor, true, false);
                
                $elemento->appendChild($xml->createElement($campo, htmlspecialchars($valor)));
            }
            // añade el nuevo elemento al elemento raíz
            $raiz->appendChild($elemento);
        }
        
        // añade el elemento raíz al documento XML
        $xml->appendChild($raiz);
        
        // retorna el resultado a modo de string en formato XML
        return $xml->saveXML();
    }
    
    
    
    /**
     * Recupera objetos desde un origen XML
     * 
     * @param string $origin origen de datos XML.
     * @param string $class nombre de la clase a la que queremos mapear los objetos recuperados en primer nivel de profundidad.
     * @param bool $file para indicar si los datos llegan de fichero (true) o url (false).
     * 
     * @return array lista de objetos PHP recuperados desde el XML.
     */
    public static function decode(
        string $origin,
        string $class = 'stdClass',
        bool $file    = true 
    ):array{
        
        // carga el XML depediendo de si es de fichero o string
        $xml = $file ? @simplexml_load_file($origin) : @simplexml_load_string($origin);
        
        // si no se pudo recuperar bien el XMl, se lanza una excepción
        if(!$xml)
            throw new XmlException("Se produjo un error al recuperar el XML.");
        
        $lista = []; // lista de objetos
        
        // para cada objeto que encontremos en el XML...
        foreach($xml as $objetoXML){
            $objeto = new $class(); // crea un nuevo objeto
            
            // mapea los datos del XML al objeto
            foreach($objetoXML as $campo=>$valor)
                $objeto->$campo = (string) $valor;
                
            $lista[]=$objeto; // añade el objeto recuperado a la lista
        }
        
        return $lista; // retorna la lista con los resultados
    }
}

