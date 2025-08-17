<?php

/*
 *   Clase: CSRF
 *   Autor: Robert Sallent
 *   Última mofidicación: 13/04/2023
 *
 *   Para trabajar con tokens CSRF
*/

class CSRF{
    
    // crea un nuevo token CSRF y lo guarda en sesión
    public static function create():string{
        
        $value = md5(uniqid());              // calcula un nuevo token
        // $value = base64_encode(openssl_random_pseudo_bytes(16));
        
        Session::set('csrf_token', $value);  // lo guarda en sesión
        
        return $value;                      
    }
    
    
    // método que compara el token que se le pasa con el guardado en sesión
    public static function check(
        string $token = null,
        bool $forget  = true
    ){
        
        if(!$token)
            throw new CsrfException("No se recibió el token CSRF.");
        
        if(!Session::has('csrf_token'))
            throw new CsrfException("No existe el token CSRF.");
            
        if($token != Session::get('csrf_token'))
            throw new CsrfException("No se pudo validar el token CSRF.");
              
        if($forget)
            self::forget();
    }
    
    
    // método que añade un token CSRF al formulario
    public static function createInput():string{

        return Session::has('csrf_token') ? 
            "<input type='hidden' name='csrf_token' value='".Session::get('csrf_token')."'>" :
            "";
    }
    
    
    // método que olvida un token CSRF
    public static function forget(){
        Session::forget('csrf_token');
    }
    
}


    
