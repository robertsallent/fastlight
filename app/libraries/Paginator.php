<?php
  
/** Paginator
 *
 * Herramienta de paginación de resultados
 *
 * Última revisión: 27/03/2024
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 */
class Paginator{
    
    // los valores de estas propiedades deben ser pasados al paginador a través del constructor
    
    /** @var $page página actual */
    private int $page; 
    
    /** @var $limit número de registros por página */
    private int $limit;
    
    /** @var $total número total de resultados */
    private int $total;      
    
    /** @var $url URL que estamos paginando */
    private string $url;    
    
    /** @var $lang URL idioma para los mensajes (en, es, ca) */
    private string $lang;
    
    // estas propiedades contienen valores calculados por el paginador
   
    /** @var $pages total de páginas */
    private int $pages;
    
    /** @var $previous número de la página anterior */
    private ?int $previous;
    
    /** @var $next número de la página siguiente */
    private ?int $next;
    
    /** @var $offset desplazamiento a la hora de recuperar los resultados a mostrar */
    private int $offset;
    
    
    // estas propiedades son configurables
    
    /** @var $langs lista de idiomas para el paginador */
    private static array $langs = [
        'ca' => ['Anterior','Següent', 'Primera', 'Última'],
        'es' => ['Anterior', 'Siguiente', 'Primera', 'Última'],
        'en' => ['Previous', 'Next', 'First', 'Last']
    ];
    
    
    
    /**
     * Constructor de la clase Paginator.
     * 
     * @param string $url URL que estamos paginando
     * @param int $page número de página actual
     * @param int $limit número de resultados a mostrar en cada página
     * @param int $total total de resultados
     * @param string $lang idioma en el que queremos los textos en los enlaces y estadísticas
     */
    public function __construct(
        string $url   = '/',   
        int $page     = 1,       
        int $limit    = 20,    
        int $total    = 0,      
        string $lang  = 'es'  
    ){
        $this->url   = $url;
        $this->page  = $page < 1 ? 1 : $page;  // controla que la página sea >=1
        $this->total = $total;
        $this->limit = $limit;
        $this->lang  = $lang;
        
        // cálculos
        $this->pages = ceil($this->total/$this->limit) != 0 ? ceil($this->total/$this->limit): 1; // total de páginas
        
        if($this->page > $this->pages)   
            $this->page = $this->pages;  // por si nos indican un número de página superior al total
            
        $this->previous = $this->page > 1 ? $this->page-1 : NULL;               // página anterior
        $this->next = $this->page < $this->pages ? $this->page+1 : NULL;        // página siguiente

        $this->offset = $limit * ($this->page-1);                               // desplazamiento          
    }  
    
    
    /**
     * Getter para la propiedad $page
     * 
     * Recupera el número de página actual.
     * 
     * @return int
     */
    public function getPage():int{
        return $this->page;
    }
    
    
    /**
     * Getter para la propiedad $limit
     * 
     * Recupera el número de resultados por página
     * 
     * @return int
     */
    public function getLimit():int{
        return $this->limit;
    }
    
    
    /**
     * Getter para la propiedad $total
     * 
     * Recupera el número total de resultados
     * 
     * @return int
     */
    public function getTotal():int{
        return $this->total;
    }
    
    
    /**
     * Getter para la propiedad $pages
     * 
     * Recupera el número total de páginas
     * 
     * @return int
     */
    public function getPages():int{
        return $this->pages;
    }
    
    
    /**
     * Getter para la propiedad $previous
     * 
     * Retorna el número de la página anterior o NULL si no la hay
     * 
     * @return int|NULL
     */
    public function getPrevious():?int{
        return $this->previous;
    }
    
    
    /**
     * Getter para la propiedad $next
     * 
     * Retorna el número de la página siguiente o NULL si no la hay
     * 
     * @return int|NULL
     */
    public function getNext():?int{
        return $this->next;
    }
    
    
    /**
     * Getter para la propiedad $offset
     * 
     * Retorna el desplazamiento calculado a partir del límite y el número de página
     * 
     * @return int
     */
    public function getOffset():int{
        return $this->offset;
    }
    
    
    
    // MÉTODOS PARA USAR EN LAS VISTAS
    
    /**
     * Método que genera los enlaces de anterior y siguiente para usar en las vistas
     * 
     * @param string $divCssClasses lista de clases para el CSS del contenedor de los enlaces
     * @param string $linkCssClasses lista de clases para el CSS de los botones
     * 
     * @return string el HTML formado para imprimir directamente en la vista
     */
    public function links(
        string $divCssClasses  = 'paginator-links',
        string $linkCssClasses = 'button'
    ):string{ 
        
        
        // prepara el HTML con los enlaces para las vistas
        $resultado = "<div class='$divCssClasses'>";
        
        $resultado .= $this->previous ? 
                    "<a class='$linkCssClasses' href='$this->url/$this->previous'>".self::$langs[$this->lang][0]."</a> " : "";
       
        $resultado .= $this->next ?
                    "<a class='$linkCssClasses' href='$this->url/$this->next'>".self::$langs[$this->lang][1]."</a> " : "";
    	
        $resultado .= "</div>";
    	
    	return $resultado;
    }
    
    
    /**
     * Método que genera los enlaces numéricos para usar en las vistas
     *
     * @param string $divCssClasses lista de clases para el CSS del contenedor de los enlaces
     * @param string $linkCssClasses lista de clases para el CSS de los botones
     *
     * @return string el HTML formado para imprimir directamente en la vista
     */
    public function numericLinks(
        string $divCssClasses = 'paginator-links',  // clases para el CSS del contenedor
        string $linkCssClasses = 'button'           // clases para el CSS de los enlaces
    ):string{
                       
        // prepara el HTML con los enlaces para las vistas
        $resultado = "<div class='$divCssClasses'>";
        
        for($i = 1; $i <= $this->pages; $i++){
            $actual = $i==$this->page ? "current" : "";
            $resultado .= "<a class='$linkCssClasses $actual' href='$this->url/$i'>$i</a>";
        }
        $resultado .= "</div>";
        
        return $resultado;
    }
    
    
    
    /**
     * Método que genera los enlaces para usar en las vistas. Pone enlaces numéricos y a última página y anterior.
     *
     * @param string $divCssClasses lista de clases para el CSS del contenedor de los enlaces
     * @param string $linkCssClasses lista de clases para el CSS de los botones
     *
     * @return string el HTML formado para imprimir directamente en la vista
     */
    public function ellipsisLinks(
        string $divCssClasses = 'paginator-links',  // clases para el CSS del contenedor
        string $linkCssClasses = 'button'           // clases para el CSS de los enlaces
    ):string{
        
        if($this->pages < 2) 
            return "";
        
        if($this->pages == 2 ) 
            return $this->numericLinks($divCssClasses, $linkCssClasses);
        
        // prepara el HTML con los enlaces para las vistas
        $resultado = "<div class='$divCssClasses'>";
        $resultado .= "<a class='$linkCssClasses' href='$this->url/1'>".self::$langs[$this->lang][2]."</a>";
        
        // cálculos
        $start = $this->page - 2;
        $start = $start < 1 ? 1 : $start;
        
        if($start > 1) 
            $resultado .= "<a class='$linkCssClasses' href='$this->url/".$this->getPrevious()."'>&lt;&lt;</a>";
        
        $end = $start + 3;
        $end = $end > $this->pages ? $this->pages : $end;

        for($i = $start; $i <= $end; $i++){
            $actual = $i==$this->page ? "current" : "";
            $resultado .= "<a class='$linkCssClasses $actual' href='$this->url/$i'>$i</a>";
        }
        
        if($end < $this->pages) 
            $resultado .= "<a class='$linkCssClasses' href='$this->url/".$this->getNext()."'>&gt;&gt;</a>";
        
        $resultado .= "<a class='$linkCssClasses' href='$this->url/$this->pages'>".self::$langs[$this->lang][3]."</a>";
        
        $resultado .= "</div>";
        
        return $resultado;
    }

    
    /**
     * Genera la información de estadísticas, para colocar directamente en las vistas
     * 
     * @param string $cssClasses lista de clases CSS para el estilo
     * @return string el código HTML listo para imprimir en las vistas
     */
    public function stats(
        string $cssClasses = 'paginator-stats my1'   // clases para el CSS del contenedor
    ):string{
        $pagina = number_format($this->page, 0, ',', '.');
        $paginas = number_format($this->pages, 0, ',', '.');
        $resultados = number_format($this->total, 0, ',', '.');
        
        $langs = [
            'ca' => "Pàgina $pagina de $paginas. Hi ha un total de $resultados resultats.",
            'es' => "Página $pagina de $paginas. Hay un total de $resultados resultados.",
            'en' => "Page $pagina of $paginas. Total $resultados results.",
        ];
        
        return "<div class='$cssClasses'>".$langs[$this->lang]."</div>";
    }    
}
