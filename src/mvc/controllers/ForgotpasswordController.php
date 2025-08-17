<?php

/** ForgotpasswordController
 *
 * Se usa para regenerar la clave del usuario en caso de que lo solicite.
 *
 * Última revisión: 08/03/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */   

class ForgotpasswordController extends Controller{
    
    /** Muestra el formulario que solicita una nueva clave. */
    public function index():Response{
        return view('forgotpassword');
    } 
    
    /**
     * Genera una nueva clave y la envía.
     * 
     * @throws Exception solamente en modo DEBUG, 
     * si no se puede generar y guardar la nueva clave o si no se
     * pudo enviar el email.
     */
    public function send():Response{
        
       // comprueba que llega el formulario 
       if(!$this->request->has('nueva'))
           throw new FormException("No se recibió el formulario.");
       
       // comprueba que llega el token CSRF y que es válido
       // TODO: en la versión 2.0 esto se implementará mediante un middleware
       CSRF::check($this->request->post('csrf_token'));
       
       // toma el email y el teléfono
       $email = $this->request->post('email'); 
       $phone = $this->request->post('phone'); 
       
       // recupera el usuario con ese email y teléfono
       $user = User::getByPhoneAndMail($phone, $email); 
       
       // Si los datos no eran correctos, vuelve al formulario
       if(!$user){
            Session::error("Los datos no son válidos.");
            return redirect('/Forgotpassword');
       }
       
       // si todo fue bien, genera un nuevo password
       $password = uniqid(); 
       
       // y actualiza el password del usuario con el que se acaba de generar
       // lo guarda encriptado
       $user->password = md5($password);    
       
       try{
            $user->update();    // actualiza el usuario en la base de datos
            
            // prepara el email
            $to       = $user->email;
            $from     = "passwordrecovery@fastlight.com";
            $name     = "Sistema de generación de claves";
            $subject  = "Aquí tienes tu nueva clave de acceso";
            $message  = "Tu nueva clave es: <b>$password</b>, recuerda que 
                         la debes cambiar lo antes posible.";
            
            // envía el email
            (new Email($to, $from, $name, $subject, $message))->send();
            
            Session::success("Nueva clave generada, consulta tu email.");
            return redirect('/Login');
            
       // si no se pudo actualizar el password
       }catch(SQLException $e){
           Session::error("No se pudo actualizar el password.");
        
           if(DEBUG)
               throw new SQLException($e->getMessage());
           
           return redirect("/Login");
           
       // si no se pudo enviar el email
       }catch(EmailException $e){
           Session::error("No se pudo enviar el email, contacta con el administrador.");
           
           if(DEBUG)
               throw new EmailException($e->getMessage());
           
           return redirect("/Login");       
       }
    }
}
    
    
    