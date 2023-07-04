<?php

/**
 * Interfaz que deben implementar las clases del núcleo como App o Api.
 * 
 * Última revisión: 04/07/23
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.9.1
 */

interface Kernel{
    
    /**
     * Método que arranca la aplicación.
     * 
     * @param Request $request petición realizada a la aplicación.
     */
    public function start(Request $request); 
    
}

