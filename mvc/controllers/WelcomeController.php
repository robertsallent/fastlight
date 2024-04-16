<?php

/** Welcome
 *
 * Controlador por defecto, según la configuración de config.php
 *
 * Última revisión: 07/03/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class WelcomeController extends Controller{
    
    /** Carga la vista de portada. */
    public function index(){
        view('welcome');
    }  
}

