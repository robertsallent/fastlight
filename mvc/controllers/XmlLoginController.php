<?php
    
use http\Client\Response;

/** XmlLoginController
 *
 * Gestiona el login XML para la API
 *
 * Última revisión: 15/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */


class XmlLoginController extends Controller{
          
    /**
     * Gestiona la identificación a partir de una petición POST con XML en el body.
     *
     * @return XmlResponse
     * 
     * @throws LoginException si la identificación no es correcta.
     */
    public function post():XmlResponse{
        
        Auth::guest();   // solo para usuarios no identificados
        
        
        $xml = $this->request->body(); // recuperar los datos en crudo en el body de la petición
        
        if(empty($xml)) // si no llegan los datos...
            throw new LoginException('No se indicaron datos de identificación');
            
        // convierte el XML recibido a PHP
        // En caso de que el XML tenga errores de sintaxis se lanzará una excepción
        $login = XML::decode($xml, 'stdClass', false)[0];
                     
        // tomar usuario (o email) y clave (encriptada) desde lo recuperado
        $user     = $login->user ?? '';
        $password = md5($login->password ?? '');
        
        $identificado = (USER_PROVIDER)::authenticate($user, $password); // recuperar el usuario
        
       
        // si hubo un error de identificación
        if(!$identificado){
            
            if(LOG_LOGIN_ERRORS)
                Log::addMessage(LOGIN_ERRORS_FILE, 'API_ERROR', "Intento de identificación API incorrecto para $user.");
                
            if(DB_LOGIN_ERRORS)
                AppError::new('API Login', "Intento de identificación API incorrecto para $user.");

            throw new LoginException('Los datos de identificación no son correctos');
            
        // si se pudo identificar correctamente al usuario
        }else{
            
            Login::set($identificado); // vincula el usuario a la sesión.
            
            $response = new XmlResponse([], "Identificación correcta");
            $response->csrfToken = CSRF::create(); // Cálculo del token CSRF
            
            if(DEBUG)
                $response->sessionId = session_id();
        }   
        
        return $response;
    }
    
    
    
    /**
     * Gestiona la operación de logout cuando se realiza una petición vía DELETE.
     * 
     * @return XmlResponse
     */
    public function delete():XmlResponse{
        
        // Auth::check();   // solo para usuarios identificados
        
        Login::clear();  // elimina los datos de sesión y desvincula el usuario
        return  new XmlResponse([], "Sayonara, baby.");
    }
}


