<?php

/* Clase Filtro
 *
 * Permite aplicar filtros que se guardarán en sesión.
 *
 * Última revisión: 15/02/2023
 * PHP: 8.1
 *
 * */

class Filter{
    
    // PROPIEDADES
    public string $nombre;              // nombre del filtro (para guardarlo en sesión)
    public string $texto;               // texto a buscar
    public string $campo;               // campo en el que buscar
    public string $campoOrden;          // campo para ordenar
    public string $sentidoOrden;        // sentido (ASC, DESC)
    public array $camposAdicionales;    // array de otros campos a comparar (WHERE x = y)
    
    // CONSTRUCTOR
    public function __construct(
        string $nombre = 'generic',     
        string $texto = '%',
        string $campo = 'id',
        string $campoOrden = 'id',
        string $sentidoOrden = 'DESC',
        array $camposAdicionales = []
    ){
        $this->texto = $texto;
        $this->campo = $campo;
        $this->campoOrden = $campoOrden;
        $this->sentidoOrden = $sentidoOrden;
        $this->camposAdicionales = $camposAdicionales;
    }
    
    // MÉTODOS
    
    // método que aplica o quita filtros
    public static function aplicar(String $nombre){
        
        if(!empty($_POST['filtrar'])){ // si se pide aplicar un filtro
            
            // primero recuperamos los campos adicionales (si los hay)
            $camposAdicionales = [];
            
            foreach($_POST['camposAdicionales'] ?? [] as $campo => $valor)
                $camposAdicionales[DB::escape($campo)] = DB::escape($valor);
                
            // después preparamos el nuevo filtro con los campos básicos y los adicionales            
            $filtro = new Filter(
                $nombre,
                DB::escape($_POST['texto']),
                DB::escape($_POST['campo']),
                DB::escape($_POST['campoOrden']),
                DB::escape($_POST['sentidoOrden']),
                $camposAdicionales
            );
            
            $_SESSION["filtro_$nombre"] = $filtro; // guarda el filtro en sesión
        }
        
        // si se pide quitar un filtro
        if(!empty($_POST['quitarFiltro']))
            unset($_SESSION["filtro_$nombre"]);
            
        // Recuperar y retornar el filtro desde la variable de sesión
        return empty($_SESSION["filtro_$nombre"]) ? NULL : $_SESSION["filtro_$nombre"];        
    }   
    
    
    // método que muestra la información del filtro aplicado en una vista
    public function stats(
        bool $adicionales = false  // para mostrar también los campos adicionales
    ){
        $texto = empty($this->texto) ?
            "Dades sense filtre de text. " :
            "Dades filtrades per  <b>$this->campo: '$this->texto'</b>. ";
        
        $texto .= "Ordenat per $this->campoOrden ";
        
        $texto .= $this->sentidoOrden == 'ASC'?
            " ascendent. " :
            " descendent. ";
        
       if($adicionales) 
           foreach($this->camposAdicionales as $campo => $valor)
               $texto .= "$campo: $valor. ";
        
       echo $texto;
    }
}

