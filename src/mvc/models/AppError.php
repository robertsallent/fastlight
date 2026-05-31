<?php

/** 
 * Clase AppError.
 *
 * Modelo responsable de guardar los errores en base de datos.
 * 
 * Última revisión: 31/05/2026
 * 
 * @author: Robert Sallent <robert@fastlight.org>
 */

class AppError extends Model{
    
    /** @var string $table nombre de la tabla en la base de datos */ 
    public static string $table = ERROR_DB_TABLE;
    
    /** @var string $type typo de error, WEB para aplicaciones web y API para apis */
    public string $type      = '';
    
    /** @var string $level nivel del error */
    public string $level     = '';
    
    /** @var string $message mensaje de error */
    public string $message   = '';
    
    /** @var string $url ruta en la que se ha producido el error */
    public string $url       = '';
    
    /** @var ?string $user displayname del usuario identificado */
    public ?string $user     = NULL;
    
    /** @var ?string $ip dirección IP desde donde llega la petición */
    public ?string $ip       = NULL;
  

    
    /** Alternativa al uso del constructor
     * 
     * @param string $level     nivel de severidad o tipo de error
     * @param string $message   mensaje
     * 
     * @return AppError el propio objeto para permitir chaining
     */
    public static function new(
        string $level   = 'Error',
        string $message = ''
    ):AppError{
        
        $error = new self($level, $message);
        
        // prepara el nivel y el mensaje de error
        $error->type    = 'WEB';
        $error->level   = $level;
        $error->message = $message;
        
        // recupera la URL, usuario e IP desde la Request
        $request      = request();
        $error->url   = $request->getUrl();
        $error->user  = $request->getUser() ? $request->getUser()->email : NULL;
        $error->ip    = $request->getIP();
        
        return $error;
    }
}
