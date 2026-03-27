<?php
    
/** LoginController
 *
 * Gestiona la operación de LogIn.
 * 
 * Última revisión: 27/03/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * 
 * @since v1.8.4 se comprueba que el usuario no tenga ROLE_BLOCKED.
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
        return Login::guest() ? view('login') : redirect(REDIRECT_AFTER_LOGIN);
    }
    
    
    
    /**
     * Gestiona la identificación y da acceso o no a la aplicación.
     * 
     * @return RedirectResponse
     */
    public function enter():RedirectResponse{
        
        // esta operación tan solo la pueden realizar los usuarios no identificados
        Auth::guest();  
        
        // comprueba que llega el formulario de Login via POST
        if(!$this->request->post('login')){
            Session::error("No se recibió el formulario de LogIn.");
            return redirect('/Login');
        }
        
        // comprueba que llega el token CSRF y que es válido
        // TODO: en la versión 2.0 esto se implementará mediante un middleware
        CSRF::check($this->request->post('csrf_token'));
            
        // recupera el usuario (email)
        $user       = $this->request->post('user');
        
        // recupera el password, no se sanea para no cambiar los caracteres 
        // especiales por otros ni eliminar los espacios de los extremos. 
        // TODO: sustituir el mecanismo de encriptado por otro más seguro (bcrypt)
        $password   = md5($_POST['password']);          
        
        // recupera el usuario con los datos enviados desde el formulario de LogIn
        $identificado = User::authenticate($user, $password); 
        
        // si la identificación no es correcta...
        if(!$identificado){
            Session::error("Los datos de identificación no son correctos para $user.");
            
            // registra el error de Login en el fichero de Log (si está activado en el config)
            if(LOG_LOGIN_ERRORS)
                Log::addMessage(LOGIN_ERRORS_FILE, 'ERROR', "Intento de identificación incorrecto para $user.");
            
            // Guarda el error de login en BDD (si está activado en el config)
            if(DB_LOGIN_ERRORS)
                AppError::new('Login', "Intento de identificación incorrecto para $user.");
            
            // redirecciona de nuevo al formulario de login
            return redirect('/Login');
        }
        
        
        // si el usuario identificado está bloqueado...
        if($identificado->hasRole('ROLE_BLOCKED')){
            
            // flashea el mensaje de error configurado en el fichero de configuración
            Session::error(BLOCKED_MESSAGE);
            
            // redirecciona a la URL indicada en el fichero de configuración
            return redirect(BLOCKED_REDIRECT);
        }
        
            
        // si las cosas han ido bien, vincula el usuario a la sesión
        Login::set($identificado); 
              
        // toma la operación pendiente (si la hay) y la borra de sesión
        $pending = Session::get('_pending_operation');
        Session::forget('_pending_operation');
        
        // redirecciona a la operación pendiente o bien donde indique el config.php o bien a portada
        return redirect($pending ?? REDIRECT_AFTER_LOGIN ?? '/');
    }
}


