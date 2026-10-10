<?php

/*
 *   Clase: CSRF
 * 
 *   Gestiona la creación y validación de tokens CSRF para proteger los formularios
 *   de ataques de falsificación de solicitudes entre sitios (Cross-Site Request Forgery).
 * 
 *   Autor: Robert Sallent <robert@fastlight.org>
 * 
 *   Última modificación: 10/10/2026
 *
 * 
*/

class CSRF{
    
    // crea un nuevo token CSRF y lo guarda en sesión
    public static function create():string{
        
        // genera un token criptográficamente seguro de 256 bits
        $value = bin2hex(random_bytes(32));
        
        // guarda el token en sesión
        Session::set('csrf_token', $value);
        
        return $value;                      
    }
    
    
    // método que compara el token que se le pasa con el guardado en sesión
    public static function check(
        ?string $token = null,
        bool $forget   = false
    ):void{
        // si no se le pasa el token, intenta recuperarlo por POST
        $token = $token ?? request()->post('csrf_token');

        // si aún así no hay token, lanza una excepción
        if(!$token)
            throw new CsrfException("No se recibió el token CSRF.");
        
        // recupera el token almacenado en sesión
        $storedToken = Session::get('csrf_token');

        // si no había token en sesión, lanza una excepción
        if(!$storedToken)
            throw new CsrfException("No existe el token CSRF.");
        
        // compara ambos tokens de forma segura
        if(!hash_equals($storedToken, $token))
            throw new CsrfException("No se pudo validar el token CSRF.");
              
        // si todo es correcto, borra el token de sesión (si se indica)
        if($forget)
            self::forget();
    }
    
    
    // método que añade un token CSRF al formulario
    public static function createInput(): string{
    
        // si ya hay un token en sesión, lo recupera; si no, crea uno nuevo
        $token = Session::has('csrf_token')
            ? Session::get('csrf_token')
            : self::create();

        // devuelve un input oculto con el token CSRF
        return "<input type='hidden' name='csrf_token' value='{$token}'>";
    }
    
    
    // método que olvida un token CSRF
    public static function forget():void{
        Session::forget('csrf_token');
    }
    
}


    
