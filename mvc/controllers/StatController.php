<?php

/** StatController
 * 
 * Controlador para gestionar estadísticas de visitas a las URL.
 * 
 * Última revisión: 15/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * @since v1.5.1 se pueden exportar las estadísticas
 */

class StatController extends Controller{
    
    
    /** Operación por defecto, redirige al método list(). */
    public function index():Response{
        return $this->list();          // redirige al método $list
    }
    
    
    
    /**
     * Listado de estadísticas, con paginación.
     * 
     * @param int $page número de página.
     */
    public function list(int $page = 1):Response{
        
        // si no están activadas las estadísticas, redirigimos a la portada
        if(!SAVE_STATS)
            return redirect('/');
        
        // operación solamente para el administrador o usuario con rol de test
        Auth::oneRole(STATS_ROLES); 
        
        // Comprobar si hay filtros a aplicar/quitar/recuperar de sesión
        $filtro = Filter::apply('stats');
                    
        // datos para paginación
        $limit = RESULTS_PER_PAGE;                       // resultados por página
        
        $total = $filtro ?                               // hay filtro ?
                    Stat::filteredResults($filtro):     // total de resultados filtrados
                    Stat::total();                      // total de resultados sin filtrar
                               
        // crea un objeto paginator
        $paginator = new Paginator('/Stat/list', $page, $limit, $total);
        
        // recupera los resultados para la página actual 
        $stats = $filtro ?    // hay filtro?
              Stat::filter($filtro, $limit, $paginator->getOffset()):         // filtrados
              Stat::orderBy('count', 'DESC', $limit, $paginator->getOffset()); // sin filtrar
        
        // cargamos la vista y le pasamos la lista de entidades, el paginador y el filtro
        return view('stats/list', [
            'stats'   => $stats,
            'paginator' => $paginator,   // pasamos el objeto Paginator a la vista 
            'filtro'    => $filtro       // pasamos el objeto filter a la vista
        ]);
    } 
    

    
    /**
     * Permite exportar las estadísticas a distintos formatos, retornando el tipo de respuesta
     * adecuado al formato solicitado vía POST.
     * 
     * @return Response
     */
    public function export():Response{
        
        // operación solamente para el administrador o usuario con rol de test
        Auth::oneRole(STATS_ROLES); 
        
        // recupera el formato de exportación
        $formato = $this->request->post('format');
        
        // hay que intentar descargar?
        $download = $this->request->post('download') ?? false;
        
        // campo para el orden?
        $order = $this->request->post('order') ?? 'count';
        
        // sentido
        $direction = $this->request->post('direction') ?? 'DESC';
        
        // el método generateExportResponse se encuentra en el trait Exportable
        return $this->exportResponse('Stat', $formato, $download, $order, $direction);
    }
    
    
      
    /**
     * Elimina una estadística de la base de datos.
     * 
     * @param int $id identificador de la estadística a eliminar.
     * 
     * @throws Exception en caso de que no se pueda eliminar de la BDD.
     */
    public function destroy(int $id = 0):Response{
        
        Auth::oneRole(STATS_ROLES); 
        
        try{
            Stat::delete($id);
            Session::success("Estadística borrada.");
            return redirect("/Stat/list");
            
        }catch(SQLException $e){
            Session::error("No se pudo borrar la estadística.");

            if(DEBUG)
                throw new ControllerException($e->getMessage());
            
            return redirect("/Stat/list");
        }
    }
    
    
    
    /**
     * Vacía la tabla de estadísticas de la base de datos.
     *
     * @throws Exception si no puede vaciar la tabla.
     */
    public function clear():Response{
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(STATS_ROLES);
        
        try{
            $rows = Stat::clear();
            Session::success("Lista de estadísticas vaciada correctamente. Se eliminaron $rows registros.");
            return redirect("/Stat/list");
            
        }catch(SQLException $e){
            Session::error("No se pudo vaciar la lista de estadísticas.");
            
            if(DEBUG)
                throw new ControllerException($e->getMessage());
                
            return redirect("/Stat/list");
        }
    }
    
}

  