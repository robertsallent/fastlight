<?php


/** View
 *
 * Trabajo con vistas
 * 
 * Es importante saber que las vistas, además de las variables mapeadas,
 * dispondrán de una variable $template y otra $identifiedUser, que contendrán
 * una referencia a la instancia del template a usar y al usuario identificado
 * respectivamente.
 *
 * Última revisión: 10/10/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.3.0
 * @since v1.5.0 añadidos setters y getters para las propiedades
 * @sicne v2.1.3 soporte para templates configurables para cada usuario
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
        string $name      = '',
        array $parameters = []
    ){
        $this->name       = $name;
        $this->parameters = $parameters;
    }
    
    
    /**
     * Setter del nombre de la vista
     * 
     * @param string $name
     */
    public function setName(string $name){
        $this->name = $name;
    }
    
    
    /**
     * Getter del nombre de la vista
     * 
     * @return string
     */
    public function getName():string{
        return $this->name;
    }
    
    
    /**
     * Setter de los parámetros
     * 
     * @param array $params
     */
    public function setParams(array $params){
        $this->parameters = $params;
    }
    
    
    /**
     * Getter de los parámetros
     * 
     * @return array
     */
    public function getParams():array{
        return $this->parameters;
    }
        
    /**
     * Añade o modifica un parámetro para la vista.
     *
     * @param string $name nombre del parámetro
     * @param mixed $value valor del parámetro
     */
    public function setParam(string $name, mixed $value){
        $this->parameters[$name] = $value;
    }
    
    
    /**
     * Elimina un parámetro para la vista.
     *
     * @param string $name nombre del parámetro a eliminar
     */
    public function removeParam(string $name){
        unset($this->parameters[$name]);
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
     * Carga la vista.
     * 
     */
    public function load(){
        
        // mapea las variables a partir de las claves del array
        foreach($this->parameters as $variable => $valor)
            $$variable = $valor;
        
        // añade una instancia del usuario identificado
        $identifiedUser = Login::user();
            
        // calcula el template a cargar en función de las preferencias del usuario 
        $template = $identifiedUser ? ($identifiedUser->template ?? TEMPLATE) : TEMPLATE;
        
        // añade la instancia del template
        $template = new $template();
            
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
}

