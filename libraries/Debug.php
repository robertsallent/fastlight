<?php


/* Clase Debug
 *
 * Mensajes para mostrar en modo debug
 *
 * Autor: Robert Sallent
 * Última revisión: 8/03/2023
 *
 */
 
    class Debug{
        
        // método estático que prepara toda la información de depuración tras un error
        public static function errorInformation(
            Throwable $e,             // excepción o error producido
            string $c,                // controlador solicitado
            string $m,                // método solicitado
            array $parametros = []    // parámetros
            
        ):string{
            
            global $errorDetail; // array en config.php que define el nivel de detalle a mostrar
            
            $mensaje = "<p>".$e->getMessage()."</p>";
            $mensaje .= "<h3>Información adicional para depuración:</h3>";
            
            $mensaje .= "<p>Tipo de error: <b>".get_class($e)."</b></p>";
            
            if(in_array('user', $errorDetail)){
                if($user = Login::get()){
                    $mensaje .= "<p>Usuario identificado: <b>$user->displayname</b> ($user->email), ";
                    $mensaje .= " roles: <b>[".implode(', ',$user->roles)."]</b></p>";
                }else{
                    $mensaje .= "<p>No hay usuario identificado</p>";
                }
            }
            
            if(in_array('trace', $errorDetail)){
                $mensaje .= "<p>Ruta: <b>".($_SERVER['REQUEST_URI'] ?? ' -- ')."</b></p>";
                $mensaje .= $c ? "<p>Controlador: <b>$c</b></p>" : '';
                $mensaje .= $m ? "<p>Método del controlador: <b>$m()</b></p>" : '';
                $mensaje .= "<p>Método de la petición: <b>".$_SERVER['REQUEST_METHOD']."</b></p>";
                $mensaje .= $parametros ? "<p>Parámetros: <b>".implode(', ',$parametros)."</b></p>" : '';
                $mensaje .= "<p>En fichero: <b>".$e->getFile()."</b></p>";
                $mensaje .= "<p>En la línea: <b>".$e->getLine()."</b></p>";
            }
            
            if(in_array('post', $errorDetail))
                $mensaje .= "<p>POST: ".arrayToString($_POST)."</p>";
            
            if(in_array('get', $errorDetail))
                $mensaje .= "<p>GET: ".arrayToString($_GET)."</p>";
            
            if(in_array('session', $errorDetail))
                $mensaje .= "<p>SESSION: ".arrayToString($_SESSION)."</p>";
            
            if(in_array('cookie', $errorDetail))
                $mensaje .= "<p>COOKIE: ".arrayToString($_COOKIE)."</p>";
            
            if(in_array('client', $errorDetail))
                $mensaje .= "<p>CLIENT IP: <b>".$_SERVER['REMOTE_ADDR']."</b></p><p>USER AGENT: ".$_SERVER['HTTP_USER_AGENT']."</p>";
            
            return $mensaje;
        }  
    }