<?php

/**
 *   Clase Email
 *
 *   Facilita la tarea de enviar emails.
 *  
 * Consulta la documentación y ejemplos en:
 *   https://fastlight.org/Backend/email
 *
 *   Última mofidicación: 22/09/2025
 *
 *   @author Robert Sallent <robertsallent@gmail.com>
 */
class Email{
    
    /** @var $date string fecha actual */
    public string $date; 
    
    /** @var $to string destinatario del email */
    public string $to;
    
    /** @var $subject string asunto del mensaje */
    public string $subject;
    
    /** @var $message string cuerpo del mensaje */
    public string $message;
    
    /** @var $from string remitente del email (ej: 'no-reply@fastlight.org') */
    public ?string $from;
    
    /** @var $name string nombre del remitente (ej: 'Mensajería de FastLight') */
    public ?string $name;
    
    /** @var $realFrom string email del remitente físico (para la operación de contacto, ej: 'pepe@fastlight.org') */
    public ?string $realFrom;
    
    /** @var $realName string nombre del remitente físico (para la operación de contacto, ej: 'Pepe') */
    public ?string $realName;
      
    /** @var $headers string cabeceras adicionales */
    public string $headers;
    
    /**
     * Constructor de la clase Email
     * 
     * @param string $to destinatario del email
     * @param string $subject asunto del mensaje
     * @param string $message cuerpo del mensaje
     * @param ?string $from dirección de correo para el envío del email (por ejemplo 'noreply@fastlight.org')
     * @param ?string $name nombre del remitente para el envío del email (por ejemplo 'Fastlight Contact Form')
     * @param ?string $realFrom email de la persona que se pone en contacto (para la operación de contacto)
     * @param ?string $realName nombre de la persona que se pone en contacto (para la operación de contacto)
     */
    public function __construct(
        string $to,
        string $subject,
        string $message,
        ?string $from     = null, // si no está indicado, lo toma de config.php (DEFAULT_EMAIL)  
        ?string $name     = null, // si no está indicado, lo toma de config.php (DEFAULT_EMAIL_NAME)        
        ?string $realFrom = null,
        ?string $realName = null 
    ){
        
        $this->date         = date('d/m/y H:i:s');
        $this->to           = $to;
        $this->subject      = $subject;
        $this->from         = $from ?? (defined('DEFAULT_EMAIL') ? DEFAULT_EMAIL : null);
        $this->name         = $name ?? (defined('DEFAULT_EMAIL_NAME') ? DEFAULT_EMAIL_NAME : null);     
        $this->realFrom     = $realFrom;
        $this->realName     = $realName;
        
        // montando las cabeceras del mensaje
        // el mensaje tendrá formato HTML
        $this->headers  = "MIME-Version: 1.0\r\n";
        $this->headers .= "Content-type: text/html; charset=utf-8\r\n";
        $this->headers .= "From: $this->name <$this->from>\r\n";
        
        // preparando el cuerpo del mensaje
        $this->prepareMessage($message);
    }
    
    
    
    /**
     * Texto del mensaje, personalizar al gusto. 
     * 
     * @param string mensaje
     */
    protected function prepareMessage(string $message){
    
        $this->message = "
            <h2>MENSAJE</h2>
            <p>
                De ".($this->realName ?? $this->name)." (".($this->realFrom ?? $this->from)."). 
                Recibido el $this->date.
            </p>
                <h2>$this->subject</h2>
                
                <p>$message</p> 
                <hr>
                <p>Enviado desde $this->name
            </p>";
    }
      

    
    /**
     * Envía el email usando la función mail() de PHP
     * 
     * @param ?string $to email del destinatario, permite enviar a otro destinatario sin cambiar ninguna otra propiedad del email
     * @return bool
     * 
     * @throws EmailException en caso de no poder enviar el mensaje
     */
    public function send(?string $to = NULL):Email{
        
        // modifica el servidor SMTP si está configurado en el fichero de configuración
        if(defined('SMTP'))
            ini_set("SMTP", SMTP);
        
        // modifica el puerto SMTP si está configurado en el fichero de configuración
        if(defined('SMTP_PORT'))
            ini_set("smtp_port", SMTP_PORT);
        
        // envía el email, si no puede lanza una excepción EmailException
        if(!mail($to ?? $this->to, $this->subject, $this->message, $this->headers))
            throw new EmailException("No se pudo enviar el email.");
        
        // retorna el propio objeto, para permitir chaining
        return $this;
    }     
}


