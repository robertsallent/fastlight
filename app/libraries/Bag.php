<?php

/**
 *   Clase Bag
 *
 *   Bolsa de objetos.
 *
 *   Última mofidicación: 15/07/2024
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.3.0
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
     * Extrae un elemento de la posición deseada de la bolsa
     * @param int $i
     * @return array
     */
    public function extract(int $i){
        return array_splice($this->items, $i, 1);
    }
}

