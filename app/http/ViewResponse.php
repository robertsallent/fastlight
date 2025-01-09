<?php

/** ViewResponse
 *
 * Respuestas HTTP con vistas
 *
 * Última modificación: 09/01/2025
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.5.0
 */

class ViewResponse extends Response{
        
    /** @var View $view vista a cargar */
    protected View $view;
    
   
    /**
     * Constructor de ViewResponse
     * 
     * @param string $name nombre de la vista a cargar
     * @param array $params array asociativo con los parámetros a pasar a la vista
     * @param int $httpCode código HTTP
     * @param string $status frase correspondiente al estado
     */
    public function __construct(
        string $name,
        array $params       = [],
        int $httpCode       = 200,
        string $status      = 'OK'
    ){    
        // llama al constructor de la clase padre
        parent::__construct('text/html', $httpCode, $status);
        
        // propiedades no heredadas
        $this->view = new View($name, $params);  
    }
    
    
    /**
     * Getter de view
     *
     * @return View la vista
     */
    public function getView():View{
        return $this->view;
    }
    
    
    /**
     * Setter de view
     *
     * @param View $view nueva vista a cargar
     */
    public function setView(View $view){
        $this->view = $view;
    }
    
       
    /**
     * Prepara y envía la respuesta al cliente
     */
    public function send(){      
        $this->prepare();      // añade las cookies y las cabeceras http a la respuesta
        $this->view->load();   // carga la vista
        die();                 // finaliza la ejecución
    } 
}

