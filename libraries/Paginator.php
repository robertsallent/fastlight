<?php
    
    /* Clase Paginator
     *
     * Herramienta de paginación de resultados
     *
     * Última revisión: 18/03/2023
     *
     * */
    
    class Paginator{
        
        // PROPIEDADES
        // las que necesita el paginador
        private int $page;       // página actual
        private int $limit;      // registros por página
        private int $total;      // número total de resultados
        
        private string $url;     // URL que estamos paginando
        private string $lang;    // idioma para los mensajes (en, es, ca)
        
        // calculadas
        private int $pages;      // total de páginas
        private $previous;       // página anterior
        private $next;           // página siguiente
        private $offset;         // desplazamiento
        
        
        // CONSTRUCTOR
        public function __construct(
            string $url = '/',   // URL que estamos paginando
            int $page = 1,       // número de página
            int $limit = 20,     // registros por página
            int $total = 0,      // total de resultados
            string $lang = 'es'  // idioma para los mensajes
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
        
        // GETTERS
        public function getPage():int{
            return $this->page;
        }
        
        public function getLimit():int{
            return $this->limit;
        }
        
        public function getTotal():int{
            return $this->total;
        }
        
        public function getPages():int{
            return $this->pages;
        }
        
        public function getPrevious(){
            return $this->previous;
        }
        
        public function getNext(){
            return $this->next;
        }
        
        public function getOffset():int{
            return $this->offset;
        }
        
        // MÉTODOS PARA USAR EN LAS VISTAS
        // genera los enlaces de anterior y siguiente
        public function links(
            string $divCssClasses = 'paginator-links',  // clases para el CSS del contenedor
            string $linkCssClasses = 'button'           // clases para el CSS de los enlaces
        ):string{ 
            $idiomas = [
                'ca' => ['Anterior', 'Següent'],
                'es' => ['Anterior', 'Siguiente'],
                'en' => ['Previous', 'Next']
            ];
            
            // prepara el HTML con los enlaces para las vistas
            $resultado = "<div class='$divCssClasses'>";
            
            $resultado .= $this->previous ? 
                        "<a class='$linkCssClasses' href='$this->url/$this->previous'>".$idiomas[$this->lang][0]."</a> " : "";
           
            $resultado .= $this->next ?
                        "<a class='$linkCssClasses' href='$this->url/$this->next'>".$idiomas[$this->lang][1]."</a> " : "";
        	
            $resultado .= "</div>";
        	
        	return $resultado;
        }
    
        
        // genera la información de paginación
        public function stats(
            string $cssClasses = 'paginator-stats'   // clases para el CSS del contenedor
        ):string{
            $pagina = number_format($this->page, 0, ',', '.');
            $paginas = number_format($this->pages, 0, ',', '.');
            $resultados = number_format($this->total, 0, ',', '.');
            
            $idiomas = [
                'ca' => "Pàgina $pagina de $paginas. Hi ha un total de $resultados resultats.",
                'es' => "Página $pagina de $paginas. Hay un total de $resultados resultados.",
                'en' => "Page $pagina of $paginas. Total $resultados results.",
            ];
            
            return "<div class='$cssClasses'>".$idiomas[$this->lang]."</div>";
        }    
    }
