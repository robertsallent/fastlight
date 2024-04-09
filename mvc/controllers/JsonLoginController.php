<?php
    
/** JsonLoginController
 *
 * Controlador para el login en JSON mediante API
 *
 * Última revisión: 09/04/2024
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class JsonLoginController extends Controller{
    
    /**
     * Realiza el login a partir de los datos que llegan vía JSON en una petición POST.
     * 
     * @throws LoginException si la identificación es incorrecta.
     */
    public function post(){
        
        Auth::guest();   // solo para usuarios no identificados
        
        // recuperar los datos en crudo en el body de la petición
        $json = $this->request->body();
        
        if(empty($json)) // si no llegan los datos...
            throw new ApiException('No se indicaron datos de identificación');
            
        // convierte a JSON los datos recibidos
        $login = JSON::decode($json)[0];
              
        $user     = $login->user;               // recupera el nombre de usuario
        $password = md5($login->password);      // recupera el password
        $identificado = (USER_PROVIDER)::authenticate($user, $password); // recupera el usuario
        
        // si hubo un error de identificación
        if(!$identificado){
            
            if(LOG_LOGIN_ERRORS)
                Log::addMessage(LOGIN_ERRORS_FILE, 'API_ERROR', "Intento de identificación API incorrecto para $user.");
                
            if(DB_LOGIN_ERRORS)
                AppError::new('API Login', "Intento de identificación API incorrecto para $user.");
        
            throw new LoginException('Los datos de identificación no son correctos');
        }
            
        // si se pudo identificar correctamente al usuario
        Login::set($identificado); // vincula el usuario a la sesión.
        
        $response = new JsonResponse([], 'Identificación correcta');
        $response->message   = "Identificación correcta";
        $response->csrfToken = CSRF::create(); // Cálculo del token CSRF
        
        if(DEBUG)
            $response->sessionId = session_id();
       
        
        // retorna la respuesta en JSON
        $response->send();
    }
    
    
    
    /**
     * Realiza el logout si llega una petición vía DELETE.
     */
    public function delete(){
        Login::clear();  // elimina los datos de sesión y desvincula el usuario
        
        $response = new JsonResponse([], 'Hasta la vista, baby');
        $response->send();
    }
}

    
    