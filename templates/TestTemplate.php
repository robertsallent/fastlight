<?php

/** TestTemplate
  *
  * Template para los tests.
  *
  * Última revisión: 07/07/23
  * @author Robert Sallent <robertsallent@gmail.com>
*/

class TestTemplate extends Template{
          
    /**
     * Retorna la parte superior (header) para las vistas de test.
     * 
     * @param string $file nombre del fichero de test cargado.
     * 
     * @return string inicio del documento de test.
     */
    public static function start(string $file = ''):string{
        
        return "
        <!DOCTYPE html>
        <html lang='es'>
            <head>
            <meta charset='UTF-8'>
            <title>$file test</title>
    		<link rel='shortcut icon' href='/favicon.ico' type='image/png'>	
            <link rel='stylesheet' type='text/css' href='/css/test.css'>
    	</head>
    	<body>".self::getHeader("$file test, ");	
    }
    
    
    
    /**
     * Retorna la parte inferior de las vistas de test.
     * 
     * @return string fin del fichero de test.
     */
    public static function end(){
        
        return "<div class='inicio'>
                    <a class='button' href='/test'>Lista de tests.</a>
                </div>".self::getFooter()."</body></html>";

    }  
}

