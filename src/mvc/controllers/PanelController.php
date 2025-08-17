<?php

/** Panel
 *
 * Carga paneles para organizar las distintas operaciones de la aplicación
 *
 * Última revisión: 05/05/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.9.4
 */

class PanelController extends Controller{
    
 
    /** 
     * Muestra el panel del administrador
     * 
     *  @return ViewResponse  
     */
    public function admin(){
        
        // comprueba que el usuario tenga el rol adecuado
        Auth::oneRole(ADMIN_PANEL_ROLES);
        
        // carga la vista del panel del administrador
        return view('panel/admin');
    }
    
    
}


