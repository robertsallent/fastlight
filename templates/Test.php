<?php

/** DARK TEMPLATE
 *
 * Template para la sección de test del framework.
 *
 * Última revisión: 25/07/2024
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 *
 */


class Test extends Base{
          
    
    /** lista de ficheros CSS para usar con este template */
    protected array $css = [
        'standard'  => '/css/test.css',
        'tablet'    => null,
        'phone'     => '/css/phone.css',
        'printer'   => '/css/printer.css'
    ];
    
    
    /**
     * Retorna la parte superior (header) para las vistas de test.
     * 
     * @param string $file nombre del fichero de test cargado.
     * 
     * @return string parte superior del documento de test.
     */
    public function top(string $file = ''):string{
        
        $breadCrumbsLinks = $file == 'index' ?
            ['Test' => NULL] :
            ['Test' => '/test', $file => NULL];
        
        return "
            <!DOCTYPE html>
            <html lang='es'>
                <head>
                <meta charset='UTF-8'>
                <title>$file test</title>
        		".$this->css()."
        	</head>
        	<body>".$this->login()
        	       .$this->header("$file test")
        	       .$this->menu()
        	       .$this->breadCrumbs($breadCrumbsLinks);	
        }
    
    
    
    /**
     * Retorna la parte inferior de las vistas de test.
     *
     * @return string fin del fichero de test.
     */
    public function end(string $file=''){
        return "
            
        	<div class='centrado test-end'>
                <p>Fin del test <code>$file</code></p>
                <a class='button' href='/test'>Lista de tests.</a>
            </div>".$this->footer();
    }
    
    
    
    /**
     * Retorna la parte inferior de las vistas de test.
     * 
     * @return string parte inferior.
     */
    public function bottom(){
        
        return "<div class='centrado test-end'>
                    <a class='button' href='/'>Volver a inicio</a>
                </div>".$this->footer()."</body></html>";

    }  
}

