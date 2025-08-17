<?php

/**
 *   Clase Email
 *
 *   Facilita la tarea de enviar emails.
 *
 *   Última mofidicación: 12/02/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 */
class Email{
    
    /** @var $date string fecha actual */
    public string $date; 
    
    /** @var $to string destinatario del email */
    public string $to;
    
    /** @var $from string remitente del email */
    public string $from;
    
    /** @var $name string nombre del remitente */
    public string $name;
    
    /** @var $subject string asunto del mensaje */
    public string $subject;
    
    /** @var $message string cuerpo del mensaje */
    public string $message;
    
    /** @var $headers string cabeceras adicionales */
    public string $headers;
    
    /**
     * Constructor de la clase Email
     * 
     * @param string $to destinatario del email
     * @param string $from remitente del mensaje
     * @param string $name nombre del remitente
     * @param string $subject asunto del mensaje
     * @param string $message cuerpo del mensaje
     */
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
        $this->message = "<h1>MENSAJE</h1>";
        $this->message .= "<p>De $this->name ($this->from).";
        $this->message .= "Recibido el $this->date.</p>"; 
        $this->message .= "<h2>$this->subject</h2>";
        $this->message .= "<p>$message</p>"; 
    }
      
    /**
     * Envía el email usando la función mail() de PHP
     * 
     * @return bool
     * 
     * @throws EmailException en caso de no poder enviar el mensaje
     */
    public function send():bool{
        
        if(!mail($this->to, $this->subject, $this->message, $this->headers))
            throw new EmailException("No se pudo enviar el email.");
        
        return true;
    }     
}


