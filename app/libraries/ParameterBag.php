<?php

/**
 * Clase para trabajar con colecciones de parámetros
 * 
 * @author Robert Sallent <robert@juegayestudia..com>
 * @since v1.2.1
 *
 */
class ParameterBag{
    
    /** @var array $parameters lista de parámetros en la bolsa */
    private array $parameters = [];
    
    
    /**
     * Añade un parámetro a la bolsa 
     * 
     * @param string $key clave 
     * @param mixed $value valor
     */
    public function add(string $key, mixed $value){
        $this->parameters[$key] = $value;
    }
    
    
    /**
     * Elimina un parámetro de la bolsa
     * 
     * @param string $key clave
     */
    public function remove(string $key){
        unset($this->parameters[$key]);
    }
    
    
    /**
     * Comprueba si existe un parámetro concreto en la bolsa de parámetros
     * 
     * @param string $key clave
     * 
     * @return bool si el parámetro existe o no
     */
    public function has(string $key):bool{
        return isset($this->parameters[$key]);
    }
}