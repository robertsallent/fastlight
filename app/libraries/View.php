<?php


/** View
 *
 * Trabajo con vistas
 *
 * Última revisión: 24/05/2024
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.3.0
 */

class View{

    /** @var string nombre de la vista */
    private string $name;
    
    /** @var array parámetros de la vista */
    private array $parameters;
    
    
    /**
     * Constructor 
     * 
     * @param string $name nombre de la vista
     * @param array $parameters parámetros a pasar a la vista
     */
    public function __construct(
        string $name,
        array $parameters = []
    ){
        $this->name       = $name;
        $this->parameters = $parameters;
    }
    
    
    /**
     * Comprueba si una vista existe y es legible
     * 
     * @param string $name nombre de la vista a cargar
     * 
     * @return bool true solo si la vista existe y es legible
     */
    public static function exists(string $name):bool{
        return is_readable(VIEWS_FOLDER."/$name.php");
    }
    
    
    /**
     * Carga la vista
     */
    public function load(){
        
        // crea las variables a partir de las claves del array en este ámbito
        foreach($this->parameters as $variable => $valor)
            $$variable = $valor;
            
        // carga la vista indicada desde el directorio de vistas
        try{
            @require VIEWS_FOLDER."/$this->name.php";
            
        }catch(Throwable $e){
            $message = DEBUG ?
            "<p>ERROR en la vista <b>".VIEWS_FOLDER."/$this->name.php</b>.</p>
             <p>INFORMACIÓN ADICIONAL: ".$e->getMessage()."</p>" :
             "Error al cargar la página.";
            
             throw new ViewException($message);
        }
    }
    

    
    /**
     * Carga la vista de error personalizado adecuada al código de error HTTP ocurrido
     * 
     * @param int $code código HTTP
     * @param string $parameters parámetros a pasar a la vista (normalmente será el mensaje de error).
     */
    public static function loadHttpErrorView(
        int $code, 
        array $parameters = []
    ){
        $name = (!DEBUG && USE_CUSTOM_ERROR_VIEWS && viewExists("httperrors/".$code)) ? "httperrors/".$code : 'error';
        (new View($name, $parameters))->load();
    }
    
    
    
    /**
     * carga una vista de error personalizada si se puede o la vista de error genérica.
     * 
     * @param int $code código de error HTTP.
     * @param array $parameters nuevos parámetros para la vista de error
     */
    public function error(
        int $code,
        array $parameters = NULL
    ){
        self::loadHttpErrorView($code, $parameters ?? $this->parameters);
    }
    
}

