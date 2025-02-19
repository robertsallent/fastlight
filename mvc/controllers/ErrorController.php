<?php

/** ErrorController
 * 
 * Controlador para gestionar errores. Trabaja con el modelo AppError.
 * 
 * Última revisión: 03/02/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 * @since v1.5.1 se pueden exportar los errores
 */

class ErrorController extends Controller{
        
    /** 
     * Operación por defecto, redirige a la operación list()
     * 
     * @return Response
     */
    public function index():Response{
        return $this->list();          // redirige al método $list
    }
    
    
    
    /**
     * Listado de errores, con paginación.
     * 
     * @param int $page número de página.
     * @return Response
     */
    public function list(int $page = 1):Response{
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(ERROR_ROLES); 
        
        // Comprobar si hay filtros a aplicar/quitar/recuperar de sesión
        $filtro = Filter::apply('errores');
                    
        // datos para paginación
        $limit = RESULTS_PER_PAGE;                       // resultados por página
        
        $total = $filtro ?                               // hay filtro ?
                    AppError::filteredResults($filtro):     // total de resultados filtrados
                    AppError::total();                      // total de resultados sin filtrar
                               
        // crea un objeto paginator
        $paginator = new Paginator('/Error/list', $page, $limit, $total);
        
        // recupera los resultados para la página actual 
        $errores = $filtro ?                                            // hay filtro?
              AppError::filter($filtro, $limit, $paginator->getOffset()):         // filtrados
              AppError::orderBy('date', 'DESC', $limit, $paginator->getOffset()); // sin filtrar
        
              
        // cargamos la vista y le pasamos la lista de entidades, el paginador y el filtro
        return view('error/list', [
            'errores'   => $errores,
            'paginator' => $paginator,   // pasamos el objeto Paginator a la vista 
            'filtro'    => $filtro,       // pasamos el objeto filter a la vista
            'summary'   => AppError::groupBy(['id'=>'COUNT'],['level'])
        ]);
    } 
    
      
    /**
     * Elimina un error de la base de datos.
     * 
     * @param int $id identificador del error a eliminar.
     * @return Response
     * @throws ControllerException en caso de que no se pueda eliminar el error de la BDD y estemos en modo DEBUG.
     */
    public function destroy(int $id = 0):Response{
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(ERROR_ROLES); 
        
        try{
            AppError::delete($id);
            Session::success("Error borrado.");
            return redirect("/Error/list");
            
        }catch(SQLException $e){
            Session::error("No se pudo borrar el error.");

            if(DEBUG)
                throw new ControllerException($e->getMessage());
            
            return redirect("/Error/list");
        }
    }
    
    
    /**
     * Permite exportar los errores a distintos formatos, retornando el tipo de respuesta
     * adecuado al formato solicitado vía POST.
     */
    public function export():Response{
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(ERROR_ROLES); 
        
        // recupera el formato de exportación
        $formato = $this->request->post('format') ?? 'JSON';
        
        // hay que intentar descargar?
        $download = $this->request->post('download') ?? false;
        
        // campo para el orden?
        $order = $this->request->post('order') ?? 'date';
        
        // sentido
        $direction = $this->request->post('direction') ?? 'DESC';
        
        // el método generateExportResponse se encuentra en el trait Exportable
        return $this->exportResponse('AppError', $formato, $download, $order, $direction);    
    }
    
    
    /**
     * Vacía la tabla de errores de la base de datos.
     * 
     * @return Response
     * @throws Exception si no puede vaciar la tabla y estamos en modo DEBUG.
     */
    public function clear():Response{
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(ERROR_ROLES); 
        
        try{
            $rows = AppError::clear();
            Session::success("Lista de errores vaciada correctamente. Se eliminaron $rows registros.");
            return redirect("/Error/list");
            
        }catch(SQLException $e){
            Session::error("No se pudo vaciar la lista de errores.");
           
            if(DEBUG)
                throw new ControllerException($e->getMessage());
            
            return redirect("/Error/list");
        }
    }

    
    
    /**
     * Descarga los ficheros de LOG.
     * 
     * @param string $fileType tipo de fichero, de momento puede ser "errors" o "login".
     * @return Response
     */
    public function download(string $fileType = 'errors'):Response{
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(ERROR_ROLES); 
        
        // mira qué fichero hay que descargar
        switch($fileType){
            case 'errors' : $response = new FileResponse(ERROR_LOG_FILE);     
                            break;
            case 'login'  : $response = new FileResponse(LOGIN_ERRORS_FILE);  
                            break;
        }
        
        // retorna la FileResponse con el fichero
        return $response;
    }
    
    
    
    
    /**
     * Elimina los ficheros de LOG.
     *
     * @param string $fileType tipo de fichero, puede ser "errors" o "login".
     * @return Response
     */
    public function erase(string $fileType = 'errors'):Response{
        
        // operación solamente para los roles autorizados a trabajar con errores
        // se configura en el fichero de configuración
        Auth::oneRole(ERROR_ROLES); 

        switch($fileType){
            case 'errors' : $ok = File::remove(ERROR_LOG_FILE);      
                            break;
            case 'login'  : $ok = File::remove(LOGIN_ERRORS_FILE);   
                            break;
            default       : $ok = false;
        }
        
        if($ok)
            Session::success("Fichero borrado.");
        else
            Session::error("No se pudo eliminar el fichero, es probable que no 
                            exista o que no se tengan los permisos adecuados.");
        
        return redirect("/Error/list");
    }
}

  