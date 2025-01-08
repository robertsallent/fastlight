<?php

/** StatsController
 * 
 * Controlador para gestionar estadísticas de visitas a las URL.
 * 
 * Última revisión: 15/05/2024
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class StatsController extends Controller{
    
    /** Operación por defecto, redirige al método list(). */
    public function index():ViewResponse{
        return $this->list();          // redirige al método $list
    }
    
    
    
    /**
     * Listado de estadísticas, con paginación.
     * 
     * @param int $page número de página.
     */
    public function list(int $page = 1):ViewResponse{
        
        // operación solamente para el administrador o usuario con rol de test
        Auth::oneRole([ADMIN_ROLE, "ROLE_TEST"]); 
        
        // Comprobar si hay filtros a aplicar/quitar/recuperar de sesión
        $filtro = Filter::apply('stats');
                    
        // datos para paginación
        $limit = RESULTS_PER_PAGE;                       // resultados por página
        
        $total = $filtro ?                               // hay filtro ?
                    Stat::filteredResults($filtro):     // total de resultados filtrados
                    Stat::total();                      // total de resultados sin filtrar
                               
        // crea un objeto paginator
        $paginator = new Paginator('/Stats/list', $page, $limit, $total);
        
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
     * Elimina una estadística de la base de datos.
     * 
     * @param int $id identificador de la estadística a eliminar.
     * 
     * @throws Exception en caso de que no se pueda eliminar de la BDD.
     */
    public function destroy(int $id = 0){
        
        Auth::oneRole(STATS_ROLES); 
        
        try{
            Stat::delete($id);
            Session::success("Estadística borrada.");
            redirect("/Stats/list");
            
        }catch(SQLException $e){
            Session::error("No se pudo borrar la estadística.");

            if(DEBUG)
                throw new ControllerException($e->getMessage());
            
            redirect("/Stats/list");
        }
    }
    
    
    
    /**
     * Vacía la tabla de estadísticas de la base de datos.
     *
     * @throws Exception si no puede vaciar la tabla.
     */
    public function clear(){
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(STATS_ROLES);
        
        try{
            $rows = Stat::clear();
            Session::success("Lista de estadísticas vaciada correctamente. Se eliminaron $rows registros.");
            redirect("/Stats/list");
            
        }catch(SQLException $e){
            Session::error("No se pudo vaciar la lista de estadísticas.");
            
            if(DEBUG)
                throw new ControllerException($e->getMessage());
                
            redirect("/Stats/list");
        }
    }
}

  