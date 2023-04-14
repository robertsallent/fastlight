<?php
    
/* Clase: XmlLoginController
 *
 * Controlador para el login en XML mediante API
 *
 * Autor: Robert Sallent
 * Última revisión: 14/04/2023
 *
 */

    class XmlLoginController extends Controller{
        
        // Constructor
        public function __construct(){
            header('Content-Type:application/xml; charset=utf-8');
        }
        
        // Login
        public function post(){
            
            // Auth::guest();   // solo para usuarios no identificados
            
            // recuperar los datos en crudo en el body de la petición
            $xml = $this->request->body();
            
            if(empty($xml)) // si no llegan los datos...
                throw new LoginException('No se indicaron datos de identificación');
                
            // convierte el XML recibido a PHP
            // En caso de que el XML tenga errores de sintaxis se lanzará una excepción
            $login = XML::decode($xml, 'stdClass', false)[0];
                         
            // recuperar usuario (o email) y clave (encriptada)
            $user     = $login->user;
            $password = md5($login->password);
            
            $identificado = (USER_PROVIDER)::authenticate($user, $password); // recuperar el usuario
            
            $response = new stdClass();
            
            // si hubo un error de identificación
            if(!$identificado){
                $response->status = "LOGIN_ERROR";
                $response->message = "Los datos no son correctos";
                
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
                $response->csrfToken = CSRF::create(); // Cálculo del token CSRF
                
                if(DEBUG)
                    $response->sessionId = session_id();
            }   
            
            // retorna la respuesta en XML
            echo XML::encode([$response], 'response', 'login');
        }
        
        
        
        // Logout
        public function delete(){
            
            // Auth::check();   // solo para usuarios identificados
            
            Login::clear();  // elimina los datos de sesión y desvincula el usuario
            $response = new stdClass();
            $response->status = "OK";
            $response->message = "LogOut realizado correctamente";
            
            echo XML::encode([$response], 'response', 'login');
        }
    }
    
    
    