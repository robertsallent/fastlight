<?php
    
/** LoginController
 *
 * Gestiona la operación de LogIn.
 * 
 * Última revisión: 10/10/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * 
 */

class LoginController extends Controller{
    
    
    
    /**
     * Muestra el formulario de LogIn
     * 
     * En caso de que el usuario ya estuviera identificado, hace una redirección hacia
     * la operación configurada tras login en el fichero config.php
     * 
     * @return Response la vista de login o una redirección
     */
    public function index():Response{
        
        // recupera el tiempo restante de bloqueo (si lo hay) y lo borra de sesión
        $blockSeconds = (int) Session::get('_login_block_seconds');
        Session::forget('_login_block_seconds');
        
        return Login::guest() ? view('login', [
            'blockSeconds' => $blockSeconds
        ]) : redirect(REDIRECT_AFTER_LOGIN);
    }
    
    
    
    /**
     * Gestiona la identificación y da acceso o no a la aplicación.
     * 
     * @return RedirectResponse
     */
    public function enter():RedirectResponse{
        
        // si ya estabas identificado, te lleva al home
        if(Login::check())
            return redirect('/user/home');
        
        // comprueba que llega el formulario de Login via POST
        if(!$this->request->post('login')){
            Session::error("No se recibió el formulario de LogIn.");
            return redirect('/login');
        }
        
        // comprueba que llega el token CSRF y que es válido
        CSRF::check();
            
        // recupera el usuario (email)
        $user  = $this->request->post('user');
        $ip    = $_SERVER['REMOTE_ADDR'] ?? '';
        
        
        // recupera el password, no se sanea para no cambiar los caracteres 
        // especiales por otros ni eliminar los espacios de los extremos. 
        // TODO: sustituir el mecanismo de encriptado por otro más seguro (bcrypt)
        $password = md5($_POST['password']);   
              
        // recupera el usuario con los datos enviados desde el formulario de LogIn
        $identificado = User::authenticate($user, $password); 
        
        // si la identificación no es correcta...
        if(!$identificado){
            
            // si está activado el middleware de limitación de intentos de login, registra el intento fallido
            if(LOGIN_THROTTLE){
                
                // recuperaremos los intentos fallidos anteriores
                $attempt = LoginAttempt::attemptsByUserAndIp($user, $ip);
                
                // si todavía no existe registro, lo crea
                if(!$attempt){
                    
                    $attempt = new LoginAttempt();
                    
                    $attempt->user          = $user;
                    $attempt->ip            = $ip;
                    $attempt->attempts      = 0;
                    $attempt->last_attempt  = date('Y-m-d H:i:s');
                    $attempt->blocked_until = null;
                    
                    $attempt->save();
                }
                
                // registra el intento fallido
                $attempt->failed();
                
                // si el usuario está bloqueado, guarda el tiempo restante en sesión
                if($attempt->isBlocked())
                    Session::set('_login_block_seconds', $attempt->remainingBlockTime());
                    
            }
            
            
            Session::error("Los datos de identificación no son correctos para {$user}.");
            
            // registra el error de Login en el fichero de Log (si está activado en el config)
            if(LOG_LOGIN_ERRORS)
                Log::addMessage(LOGIN_ERRORS_FILE, 'ERROR', "Intento de identificación incorrecto para {$user}.");
            
            // Guarda el error de login en BDD (si está activado en el config)
            if(DB_LOGIN_ERRORS)
                (AppError::new('Login', "Intento de identificación incorrecto para {$user}."))->save();
            
            // redirecciona de nuevo al formulario de login
            return redirect('/login');
        }
                
        // si las cosas han ido bien, vincula el usuario a la sesión
        Login::set($identificado); 
        
        // regenera el ID de sesión (buena práctica)
        session_regenerate_id(true);
              
        // toma la operación pendiente (si la hay) y la borra de sesión
        $pending = Session::get('_pending_operation');
        Session::forget('_pending_operation');
        
        // redirecciona a la operación pendiente o bien donde indique el config.php o bien a portada
        return redirect($pending ?? REDIRECT_AFTER_LOGIN ?? '/');
    }
}