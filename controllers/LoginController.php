<?php
    
/* Clase: LoginController
 *
 * Controlador para la operación de login
 *
 * Autor: Robert Sallent
 * Última revisión: 21/03/2023
 *
 */

    class LoginController extends Controller{
        
        // muestra el formulario de login
        public function index(){
            Auth::guest();  // solo para usuarios no identificados
            $this->loadView('login');        
        }
        
        // método que gestiona la identificación y da acceso o no
        public function enter(){
            Auth::guest();  // solo para usuarios no identificados
            
            // comprobar que llegan los datos
            if(empty($_POST['login'])){
                Session::error("No se recibió el formulario de LogIn.");
                redirect('/Login');
                return;
            }
            
            // recuperar usuario (o email) y clave
            $user = DB::escape($_POST['user']);
            $password = md5($_POST['password']);    // la clave va en MD5
            
            $identificado = (USER_PROVIDER)::authenticate($user, $password); // recuperar el usuario
            
            if(!$identificado){
                Session::error("Los datos de identificación no son correctos para $user.");
                
                if(LOG_LOGIN_ERRORS)
                    Log::addMessage(LOGIN_ERRORS_FILE, 'ERROR', "Intento de login incorrecto para $user.");
                
                if(DB_LOGIN_ERRORS)
                    AppError::create($_GET['url'], 'LOGIN', "Intento de login incorrecto para $user.");
                    
                redirect('/Login');
                return;
            }
            
            Login::set($identificado); // vincula el usuario a la sesión
            
            // TODO: editar la redirección final para que nos lleve a la home del usuario
            // como aún no tenemos esta operación, redirigiremos a la portada
            redirect("/");  // redirect("/User/home");
        }
    }
    
    
    