<?php

/* Clase: ForgotpasswordController
 *
 * Controlador para generar nuevas claves de usuario
 *
 * Autor: Robert Sallent
 * Última revisión: 27/03/2023
 *
 */
    
class ForgotpasswordController extends Controller{
    
    // método que muestra el formulario de nueva clave
    public function index(){
        $this->loadView('forgotpassword');
    } 
    
    // método que genera una nueva clave y la envía
    public function send(){
        
       if(empty($_POST['nueva']))
           throw new Exception("No se recibió el formulario.");
           
       $email = $this->request->post('email'); // recupera el email
       $phone = $this->request->post('phone'); // recupera el teléfono
       
       $user = User::getByPhoneAndMail($phone, $email); // busca el usuario
       
       if(!$user){
            Session::error("Los datos no son válidos.");
            redirect('/Login');
       }
       
       $password = uniqid();                // genera el nuevo password
       $user->password = md5($password);    // lo guarda en el user (encriptado)
       
       try{
            $user->update();    // actualiza el user
            
            // prepara el email
            $to = $user->email;
            $from = "passwordrecovery@fastlight.com";
            $name = "Sistema de generación de claves";
            $subject = "Aquí tienes tu nueva clave de acceso";
            $message = "Tu nueva clave es: <b>$password</b>, recuerda que 
                        debes cambiar a lo antes posible.";
            
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
    
    
    