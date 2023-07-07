<?php

/** Request
 * 
 * Permitirá acceder a los datos de la petición fácilmente desde los controladores.
 * 
 * Última mofidicación: 07/07/2023.
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.6.5
 */

class Request{
    
    
    /** @var Authenticable|null $user usuario identificado en la aplicación */
    public ?Authenticable $user;
    
    /** @var string|null $url url indicada en la petición http. */
    public ?string $url;
    
    /** @var string|null $csrfToken token CSRF que llega con la petición. */
    public ?string $csrfToken;
    
    /** @var $oldInputs inputs de la petición anterior, útil para recuperar los 
     *  valores de la petición anterior en los formularios y evitar que se borren cuando
     *  se produce un error. 
     *  Se debe usar el helper old() en las vistas para recuperar los valores. */
    public array $oldInputs = [];
    
    
    
    /**
     * Constructor de Request.
     */
    public function __construct(){
        
        $this->user = Login::user();            // mete el usuario identificado en la Request
        $this->url  = $_SERVER['REQUEST_URI'];  // mete la URL en la request
        $this->csrfToken = apache_request_headers()['csrf_token'] ?? null;  // token CSRF que llega en los headers
        
        // recupera los inputs de la petición anterior.
        $this->oldInputs = $_SESSION['flashed_input'] ?? [];
        
        // flashea los inputs de la nueva petición que llegan por POST desde un formulario.
        $_SESSION['flashed_input'] = self::posts();   
    }
    
       
    
    /**
     * Método estático para crea un nuevo objeto de tipo Request.
     * 
     * @return Request
     */
    public static function create(){
        return new self();
    }
    
    
    
    /**
     * Recupera la request.
     * 
     * @return Request
     */
    public static function take():Request{
        return Kernel::getRequest();
    }
    
    
    
    /**
     * método de la petición HTTP.
     * 
     * @return string
     */
    public function method():string{
        return $_SERVER['REQUEST_METHOD'];
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
     * Retorna un array con todas las entradas de $_GET saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_GET y los valores saneados
     */
    public static function gets():array{
        $all = [];
        
        foreach($_GET as $property => $value)
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
     * Recupera un fichero subido desde un formulario.
     * 
     * @param string $key nombre del input, clave en el array superglobal $_FILES.
     * 
     * @return UploadedFile|NULL un objeto de tipo UploadedFile o NULL si no existe la clave indicada.
     */
    public function file(string $key):?UploadedFile{
        try{
            return new UploadedFile($key);
        }catch(UploadException $e){
            return NULL;
        }
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
