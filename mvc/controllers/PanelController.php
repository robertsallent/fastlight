<?php

/** Panel
 *
 * Carga paneles para organizar las distintas operaciones de la aplicación
 *
 * Última revisión: 09/01/2025
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
        
        // comprueba que el usuario sea administrador
        Auth::admin();
        
        // carga la vista del panel del administrador
        return view('panel/admin');
    }
    
    
}


