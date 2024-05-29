<?php

/**
 *   Clase Cookie
 *
 *   Facilita la tarea de enviar y recuperar cookies.
 *
 *   Última mofidicación: 29/05/2024
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 *   @since v1.2.2
 */
class Cookie{
    
    
    public static function get(
        string $name        // nombre de la cookie
    ): ?string{
        return Kernel::getRequest()->cookie($name);
    }
}


