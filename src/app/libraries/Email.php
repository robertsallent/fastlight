<?php

/**
 *   Clase Email
 *
 *   Facilita la tarea de enviar emails.
 *
 *   Última mofidicación: 01/09/2025
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
     * @param string $from dirección de correo para el envío del email (por ejemplo 'noreply@fastlight.org')
     * @param string $name nombre del remitente para el envío del email (por ejemplo 'Fastlight Contact Form')
     * @param string $subject asunto del mensaje
     * @param string $message cuerpo del mensaje
     * @param ?string $realFrom email de la persona que se pone en contacto (para la operación de contacto)
     * @param ?string $realName nombre de la persona que se pone en contacto (para la operación de contacto)
     */
    public function __construct(
        string $to,        
        string $from,      
        string $name,      
        string $subject,   
        string $message,   
        ?string $realFrom = null,
        ?string $realName = null 
    ){
        $this->date = date('d/m/y H:i:s');
        $this->to = $to;
        $this->from = $from;
        $this->name = $name;
        $this->subject = $subject;
        $this->realFrom = $realFrom;
        $this->realName = $realName;
        
        // el mensaje será con formato HTML
        $this->headers = "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-type: text/html; charset=utf-8\r\n";
        $this->headers .= "From: $this->name <$this->from>\r\n";
        
        // preparamos el mensaje que se enviará
        $this->message = "<h1>MENSAJE</h1>";
        $this->message .= "<p>De ".($this->realName ?? $this->name)." (".($this->realFrom ?? $this->from)."). ";
        $this->message .= "Recibido el $this->date.</p>"; 
        $this->message .= "<h2>$this->subject</h2>";
        $this->message .= "<p>$message</p>"; 

        $this->message .= "<hr><p>Enviado desde $this->name</p>";
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


