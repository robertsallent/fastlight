<?php

/* Clase: LogoutController
 *
 * Controlador para la operación de logout
 *
 * Autor: Robert Sallent
 * Última revisión: 21/03/2023
 *
 */
    
    class LogoutController extends Controller{
        
        // método que gestiona la salida del usuario de la aplicación
        public function index(){
            Auth::check();   // solo para usuarios identificados
            Login::clear();  // elimina los datos de sesión y desvincula el usuario      
            redirect('/');   // redirige a la portada 
        } 
    }
    
    
    