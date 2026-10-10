<?php

/**
 * LoginThrottle
 *
 * Impide realizar nuevos intentos de login mientras
 * el usuario/IP se encuentre temporalmente bloqueado.
 *
 * Este middleware se ejecuta en todas las rutas, pero
 * solamente actúa cuando detecta el formulario de login.
 *
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.15.0
 * 
 * Última revisión: 10/10/2026
 * 
 */
class LoginThrottle{

    /**
     * Ejecuta el middleware.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next):Response{

        // si no llega el formulario de login o el throttling está desactivado, no hace nada y deja continuar la petición
        if(!$request->has('login') || !LOGIN_THROTTLE)
            return $next($request);


        // si llega el formulario de login, realiza las comprobaciones necesarias

        // recupera el usuario y la IP
        $user = trim($request->post('user'));
        $ip   = $_SERVER['REMOTE_ADDR'] ?? '';


        // primero comprobamos el límite global por IP para evitar ataques de fuerza bruta
        if(LoginAttempt::attemptsByIp($ip) >= LOGIN_IP_MAX_ATTEMPTS){

            $seconds = LoginAttempt::remainingIpBlockTime($ip);

            // guarda el tiempo restante en sesión para mostrarlo en la vista
            Session::set('_login_block_seconds', $seconds);

            // flashea el mensaje en sesión para que se muestre en la vista
            Session::danger("Demasiados intentos de identificación desde tu IP, inténtalo de nuevo en {$seconds} segundos.");

            // no permite que la petición llegue al controlador, redirige a login
            return redirect('/login');
        }

        // recupera el registro de intentos para este usuario/IP
        $attempt = LoginAttempt::attemptsByUserAndIp($user, $ip);

        // si el bloqueo ya ha caducado, lo elimina para permitir nuevos intentos
        if($attempt && $attempt->blocked_until && strtotime($attempt->blocked_until) <= time()){
            $attempt->deleteObject();
            $attempt = null;
        }

        // si no hay intentos registrados o no está bloqueado, continúa normalmente con la petición
        if(!$attempt || !$attempt->isBlocked())
            return $next($request);


        // en caso contrario, obtiene el tiempo restante de bloqueo
        $seconds = $attempt->remainingBlockTime();

        // guarda el tiempo restante en sesión para poderlo mostrar en la vista
        Session::set('_login_block_seconds', $seconds);

        // guarda el mensaje en sesión para informar al usuario desde la vista
        Session::error("Demasiados intentos, inténtalo de nuevo en {$seconds} segundos.");

        // no permite que la petición llegue al controlador y redirige a login
        return redirect('/login');
    }
}