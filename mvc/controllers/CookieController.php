<?php

/** CookieController
 *
 * Implementa el mecanismo de aceptar cookies
 *
 * Última revisión: 29/05/2024
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.2.2
 */

class CookieController extends Controller{
    
    // TODO: usar librería Cookie
    /** Aceptar las cookies */
    public function accept(){
                
        // comprueba que llega el formulario
        if($this->request->has('accept')){
            
            // crea la cookie para saber que han aceptado las cookies
            setcookie(ACCEPT_COOKIES_NAME, true, ACCEPT_COOKIES_EXPIRATION, '/');
            // header("Set-Cookie: ".ACCEPT_COOKIES_NAME."=true; Expires=".ACCEPT_COOKIES_EXPIRATION."; Path=/");
           
            // redirige a la operación que se estuviera intentando hacer
            redirect($this->request->previousUrl);
        }
        
        // si no llegó el formulario, redirigimos a la portada
        redirect('/');
    }  
}

