<?php

/** BASE TEMPLATE
 *
 * Se usa para generar las partes comunes de todas las vistas
 *
 * Última revisión: 18/02/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 *
 */
class Base implements TemplateInterface{
    
    /** Lista de ficheros CSS para usar con este template 
     * 
     *    Se pueden añadir o quitar entradas sin problema. 
     *    
     *    Si tienes otros templates que hereden de éste, puedes redefinir la propiedad 
     *    para usar otras hojas de estilo diferentes. 
     *    
     *    Puede ser útil que tus ficheros CSS importen éstos (si así  lo quieres). 
     * */
    protected array $css = [
        'standard'  => '/css/base.css',         // hoja de estilo para PC
        'tablet'    => '/css/base_tablet.css',  // hoja de estilo para tablet
        'phone'     => '/css/base_phone.css',   // hoja de estilo para teléfono
        'printer'   => '/css/base_printer.css'  // hoja de estilo para impresora    
    ];
    
    
    
    /** Media queries para cargar los distintos ficheros CSS.
     * 
     *  Puedes añadir o quitar entradas sin problema, reescribirlas o bien cambiar
     *  los rangos de resolución para los distintos tipos de pantalla.
     *  
     *  Adaptar al gusto.
     *  */
    protected array $mediaQueries = [
        'standard'  => 'screen',
        'tablet'    => 'screen and (max-width: 850px)',
        'phone'     => 'screen and (max-width: 450px)',
        'printer'   => 'print'
    ];
    
    
    /* ****************************************************************************
     * CARGA DE FICHEROS CSS
     *****************************************************************************/
    
    /**
     * Prepara el HTML con las etiquetas <link> a todos los ficheros CSS, configurados mediante 
     * las propiedades $css y $mediaQueries definidas más arriba.
     * 
     * @return string HTML con los links a los ficheros CSS.
     */
    public function css(){
        $html = "\n";
        
        // para cada fichero CSS a cargar...
        foreach($this->css as $device => $file){
            
            // si no es null...
            if($file){
                // añade la etiqueta <link> para cargar el fichero CSS al HTML, incluyendo la media query
                $html .= "\t\t<link rel='stylesheet' media='".($this->mediaQueries[$device])."' type='text/css' href='$file'>\n";
            }
        }
        return $html;
    }
    
    
    
    /* ****************************************************************************
     * LOGIN / LOGOUT
     *****************************************************************************/
    
    /**
     * Prepara el HTML con los enlaces de login/logout en función del 
     * rol de usuario identificado.
     * 
     * @return string HTML con los enlaces a login y logout.
     */
    public function login(){
        
        // si el usuario no está identificado
        if(Login::guest()){
            
            // prepara el HTML solamente con el botón de "LogIn"
            $html = " 
            <div id='access-bar'>
               <a class='button-light' href='/Login'>
                    LogIn
               </a>
            </div>";
            
            
        // en caso de que el usuario sí esté identificado
        }else{
            $user = Login::user(); // recupera el usuario
            
            // pone el texto "Bienvenido usuario" con un enlace a su home
            $html = "
            <div id='access-bar'>
                <span class='pc'>Bienvenido</span>
                <a class='negrita' href='/User/home' title='Acceder al espacio personal'>
                    $user->displayname
                </a>
                <span class='pc cursiva'>&lt;$user->email&gt;</span>";
                            
                // si el usuario es administrador, le informa de ello
                if($user->isAdmin())
                    $html .= "
                <span class='pc'> eres
                    <a class='negrita' href='/Panel/admin' title='Ir al panel del administrador'>administrador</a>.
                </span>";
                                
                // pone la imagen de perfil y el enlace a logout
                $html .= " 
                <a href='/User/home'>
                <img class='icon'
                    src='".USER_IMAGE_FOLDER."/".($user->picture ?? DEFAULT_USER_IMAGE)."'
                    alt='Imagen de perfil'>
                </a>   
                <a class='button-light' href='/Logout'>LogOut</a>
            </div>";
        }
        return $html; // retorna el código HTML generado
    }
        
        
    /* ****************************************************************************
     * HEADER
     *****************************************************************************/
    
    /**
     * Genera el HTML con el header principal de la página.
     * 
     * @param string $title título a mostrar, por defecto será el nombre de la aplicación.
     * @param string $subtitle subtítulo a mostrar.
     * 
     * @return string HTML con el header principal de la página.
     */
    public function header(
        ?string $title    = null, 
        ?string $subtitle = null
    ){ 
        return "
            <header id='main-header'>
                <div class='flex-container gap1'>
                    <figure class='flex1 perfect-centered'>
                        <a href='/'>
                            <img alt='FastLight Logo' src='/images/template/fastlight_base.png'>
                        </a>
                    </figure>
                    <hgroup class='flex7'>
                	    <h1>".($title ?? APP_NAME)."</h1>
                        ".($subtitle ? "<p>".$subtitle."</p>" : "")."
                    </hgroup>
                </div>
            </header>
        ";
    }
    
       
        
    /* ****************************************************************************
     * MENÚ
     *****************************************************************************/
    
     /**
     * Genera el HTML con el menú principal de la página.
     * 
     * @return string HTML del menú principal de la página.
     */
    public function menu(){ 
        
        // script para el botón de la hamburguesa
        $html = "<script src='/js/components/burguerMenu.js'></script>";
        
        // menú
        $html .= "<nav id='main-menu'>\n";
        
        // botón de la hamburguesa
        $html .= "\t<button class='button' id='burger' aria-label='Abrir menú'>
                  <span></span>
                  <span></span>
                  <span></span>
                 </button>";
        
        $html .= "\t<menu class='menu flex1'>\n";
        
       
        
        $html .= "\t\t<li><a href='/'>Inicio</a></li>\n";
        
        // Enlace a los ejemplos de maquetación.
        // Lo eliminaremos en producción junto con la carpeta mvc/views/examples y el ExampleController
        $html .= "\t\t<li><a href='/Example'>Ejemplos de maquetación</a></li>\n";
           
        // Panel del administrador
        if(Login::oneRole(ADMIN_PANEL_ROLES))
            $html .= "\t\t<li><a href='/Panel/admin'>Panel del administrador</a></li>\n";
                
        // Enlace al repositorio de FastLight en GitHub  
        // Lo podéis eliminar, para que no aparezca en vuestras aplicaciones
        $html .=   "\t\t<li><a href='https://github.com/robertsallent/fastlight'>GitHub</a></li>\n";
            
        $html .= "\t</menu>\n";
        $html .= "</nav>\n";
        
        return $html;
    } 
        
    

    /* ****************************************************************************
     * ACEPTAR COOKIES
     *****************************************************************************/
    
    /**
     * Genera el HTML para el modal de "aceptar cookies".
     *
     * @return string HTML con el modal de "aceptar cookies".
     */
    public function acceptCookies(){
        return ACCEPT_COOKIES && !HttpCookie::get(ACCEPT_COOKIES_NAME) ?
            "<div class='modal w50'>
            	<form method='POST' class='centered-block' id='accept-cookies' action='/Cookie/accept'>
            		<h2>Aceptar cookies</h2>
            		".paragraph(ACCEPT_COOKIES_MESSAGE)."
            		<div class='centered'>
                        <input type='submit' class='button' name='accept' value='Aceptar'>
                    </div>
        		</form>
            </div>"  		    
	    : '';
    }
    
    
    
    
    /* ****************************************************************************
     * MIGAS
     *****************************************************************************/
    
    /**
     * Genera el HTML del elemento migas, que construye a partir de un array asociativo.
     * 
     * @param array $migas array asociativo con las entradas que deben aparecer en el migas.
     * 
     * @return string HTML del elemento migas.
     */
    public function breadCrumbs(
        array $migas = []
    ):string{
       
        $migas = ["Inicio"=>"/"] + $migas; // coloca el enlace a "inicio"
        
        // prepara el migas a partir del array 
        $html = "<nav aria-label='breadcrumb' class='breadcrumbs'>\n";
        $html .= "\t<span class='mini pc'>Te encuentras en: </span>\n";
        $html .= "\t<ul>\n";
        
        foreach($migas as $miga => $ruta){
            $html .= "\t\t<li>";
            $html .= $ruta ? "<a href='$ruta'>$miga</a>" : $miga;
            $html .= "</li>\n"; 
        }
        
        $html .= "\t</ul>\n";
        $html .= "</nav>\n";
        
        return $html;
    } 
    
    
      
          
    /* ****************************************************************************
     * MENSAJES FLASHEADOS DE ÉXITO Y ERROR
     *****************************************************************************/
    
    
    /**
     * Retorna el HTML para los mensajes de éxito flasheados en sesión.
     * 
     * @return string HTML con el mensaje de éxito.
     */
    public function successMessage(){
        
        return ($mensaje = Session::getFlash('success')) ?
            "<div class='modal' onclick='this.remove()'>
            	<div class='message success'>
            		<h2>Operación realizada con éxito</h2>
            		<p>$mensaje</p>
            		<p class='mini cursiva'>-- Clic para cerrar --</p>
        		</div>
            </div>"
            : '';  
    } 

    
    /**
     * Retorna el HTML para los mensajes de warning flasheados en sesión.
     *
     * @return string HTML con el mensaje de warning.
     */
    public function warningMessage(){
            
        return ($mensaje = Session::getFlash('warning')) ?
            "<div class='modal' onclick='this.remove()'>
            	<div class='message warning'>
            		<h2>Hay advertencias:</h2>
            		<p>$mensaje</p>
            		<p class='mini cursiva'>-- Clic para cerrar --</p>
        		</div>
            </div>"
            : '';
    }
                
    
    
    /**
     * Retorna el HTML para los mensajes de error flasheados en sesión.
     *
     * @return string HTML con el mensaje de error.
     */
    public function errorMessage(){

        return ($mensaje = Session::getFlash('error')) ?
            "<div class='modal' onclick='this.remove()'>
            	<div class='message danger'>
            		<h2>Se ha producido un error</h2>
            		<p>$mensaje</p>
            		<p class='mini cursiva'>-- Clic para cerrar --</p>
        		</div>
            </div>"
            : '';
    } 
	
        
    /**
     * Retorna el HTML para los mensajes de éxito, advertencia y error flasheados en sesión.
     *
     * @return string HTML con mensajes de éxito, advertencia y/o error.
     */
    public function messages(){
        return $this->successMessage().$this->warningMessage().$this->errorMessage();
    }
        
    
    
    /* ****************************************************************************
     * FILTROS DE BÚSQUEDA
     *****************************************************************************/
    
    /**
     * Retorna el HTML para los formularios de filtrado de resultados.
     * 
     * @param array $fields lista de campos para el desplegable con el campo de búsqueda.
     * @param array $orders lista de campos para el desplegable con el orden de los resultados.
     * @param string $selectedField campo seleccionado por defecto en el desplegable con los campos de búsqueda.
     * @param string $selectedOrder campo seleccionado por defecto en el desplegable con los campos de ordenación.
     * @param string $action URL donde se enviará el formulario de búsqueda.
     * 
     * @return string HTML con el formulario de búsqueda.
     */
    public function filterForm(
        array $fields         = [],
        array $orders         = [],
        string $selectedField = '',
        string $selectedOrder = '',
        ? string $action      = NULL, 
    ){
        
        $html = "<search>";
        $html .= "<form method='POST' id='filtro' class='derecha' action='".($action ?? URL::get())."'>";
       
        $html .= "<label>Buscar</label>";
        $html .= "<input type='search' name='texto' placeholder='texto'> ";
        
        $html .= "<label>en</label>";
        $html .= "<select name='campo'>";
        
        foreach($fields as $nombre=>$valor){
            $html .= "<option value='$valor' ";
            $html .= $selectedField == $nombre ? 'selected' : '';
            $html .= ">$nombre</option>";
        }
        
        $html .= "</select>";
        
        $html .= "<label>ordenado por</label>";
        $html .= "<select name='campoOrden'>";
        
        foreach($orders as $nombre=>$valor){
            $html .= "<option value='$valor' ";
            $html .= $selectedOrder == $nombre ? 'selected' : '';
            $html .= ">$nombre</option>";
        }
        
        return $html."</select>
                    <label>sentido</label>
    				<select name='sentidoOrden'>
                        <option value='ASC'>Ascendente</option>
    				    <option value='DESC'>Descendente</option>
                    </select>
    				<input id='filterFormButton' class='button-light' type='submit' name='filtrar' value='Filtrar'>
    			</form>
            </search>";
    }
    
    
    
    
    /**
     * Genera el HTML con el formulario para quitar un filtro de búsqueda.
     * 
     * @param Filter $filtro objeto Filter con el filtro aplicado.
     * @param string $action URL a la que se debe enviar el formulario. Normalmente será a la misma operación de listado en la que nos encontramos.
     * 
     * @return string
     */
    public function removeFilterForm(
        Filter $filter,
        ?string $action = NULL
    ){
        
        return "<form id='filtro' class='derecha' method='POST' action='".($action ?? URL::get())."'>
					<label class='long'>$filter</label>
					<input id='filterFormButton' class='button-light' style='display:inline' type='submit' 
					       name='quitarFiltro' value='Quitar filtro'>
				</form>";
    }
    
    
    /**
     * Crea el formulario para exportar resultados a distintos formatos. En el controlador
     * debe existir el método para permitir la exportación
     * 
     * @param string $url
     * @return string
     */
    public function exportForm(string $url):string{
        return "<section class='pc'>
                    <h2>Exportación de datos</h2>
                    <p class='info'>Puedes exportar todos los datos a <i>JSON, XML, CSV, CSV-Excel</i> o texto.</p>
                    <form class='p1 m0 no-border no-shadow' method='POST' action='$url'>
                        <span>En formato</span>
                        <select name='format'>
                            <option value='JSON'>JSON</option>
                            <option value='XML'>XML</option>
                            <option value='CSV'>CSV</option>
                            <option value='CSV-Excel'>CSV para Excel</option>
                            <option value='TEXT'>Texto</option>
                        </select>
                        
                        <input type='checkbox' name='download' value='1' id='chk-download'>
                        <label for='chk-download'>Descargar</label>
                        
                        <input type='submit' class='button' value='Exportar'>
                    </form> 
                </section>";
     }
    
 
    /* ****************************************************************************
     * FOOTER
     *****************************************************************************/
    
    
    /**
     * Genera el HTML con el footer principal de la página.
     * 
     * @return string HTML con el footer.
     */
    public function footer(){
        return "
        <footer class='page-footer flex-container left drop-shadow'>
            
            <div class='flex4 p2'>
                <p><a class='negrita maxi cursiva' href='https://github.com/robertsallent/fastlight'>FastLight Framework</a></p>
                <p>
                    Desarrollado por <a href='https://robertsallent.com'>
                    Robert Sallent</a> para sus cursos de desarrollo de aplicaciones web (2022/2025).
                </p>
            </div>

            <div class='flex1 p1 m1 mt3 right'>
                <figure class='p1 centrada drop-shadow'>
                    <a href='https://robertsallent.com' rel='author'>
                        <img class='w100' src='/images/template/logo.png' alt='Robert Sallent'>
                    </a>
                </figure>
                <figure class='p1 centrada drop-shadow'>
                    <a href='https://www.linkedin.com/in/robert-sallent-l%C3%B3pez-4187a866'>
                        <img class='w100' src='/images/template/linkedin.png' alt='LinkedIn'>
                    </a>
                </figure>
                <figure class='p1 centrada drop-shadow'>
                    <a href='https://github.com/robertsallent'>
                        <img class='w100' src='/images/template/github.png' alt='GitHub'>
                    </a>
                </figure>
            </div>
            
        </footer>";
    }  
    
    
    /**
     * muestra la versión del framework usada
     * 
     * @return string
     */
    public function version(){
        $text = '';
        
        if(SHOW_VERSION){
            $text .= "<p id='version' class='right m1 italic mini'>";
            $text .= APP_NAME.",  versión ".APP_VERSION;
            $text .="</p>";
        }

        return $text;
    }
}

