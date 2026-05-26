<?php

/** ForgotPasswordController
 *
 * Se usa para regenerar la clave del usuario en caso de que lo solicite.
 *
 * Última revisión: 19/05/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 */   

class ForgotPasswordController extends Controller{
    
    /** Muestra el formulario que solicita una nueva clave. */
    public function index():Response{
        return view('forgotpassword');
    } 
    
    
    
    /**
     * Genera una nueva clave y la envía.
     * 
      @throws SQLException solamente en modo DEBUG, si no se puede generar y guardar la nueva clave 
      @throws EmailException solamente en modo DEBUG, si no se pudo enviar el email.
     */
    public function send():Response{
        
       // comprueba que llega el formulario vía POST
       if(!$this->request->post('nueva'))
           throw new FormException("No se ha recibido el formulario.");
       
       // comprueba que llega el token CSRF y que es válido
       CSRF::check($this->request->post('csrf_token'));
       
       // toma el email y el teléfono
       $email = $this->request->post('email'); 
       $phone = $this->request->post('phone'); 
       
       // recupera el usuario con ese email y teléfono
       $user = User::getByPhoneAndMail($phone, $email); 
       
       // Si los datos no eran correctos, vuelve al formulario
       if(empty($user)){
            Session::error("Los datos no coinciden.");
            return redirect('/forgot-password');
       }
       
       // si todo fue bien, genera un nuevo password
       $password = uniqid(); 
       
       // y actualiza el password del usuario con el que se acaba de generar
       // lo guarda encriptado
       $user->password = md5($password);    
       
       try{
            // actualiza los datos del usuario en la base de datos
            $user->update();
            
            // prepara y envía el email
            $this->prepareAndSendEmail($user, $password);
            
            // flashea mensaje de éxito y redirige a login
            Session::success("Nueva clave generada, consulta tu email.");
            return redirect('/Login');
                  
        // si no se pudo actualizar el password
        }catch(PDOException $e){
            
            Session::error("No se ha podido actualizar la clave, contacta con el administrador
                           mediante el formulario de contacto y pide que te la genere manualmente.");
            
            // si estamos en modo DEBUG, relanzamos la excepción
            if(DEBUG) throw new SQLException($e->getMessage());
            
            return redirect("/Login");
            
        // si no se pudo enviar el email            
        }catch(EmailException $e){
            Session::error("No se ha podido enviar el email con la nueva clave, contacta con el administrador
                           mediante el formulario de contacto y pide que te la genere manualmente.");
            
            // si estamos en modo DEBUG, relanzamos la excepción hacia el Kernel
            if(DEBUG) throw $e;
            
            return redirect("/Login");
        }
    }
    
    
    
    /**
     * Prepara y envía el email de recuperación de password
     *
     * @param User $user usuario al que se le envía el email
     * @param string $password nuevo password generado
     */
    private function prepareAndSendEmail(User $user, string $password):void{
        
        // prepara el email
        $to       = $user->email;
        $from     = DEFAULT_EMAIL;
        $name     = "Sistema de generación de claves de ".APP_NAME;
        $subject  = "Esta es tu nueva clave de acceso";
        
        $message  = "<p>La nueva clave es  <b>{$password}</b>, recuerda cambiarla cuanto antes mejor.</p>";       
        $message .= "<h2>Enlaces útiles</h2>";        
        $message .= "<p>Deberás identificarte primero con tu nueva clave.</p>";
        
        $message .= "<ul>";
        $message .= "<li><a href='".APP_URL."'>Portada de ".APP_NAME."</a></li>."; 
        $message .= "<li><a href='".APP_URL."/user/home'>Espacio personal.</a></li>";       
        $message .= "<li><a href='".APP_URL."/user/change-password'>Cambio de clave</a>.</li>";
        $message .= "</ul>";
        
        // prepara el email con los datos adecuados
        $email = new Email($to, $from, $name, $subject, $message);
        
        // envía el email
        $email->send();
    }  
}
    
    
    