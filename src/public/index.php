<?php

/** index.php
 *
 * Punto de entrada para todas las peticiones.
 * 
 * - Carga el fichero de configuración.
 * - Comprueba la versión de PHP en el servidor.
 * - Lanza la aplicación.
 * - Envia la Response final, invocando al método send().
 * - Si se produce algún error en la fase de arranque, carga una vista de  error genérica (código 500).
 * 
 * Última revisión: 31/05/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * 
 * @since v0.1.0
 * @since v1.4.5 se puede comprobar que la versión de PHP sea la adecuada
 * @since v2.6.0 se incorpora la carga del fichero de configuración del middleware
 * @since v2.8.0 se separa la creacion de APIs RESTFUL al proyecto FastLightAPI
 * @since v2.12.0 se extrae la inicialización de la sesión a la clase App
 */


/* -------------------------------------------------------------------------------------
 * INICIALIZACIÓN 
 * -------------------------------------------------------------------------------------*/

// carga el fichero de configuración
require  '../config/config.php';    

// si no se deben mostrar errores sobre la web, asegura que estén desactivados
// si está configurado a true (en config.php), los mostrará o no dependiendo de la configuración del servidor 
if(!DISPLAY_ERRORS)
    ini_set('display_errors', 0);
    
// comprueba la versión de PHP (según lo especificado en config.php)
if (CHECK_PHP_VERSION && version_compare(PHP_VERSION, MIN_PHP_VERSION, '<')) 
    die("ERROR: se requiere PHP ".MIN_PHP_VERSION." pero se detectó PHP ".PHP_VERSION.". Puedes actualizar la 
         versión de PHP en el servidor o modificar el parámetro MIN_PHP_VERSION en el fichero de configuración 
         (pero no se garantiza el correcto funcionamiento).");

// carga la configuración de los middlewares (si existiera)
@include '../config/middleware.php'; 
    
// carga el autoload y las funciones helper globales
require '../app/autoload.php';          
require '../app/helpers/helpers.php';   

    
/* -------------------------------------------------------------------------------------
 * PUESTA EN MARCHA
 * -------------------------------------------------------------------------------------*/
try{

    // Crea la instancia del Kernel App y llama al método handle()
    $response = (new App())->handle();
    
    // se envía la respuesta al cliente
    $response->send();
    

// si se produce un error en una vista
// la vista quedará cortada en el punto donde se produjo el error, mostrando el mensaje
}catch(ViewException $t){
         
    // Prepara el mensaje de error en formato HTML.
    // En modo DEBUG, se añade información adicional al mensaje de error.
    $message = DEBUG ||  user() && user()->hasRole('ROLE_DEBUG')? $t->getMessage() : "Error al mostrar la respuesta.";
    
    $informacion = "<section class='error'>
                        <h2>Se ha producido un error</h2>
                        <p>Revisa la información a continuación.</p>
                        <p class='caution'>{$message}</p>
                    </section>";
    
    echo $informacion;
    
    
// para cualquier otro tipo de error
}catch(Throwable $t){
    
    // prepara el mensaje de error.
    $mensaje = DEBUG ? 
        'Error en el proceso, el mensaje es: '.$t->getMessage() : 
        'Se produjo un error, contacte con el administrador '.ADMIN_EMAIL.' si lo considera necesario.';
    
    // prepara la respuesta de error.
    $response = abort(500, 'INTERNAL SERVER ERROR', $mensaje, $t);
    $response->send();
}
    

