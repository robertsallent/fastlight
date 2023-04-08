<?php
    
/* Clase: JsonLoginController
 *
 * Controlador para el login en JSON mediante API
 *
 * Autor: Robert Sallent
 * Última revisión: 08/04/2023
 *
 */

    class JsonLoginController extends Controller{
        
        // Constructor
        public function __construct(){
            header('Content-Type:application/json; charset=utf-8');
        }
        
        // Login
        public function post(){
            
            // Auth::guest();   // solo para usuarios no identificados
            
            // recuperar los datos en crudo en el body de la petición
            $json = $this->request->body();
            
            if(empty($json)) // si no llegan los datos...
                throw new LoginException('No se indicaron datos de identificación');
                
            // convierte el JSON recibido a PHP
            // En caso de que el JSON tenga errores de sintaxis se lanzará una excepción
            $login = JSON::decode($json)[0];
             
            // recuperar usuario (o email) y clave (encriptada)
            $user     = $login->user;
            $password = md5($login->password);
            
            $identificado = (USER_PROVIDER)::authenticate($user, $password); // recuperar el usuario
            
            $response = new stdClass();
            
            // si hubo un error de identificación
            if(!$identificado){
                $response->status = "LOGIN ERROR";
                
                if(LOG_LOGIN_ERRORS)
                    Log::addMessage(LOGIN_ERRORS_FILE, 'API_ERROR', "Intento de identificación API incorrecto para $user.");
                    
                if(DB_LOGIN_ERRORS)
                    AppError::create('API Login', "Intento de identificación API incorrecto para $user.");
            
                header("HTTP/1.1 401 Unauthorized");
                
            // si se pudo identificar correctamente al usuario
            }else{
                Login::set($identificado); // vincula el usuario a la sesión.
                $response->status = "OK";
                $response->message = "Identificación correcta";
                
                // Cálculo del token CSRF
                $response->csrfToken = md5($user.uniqid());
                Session::set('csrf_token', $response->csrfToken);
                
                if(DEBUG)
                    $response->sessionId = session_id();
            }   
            
            // retorna la respuesta en JSON
            echo JSON::encode($response);
        }
        
        
        
        // Logout
        public function delete(){
            
            // Auth::check();   // solo para usuarios identificados
            
            Login::clear();  // elimina los datos de sesión y desvincula el usuario
            $response = new stdClass();
            $response->status = "OK";
            $response->message = "LogOut realizado correctamente";
            
            echo JSON::encode($response);
        }
    }
    
    
    