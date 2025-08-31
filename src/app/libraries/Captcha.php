<?php

/*
 *   Clase: Captcha
 *   Autor: Robert Sallent
 *   Última mofidicación: 31/08/2025
 *
 *   Librería para generar y comprobar captchas sencillos
*/

class Captcha{
    
    
    /**
     * Genera un captcha sencillo y lo guarda en sesión. Retorna el valorgenerado
     */
    public static function generate(int $long = 4, bool $numeric = true):String{

        $result = "";

        // calcula el valor aleatorio
        if($numeric){
            for($i = 0 ; $i< $long; $i++)
                $result .= random_int(0,9);
        }else{
            $letras = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            for($i = 0 ; $i< $long; $i++)
                $result .= $letras[random_int(0, $max)];
        }

        // lo guarda en sesión
        Session::set('Captcha', $result);

        // lo retorna
        return $result;
    }


    /**
     * Comprueba que el texto coincide con el texto del captcha guardado en sesión
     */
    public static function verify(string $text):bool{
        return $text == Session::get('Captcha');

    }
    
}


    
