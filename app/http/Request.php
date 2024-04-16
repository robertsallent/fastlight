<?php

/** Request
 * 
 * Permitirá acceder a los datos de la petición fácilmente desde los controladores.
 * 
 * Última modificación: 09/04/2024.
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 * @since v0.6.5
 * @since v0.9.4 añadida propiedad $previousUrl y método sameAsPrevious()
 * @since v1.0.2 añadido métodos fromJson() y fromXML()
 */

class Request{
    
    
    /** @var Authenticable|null $user usuario identificado en la aplicación */
    public ?Authenticable $user;
    
    /** @var string|null $url url indicada en la petición http. */
    public ?string $url;
    
    /** @var string $method método de la petición */
    public string $method;
    
    /** @var string|null $previousUrl url de la petición anterior. */
    public ?string $previousUrl;
    
    /** @var string|null $csrfToken token CSRF que llega con la petición. */
    public ?string $csrfToken;
    
    /** @var $previousInputs inputs de la petición anterior, útil para recuperar los 
     *  valores de la petición anterior en los formularios y evitar que se borren cuando
     *  se produce un error. 
     *  Se debe usar el helper old() en las vistas para recuperar los valores. */
    public array $previousInputs = [];
    
    
    
    /**
     * Constructor de Request.
     */
    public function __construct(){
        
        $this->user = Login::user();            // mete el usuario identificado en la Request
        $this->url  = $_SERVER['REQUEST_URI'];  // mete la URL en la request
        
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']); // método de la petición
        
        $this->csrfToken = apache_request_headers()['csrf_token'] ?? null;  // token CSRF que llega en los headers
        
        // recupera los inputs de la petición anterior.
        $this->previousInputs = Session::get('flashed_input') ?? [];
        
        // recupera la URL de la petición anterior.
        $this->previousUrl = Session::get('previousUrl');
        
        // Guarda en sesión los inputs de la nueva petición que llegan por POST desde un formulario.
        // En la próxima petición podrán ser recuperados mediante el helper old().
        Session::set('flashed_input', self::posts()); 
        
        // guarda en sesión la URL actual (para tenerlo en la próxima petición)
        Session::set('previousUrl', $this->url);
    }
    
    
    
    /**
     * Retorna si estamos realizando la misma petición (refresh).
     * 
     * @return boolean true si la petición actual es a la misma ruta que la anterior.
     */  
    public function sameAsPrevious(){
        return $this->url == $this->previousUrl;
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
     * Busca una cadena de texto en la url.
     * 
     * @param string $url cadena de texto a buscar.
     * @return bool si la url contiene la cadena de texto buscada.
     */
    public function urlHas(string $url):bool{
        return str_contains($this->url, $url);
    }
    
    
    
    /**
     * Comprueba si una ruta comienza por un texto determinado.
     * 
     * @param string $url cadena de texto a buscar al inicio de la ruta.
     * @return bool true si la url comienza por la cadena de texto indicada.
     */
    public function urlBeginsWith(string $url):bool{
        return strpos($this->url, $url) === 0;
    }
    
    
    
    /**
     * método de la petición HTTP.
     * 
     * @return string
     */
    public function method():string{
        return $this->method;
    }
    
    
    /**
     * comprueba si un método será permitido por las directivas CORS, 
     * dependiendo de la configuración en config.php
     * 
     * @param string $method método a comprobar
     * @return bool retorna si será bloqueada la petición por CORS o no
     */
    public function allowedByCors():bool{
        
        $permitidos = explode(',', ALLOW_METHODS);
        
        for($i = 0; $i<count($permitidos); $i++)
            $permitidos[$i] = trim($permitidos[$i]);
        
        return in_array(strtoupper($this->method()), $permitidos);
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
        
        if(!isset($_POST[$name])) // mira si llega el campo
            return NULL; 
        
        $data = $_POST[$name];    // toma el dato que llega
        
        // si hay que pasar la cadena vacía a NULL...
        if(EMPTY_STRINGS_TO_NULL && $data === '')
              return NULL;
        
        // retornamos los datos escapados
        return  (DB_CLASS)::escape($data);
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
            
        if(!isset($_GET[$name])) // mira si llega el campo
            return NULL;
            
        $data = $_GET[$name];    // toma el dato que llega
            
        // si hay que pasar la cadena vacía a NULL...
        if(EMPTY_STRINGS_TO_NULL && $data === '')
            return NULL;
            
        // retornamos los datos escapados
        return  (DB_CLASS)::escape($data);
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
        
        if(!isset($_COOKIE[$name])) // mira si llega el campo
            return NULL;
            
        $data = $_COOKIE[$name];    // toma el dato que llega
            
        // si hay que pasar la cadena vacía a NULL...
        if(EMPTY_STRINGS_TO_NULL && $data === '')
            return NULL;
                
        // retornamos los datos escapados
        return  (DB_CLASS)::escape($data);
    }    
    
    


    /**
     * Retorna un array con todas las entradas de $_REQUEST saneadas.
     * 
     * @return array un array asociativo con las mismas claves que la 
     * variable superglobal $_REQUEST y los valores saneados
     */
    public static function all():array{
        $all = [];
        
        foreach($_REQUEST as $property => $value){
            
            // si hay que pasar la cadena vacía a NULL...
            if(EMPTY_STRINGS_TO_NULL && $value === '')
                $value = NULL;
            
            $all[$property] =  $value ? (DB_CLASS)::escape($value) : NULL;
        }
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
        
        foreach($_POST as $property => $value){
            
            // si hay que pasar la cadena vacía a NULL...
            if(EMPTY_STRINGS_TO_NULL && $value === '')
                $value = NULL;
            
            $all[$property] =  $value ? (DB_CLASS)::escape($value) : NULL;
        }
            
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
        
        foreach($_GET as $property => $value){
            
            // si hay que pasar la cadena vacía a NULL...
            if(EMPTY_STRINGS_TO_NULL && $value === '')
                $value = NULL;
            
            $all[$property] =  $value ? (DB_CLASS)::escape($value) : NULL;
        }
            
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
        
        foreach($_COOKIE as $property => $value){
            
            // si hay que pasar la cadena vacía a NULL...
            if(EMPTY_STRINGS_TO_NULL && $value === '')
                $value = NULL;
            
            $all[$property] =  $value ? (DB_CLASS)::escape($value) : NULL;
        }
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
    
    /**
     * recupera los datos contenidos en una petición con datos en JSON y los retorna a modo de array de objetos.
     *
     * @param string $class clase a la que mapear los elementos de pimer nivel dentro del array retornado
     *
     * @return array|NULL retorna un array de objetos creado a partir del JSON
     */
    public function fromJson(
        string $class = 'stdClass'
    ):?array{
            
        // recupera los datos contenidos en el cuerpo de la petición
        if(empty($json = $this->body())) 
            throw new ApiException('No se recibieron datos en la petición.');
            
        // convierte los datos en una lista de objetos del tipo deseado    
        return JSON::decode($json, $class); 
    }
    
    
    /**
     * recupera los datos contenidos en una petición con datos en XML y los retorna a modo de array de objetos.
     *
     * @param string $class clase a la que mapear los elementos de pimer nivel dentro del array retornado
     *
     * @return array|NULL retorna un array de objetos creado a partir del XML
     */
    public function fromXML(
        string $class = 'stdClass'
    ):?array{
            
        // recupera los datos contenidos en el cuerpo de la petición
        if(empty($xml = $this->body()))
            throw new ApiException('No se recibieron datos en la petición.');
            
        // convierte los datos en una lista de objetos del tipo deseado
        return XML::decode($xml, $class);
    }
}
