<?php
    // FUNCIONES HELPER PARA DEPURACIÓN
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
    
    // array to string
    function arrayToString(array $lista):string{
        $texto = '';
        
        foreach($lista as $clave => $valor)
            $texto .= "$clave => $valor, ";
           
        return '[ '.substr($texto, 0, strlen($texto)-2).' ]';
    }
    
    // REDIRECCIONES Y URLS
    // redirect
    function redirect(string $url = '/', int $delay = 0){
        URL::redirect($url, $delay);
    }