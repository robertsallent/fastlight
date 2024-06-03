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
    
    /** Aceptar las cookies */
    public function accept(){
                
        // comprueba que llega el formulario
        if($this->request->has('accept')){
            
            // crea la cookie para saber que han aceptado las cookies
            Cookie::set(ACCEPT_COOKIES_NAME, true, ACCEPT_COOKIES_EXPIRATION, '/');
            
            // redirige a la operación que se estuviera intentando hacer
            redirect($this->request->previousUrl);
        }
        
        // si no llegó el formulario, redirigimos a la portada
        redirect('/');
    }  
}

