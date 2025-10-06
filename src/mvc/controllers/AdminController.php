<?php

/** AdminController
 *
 * Controlador para las operaciones del administrador
 *
 * Última revisión: 06/10/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.9.4
 * @since v2.1.0 cambia el nombre de PanelController por AdminController
 * @since v2.1.0 se añade el método exportdb()
 */

class AdminController extends Controller{
    
    
    /**
     * Muestra el panel del administrador
     * 
     * @return ViewResponse
     */
    public function index():ViewResponse{
        
        // comprueba que el usuario tenga el rol adecuado
        Auth::oneRole(ADMIN_PANEL_ROLES);
        
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
     * Exporta la base de datos y fuerza la descarga del fichero
     */
    public function exportdb(){
        
        // debes ser administrador
        Auth::admin();
        
        // nombre del archivo de descarga
        $fecha = date('Y_m_d_H_i_s');
        $name = toSnakeCase(APP_NAME)."_backup_{$fecha}.sql";
        
        // cabeceras HTTP para forzar la descarga
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . $name . '"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // prepara el comando mysqldump, que ejecutaremos directamente sobre el SO
        // el comando debe estar incluido al PATH del sistema
        $comando = "mysqldump --single-transaction --no-tablespaces --skip-extended-insert -h ".DB_HOST." -P ".DB_PORT." -u ".DB_USER." -p'".DB_PASS."' ".DB_NAME;

        // ejecuta el comando y envía su salida directamente al navegador
        passthru($comando);
        
        die();
    } 
}


