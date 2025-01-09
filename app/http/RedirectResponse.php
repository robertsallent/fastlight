<?php

/** RedirectResponse
 *
 * Respuestas de redirección HTTP
 *
 * Última modificación: 09/01/2025
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.5.0
  */


class RedirectResponse extends Response{
        
    /** @var string $url dirección a la que se debe redireccionar */
    protected string $url;
    
    /** @var int $delay tiempo de espera antes de redireccionar */
    protected string $delay;
        
  
    /**
     * Constructor de RedirectResponse
     * 
     * @param string $url dirección para la redirección
     * @param int $delay tiempo de espera
     * @param int $httpCode código HTTP
     * @param string $status frase correspondiente al estado
     */
    public function __construct(
        string $url  = '/',
        int $delay    = 0,
        int $httpCode       = 302,
        string $status      = 'FOUND'
    ){    
        // llama al constructor de la clase padre
        parent::__construct('text/html', $httpCode, $status);
        
        // propiedades no heredadas
        $this->url      = $url;
        $this->delay     = $delay;
    }
    
    
    /**
     * Getter de url
     *
     * @return string
     */
    public function getUrl():string{
        return $this->url;
    }
    
    
    /**
     * Setter de url
     *
     * @param string $url
     */
    public function setUrl(string $url){
        $this->url = $url;
    }
    
    
    
    /**
     * Getter de delay
     * 
     * @return int $delay
     */
    public function getDelay():int{
        return $this->delay;
    }
    
    
    /**
     * Setter de delay
     * 
     * @param string $delay
     */
    public function setDelay(int $delay){
        $this->delay = $delay;
    }
       
        
    
    /**
     * Realiza una redirección HTTP
     * 
     * @param bool $show permite indicar si se quiere mostrar el mensaje de redirección
     */
    public function send(bool $show = false){
        
        // añade el header necesario para la redirección HTTP
        self::addHeader("Refresh:$this->delay; URL=$this->url");
        
        $this->prepare(); // prepara la respuesta
        
        if($show)
            echo "Redireccionando a $this->url en $this->delay segundos.";
        
        die();
    }
}

