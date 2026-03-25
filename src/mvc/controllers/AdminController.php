<?php

/** AdminController
 *
 * Controlador para las operaciones del administrador
 *
 * Última revisión: 09/10/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.9.4
 * @since v2.1.0 cambia el nombre de PanelController por AdminController
 * @since v2.1.0 se añade el método exportdb()
 * @since v2.2.0 se añade el método exportdbzip()
 */


class AdminController extends Controller{
    
    
    /**
     * Muestra el panel del administrador
     * 
     * @return ViewResponse
     */
    public function index():ViewResponse{
        // redirige a la operación panel()
        return $this->panel();
    }
 
    
    /** 
     * Muestra el panel del administrador
     * 
     *  @return ViewResponse  
     */
    public function panel():ViewResponse{
        
        // comprueba que el usuario tenga el rol adecuado
        Auth::oneRole(ADMIN_PANEL_ROLES);
        
        // carga la vista del panel del administrador
        return view('panel/admin');
    }
    
    
    
    /**
     * Exporta la base de datos en sql y fuerza la descarga del fichero
     */
    public function exportdb(){
        
        // debes ser administrador
        Auth::admin();
        
        // nombre del archivo de descarga
        $fecha = date('Y_m_d_H_i_s');
        $name = snake(APP_NAME)."_backup_{$fecha}.sql";
        
        // cabeceras HTTP para forzar la descarga
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // prepara el comando mysqldump, que ejecutaremos directamente sobre el SO
        // el comando mysqldump debe estar incluido en el PATH del sistema
        $comando = "mysqldump --single-transaction --no-tablespaces --skip-extended-insert -h ".DB_HOST." -P ".DB_PORT." -u ".DB_USER." -p'".DB_PASS."' ".DB_NAME;

        // ejecuta el comando y envía su salida directamente al navegador
        passthru($comando);
        
        die();
    } 
    
    
    
    /**
     * Exporta la base de datos en un fichero comprimido
     */
    public function exportdbzip():Response{
        
        // debes ser administrador
        Auth::admin();
        
        // nombre base del archivo
        $fecha = date('Y_m_d_H_i_s');
        $baseName = snake(APP_NAME) . "_backup_{$fecha}";
        
        // cálculo de la ruta para el fichero SQL
        $sqlPath = "../tmp/{$baseName}.sql";
        
        // prepara el comando mysqldump
        $comando = "mysqldump --single-transaction --no-tablespaces --skip-extended-insert -h ".DB_HOST." -P ".DB_PORT." -u ".DB_USER." -p'".DB_PASS."' ".DB_NAME." > {$sqlPath}";
        
        try{
            // ejecuta el comando y genera el fichero SQL
            system($comando, $resultado);
                      
            // si no ha funcionado...
            if ($resultado !== 0 || !file_exists($sqlPath)){
                
                // si el error es 127 significa que no ha encontrado el comando mysqldump
                if($resultado == 127)
                    throw new OSException("Tu sistema operativo no encuentra el comando mysqldump, por favor añádelo al PATH del sistema.");
                   
                // para cualquier otro error, mostraremos el código    
                throw new OSException("Error al crear el backup de la base de datos en SQL. Código {$resultado} para {$sqlPath}.");
            }
            
            // crea el objeto File a partir del fichero SQL generado    
            $sqlFile = new File($sqlPath);
            
            // crea el fichero zip comprimido y con el password
            $zipFile = $sqlFile->zip(null, '../tmp', APP_PASSWORD);
            
            // borra el fichero SQL
            $sqlFile->delete();
            
            // genera la respuesta con el fichero comprimido
            $response = new FileResponse($zipFile, true);
            
            // envía la respuesta y elimina el fichero tras hacerlo
            $response->send(true);
          
        // en caso de error
        }catch(Throwable $t){
            
            Session::error($t->getMessage());
            
            // intenta limpiar los ficheros que se hubieran creado (importante)
            @unlink($sqlFile);
            @unlink($zipFile);
            
            if(DEBUG)
                throw new Exception($t->getMessage());
            
            return redirect("/Admin/panel");
        }
     }          
}


