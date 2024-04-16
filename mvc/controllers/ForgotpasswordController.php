<?php

/** ForgotpasswordController
 *
 * Se usa para regenerar la clave del usuario en caso de que lo solicite.
 *
 * Última revisión: 30/06/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */   

class ForgotpasswordController extends Controller{
    
    /** Muestra el formulario que solicita una nueva clave. */
    public function index(){
        view('forgotpassword');
    } 
    
    /**
     * Genera una nueva clave y la envía.
     * 
     * @throws Exception solamente en modo DEBUG, 
     * si no se puede generar y guardar la nueva clave o si no se
     * pudo enviar el email.
     */
    public function send(){
        
       if(empty($_POST['nueva']))
           throw new Exception("No se recibió el formulario.");
           
       $email = $this->request->post('email'); // recupera el email
       $phone = $this->request->post('phone'); // recupera el teléfono
       
       $user = User::getByPhoneAndMail($phone, $email); // busca el usuario
       
       if(!$user){
            Session::error("Los datos no son válidos.");
            redirect('/Forgotpassword');
       }
       
       $password = uniqid();                // genera el nuevo password
       $user->password = md5($password);    // lo guarda en el user (encriptado)
       
       try{
            $user->update();    // actualiza el user
            
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
            redirect('/Login');
            
       // si no se pudo actualizar el password
       }catch(SQLException $e){
           Session::error("No se pudo actualizar el password.");
        
           if(DEBUG)
               throw new Exception($e->getMessage());
           else
               redirect("/Login");
           
       // si no se pudo enviar el email
       }catch(EmailException $e){
           Session::error("No se pudo enviar el email, contacta con el administrador.");
           
           if(DEBUG)
               throw new Exception($e->getMessage());
           else
               redirect("/Login");       
       }
    }
}
    
    
    