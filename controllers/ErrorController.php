<?php

    // controlador para las operaciones con AppErrors
    // cada metodo implementará una operación o un paso de la misma
    class ErrorController extends Controller{
        
        // operación por defecto
        public function index(){
            $this->list();          // redirige al método $list
        }
        
        // operación para listar los errores (con paginación)
        public function list(int $page = 1){
            
            Auth::admin();// operación solamente para el administrador
            
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
            $errores = $filtro ?    // hay filtro?
                  AppError::filter($filtro, $limit, $paginator->getOffset()):         // filtrados
                  AppError::orderBy('date', 'DESC', $limit, $paginator->getOffset()); // sin filtrar
            
            // cargamos la vista y le pasamos la lista de entidades, el paginador y el filtro
            $this->loadView('error/list', [
                'errores'   => $errores,
                'paginator' => $paginator,   // pasamos el objeto Paginator a la vista 
                'filtro'    => $filtro       // pasamos el objeto filter a la vista
            ]);
        } 
        
          
        // elimina un error de forma individual
        public function destroy(int $id = 0){
            Auth::admin(); // operación solamente para el administrador
            
            try{
                AppError::delete($id);
                Session::flash('success', "Error borrado.");
                redirect("/Error/list");
                
            }catch(SQLException $e){
                Session::flash('error', "No se pudo borrar el error.");

                if(DEBUG)
                    throw new Exception($e->getMessage());
                else
                    redirect("/Error/list");
            }
        }
        
        
        // vacía la lista de errores en la base de datos
        public function clear(){
            Auth::admin(); // operación solamente para el administrador
            
            try{
                $rows = AppError::clear();
                Session::success("Lista de errores vaciada correctamente. 
                                  Se eliminaron $rows registros.");
                
                redirect("/Error/list");
                
            }catch(SQLException $e){
                Session::error("No se pudo vaciar la lista de errores.");
               
                if(DEBUG)
                    throw new Exception($e->getMessage());
                else
                    redirect("/Error/list");
            }
        }

        
        // descarga los ficheros de LOG
        public function download(string $fileType = 'errors'){
            Auth::admin(); // operación solamente para el administrador
            
            switch($fileType){
                case 'errors' : $file = ERROR_LOG_FILE;     break;
                case 'login'  : $file = LOGIN_ERRORS_FILE;  break;
                default       : return;
            }
            
            File::openTextFile($file, pathinfo($file, PATHINFO_BASENAME)); 
            die();
        }
        
        
        // elimina ficheros de LOG
        public function erase(string $fileType = 'errors'){
            Auth::admin(); // operación solamente para el administrador
  
            switch($fileType){
                case 'errors' : $ok = File::remove(ERROR_LOG_FILE);      break;
                case 'login'  : $ok = File::remove(LOGIN_ERRORS_FILE);   break;
                default       : $ok = false;
            }
            
            if($ok)
                Session::success("Fichero borrado.");
            else
                Session::error("No se pudo eliminar el fichero, es probable que no 
                                exista o que no se tengan los permisos adecuados en 
                                el sistema de ficheros.");
            
            redirect("/Error/list");
        }
    }
    
    
    
    
    