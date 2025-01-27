<?php

/** Controller
 *
 * Clase base de la que heredarán los controladores de nuestras aplicaciones.
 *
 * Última revisión: 20/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 */
abstract class Controller{
    
    /** @var Request|null $request objeto Request con los datos de la petición. */
    protected ?Request $request = null;
    
       
    /** Constructor. */
    public function __construct(){
        $this->request = request();
        
        // si hay que almacenar estadísticas de visitas para las URLs
        if(SAVE_STATS)
            Stat::saveOrIncrement($this->request->url);   
    }
    
      
    /**
     * Setter para la propiedad $request
     * 
     * @param Request $request
     */
    public final function setRequest(Request $request){
        $this->request = $request;
    }
    
       
    /**
     * Getter para la propiedad Request
     * 
     * @return Request 
     */
    public final function getRequest():?Request{
        return $this->request;
    }
    
       
    /**
     * Compara el token CSRF que recibe con el guardado en sesión.
     * 
     * @param string $token token CSRF.
     */
    public function checkCsrfToken(string $token = null){
        CSRF::check($token);   
    }
    
    
    
    /**
     * Permite exportar listados de entidades a distintos formatos.
     *
     * @param string $model nombre del modelo del que se pretenden exportar datos.
     * @param string $format formato de exportación
     * @param bool $download intenta forzar la descarga del fichero con los resultados de la exportación.
     * @param string $orderField campo de ordenación para los resultados.
     * @param string $order orden de los resultados.
     *
     * @return Response
     */
    protected function exportResponse(
        ?string $model      = null,
        string $format      = 'JSON',
        bool $download      = false,
        string $orderField  = 'id',
        string $order       = 'ASC'
    ):Response{
            
        // si no se le pasa el nombre del modelo relacionado,
        // calcula el nombre del modelo a partir del nombre del controlador
        $model = $model ?? str_replace('Controller', '', get_called_class());
        
        // evalúa el formato y prepara el tipo de respuesta adecuado
        switch($format){
            
            case 'JSON': $response = new JsonResponse(($model)::orderBy($orderField, $order));
            $extension = 'json';
            break;
            
            case 'XML':  $response = new XmlResponse(($model)::orderBy($orderField, $order));
            $extension = 'xml';
            break;
            
            case 'CSV':  $response = new CsvResponse(($model)::orderBy($orderField, $order));
            $extension = 'csv';
            break;
            
            case 'CSV-Excel': $response = new CsvResponse(($model)::orderBy($orderField, $order), ';');
            $extension = 'csv';
            break;
            
            default:    $response = new ApiResponse(($model)::orderBy($orderField, $order));
            $extension = 'txt';
        }
        
        
        // si quieren descargar el fichero...
        if($download){
            $date = date('_Y_m_d_h_i_s');
            header("Content-disposition: attachment; filename=$model.$date.$extension");
        }
        
        return $response;
    }
}

