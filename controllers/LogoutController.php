<?php

/* Clase: LogoutController
 *
 * Controlador para la operación de logout
 *
 * Autor: Robert Sallent
 * Última revisión: 07/03/2023
 *
 */
    
    class LogoutController extends Controller{
        
        // método que gestiona la salida del usuario de la aplicación
        public function index(){
            Login::clear();         // elimina los datos de sesión y desvincula el usuario      
            URL::redirect('/');     // redirige a la portada 
        } 
    }
    
    
    