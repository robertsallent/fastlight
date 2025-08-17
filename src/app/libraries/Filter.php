<?php
    
/**
 * Filter
 *
 * Para trabajar con filtros y búsquedas. 
 * 
 * Guarda los filtros en sesión, para que combinen bien con herramientas
 * como paginación y para mejorar la usabilidad.
 *
 * Última revisión 23/03/24
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 */
    
class Filter{
    
    /** @var string $text texto de búsqueda */
    public string $text; 
    
    /** @var string $field campo en el que buscar */
    public string $field;               
    
    /** @var string $order campo para la ordenación */
    public string $orderField;          
    
    /** @var string $order sentido de la ordenación, ASC o DESC */
    public string $order;  
    
    /** @var string $fields nombres de los campos del formulario */
    protected static array $fields = [
        'filter'        => 'filtrar',       // nombre para una petición de nuevo filtro
        'removeFilter'  => 'quitarFiltro',  // nombre para una petición de quitar filtro
        'text'          => 'texto',         // nombre del input para el texto
        'field'         => 'campo',         // nombre del input para el campo 
        'orderField'    => 'campoOrden',    // nombre del input para el campo de ordenación
        'order'         => 'sentidoOrden'   // nombre del input para el campo de sentido
    ];
    
    
    /**
     * Constructor de Filter
     *
     * @param string $text texto a buscar
     * @param string $field campo en el que realizar la búsqueda
     * @param string $orderField campo para la ordenación de los resultados
     * @param string $order sentido de la ordenación: ASC o DESC
     */
    public function __construct(
        string $text        = '%',
        string $field       = 'id',
        string $orderField  = 'id',
        string $order       = 'DESC'
    ){
        $this->text         = $text;
        $this->field        = $field;
        $this->orderField   = $orderField;
        $this->order        = $order; 
    }
    
    
    
    /**
     * Método para aplicar o quitar filtros.
     * 
     * Este es el método clave para utilizar el sistema de filtrado de Fastlight. 
     * Analiza la petición POST para saber si debe aplicar o quitar un filtro y
     * trabaja con las sesiones tanto para guarda, recuperar o eliminar los filtros. 
     *
     * @param string $name nombre del filtro en sesión, para que no se confunda con otros filtros que pudieran haber sido aplicados.
     *
     * @return ?Filter el filtro guardado en sesión o NULL.
     */
    public static function apply(
        string $name = 'standardFilter' 
    ):?Filter{
        
        $request = request();
        
        // si nos están pidiendo aplicar un nuevo filtro...
        if($request->has(self::$fields['filter'])){ 
                            
            // prepara el nuevo filtro             
            $filtro = new Filter(
                $request->post(self::$fields['text']) ?? '',
                $request->post(self::$fields['field']),
                $request->post(self::$fields['orderField']),
                $request->post(self::$fields['order']),
            );
            
            // guarda el nuevo filtro en sesión
            Session::set("_filter_$name", $filtro); 
        }
        
        
        // si se pide quitar un filtro
        if($request->has(self::$fields['removeFilter']))
            Session::forget("_filter_$name");
            
            
        // pase lo que pase, hay que ecuperar y retornar el filtro desde la variable de sesión
        return Session::has("_filter_$name") ? Session::get("_filter_$name") : NULL;        
    }   
    
    
    /**
     * Método toString()
     * 
     * retorna una representación en texto para el filtro. Puede ser usado en las vistas.
     * 
     * @return string
     */
    public function __toString():string{
        
        $texto = empty($this->text) ?
            "Todos los resultados. " :
            "Datos filtrados por <b>'$this->field'</b> = <b>'$this->text'</b>. ";
        
        $texto .= "Ordenado por <b>'$this->orderField'</b> ";
        
        $texto .= $this->order == 'ASC'?
            " ascendente. " :
            " descendente. ";
                
       return $texto;
    }
}
    
