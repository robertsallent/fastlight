<?php

/** TemplateInterface
 *
 *  Métodos que deben implementar los Templates.
 *   
 *  Los implementa la clase Base en templates/Base.php. 
 *  
 *  Cuando hagamos nuestras propias plantillas, la opción más simple es 
 *  heredar directamente de la clase Base para asegurarnos que los implementamos.
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 * última revisión: 02/03/2025
 *
 */

interface TemplateInterface{
    
   public function css();
   
   public function login();
   public function header();
   public function menu();
   public function acceptCookies();
   public function breadCrumbs();
   public function footer();
   public function version();
   
   public function successMessage();
   public function warningMessage();
   public function errorMessage();
   public function messages();
}

