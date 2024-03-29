<?php

/** TestTemplate
  *
  * Template para los tests.
  *
  * Última revisión: 07/07/23
  * @author Robert Sallent <robertsallent@gmail.com>
*/

class Test extends Template{
          
    /**
     * Retorna la parte superior (header) para las vistas de test.
     * 
     * @param string $file nombre del fichero de test cargado.
     * 
     * @return string parte superior del documento de test.
     */
    public static function top(string $file = ''):string{
        
        return "
        <!DOCTYPE html>
        <html lang='es'>
            <head>
            <meta charset='UTF-8'>
            <title>$file test</title>
    		<link rel='shortcut icon' href='/favicon.ico' type='image/png'>	
            <link rel='stylesheet' type='text/css' href='/css/test.css'>
    	</head>
    	<body>".self::getHeader("$file test");	
    }
    
    
    
    /**
     * Retorna la parte inferior de las vistas de test.
     *
     * @return string fin del fichero de test.
     */
    public static function end(string $file=''){
        return "
            <p class='end'>Fin del test $file</p>
        	<div class='inicio'>
                <a class='button' href='/test'>Lista de tests.</a>
            </div>";
    }
    
    
    
    /**
     * Retorna la parte inferior de las vistas de test.
     * 
     * @return string parte inferior.
     */
    public static function bottom(){
        
        return self::getFooter()."</body></html>";

    }  
}

