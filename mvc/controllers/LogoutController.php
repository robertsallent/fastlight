<?php

/** LogoutController
 *
 * Controlador para la operación de logout
 *
 * Última revisión: 21/03/2023
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */
    
class LogoutController extends Controller{
    
    /** Gestiona la operación de logout. */
    public function index():Response{
        Auth::check();   // solo para usuarios identificados
        Login::clear();  // elimina los datos de sesión y desvincula el usuario      
        return redirect('/');   // redirige a la portada 
    } 
}
    
    
    