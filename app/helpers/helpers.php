<?php

/*
 |==========================================================================
 | FUNCIONES HELPER
 |==========================================================================
 |
 | Funciones helper para realizar tareas habituales.
 |
 | Última revisión: 11/07/2023
 | @author Robert Sallent <robertsallent@gmail.com>
 |
 |
 |--------------------------------------------------------------------------
 | DEPURACIÓN Y VOLCADO DE DATOS SOBRE EL DOCUMENTO
 |--------------------------------------------------------------------------
*/


/**
 * Función para volcar el contenido de variables sobre el documento.
 * Útil para depuración.
 * 
 * @param mixed $thing variable a mostrar.
 */
function dump(...$things){
    echo "<pre>";
    
    foreach($things as $thing)
        var_dump($thing);
    
    echo "</pre>";
}

/**
 * Dump and Die, vuelca el contenido de variables sobre el documento 
 * y detiene la ejecución. 
 * 
 * @param mixed $thing variable a mostrar.
 * @param string $message mensaje a mostrar al finalizar la ejecución.
 */
function dd($thing, string $message = 'Se detuvo la ejecución.'){
    dump($thing);
    die($message);
}



/*
 |--------------------------------------------------------------------------
 | ARRAYS Y STRINGS
 |--------------------------------------------------------------------------
*/


/**
 * Convierte un array en string para ser mostrado en vistas o mensajes.
 * 
 * @param array $lista array a convertir.
 * @param bool $brackets mostrar corchetes rodeando el array?
 * @param bool $associative se trata de un array asociativo?
 * 
 * @return string representación del array a modo texto.
 */
function arrayToString(
    array $lista,
    bool $brackets = true,
    bool $associative = true
    
):string{
    $texto = '';
    
    foreach($lista as $clave => $valor){
        
        if(gettype($valor)=='array')
            $valor = arrayToString($valor);
        
        $texto .= $associative ? "$clave => $valor, " : "$valor, ";
    }
    
    return $brackets ? '[ '.rtrim($texto, ', ').' ]' : rtrim($texto, ', ');
}



/*
 |--------------------------------------------------------------------------
 | REDIRECCIONES Y URLS
 |--------------------------------------------------------------------------
 */



/**
 * helper que permite realizar redirecciones de forma simple.
 * 
 * @param string $url URL a la que queremos redireccionar.
 * @param int $delay retardo en la redirección.
 * @param bool $die finalizar la ejecución tras la redirección?
 */
function redirect(
    string $url = '/', 
    int $delay = 0,
    bool $die = true
){
    URL::redirect($url, $delay, $die);
}


/*
 |--------------------------------------------------------------------------
 | VISTAS
 |--------------------------------------------------------------------------
 */

/**
 * Carga una vista a partir del nombre y una lista de parámetros.
 * 
 * @param string $name nombre de la vista, sin la extensión.
 * @param array $parameters array asociativo con los datos que se le pasan a la vista.
 * 
 * @throws ViewException en caso de que algo falle.
 */
function view(
    string $name,           // nombre del fichero (sin extensión)
    array $parameters = []  // array asociativo de parámetros para la vista
){
    
    // crea las variables a partir de las claves del array en este ámbito
    foreach($parameters as $variable => $valor)
        $$variable = $valor;
        
    // carga la vista indicada desde el directorio de vistas
    try{
        require VIEWS_FOLDER."/$name.php";
        
    }catch(Throwable $e){
        $message = DEBUG ?
        "<p>ERROR en la vista <b>".VIEWS_FOLDER."/$name.php</b>.</p>
         <p>INFORMACIÓN ADICIONAL: ".$e->getMessage()."</p>" :
         "Error al cargar la página.";
        
        throw new ViewException($message);
    }
}   


/*
 |--------------------------------------------------------------------------
 | FORMULARIOS
 |--------------------------------------------------------------------------
 */

/**
 * Recupera los valores de los inputs flasheados en sesión (de la petición anterior).
 * Solamente los retorna si estamos en la misma URL, para evitar cruzar inputs
 * entre formularios en distintas URLs.
 * 
 * @param string $inputName nombre del input a recuperar.
 * 
 * @return string valor del input recuperado.
 */
function old(string $inputName):string{
    return Request::take()->previousInputs[$inputName] ?? '';
}

