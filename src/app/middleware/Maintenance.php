<?php

/** Maintenance middleware
 *
 * Middleware que comprueba si la aplicación está en modo mantenimiento y redirige
 * a la operación de mantenimiento
 * 
 * Se puede saltar el modo mantenimiento indicando un parámetro ?passkey=xxx en la URL
 * con la clave definida en el fichero config.php. Este paso saltándose el modo mantenimiento
 * tiene duración de sesión.
 *
 * Última revisión: 31/03/2026
 *
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.6.0
 */

class Maintenance{
    
    /**
     * El método handle() es invocado automáticamente por el Kernel
     * 
     * @param Request $request petición
     * @param Closure $next siguiente método a ser invocado (para el pipeline)
     * @return Response la respuesta final a retornar al cliente
     */
    public function handle(Request $request, Closure $next):Response{
            
        // si está activado el modo mantenimiento
        if (defined('MAINTENANCE_MODE') && MAINTENANCE_MODE === true ){
            
            // comprueba si llega la clave de passthroug
            $pass = $request->get('passkey');
            
            // en caso de que llegue y sea correcta, hay que guardarla para la sesión actual
            if($pass && $pass == MAINTENANCE_PASSKEY)
                Session::set('_maintenance_passthrough', 1);
            
            // si no está activado el passthroug, echamos al usuario a la vista mantenimiento    
            if(!$pass = Session::get('_maintenance_passthrough'))    
                return view('error/maintenance');
        }
                
        // deja avanzar la petición por el pipeline
        return $next($request);
    }   
}

