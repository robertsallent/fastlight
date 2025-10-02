<?php

/** CookieController
 *
 * Implementa el mecanismo de "aceptar cookies".
 *
 * Última revisión: 24/09/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.2.2
 * @since v2.0.9 añadido método policy(), que carga la vista con la política de cookies.
 */

class CookieController extends Controller{
    
    /**
     * Implementa el mecanismo de "aceptar cookies"
     * 
     * @return Response
     */
    public function accept():Response{
                
        // comprueba que llega el formulario
        if($this->request->has('accept')){
            
            // crea la cookie para saber que han aceptado las cookies
            Response::addCookie(ACCEPT_COOKIES_NAME, true, ACCEPT_COOKIES_EXPIRATION, '/');

            // redirige a la operación que se estuviera intentando hacer
            return redirect($this->request->previousUrl);
        }
        
        // si no llegó el formulario, redirigimos a la portada
        return redirect('/');
    }  
    
    
    /**
     * Muestra la política de cookies
     *
     * @return ViewResponse
     */
    public function policy(){
        return view('politicacookies');
    }
}

