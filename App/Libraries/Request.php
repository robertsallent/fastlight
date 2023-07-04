<?php

/** Clase Request
 * 
 * Permitirá acceder a los datos saneados de la petición 
 * fácilmente desde los controladores.
 * 
 * Última mofidicación: 13/04/2023.
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class Request{
    
    /** @var Authenticable|null $user usuario identificado en la aplicación */
    public ?Authenticable $user;
    
    /** @var string|null $url url indicada en la petición http. */
    public ?string $url;
    
    /** @var string|null $csrfToken token CSRF que llega con la petición. */
    public ?string $csrfToken;
    
    
    
    /**
     * Crea un nuevo objeto Request.
     * 
     * @return Request
     */
    public static function create(){
        $request = new self();
        
        $request->user = Login::user();          // mete el usuario identificado en la Request
        $request->url = $_SERVER['REQUEST_URI']; // mete la URL en la request
        $request->csrfToken = apache_request_headers()['csrf_token'] ?? null; // token CSRF que llega en los headers
        
        return $request;
    }
    
    
    
    /**
     * Comprueba si llega un determinado parámetro en la petición.
     * 
     * @param string $name nombre del parámetro. 
     * @param string $method método HTTP por el que debe llegar.
     * 
     * @return bool true si el parámetro llega, false en caso contrario.
     */
    public function has(
        string $name, 
        string $method = 'POST'  // POST, GET o COOKIE
            
    ):bool{
        switch(strtoupper($method)){
            case 'POST' : return isset($_POST[$name]);
            case 'GET' : return isset($_GET[$name]);
            case 'COOKIE' : return isset($_COOKIE[$name]);
        }
        
        return false; 
    }
    
    
    
    /**
     * Recupera parámetros que llegan por POST.
     * 
     * @param string $name nombre del parámetro a recuperar.
     * 
     * @return string|NULL valor recuperado o NULL si no existe el parámetro.
     */
    public function post(
        string $name        // nombre del campo a recuperar
        
    ): ?string{
        
        $data = $_POST[$name] ?? NULL; 
        return  $data ? (DB_CLASS)::escape($data) : NULL;
    }
    
    
    
    /**
     * Recupera parámetros que llegan por GET.
     *
     * @param string $name nombre del parámetro a recuperar.
     *
     * @return string|NULL valor recuperado o NULL si no existe el parámetro.
     */
    public function get(
        string $name        // nombre del parámetro a recuperar
        
    ): ?string{
            
        $data = $_GET[$name] ?? NULL;
        return  $data ? (DB_CLASS)::escape($data) : NULL;
    }
    
    
    
    /**
     * Recupera valores que llegan por COOKIE.
     *
     * @param string $name nombre de la cookie a recuperar.
     *
     * @return string|NULL valor recuperado o NULL si no existe la cookie.
     */
    public function cookie(
        string $name        // nombre de la cookie a recuperar
 
    ): ?string{
        
        $data = $_COOKIE[$name] ?? NULL;
        return  $data ? (DB_CLASS)::escape($data) : NULL;
    }    
    


    /**
     * Retorna un array con todas las entradas de $_REQUEST saneadas.
     * 
     * @return array un array asociativo con las mismas claves que la 
     * variable superglobal $_REQUEST y los valores saneados
     */
    public static function all():array{
        $all = [];
        
        foreach($_REQUEST as $property => $value)
            $all[$property] =  (DB_CLASS)::escape($value);
        
        return $all;
    }
    
    
    
    /**
     * Retorna un array con todas las entradas de $_POST saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_POST y los valores saneados
     */
    public static function posts():array{
        $all = [];
        
        foreach($_POST as $property => $value)
            $all[$property] =  (DB_CLASS)::escape($value);
            
        return $all;
    }
    
    
    
    /**
     * Retorna un array con todas las entradas de $_COOKIE saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_COOKIE y los valores saneados
     */
    public static function cookies():array{
        $all = [];
        
        foreach($_COOKIE as $property => $value)
            $all[$property] =  (DB_CLASS)::escape($value);
            
        return $all;
    }
    
    
    
    /**
     * Recupera los datos en el body de la petición. Los datos no son
     * saneados puesto que tendríamos problemas si son en JSON o XML.
     * 
     * @return string información recuperada del cuerpo de la petición.
     */
    public function body():string{
        return file_get_contents('php://input');
    }   
}
