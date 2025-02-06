<?php

/**
 * Funciones helper para realizar tareas habituales.
 * 
 * Última revisión: 31/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v1.4.2 añadido el helper request() que retorna el objeto Request con información de la petición.
 * @since v1.4.2 añadido el helper user() que retorna el usuario identificado.
 * @since v1.7.3 el helper arrayToString recibe un quinto parámetro (opcional).
 * @since v1.7.4 añadidos helpers formatInt() y formatFloat()
*/



/*
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
 * @param string $separator separador de elementos, por defecto la coma y un espacio.
 * @param string $keyValueSeparator separador entre clave y valor.
 * 
 * @return string representación del array a modo texto.
 */
function arrayToString(
    array $lista,
    bool $brackets    = true,
    bool $associative = true,
    string $separator = ", ",
    string $keyValueSeparator = " => "
):string{
    
    $texto = '';
    
    foreach($lista as $clave => $valor){
        
        if(gettype($valor)=='array')
            $valor = arrayToString($valor, $brackets, $associative, $separator);
        
        $texto .= $associative ? "$clave $keyValueSeparator $valor$separator" : "$valor$separator";
    }
    
    return $brackets ? '[ '.rtrim($texto, "$separator").' ]' : rtrim($texto, "$separator");
}


/**
 * Convierte un texto a párrafos HTML.
 * 
 * Añade las etiquetas <p> y </p> al inicio y final y reemplaza los saltos de línea \n
 * por las etiquetas de cierre y apertura de párrafo. Además colapsa los espacios
 * en blanco consecutivos.
 * 
 * @param string $text texto a convertir
 * @param bool $edges coloca las etiquetas <p> y </p> al inicio y final del texto (por defecto true).
 * @param bool $collapse une múltiples espacios en blanco en uno solo.
 * 
 * @return string texto metido en párrafos.
 */
function paragraph(
    string $text = '', 
    bool $edges = true,
    bool $collapse = true
):string{
    
    // cambia los saltos de línea por etiquetas HTML
    $text =  str_replace("\n", "</p><p>", $edges ? "<p>$text</p>" : $text);
    $text =  str_replace('&#13;', "</p><p>", $edges ? "<p>$text</p>" : $text);
    
    if($collapse){
        // elimina espacios en blanco consecutivos
        $text = preg_replace('/\s+/', ' ', $text);
        
        // limpia espacios en blanco después de la apertura o antes del cierre
        $text = preg_replace('/(\s<)/', '<', $text);
        $text = preg_replace('/(>\s)/', '>', $text);
    }
    
    return $text;
}



/**
 * Formatea un número entero para poner el separador de miles
 * 
 * @param int $number el número a formatear
 * 
 * @return string el número formateado
 */
function formatInt(int $number):string{
    return number_format($number, 0, ',', '.');
}



/**
 * Formatea un número float para poner el separador de miles y de decimales
 *
 * @param int $number el número a formatear
 *
 * @return string el número formateado
 */
function formatFloat(int $number, int $decimal = 0):string{
    return number_format($number, $decimal, ',', '.');
}



/*
 |--------------------------------------------------------------------------
 | REQUESTS
 |--------------------------------------------------------------------------
 */


/**
 * Retorna la petición mediante un objeto de tipo Request.
 *
 * @return Request el objeto Request con la información de la petición.
 */
function request(){
    return Request::retrieve();
}



/*
 |--------------------------------------------------------------------------
 | RESPONSES Y VIEWS
 |--------------------------------------------------------------------------
 */

/**
 * Carga una vista a partir del nombre y una lista de parámetros.
 *
 * @param string $name nombre de la vista, sin la extensión.
 * @param array $parameters array asociativo con los datos que se le pasan a la vista.
 * @param int $httpcode código HTTP de la respuesta
 * @param string $status frase de estado HTTP

 * 
 * @return ViewResponse
 * 
 * @throws ViewException en caso de que algo falle.
 */
function view(
    string $name,
    array $parameters   = [],
    int $httpCode       = 200,
    string $status      = 'OK',
):ViewResponse{
    return new ViewResponse($name, $parameters, $httpCode, $status);
}


/**
 * Comprueba si una vista existe y es legible.
 *
 * @param string $name nombre de la vista.
 *
 * @return bool true si la vista existe y es legible, false en caso contrario.
 */
function viewExists(string $name):bool{
    return View::exists($name);
}


/**
 * Aborta la operación y retorna una respuesta de error, cargando
 * la vista personalizada si existe.
 *
 * @param int $code código HTTP del error.
 * @param string $status texto de estado http
 * @param string $message mensaje para mostrar.
 * @param Throwable $t error o excepción producida, para preparar mejor la respuesta
 *
 * @return Response 
 * 
 * @throws ViewException si no encuentra la vista.
 *
 */
function abort(
    int $code           = 500,
    string $status      = 'INTERNAL SERVER ERROR',
    string $message     = '',
    Throwable $t        = null
):Response{
    return new ViewErrorResponse($t, $code, $status, $message);
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
 * @param int $httpCode código HTTP
 * @param string $status frase de estado HTTP
 * @param string $contentType tipo MIME de la respuesta
 * @param bool $die finalizar la ejecución tras la redirección?
 * 
 * @return RedirectResponse
 */
function redirect(
    string $url = '/', 
    int $delay = 0,
    int $httpCode       = 302,
    string $status      = 'FOUND'
):RedirectResponse{
    return new RedirectResponse($url, $delay, $httpCode, $status);
}






/*
 |--------------------------------------------------------------------------
 | USUARIOS
 |--------------------------------------------------------------------------
 */


/**
 * Retorna el usuario identificado en la sesión.
 * 
 * @return User el usuario identificado
 */
function user(){
    return Login::user();    
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
 * @param string $dbValue para las operaciones de edición, valor antiguo de la BDD.

 * @return string valor del input recuperado.
 */
function old(string $inputName, string $dbValue = NULL):string{
    return request()->previousInputs[$inputName] ?? $dbValue ?? '';
}


/**
 * Selecciona una opción en un input, dependiendo del valor.
 * 
 * @param string $inputName nombre del input.
 * @param string $value valor a comprobar.
 * 
 * @return string selected o cadena vacía.
 */
function oldSelected(string $inputName, string $value):string{
    return request()->previousInputs[$inputName] == $value ? ' selected ' : '';
}


/**
 * Marca un checkbox o botón de radio, dependiendo del valor.
 * 
 * @param string $inputName nombre del input.
 * @param string $value valor a comprobar.
 * @param bool $default si debe estar marcado por defecto.
 * 
 * @return string checked o cadena vacía.
 */
function oldChecked(
    string $inputName, 
    string $value,
    bool $default = false
):string{
    
    $oldValue = request()->previousInputs[$inputName];
    
    if(!$oldValue && $default)
        return ' checked';
    
    return $oldValue == $value ? ' checked ' : '';
}



/**
 * Crea un token CSRF y un input hidden para colocarlo en el formulario
 * 
 * @return string el código del input
 */
function csrf():string{
    // crea un nuevo token CSRF y lo guarda en sesión
    CSRF::create();
    
    // retorna un input hidden para colocarlo en el formulario
    return CSRF::createInput();
}




