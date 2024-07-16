<?php

    /** Intarface TemplateInterface
     *
     * Métodos que deben implementar los Templates. 
     * Los implementa la clase Template, así que heredando de Template nos aseguraremos
     * que nuestras clases ya los implementen.
     *
     * @author Robert Sallent <robertsallent@gmail.com>
     * última revisión: 10/06/2024
     *
     */
    
    interface TemplateInterface{
        
       public function css();
       
       public function login();
       public function header();
       public function menu();
       public function breadCrumbs();
       public function acceptCookies();
       public function footer();
       
       public function successMessage();
       public function warningMessage();
       public function errorMessage();
    }

