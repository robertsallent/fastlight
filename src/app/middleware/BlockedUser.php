<?php

/** Blocked User middleware
 *
 * Comprueba si el usuario que ha hecho login está bloqueado. En caso de estarlo,
 * le muestra un mensaje y lo redirige al lugar configurado en config/middleware.php
 *
 * Última revisión: 31/03/2026
 *
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.6.5
 */

class BlockedUser{
    
    /**
     * El método handle() es invocado automáticamente por el Kernel
     *
     * @param Request $request petición
     * @param Closure $next siguiente método a ser invocado (para el pipeline)
     * @return Response la respuesta final a retornar al cliente
     */
    public function handle(Request $request, Closure $next){
            
        // tomamos el usuario identificado
        $user = user();
        
        // si hay usuario identificado y está bloqueado...
        if($user && $user->hasRole(ROLE_BLOCKED) && request()->url != BLOCKED_REDIRECT){
            
            // echa al usuario de la sesión
            Login::unset();
            
            // flashea el mensaje de error configurado en el fichero de configuración
            Session::error(BLOCKED_MESSAGE);
            
            // redirecciona a la URL indicada en el fichero de configuración
            return redirect(BLOCKED_REDIRECT);
        }
                
        // deja avanzar la petición por el pipeline
        return $next($request);
    }  
}

