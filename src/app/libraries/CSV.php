<?php

/**
 *   CSV
 *
 *   Herramientas para trabajar con CSV desde PHP.
 *
 *   Última mofidicación: 14/01/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   
 *   @since v1.5.1
 */

class CSV{
    
    /**
     * Codifica un array de objetos a CSV.
     *
     * @param array $datos lista de objetos a pasar a CSV.
     * @param string $fieldSeparator separador de campos, por defecto la coma.
     * @param string $entitySeparator separador de entidades, por defecto el salto de línea
     * @param bool $columnHeaders permite indicar si queremos una primera fila con los nombres de los campos
     * 
     * @return string el texto con los datos codificados en CSV.
     */
    public static function encode(
        array $datos, 
        string $fieldSeparator   = ",",
        string $entitySeparator   = "\n",
        bool $columnHeaders = true
    ):string{
        
        $csv = "";
        
        // si queremos generar la fila de encabezados (y hay datos)
        if($columnHeaders && sizeof($datos)){
            foreach($datos[0] as $propiedad => $valor)
                $csv .= $propiedad.$fieldSeparator;
            
            $csv = rtrim($csv, $fieldSeparator);    // quita el último separador de campos
            $csv .= $entitySeparator;               // añade el separador de entidades
        }
        
        // para cada entidad a añadir al CSV...
        foreach($datos as $entidad){

            // para cada campo de cada entidad
            foreach($entidad as $propiedad => $valor)
                
                if(gettype($valor)=='array')
                    $csv .= arrayToString($valor, false, false, " ").$fieldSeparator;
                else
                    $csv .= $valor.$fieldSeparator;
       
            $csv = substr($csv, 0, strlen($csv)-1); // quita el último separador de campos
            $csv .= $entitySeparator;               // añade el separador de entidades
        }
        
       return $csv; // retorna el código CSV
    }
    
    
    /**
     * Decodifica un string CSV y lo convierte en una lista de objetos.
     *
     * @param string $csv texto en CSV que queremos convertir a lista de objetos PHP.
     * @param string $class clase a la que queremos convertir los objetos (por defecto stdClass).
     * @param bool $columnHeaders permite indicar si están indicados los nombres de los campos,
     * si no lo estuvieran, los nombres de las propiedades serían genéricos.
     *
     * @return array el listado de objetos recuperados.
     */
    
    public static function decode(
        string $csv,  
        string $class       = 'stdClass', 
        bool $columnHeaders = true       
    ):object{
        
        $object = new $class();
        
        // TODO: falta implementar este método
        
        return $object;
    }
}

