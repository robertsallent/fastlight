<?php

/** 
 * Clase AppError.
 *
 * Modelo responsable de guardar los errores en base de datos.
 * 
 * Última revisión: 19/04/2026
 * 
 * @author: Robert Sallent <robert@fastlight.org>
 */

class AppError extends Model{
    
    /** @var string $table nombre de la tabla en la base de datos */ 
    protected static string $table = ERROR_DB_TABLE;
    
    /** @var string $type typo de error, WEB para aplicaciones web y API para apis */
    protected string $type      = '';
    
    /** @var string $level nivel del error */
    protected string $level     = '';
    
    /** @var string $message mensaje de error */
    protected string $message   = '';
    
    /** @var string $url ruta en la que se ha producido el error */
    protected string $url       = '';
    
    /** @var ?string $user displayname del usuario identificado */
    protected ?string $user     = NULL;
    
    /** @var ?string $ip dirección IP desde donde llega la petición */
    protected ?string $ip       = NULL;
  
    
    /**
     * Constructor.
     * 
     * @static  
     * @param string $level     nivel de severidad o tipo de error
     * @param string $message   mensaje
     * 
     * @return void
     */
    public function __construct(
        string $level   = 'Error', 
        string $message = ''     
    ){
        // prepara el nivel y el mensaje de error
        $this->type    = 'WEB';
        $this->level   = $level;
        $this->message = $message;
        
        // recupera la URL, usuario e IP desde la Request
        $request       = request();
        $this->url     = $request->url;
        $this->user    = $request->user ? $request->user->email : NULL;
        $this->ip      = $request->ip;
    }    
}
