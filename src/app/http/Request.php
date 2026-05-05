<?php

/** Request
 * 
 * Permitirá acceder a los datos de la petición fácilmente desde los controladores.
 * 
 * Última modificación: 05/05/2026.
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v0.6.5
 * @since v0.9.4 añadida propiedad $previousUrl y método sameAsPrevious()
 * @since v1.0.2 añadido métodos fromJson() y fromXML()
 * @since v1.3.0 añadido el método header()
 * @since v1.4.2 añadida la propiedad $ip
 * @since v1.4.2 añadido el método headers()
 * @since v1.5.2 añadida la propiedad estática $request, con una instancia de Request generada a partir de la petición recibida.
 * @since v2.1.0 añadido el parámetro $default a los métodos: get(), post(), cookie() y header()
 * @since v2.3.0 añadido nuevo método imageFile(), que recupera un fichero subido a modo de UploadedImage
 * @since v2.8.1 añadido el método forget() que permite olvidar datos de una superglobal o vaciarla completamente
 * @since v2.8.1 los métodos posts() y gets() pasan a ser de objeto y no estáticos.
 * @since v2.9.0 añadidos los métodos scheme(), host() y uri().
 */

class Request{
    
    /** @var Request petición recibida */
    private static ?Request $request = null;
    
    /** @var User|null $user usuario identificado en la aplicación */
    public ?User $user;
    
    /** @var string|null $url url indicada en la petición http. */
    public ?string $url;
    
    /** @var string $method método de la petición */
    public string $method;
    
    /** @var string $scheme http o https */
    public string $scheme;
    
    /** @var string $host nombre de host */
    public string $host;
    
    /** @var string $uri URI completa */
    public string $uri;
    
    /** @var string|null $previousUrl url de la petición anterior. */
    public ?string $previousUrl;
    
    /** @var string|null $csrfToken token CSRF que llega con la petición. */
    public ?string $csrfToken;
    
    /** @var string|null $ip ip del cliente */
    public ?string $ip;
    
    /** @var string|null $ip ip del cliente */
    public ?string $userAgent;
    
    /** @var $previousInputs inputs de la petición anterior, útil para recuperar los 
     *  valores de la petición anterior en los formularios y evitar que se borren cuando
     *  se produce un error. 
     *  Se debe usar el helper old() en las vistas para recuperar los valores. */
    public array $previousInputs = [];
    
    
    
    /** Constructor de Request. */
    public function __construct(){
        
        $this->user         = Login::user();
        $this->url          = URL::get();
        $this->method       = strtoupper($_SERVER['REQUEST_METHOD']);
        $this->scheme       = URL::scheme();
        $this->host         = URL::host();
        $this->uri          = URL::uri();
        $this->ip           = $_SERVER['REMOTE_ADDR'];
        $this->userAgent    = $_SERVER['HTTP_USER_AGENT'];
        
        // token CSRF que llega en los headers (o no)
        $this->csrfToken = HttpHeader::get('csrf_token');  
        
        // recupera los inputs de la petición anterior.
        $this->previousInputs = Session::get('_flashed_input') ?? [];
        
        // recupera la URL de la petición anterior.
        $this->previousUrl = Session::get('_previousUrl');
        
        // Guarda en sesión los inputs de la nueva petición que llegan por POST desde un formulario.
        // En la próxima petición podrán ser recuperados mediante el helper old().
        Session::set('_flashed_input', self::posts()); 
        
        // guarda en sesión la URL actual (para conocerla en la próxima petición)
        Session::set('_previousUrl', $this->url);        
    }
    
    
    /**
     * Crea una request a partir de los datos recibidos en la petición.
     * 
     *  La Request creada es guardada en la propiedad estática $request, pudiendo ser
     *  accedida posteriormente desde cualquier punto de la aplicación. 
     *  Este método es usado en el constructor de Kernel.php.
     * 
     * @return Request la petición recibida
     */
    public static function createFromGlobals(){
        self::$request = new self();
        return self::$request;
    }
    
        
    /**
     * Método que retorna la petición recibida.
     * 
     * Para recuperar la petición, se puede usar Request::retrieve() o directamente 
     * usar el helper request(), que es más cómodo
     * 
     * @return ?Request la petición recibida
     */
    public static function retrieve():?Request{
        return self::$request;
    }
    
 
 
    /**
     * Retorna si se está repitiendo una petición a la misma URL que antes (refresh).
     * 
     * @return boolean true si la petición actual es a la misma ruta que la petición anterior.
     */  
    public function sameAsPrevious(){
        return $this->url == $this->previousUrl;
    }
    
    
    
    /**
     * Busca una cadena de texto en la URL.
     * 
     * @param string $url cadena de texto a buscar.
     * @return bool si la url contiene la cadena de texto buscada.
     */
    public function urlHas(string $url):bool{
        return str_contains($this->url, $url);
    }
    
    
    
    /**
     * Comprueba si la URL comienza por un texto determinado.
     * 
     * @param string $url cadena de texto a buscar al inicio de la ruta.
     * @return bool true si la url comienza por la cadena de texto indicada.
     */
    public function urlBeginsWith(string $url):bool{
        return strpos($this->url, $url) === 0;
    }
        
    
    
    /**
     * URL
     *
     * @return string
     */
    public function url():string{
        return $this->url;
    }
    
    
    /**
     * método de la petición HTTP.
     * 
     * @return string
     */
    public function method():string{
        return $this->method;
    }
    
    
    /** Retorna si el protocolo es http o https
     * 
     * @return string
     */
    public function scheme(){
        return $this->scheme;
    }
    
    
    
    /** Retorna el nombre de host
     * 
     * @return string
     */
    public function host(){
        return $this->host;
    }
    
    
    /** Retorna la URI completa
     * 
     * @return string
     */
    public function uri(){
        return $this->uri;
    }

    
    /**
     * comprueba si el método de la petición será permitido por las directivas CORS, 
     * dependiendo de la configuración en config.php
     * 
     * @return bool retorna si será permitida la petición por CORS o no
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
     * Elimina una clave de una variable superglobal o la vacía completamente
     * 
     * Está pensada en el contexto de la Request, con lo que lo normal sería borrar en
     * de POST, GET o COOKIE, aunque se podría usar para cualquier superglobal.
     * 
     * @param string $method método por el que llega el dato a borrar (normalmente GET, POST o COOKIE) 
     * @param ?string $key clave del dato a borrar, se permite null para vaciar completamente la superglobal
     * 
     * @return Request la propia instancia de Request, para permitir el chaining
     */
    public function forget(
        string $method = 'POST',
        string $key    = null
    ):Request{
        
        // calcula la variable superglobal correspondiente
        $superGlobal = "$_{$method}";
        
        // si se indica la clave, desinstancia esa clave de la superglobal
        if(isset($superGlobal) && $key)
            unset($$superGlobal[$key]);
        
        // si no se indica la clave, vacía la superglobal
        if(isset($superGlobal) && !$key)
            $$superGlobal = [];
    
        // retorna la propia Request para permitir el chaining
        return $this;
    }
    
    
    
    /**
     * Recupera parámetros que llegan por POST.
     *
     * @param string $name nombre del parámetro a recuperar
     * @param ?string $default valor por defecto
     *
     * @return string|NULL valor recuperado o NULL si no existe el parámetro y no se indicó valor por defecto.
     */
    public function post(
        string $name,
        ?string $default = null
    ):?string {
            
        $data = filter_input(INPUT_POST, $name, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if ($data === null)
            return $default;
        
        $data = trim($data);
        
        if (EMPTY_STRINGS_TO_NULL && $data === '')
            return $default;
        
        return $data;
    }
    
    
    
    /**
     * Recupera parámetros que llegan por GET.
     *
     * @param string $name nombre del parámetro a recuperar.
     * @param ?string $default valor por defecto
     *
     * @return string|NULL valor recuperado o NULL si no existe el parámetro y no se indicó valor por defecto.
     */
    public function get(
        string $name,
        ?string $default = null
    ): ?string {
        
        $data = filter_input(INPUT_GET, $name, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if ($data === null)
            return $default;
        
        $data = trim($data);
        
        if (EMPTY_STRINGS_TO_NULL && $data === '')
            return $default;
        
        return $data;
    }
    
    
    
    /**
     * Recupera valores que llegan por COOKIE.
     *
     * @param string $name nombre de la cookie a recuperar.
     * @param ?string $default valor por defecto
     *
     * @return string|NULL valor recuperado o NULL si no existe la cookie y no se indicó valor por defecto.
     */
    public function cookie(
        string $name,
        ?string $default = null
    ):?string{  
        return HttpCookie::get($name, $default);
    }
     
    
    
    
    /**
     * Recupera valores de los encabezados.
     *
     * @param string $name nombre del encabezado a recuperar
     * @param string $default valor por defecto
     *
     * @return string|NULL valor recuperado o NULL si no existe y no hay valor por defecto
     */
    public function header(
        string $name,
        ?string $default = null
    ):?string{
        return HttpHeader::get($name, $default);
    }
    
    
    
    /**
     * Retorna todas las cabeceras recibidas en la Request.
     * 
     * @return array lista con las cabeceras recibidas.
     */
    public function headers():array{
        return HttpHeader::all();
    }
      
    
    
    /**
     * Retorna un array con todas las entradas de $_POST saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_POST y los valores saneados
     */
    public function posts(): array{
        $all = [];
        
        foreach ($_POST as $property => $_) {
            
            $value = filter_input(INPUT_POST, $property, FILTER_SANITIZE_SPECIAL_CHARS);
            
            if ($value === null) {
                $all[$property] = null;
                continue;
            }
            
            $value = trim($value);
            
            if (EMPTY_STRINGS_TO_NULL && $value === '') {
                $all[$property] = null;
                continue;
            }
            
            $all[$property] = $value;
        }
        
        return $all;
    }
    
    
    
    /**
     * Retorna un array con todas las entradas de $_GET saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_GET y los valores saneados
     */
    public function gets():array{
        $all = [];
        
        foreach ($_POST as $property => $_) {
            
            $value = filter_input(INPUT_POST, $property, FILTER_SANITIZE_SPECIAL_CHARS);
            
            if ($value === null) {
                $all[$property] = null;
                continue;
            }
            
            $value = trim($value);
            
            if (EMPTY_STRINGS_TO_NULL && $value === '') {
                $all[$property] = null;
                continue;
            }
            
            $all[$property] = $value;
        }
        
        return $all;
    }
    
    
    
    /**
     * Retorna un array con todas las entradas de $_COOKIE saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_COOKIE y los valores saneados
     */
    public function cookies():array{
        return HttpCookie::all();
    }
    
    
    
    /**
     * Retorna un array con todas las entradas de $_REQUEST saneadas.
     *
     * @return array un array asociativo con las mismas claves que la
     * variable superglobal $_REQUEST y los valores saneados
     */
    public function all():array{
        return self::posts()+self::gets()+self::cookies();
    }
    
    
    
    /**
     * Recupera un fichero subido desde un formulario a modo de UploadedFile.
     *
     * @param string $key clave de $_FILES a recuperar (nombre del input).
     * @param int $maxSize tamaño máximo del fichero (0 sin límite)
     * @param array $mimes lista de tipos MIME permitidos. Lista vacía para cualquier tipo de fichero.
     *
     * @return UploadedFile|NULL un objeto de tipo UploadedFile o NULL si no existe la clave indicada.
     */
    public function file(
        string $key,
        int $maxSize = UPLOAD_MAX_SIZE,  // definido en config.php
        array $mimes = []
    ):?UploadedFile{
        
        if(UploadedFile::check($key))
            return new UploadedFile($key, $maxSize, $mimes);
            
        return NULL;
    }
    
    
    
    /**
     * Recupera una imagen subida desde un formulario a modo de UploadedImage
     *
     * @param string $key clave de $_FILES a recuperar (nombre del input).
     * @param int $maxSize tamaño máximo del fichero (0 sin límite)
     * @param array $mimes lista de tipos MIME permitidos. Lista vacía para cualquier tipo de fichero.
     *
     * @return UploadedImage|NULL un objeto de tipo UploadedImage o NULL si no existe la clave indicada.
     */
    public function imageFile(
        string $key,
        int $maxSize = UPLOAD_MAX_SIZE,  // definido en config.php
        array $mimes = []
    ):?UploadedImage{
        
        if(UploadedImage::check($key))
            return new UploadedImage($key, $maxSize, $mimes);
            
        return NULL;
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
