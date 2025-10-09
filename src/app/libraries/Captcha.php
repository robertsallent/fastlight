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
     * 
     * @param int $long número de caracteres a generar (opcional, por defecto 4)
     * @param bool $isNumeric si el captcha debe ser solo numérico o por el contrario alfanumérico
     * 
     * @return string la cadena de texto con el captcha que se debe mostrar en el formulario
     */
    public static function generate(
        int $long = 4, 
        bool $numeric = true
    ):string{

        $result = "";

        // calcula el valor aleatorio
        if($numeric){
            for($i = 0 ; $i< $long; $i++)
                $result .= random_int(0,9);
        }else{
            $letras = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            for($i = 0 ; $i< $long; $i++)
                $result .= $letras[random_int(0, strlen($letras)-1)];
        }

        // lo guarda en sesión
        Session::set('Captcha', $result);

        // lo retorna
        return $result;
    }


    /**
     * Comprueba que el texto coincide con el texto del captcha guardado en sesión
     * 
     * @param ?string $text texto a comprobar (vendrá desde el formulario)
     * 
     * @return bool true si es correcto o false si no lo es
     */
    public static function verify(?string $text = ''):bool{
        return $text == Session::get('Captcha');

    }
    
}


    
