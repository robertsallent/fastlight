<?php
    
/** LoginController
 *
 * Gestiona la operación de LogIn
 *
 * Última revisión: 23/03/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class LoginController extends Controller{
    
    /** Muestra el formulario de login. */
    public function index(){
        Auth::guest();              // solo para usuarios no identificados
        $this->loadView('login');   // carga la vista de login     
    }
    
    /**
     * Gestiona la identificación y da acceso o no a la aplicación.
     */
    public function enter(){
        Auth::guest();  // solo para usuarios no identificados
        
        // comprobar que llegan los datos
        if(!$this->request->has('login')){
            Session::error("No se recibió el formulario de LogIn.");
            redirect('/Login');
        }
        
        // recuperar usuario (o email) y clave (encriptada)
        $user       = $this->request->post('user');
        $password   = md5($this->request->post('password'));          
        
        $identificado = (USER_PROVIDER)::authenticate($user, $password); // recuperar el usuario
        
        if(!$identificado){
            Session::error("Los datos de identificación no son correctos para $user.");
            
            if(LOG_LOGIN_ERRORS)
                Log::addMessage(LOGIN_ERRORS_FILE, 'ERROR', "Intento de identificación incorrecto para $user.");
            
            if(DB_LOGIN_ERRORS)
                AppError::create('Login', "Intento de identificación incorrecto para $user.");
                
            redirect('/Login');
        }
        
        Login::set($identificado); // vincula el usuario a la sesión
        
        // redirección tras Login
        redirect(Session::getFlash('pending_operation') ?? REDIRECT_AFTER_LOGIN ?? '/');
    }
}


