<?php

/* Clase TestTemplate
 *
 * Template para los tests
 *
 * autor: Robert Sallent
 * última revisión: 24/03/2023
 *
     */
    
    class TestTemplate extends Template{
              
        // pone la parte superior de las vistas de test
        public static function start(string $method = ''):string{
            
            return "
            <!DOCTYPE html>
            <html lang='es'>
                <head>
                <meta charset='UTF-8'>
                <title>Test de $method</title>
        		<link rel='shortcut icon' href='/favicon.ico' type='image/png'>	
                <link rel='stylesheet' type='text/css' href='/css/test.css'>
        	</head>
        	<body>".self::getHeader("Test de $method");	
        }
        
        // pone la parte inferior de las vistas de test
        public static function end(){
            return self::getFooter()."</body></html>";
        }  
    }
    
