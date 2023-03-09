<?php

/* Clase: Welcome
 *
 * Controlador por defecto, según la configuración de config.php
 *
 * Autor: Robert Sallent
 * Última revisión: 07/03/2023
 *
 */

    class Welcome extends Controller{
        
        // método responsable de mostrar la portada
        public function index(){
            $this->loadView('portada');
        }
        
    }

