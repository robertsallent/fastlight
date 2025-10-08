<?php

/** AdminController
 *
 * Controlador para las operaciones del administrador
 *
 * Última revisión: 08/10/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.9.4
 * @since v2.1.0 cambia el nombre de PanelController por AdminController
 * @since v2.1.0 se añade el método exportdb()
 * @since v2.1.1 se añade el método exportdbzip()
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
        $name = toSnakeCase(APP_NAME)."_backup_{$fecha}.sql";
        
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
    public function exportdbzip() {
        
        // debes ser administrador
        Auth::admin();
        
        // nombre base del archivo
        $fecha = date('Y_m_d_H_i_s');
        $baseName = toSnakeCase(APP_NAME) . "_backup_{$fecha}";
        
        // rutas para el fichero sql y el zip
        $sqlFile = "../tmp/{$baseName}.sql";
        $zipFile = "../tmp/{$baseName}.zip";
        
        // prepara el comando mysqldump
        $comando = "mysqldump --single-transaction --no-tablespaces --skip-extended-insert -h ".DB_HOST." -P ".DB_PORT." -u ".DB_USER." -p'".DB_PASS."' ".DB_NAME." > {$sqlFile}";
        
        try{
            // ejecuta el comando y genera el .sql
            system($comando, $resultado);
            
           
            if ($resultado !== 0 || !file_exists($sqlFile))
                throw new FileException("Error al crear el backup de la base de datos en SQL.");
            
                
            // TODO: trasladar la compresión de ficheros hacia la librería File
            // TODO: retornar una FileResponse con el fichero zip
            
            // crea el fichero ZIP
            $zip = new ZipArchive();
            
            // unav ez descargado, el fichero requerirá la clave configurada en el fichero config.php
            if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
                $zip->setPassword(APP_PASSWORD);
                $zip->addFile($sqlFile, basename($sqlFile));
                $zip->setEncryptionName(basename($sqlFile), ZipArchive::EM_AES_256); // cifrado AES-256
                $zip->close();
            } else 
                throw new FileException("Error al crear el archivo ZIP.");
            
            
            // Cabeceras HTTP para forzar la descarga
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="'.basename($zipFile).'"');
            header('Pragma: no-cache');
            header('Expires: 0');
            header('Content-Length: '.filesize($zipFile));
            
            // Enviar el ZIP al navegador
            readfile($zipFile);
            
            // Limpieza de archivos temporales
            unlink($sqlFile);
            unlink($zipFile);
            
            die();
            
        }catch(Throwable $t){
            
            Session::error($t->getMessage());
            
            @unlink($sqlFile);
            @unlink($zipFile);
            
            if(DEBUG)
                throw new Exception($t->getMessage());
            
            return redirect("/Admin/panel");
        }
     }            
}


