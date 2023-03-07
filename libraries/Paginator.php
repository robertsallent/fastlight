<?php

/* Clase Paginator
 *
 * Herramienta de paginación de resultados
 *
 * Última revisión: 15/02/2023
 * PHP: 8.1
 *
 * */

class Paginator{
    
    // PROPIEDADES
    public int $results;    // número de resultados
    public int $page;       // página actual
    public int $pages;      // total de páginas
    public $previous;       // página anterior
    public $next;           // página siguiente
    public int $limit;      // registros por página
    public int $offset;     // offset
    
    public function __construct(
        int $page = 1,
        int $results = 0,
        int $limit = 20
    ){
        $this->page = $page;
        $this->results = $results;
        $this->limit = $limit;
        
        $this->pages = ceil($results/$limit) != 0 ? ceil($results/$limit): 1;
        $this->previous = $page > 1 ? $page-1 : NULL;
        $this->next = $page < $this->pages ? $page+1 : NULL;
    }  
    
    // genera los enlaces
    public function links(
        string $url = '',       // url a paginar
        string $lang = 'ca',    // código de idioma (ca, es, en)
        string $divClasses = 'paginacion pc', // clases para el CSS del contenedor
        string $linkClasses = 'button'        // clases para el CSS de los enlaces
    ){ 
        
        $idiomas = [
            'ca' => ['Anterior', 'Següent'],
            'es' => ['Anterior', 'Siguiente'],
            'en' => ['Previous', 'Next']
        ];
        
        // prepara el HTML con los enlaces para las vistas
        $resultado = "<div class='$divClasses'>";
        
        $resultado .= $this->previous ? 
                    "<a class='$linkClasses' href='$url/$this->previous'>".$idiomas[$lang][0]."</a> " : "";
       
        $resultado .= $this->next ?
                    "<a class='$linkClasses' href='$url/$this->next'>".$idiomas[$lang][1]."</a> " : "";
    	
        $resultado .= "</div>";
    	
    	return $resultado;
    }

    
    // genera la información de paginación
    public function stats(
        string $lang = 'ca',    // código de idioma (ca, es, en)
        string $classes = 'stats'   // clases para el CSS del contenedor
    ){
        $pagina = number_format($this->page, 0, ',', '.');
        $paginas = number_format($this->pages, 0, ',', '.');
        $resultados = number_format($this->results, 0, ',', '.');
        
        $idiomas = [
            'ca' => "Pàgina $pagina de $paginas. Hi ha un total de $resultados resultats.",
            'es' => "Página $pagina de $paginas. Hay un total de $resultados resultados.",
            'en' => "Page $pagina of $paginas. Total $resultados results.",
        ];
        
        return "<div class='$classes'>".$idiomas[$lang]."</div>";
    }    
}

