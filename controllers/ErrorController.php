<?php

    // controlador para las operaciones con AppErrors
    // cada metodo implementará una operación o un paso de la misma
    class ErrorController extends Controller{
        
        // operación por defecto
        public function index(){
            $this->list();          // redirige al método $list
        }
        
        // operación para listar los errores
        public function list(){
            Auth::admin(); // operación solamente para el administrador
                
            $this->loadView('error/list', [
                'errores' => AppError::orderBy('date', 'DESC')
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
        
        // vacía la lista de errores
        public function clear(){
            Auth::admin(); // operación solamente para el administrador
            
            try{
                $rows = AppError::clear();
                Session::flash('success', "Lista de errores vaciada correctamente. Se eliminaron $rows registros.");
                redirect("/Error/list");
                
            }catch(SQLException $e){
                Session::flash('error', "No se pudo vaciar la lista de errores.");
               
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
                case 'errors' : $file = ERROR_LOG_FILE;
                break;
                case 'login'  : $file = LOGIN_ERRORS_FILE;
                break;
                default       : return;
            }
            
            if(is_readable($file))
                openTextFile($file, pathinfo($file, PATHINFO_FILENAME));
            else
                Session::flash('error',"No se puede abrir el fichero, es probable que no
                                exista o que no se tengan los permisos adecuados en el sistema de ficheros.");
            
            redirect("/Error/list");
        }
        
        // elimina ficheros de LOG
        public function erase(string $fileType = 'errors'){
            Auth::admin(); // operación solamente para el administrador
  
            switch($fileType){
                case 'errors' : $ok = @unlink(ERROR_LOG_FILE);
                                break;
                case 'login'  : $ok = @unlink(LOGIN_ERRORS_FILE);
                                break;
                default       : $ok = false;
            }
            
            if($ok)
                Session::flash('success',"Fichero borrado.");
            else
                Session::flash('error',"No se pudo eliminar el fichero, es probable que no 
                                exista o que no se tengan los permisos adecuados en el sistema de ficheros.");
            
            redirect("/Error/list");
        }
    }
    
    
    
    
    