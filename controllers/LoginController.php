<?php
    
/* Clase: LoginController
 *
 * Controlador para la operación de login
 *
 * Autor: Robert Sallent
 * Última revisión: 07/03/2023
 *
 */

    class LoginController{
        
        // muestra el formulario de login
        public function index(){
            require '../views/login.php';        
        }
        
        // método que gestiona la identificación y da acceso o no
        public function enter(){
            
            // comprobar que llegan los datos
            if(empty($_POST['login']))
                throw new LoginException('No se recibió el formulario de LogIn.');
            
            // recuperar usuario (o email) y clave
            $user = DB::escape($_POST['user']);
            $password = md5($_POST['password']);    // la clave va en MD5
            
            $identificado = (USER_PROVIDER)::identificar($user, $password); // recuperar el usuario
            
            if(!$identificado)
                throw new LoginException('Los datos de identificación no son correctos.');
        
            Login::set($identificado); // vincula el usuario a la sesión
            
            // nos lleva a la home del usuario
            //URL::redirect("/User/home");
            
            URL::redirect("/");
        }
    }
    
    
    