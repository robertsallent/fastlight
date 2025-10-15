<?php

/** TemplateInterface
 *
 *  Interfaz que define los métodos que deben implementar los Templates.
 *   
 *  Los implementa la clase Base en templates/Base.php. 
 *  
 *  Cuando hagamos nuestras propias plantillas, la opción más simple es 
 *  heredar directamente de la clase Base para asegurarnos que los implementamos.
 *
 * última revisión: 15/10/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * 
 */

interface TemplateInterface{
    
    // coloca los metadatos (head de la página )
    public function metaData(
        string $title,
        string $description
    ); 
    
   public function css();               // coloca los links CSS con sus media queries
   
   public function login();             // pone los enlaces de login/logout
   public function header();            // coloca el header de la página
   public function menu();              // coloca el menú principal de la página
   public function acceptCookies();     // muestra el modal "aceptar cookies"
   public function breadCrumbs();       // muestra el "migas" de la página
   
   public function footer();            // coloca el footer principal
   public function version();           // muestra la versión de la aplicación
   
   public function messages();          // coloca el modal para cualquier tipo de mensaje
}

