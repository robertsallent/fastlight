<?php

/** Funciones helper para realizar tareas habituales.
 * 
 * Última revisión: 23/03/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v1.4.2 añadidos request() y user().
 * @since v1.7.4 añadidos helpers formatInt() y formatFloat()
 * @since v2.0.0 añadido el helper humanDate()
 * @since v2.1.0 añadidas snakeToCamel() y snake()
 * @since v2.4.3 nuevas funciones kebab(), camel(), fromKebab(), fromCamel(), fromSnake(), kebabToCamel() y camelToKebab()
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
 | ARRAYS
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


/*
 |--------------------------------------------------------------------------
 | STRINGS
 |--------------------------------------------------------------------------
 */

/**
 * Convierte un texto a lower snake case
 *
 * @param string $texto el texto a convertir
 * @return string el texto convertido
 */
function snake(string $texto): string {
    // reemplaza espacios o guiones por guiones bajos
    $texto = preg_replace('/[\s\-]+/', '_', $texto);
    
    // inserta guiones bajos antes de mayúsculas (de camel case a snake case)
    $texto = preg_replace('/([a-z])([A-Z])/', '$1_$2', $texto);
    
    // convierte todo a minúsculas
    return strtolower($texto);
}


/** Convierte un texto a lower kebab case
 * 
 * @param string $texto texto original
 * @return string resultado en kebab case
 */
function kebab(string $texto): string {
    return strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $texto), '-'));
}


/** Convierte un texto a camel case
 * 
 * @param string $texto texto a convertir
 * @param bool $pascal si deseamos usar pascal case (inicial en mayúsculas)
 * @return string resultado
 */
function camel(
    string $texto, 
    bool $pascal = false
): string {
    
    // realiza las sustituciones
    $resultado = str_replace(' ', '', ucwords(preg_replace('/[^a-z0-9]+/i', ' ', strtolower($texto))));
    
    // retorna el resultado, la inicial estará en mayúsculas si se indicó Pascal case
    return $pascal ? $resultado : lcfirst($resultado);
}


/**
 * Convierte de snake case a camel o Pascal case
 *
 * @param string $texto texto a convertir
 * @param bool $pascal si está a true retornará Pascal Case (inicial en mayúsculas). Opcional, por defecto false
 *
 * @return string el resultado de pasar de snake a camel case o Pascal case
 */
function snakeToCamel(
    string $texto, 
    bool $pascal = false
): string {
    
    // divide la cadena en partes separadas por guiones bajos
    $partes = explode('_', strtolower($texto));
    
    // convierte la primera letra de cada parte en mayúscula
    $partes = array_map('ucfirst', $partes);
    $resultado = implode('', $partes);
    
    // retorna Pascal case o camel case
    return $pascal? $resultado : lcfirst($resultado);
}


/** Pasa de camel case a snake case
 * 
 * @param string $texto texto a convertir
 * @return string textoo en snake case
 */
function camelToSnake(string $texto): string {
    
    // inserta guiones bajos antes de cada mayúscula (excepto la primera)
    $resultado = preg_replace('/(?<!^)[A-Z]/', '_$0', $texto);
    
    // convierte todo a minúsculas
    return strtolower($resultado);
}


/** Pasa un texto de kebab case a camel case
 *
 * @param string $texto texto en kebab-case
 * @param bool $pascal opcional, true si queremos el texto en Pascal case
 * @return string texto en camel case
 */
function kebabToCamel(
    string $texto,
    bool $pascal = false
) {
    $resultado = lcfirst(str_replace(' ', '', ucwords(str_replace('-', ' ', $texto))));
    return $pascal? ucfirst($resultado) : $resultado;
}


/** Pasa un texto de camel a kebab kase
 *
 * Ojo, alfabeto inglés sin acentos ni diéresis ni "ñ" ni "ç"...
 *
 * @param string $texto texto en camel case
 * @param bool $pascal opcional, true si queremos el texto en Pascal case
 * @return string texto en kebab case
 */
function camelToKebab(
    string $texto,
    bool $pascal = false
) {
    $resultado = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $texto));
    return $pascal? ucfirst($resultado) : $resultado;
}



/** Pasa de snake case a texto
 * 
 * @param string $texto texto a convertir
 * @param bool $capitalize si queremos las iniciales de cada palabra en mayúsculas
 * @return string resultado
 */
function fromSnake(
    string $texto,
    bool $capitalize = false
): string {
    
    // quita los guiones bajos
    $resultado = str_replace('_', ' ', strtolower($texto));
    
    // retorna el resultado
    return $capitalize ? ucwords($resultado) : $resultado;
}


/** Pasa de kebab case a texto
 *
 * @param string $texto texto a convertir
 * @param bool $capitalize si queremos las iniciales de cada palabra en mayúsculas
 * @return string resultado
 */
function fromKebab(
    string $texto,
    bool $capitalize = false
): string {
    
    // quita los guiones bajos
    $resultado = str_replace('-', ' ', strtolower($texto));
    
    // retorna el resultado
    return $capitalize ? ucwords($resultado) : $resultado;
}


/** Pasa de camel case a texto
 *
 * @param string $texto texto a convertir
 * @param bool $capitalize si queremos las iniciales de cada palabra en mayúsculas
 * @return string resultado
 */

function fromCamel(
    string $texto,
    bool $capitalizar = false
): string {
    
    // separa palabras antes de cada mayúscula
    $resultado = preg_replace('/(?<!^)[A-Z]/', ' $0', $texto);
    
    // pasa a minúsculas
    $resultado = strtolower($resultado);
    
    // capitaliza si se indica
    return $capitalizar ? ucfirst($resultado) : $resultado;
}

/*
 |--------------------------------------------------------------------------
 | FORMATEANDO HTML
 |--------------------------------------------------------------------------
 */
/**
 * Normaliza los saltos de línea en \n. 
 * 
 * Se implementa de esta forma porque FastLight (por ahora) guarda los datos escapados y las entidades
 * en la base de datos. Al ser un framework para docencia, lo hago así por seguridad.
 * 
 * @param string $text texto a normalizar
 * @return string texto normalizado
 */
function makeEndLines(string $text = ''): string{
    // Normalizar y eliminar saltos de línea consecutivos
    $text = preg_replace("/(?:&#13;&#10;|&#13;|&#10;){2,}/", "\n", $text);
    
    // eliminar los saltos de línea al inicio y final
    return trim($text, "\n");
}

/**
 * Convierte un texto a párrafos HTML.
 * 
 * Añade las etiquetas <p> y </p> al inicio y final y reemplaza los saltos de línea \n
 * por las etiquetas de cierre y apertura de párrafo. Además colapsa los espacios
 * en blanco consecutivos.
 * 
 * @param string $text texto a convertir
 * 
 * @return string texto metido en párrafos.
 */
function makeParagraphs(string $text    = ''):string{
    
     // cambia los saltos de línea por etiquetas HTML
    $text =  str_replace("\n", "</p><p>", $text);
    // $text =  str_replace('&#10;', "</p><p>", $text);
        
    // elimina espacios en blanco consecutivos
    $text = preg_replace('/\s+/', ' ', $text);
    
    return "<p>{$text}</p>";
}


/**
 * Función obsoleta que será eliminada con el tiempo
 * 
 * @param string $text
 * @return string
 * 
 * @deprecated ahora se usa toHTML()
 */
function paragraph(string $text    = ''):string{
    return makeParagraphs(makeEndLines($text));
}


/**
 * Convierte líneas que comienzan por guión en listas HTML.
 * Cada línea se considera un "párrafo".
 * 
 * @param string $html el texto a procesar.
 * 
 * @return string el HTML con las listas convertidas.
 */
function makeLists(string $html) {

    // Separar por saltos de línea
    $lineas = preg_split('/\r\n|\r|\n/', $html);

    $resultado = '';
    $enLista = false;

    foreach ($lineas as $linea) {

        $contenido = trim($linea);

        // Línea vacía → cerrar lista si está abierta y saltar
        if ($contenido === '') {
            if ($enLista) {
                $resultado .= "</ul>\n";
                $enLista = false;
            }
            continue;
        }

        // Detecta si la línea comienza por guión
        if (preg_match('/^\s*-\s*/', $contenido)) {

            // Abrir lista si no está abierta
            if (!$enLista) {
                $resultado .= "<ul>\n";
                $enLista = true;
            }

            // Quitar el guión y espacios
            $contenidoSinGuion = preg_replace('/^\s*-\s*/', '', $contenido);

            $resultado .= "\t<li>$contenidoSinGuion</li>\n";

        } else {

            // Terminar lista si está abierta
            if ($enLista) {
                $resultado .= "</ul>\n";
                $enLista = false;
            }

            $resultado .= "<p>$contenido</p>\n";
        }
    }

    // Cerrar lista si el texto termina dentro de una lista
    if ($enLista) {
        $resultado .= "</ul>\n";
    }

    return $resultado;
}



/**
 * Convierte los enlaces de texto en enlaces HTML
 * 
 * @param string $texto texto donde realizar la sustitución
 */
function makeLinks(string $html): string {
     return preg_replace_callback(
        '/\b(https?:\/\/[^\s,<>"\'()]+)/i',
        function ($match) {
            $href    = preg_replace('/(?:[.;:!?\'""]|(?:&#0*39;|&apos;|&quot;))+$/', '', $match[1]);
            $display = $match[1];
            return "<a href='{$href}' rel='nofollow noopener noreferrer'>{$display}</a> ";
        },
        $html
    );
}


/**
 * Convierte las líneas que comiencen por _hx en cabeceras de orden x (<hx>)
 * 
 * @param string $html
 * @return string|array|NULL
 */
function makeHeaders(string $html = '') {
    // Buscar todas las líneas que comiencen por _h[1-6]
    return preg_replace_callback(
        '/_h([1-6])\s(.*?)\n/s',                          // regexp de búsqueda
        function($match){
            return "<h{$match[1]}>{$match[2]}</h{$match[1]}>";      // retorna las líneas bien formadas
        },
        $html
    );
}


/**
 * Procesa el texto para ser mostrado como HTML
 * 
 * @param string $text
 * @param bool $endlines
 * @param bool $lists
 * @param bool $headers
 * @param bool $links
 * @param bool $paragraphs
 * 
 * @return string
 */
function toHTML(
    ?string $text    = null,
    bool $endLines   = true,
    bool $lists      = true,
    bool $headers    = true,
    bool $links      = true,
    bool $paragraphs = true
    
): string {
    
    if($text){
        $text = $endLines   ? makeEndLines($text)   : $text;
        $text = $lists      ? makeLists($text)      : $text;
        $text = $headers    ? makeHeaders($text)    : $text;
        $text = $links      ? makeLinks($text)      : $text;
        $text = $paragraphs ? makeParagraphs($text) : $text;       
    }
    return $text ?? '';
}


/**
 * Decodifica el html_entities en las cadenas de texto de objetos.
 *
 * Útil para respuestas de APIS.
 *
 * @param mixed $obj
 * @return mixed
 */
function decodeStringFields(mixed $obj):mixed{
    
    foreach ($obj as $key => $value)
        if (is_string($value)){
            // Primero decodificamos entidades HTML normales
            $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            // Luego reemplazamos los &#13; por salto de línea
            $decoded = str_replace(["\r", "\n", "&#13;"], " ", $decoded);
            // También podemos limpiar múltiples espacios
            $decoded = preg_replace('/\s+/', ' ', $decoded);
            $obj->$key = $decoded;
    }
    
    // retorna el objeto con las html_entities decodificadas
    return $obj;
}



/*
 |--------------------------------------------------------------------------
 | FORMATEO DE NÚMEROS
 |--------------------------------------------------------------------------
 */

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
 * @param float $number el número a formatear
 *
 * @return string el número formateado
 */
function formatFloat(float $number, int $decimal = 0):string{
    return number_format($number, $decimal, ',', '.');
}



/*
 |--------------------------------------------------------------------------
 | FECHAS
 |--------------------------------------------------------------------------
 */

function humanDate(string $date, bool $time = true):string{
    
    $months = [
        "enero",
        "febrero",
        "marzo",
        "abril",
        "mayo",
        "junio",
        "julio",
        "agosto",
        "septiembre",
        "octubre",
        "noviembre",
        "diciembre"
    ];
    
    $dateTime = explode(" ", $date);
    $dateArray = explode("-", $dateTime[0]);
    
    $result = intval($dateArray[2])." de ".$months[$dateArray[1]-1]." de ".$dateArray[0];
    
    if($time && ($dateTime[1] ?? false))
        $result .= ", a las ".$dateTime[1];   
    
    return $result;
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
function oldSelected(
    string $inputName, 
    string $value
):string{
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



/*
 |--------------------------------------------------------------------------
 | TOKENS Y SEGURIDAD
 |--------------------------------------------------------------------------
 */


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




