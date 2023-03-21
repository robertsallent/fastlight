<?php

/* Clase: Email
 * 
 * Nos facilitará la tarea de enviar emails
 * 
 * Autor: Robert Sallent
 * Última mofidicación: 24/02/2023
 * 
 */

class Email{
    
    // PROPIEDADES
    public string $date, $to, $from, $name, $subject, $message, $headers;
    
    // CONSTRUCTOR
    public function __construct(
        string $to,         // destinatario
        string $from,       // remitente
        string $name,       // nombre
        string $subject,    // asunto
        string $message     // mensaje
    ){
        $this->date = date('d/m/y H:i:s');
        $this->to = $to;
        $this->from = $from;
        $this->name = $name;
        $this->subject = $subject;
        
        // el mensaje será con formato HTML
        $this->headers = "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-type: text/html; charset=utf-8\r\n";
        $this->headers .= "To: <$this->to>\r\n";
        $this->headers .= "From: $this->name <$this->from>\r\n";
        
        // preparamos el mensaje que se enviará
        $this->message = "<h2>MENSAJE</h2>";
        $this->message .= "<p>De $this->name ($this->from).";
        $this->message .= "Recibido el $this->date.</p>"; 
        $this->message .= "<h3>$this->subject</h3>";
        $this->message .= "<p>$message</p>"; 
    }
      
    // método que envía el email usando la función mail() de PHP
    public function send():bool{
        if(!mail($this->to, $this->subject, $this->message, $this->headers))
            throw new EmailException("No se pudo enviar el email.");
        
        return true;
    }     
}


