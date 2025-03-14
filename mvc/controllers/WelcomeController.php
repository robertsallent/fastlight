<?php

/** Welcome
 *
 * Controlador por omisión según la configuración por defecto del
 * fichero de configuración config.php.
 *
 * Última revisión: 09/03/2025
 * 
 * @author Robert Sallent <robert@fastlight.org>
 */

class WelcomeController extends Controller{
    
    /** 
     * Carga la vista de portada. 
     * 
     * @return ViewResponse
     * 
     * */
    public function index():ViewResponse{
        return view('welcome');
    }  
}

