<?php

    //FICHERO autoload.php

    //función que usaremos para buscar las clases
    function load($clase){ 
        global $classmap; //indicamos que use la variable global
    
        //para cada directorio de la lista
        foreach($classmap as $directorio){
           $ruta = "$directorio/$clase.php"; //calcula la ruta
          
           if(is_readable($ruta)){  //si es legible...
                require_once $ruta; //carga la clase
                break;              //ahorra iteraciones
           }
        }
    }
    
    spl_autoload_register("load");  //registrar la función de autoload

