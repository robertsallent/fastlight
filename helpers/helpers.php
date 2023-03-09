<?php

/* Funciones helper para simplificar tareas habituales
 *
 *
 * autor: Robert Sallent
 * última revisión: 09/03/2023
 *
 */

    // FUNCIONES PARA DEPURACIÓN
    // dump
    function dump($thing){
        echo "<pre>";
        var_dump($thing);
        echo "</pre>";
    }
    
    // dump and die
    function dd($thing, string $message = 'Fin de la ejecución.'){
        dump($thing);
        die($message);
    }

    
    
    // FUNCIONES PARA ARRAYS Y STRINGS
    function arrayToString(array $lista):string{
        $texto = '';
        
        foreach($lista as $clave => $valor)
            $texto .= "$clave => $valor, ";
           
        return '[ '.rtrim($texto, ', ').' ]';
    }
    
    
    
    // REDIRECCIONES Y URLS
    // redirect
    function redirect(string $url = '/', int $delay = 0){
        URL::redirect($url, $delay);
    }
    
    
    