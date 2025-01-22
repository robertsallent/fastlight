<?php

/** Debug
 *
 * Para preparar mensajes de error cuando la aplicación está en modo DEBUG.
 *
 * Última modificación: 20/01/2025.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class DebugInformation{
    
    
    private Throwable $throwable;
    private string $controller;
    private string $method;
    private array $parameters; 
    
    
    /**
     * Constructor de DebugInformation
     * 
     * @param Throwable $t error producido
     * @param string $controlador  controlador solicitado mediante la URL
     * @param string $metodo método solicitado mediante la URL
     * @param array $parametros parámetros adicionales en la URL
     */
    public function __construct(
        Throwable $t,
        string $controlador,
        string $metodo, 
        array $parametros = []
        
    ){
        $this->throwable    = $t;
        $this->controller   = $controlador;
        $this->method       = $metodo;
        $this->parameters   = $parametros;
    }
    
    /**
     * Prepara la información de depuración en formato HTML.
     * 
     * Se usa desde el fichero App.php, es llamado cuando se produce una excepción.
     *
     * @return string
     */
    public function toHtml():string{
        
        
        // mensaje principal del error
        $mensaje = "<p>".$this->throwable->getMessage()."</p>";
        
       
        $mensaje .= "</section>";
        
        // INFORMACIÓN EXTRA PARA AYUDAR A LA DEPURACIÓN
        $mensaje .= "<section class='m2'>";
        
        $mensaje .= "<h2>DEBUG MODE ON</h2>";
        
        $mensaje .= "<p>Los datos que se muestran a continuación son visibles porque 
                     la aplicación se encuentra en <b>modo DEBUG</b>, en producción
                     nunca debe estar activado este modo. Para desactivarlo pon valor 
                     <code>false</code> en la constante <code>DEBUG</code> del fichero
                     <b class='italic'>config.php</b>.</p>";
        
        $mensaje .= "<p class='italic'>Opciones seleccionadas en la configuración: <b>".arrayToString(DEBUG_INFO, false, false)."</b>.</p>";
        
        // tipo del error producido
        $mensaje .= "<p>El error que se ha producido es de tipo <b class='maxi'>".get_class($this->throwable)."</b></p>";
        
        $mensaje .= "</section>";
        
        // si en el config.php se solicita información del usuario...
        if(in_array('user', DEBUG_INFO)){
            
            $mensaje .= "<section class='m2'>";
            $mensaje .= "<h3>Datos del usuario y cliente</h3>";
            
            if($user = user()){
                $mensaje .= "<p><span class='label'>Usuario</span> <b>$user->displayname</b> (<i>$user->email</i>).</p>";
                $mensaje .= "<p><span class='label'>Roles</span> <b>".arrayToString($user->roles, false, false)."</b></p>";
            }else
                $mensaje .= "<p>No hay usuario identificado</p>";
            
            $mensaje .= "<p><span class='label'>IP remota</span> <b>".request()->ip."</b></p>";
            $mensaje .= "<p><span class='label'>User Agent</span> <i>".request()->userAgent."</i>.</p>";
            
            $mensaje .= "</section>";
        }
        
        // si en el config.php se solicita traza del error...
        if(in_array('trace', DEBUG_INFO)){
            
            $mensaje .= "<section class='m2'>";
            $mensaje .= "<h3>Controlador y método</h3>";
            
            // datos de la solicitud concreta
            $mensaje .= $this->controller ? "<p><span class='label'>Controlador solicitado</span> <b>$this->controller</b></p>" : '';
            $mensaje .= $this->method ? "<p><span class='label'>Método de controlador</span> <b>$this->method()</b></p>" : '';
            $mensaje .= $this->parameters ? "<p><span class='label'>Parámetros</span> <b>".arrayToString($this->parameters, false, false)."</b></p>" : '';
            
                        
            // comprueba si ese controlador tiene ese método y éste puede ser invocado
            $mensaje .= !method_exists($this->controller, $this->method)?
            "<p>La combinación indicada de controlador y método <b class='error inline-block p1'>NO EXISTE</b>,
                 comprueba si se trata de un error tipográfico o implementa el método
                 <code>$this->method()</code> en el fichero <i>mvc/controllers/$this->controller.php</i>.</p>" :
                 "<p>La combinación indicada de controlador y método <b class='success inline-block p1'>SÍ EXISTE</b>,
                 así que puede que tengas que revisar el método <b>$this->method()</b>
                 en <b>$this->controller</b>.</p>";
            
            // localización del error
            $mensaje .= "<h3>Localización del error ".get_class($this->throwable)."</h3>";
            $mensaje .= "<p><span class='label'>Fichero</span> <b>".$this->throwable->getFile()."</b></p>";
            $mensaje .= "<p><span class='label'>Línea</span> <b>".$this->throwable->getLine()."</b></p>";
            $mensaje .= "<p><span class='label'>Error Trace</span></p>";
            $mensaje .= "<p>".arrayToString($this->throwable->getTrace(), true, true, ", ").".</p>";
            
           
            
            $mensaje .= "</section>";
        }
        
        
         
        // información de la petición
        if(in_array('request', DEBUG_INFO)){
            
            $mensaje .= "<section class='m2'>";
            $mensaje .= "<h3>Petición HTTP</h3>";
            
            // datos de la petición HTTP
            $mensaje .= "<p><span class='label'>URL</span> <b>".request()->url."</b></p>";
            $mensaje .= "<p><span class='label'>Método HTTP</span> <b>".request()->method."</b></p>";
            
            // datos recibidos por POST
            $mensaje .= "<p><span class='label'>POST</span></p><p>";
            $mensaje .= request()->posts() ?
                arrayToString(request()->posts(), false, true, '<br>')."</p>":
                "No se recibieron datos.</p>";
            
                
            // datos recibidos por GET
            $mensaje .= "<p><span class='label'>GET</span></p><p>";
            $mensaje .= request()->gets() ?
                arrayToString(request()->gets(), false, true, '<br>')."</p>":
                "No se recibieron datos.</p>";
            
            // datos recibidos por COOKIE
            $mensaje .= "<p><span class='label'>COOKIE</span></p><p>";
            $mensaje .= request()->cookies() ?
                arrayToString(request()->cookies(), false, true, '<br>')."</p>":
                "No se recibieron datos.</p>";
            
            // datos en FILES
            $mensaje .= "<p><span class='label'>FILES</span></p><p>";
            $mensaje .= $_FILES ?
                arrayToString($_FILES, false, true, '<br>')."</p>":
                "No se recibieron datos.</p>";
            
            $mensaje .= "<p><span class='label'>Token CSRF</span> <b>".(request()->csrfToken ?? ' Ninguno recibido ')."</b></p>";
            $mensaje .= "<p><span class='label'>URL anterior</span> <b>".(request()->previousUrl ?? ' Sin datos ')."</b></p>";
                
            $mensaje .= "</section>";
        }
        

  
        // información guardada en sesión
        if(in_array('session', DEBUG_INFO)){
            $mensaje .= "<section class='m2'>";
            $mensaje .= "<h3>Variables de sesión</h3>";
            $mensaje .= "<p><span class='label'>SESSION</span></p><p>".arrayToString(Session::all(), false, true, '<br>')."</p>";
            
            $mensaje .= "</section>";
        }
         
        $mensaje .= "<section class='m2 centrado danger'> -- Fin del informe de depuración -- ";
        
        return $mensaje;
    }  
}