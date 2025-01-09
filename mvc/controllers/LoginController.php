<?php
    
/** LoginController
 *
 * Gestiona la operación de LogIn
 *
 * Última revisión: 09/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class LoginController extends Controller{
    
    
    
    /** Muestra el formulario de login. */
    public function index():Response{
        Auth::guest();   // solo para usuarios no identificados
        return view('login');   // carga la vista de login     
    }
    
    
    
    /**
     * Gestiona la identificación y da acceso o no a la aplicación.
     */
    public function enter():Response{
        // esta operación tan solo la pueden realizar los usuarios no identificados
        Auth::guest();  
        
        // comprobar que llega el formulario de Login
        if(!$this->request->has('login')){
            Session::error("No se recibió el formulario de LogIn.");
            return redirect('/Login');
        }
        
        // comprobar que llega el token CSRF
        CSRF::check($this->request->post('csrf_token'));
            
        // recuperar usuario (email) y la clave (hay que encriptarla)
        $user       = $this->request->post('user');
        $password   = md5($this->request->post('password'));          
        
        // recuperamos el usuario con esos datos
        $identificado = (USER_PROVIDER)::authenticate($user, $password); 
        
        // si la identificación no es correcta...
        if(!$identificado){
            Session::error("Los datos de identificación no son correctos para $user.");
            
            if(LOG_LOGIN_ERRORS)
                Log::addMessage(LOGIN_ERRORS_FILE, 'ERROR', "Intento de identificación incorrecto para $user.");
            
            if(DB_LOGIN_ERRORS)
                AppError::new('Login', "Intento de identificación incorrecto para $user.");
                
            return redirect('/Login');
        }
        
        // si las cosas han ido bien...
        
        Login::set($identificado); // vincula el usuario a la sesión
              
        // toma la operación pendiente (si la hay) y la borra de sesión
        $pending = Session::get('_pending_operation');
        Session::forget('_pending_operation');
        
        // redirección a la operación pendiente o bien donde indique el config.php o bien a portada
        return redirect($pending ?? REDIRECT_AFTER_LOGIN ?? '/');
    }
}


