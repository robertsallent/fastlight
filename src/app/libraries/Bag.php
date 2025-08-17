<?php

/**
 *   Clase Bag
 *
 *   Bolsa de objetos.
 *
 *   Última mofidicación: 02/12/2024
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.3.0
 *   @since v1.3.7 se añaden los métodos addAll(), pop() y __toString()
 */
class Bag{
    
    /** @var array lista de elementos en la bolsa */
    private array $items = [];
    
    
    /**
     * Recupera todos los elementos en la bolsa, a modo de array.
     * 
     * @return array
     */
    public function getItems():array{
        return $this->items;
    }
    
    
    /**
     * Añade un elemento al final de la bolsa
     * 
     * @param unknown $item
     */
    public function push($item){
        $this->items[] = $item; 
    }
    
    
    /**
     * Añade todos los elementos de una lista a la bolsa
     * 
     * @param array $items
     */
    public function addAll(array $newItems){
        $this->items = array_merge($this->items, $newItems);
    }
    
    
    /**
     * Extrae el último elemento de la bolsa
     *
     * @return unknown $item
     */
    public function pop(){
        return array_pop($this->items);
    }
    
     
    /**
     * Extrae un elemento de la posición deseada de la bolsa
     * @param int $i
     * @return unknown $item
     */
    public function extract(int $i){
        return array_splice($this->items, $i, 1)[0];
    }
    
    
    
    /**
     * Convierte a cadena de texto (para las pruebas)
     * 
     * @return string
     */
    public function __toString(){
        $text = '';
        
        foreach($this->items as $item)
            $text .= "$item, ";
        
        return substr($text, 0, strlen($text)-2);
    }
}

