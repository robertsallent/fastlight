<?php

/* Clase Template
 *
 * Se usa para generar las partes comunes de todas las vistas
 *
 * autor: Robert Sallent
 * última revisión: 16/03/2023
 *
 */

class Template implements TemplateInterface{
    
    // ficheros CSS para usar con este template
    protected static array $css = ['/css/style.css'];
    
    /*****************************************************************************
     * CSS
     *****************************************************************************/
    // método que prepara los links a todos los ficheros CSS configurados arriba
    public static function getCss(){
        $html = "";
        
        foreach(get_called_class()::$css as $file)
            $html .= "<link rel='stylesheet' type='text/css' href='$file'>\n";
            
        return $html;
    }
    
    /*****************************************************************************
     * LOGIN / LOGOUT
     *****************************************************************************/
    // retorna los enlaces a login/logout
    public static function getLogin(){
        
        // si el usuario no está identificado, retorna el botón de LogIn
        if(Login::guest())
            return <<<EOT
               <div class='derecha'>
                    <a class='button' href='/Login'>LogIn</a>
               </div>
EOT;
        
        $user = Login::user(); // recupera el usuario identificado
          
        // si el usuario es administrador...
        if(Login::isAdmin())
            return <<<EOT
                 <div class='derecha'>
                    <span>Bienvenido <a class='negrita' href='/User/home'>$user->displayname</a> 
                    (<span class='cursiva'>$user->email</span>)
                    , eres <a class='negrita' href='/Admin'>administrador</a>.</span> 
                    <a class='button' href='/Logout'>LogOut</a>
                 </div>
EOT;  
        
        // si el usuario no es administrador...
        if(Login::check())
            return <<<EOT
                 <div class='derecha'>
                    <span>Bienvenido <a href='/User/home'>$user->displayname</a>
                    (<span class='cursiva'>$user->email</span>).</span> 
                    <a class='button' href='/Logout'>LogOut</a>
                 </div>
EOT;    
    
    }
        
        
    /*****************************************************************************
     * HEADER
     *****************************************************************************/
    // retorna el header
    public static function getHeader(string $titulo=''){ 
        $name = APP_NAME;
        
        return <<<EOT
            <header class='primary'>
                <figure>
                    <a href='/'>
                        <img style='width:100%;' src='/images/template/logo.png'>
                    </a>
                </figure>
                <hgroup>
            	   <h1>$titulo en $name</h1>
                </hgroup>  
            </header>
EOT;}
    
        
    /*****************************************************************************
     * MENÚ
     *****************************************************************************/
    // retorna el menú principal
    public static function getMenu(){ 
        $html  = "<ul class='navBar'>";
        $html .=   "<li><a href='/'>Inicio</a></li>";
        
        if(Login::isAdmin() && (DB_ERRORS || LOG_ERRORS || LOG_LOGIN_ERRORS))
            $html .=   "<li><a href='/Error/list'>Errores</a></li>";
        
        $html .=   "<li><a href='/'>Foo</a></li>";
        $html .=   "<li><a href='/'>Bar</a></li>";
        $html .= "</ul>";

        return $html;
    } 
        
    /*****************************************************************************
     * MIGAS
     *****************************************************************************/
    // retorna el elementos migas
    public static function getBreadCrumbs(array $migas = []):string{
        // asegura que esté el enlace a Inicio
        $migas = ["Inicio"=>"/"]+$migas; 
        
        // preparamos el migas a partir del array 
        $html = "<nav aria-label='Breadcrumb' class='breadcrumbs'>";
        $html .= "<ul>";
        
        foreach($migas as $miga => $ruta){
            $html .= "<li>";
            $html .= $ruta ? "<a href='$ruta'>$miga</a>" : $miga;
            $html .= "</li>"; 
        }
        
        $html .= "</ul>";
        $html .= "</nav>";
        return $html;
    } 
    
    
        
          
    /*****************************************************************************
     * MENSAJES FLASHEADOS DE ÉXITO Y ERROR
     *****************************************************************************/
    // muestra mensajes de éxito flasheados
    public static function getSuccess(){
        
            return ($mensaje = Session::getFlash('success')) ?
            <<<EOT
            <div class="mensajeExito" onclick="this.remove()">
            	<div>
            		<h2>Operación realizada con éxito</h2>
            		<p>$mensaje</p>
            		<p class="mini cursiva">-- Clic para cerrar --</p>
        		</div>
            </div>
EOT: '';} 

        // muestra mensajes de warning flasheados
        public static function getWarning(){
                
                return ($mensaje = Session::getFlash('warning')) ?
                <<<EOT
            <div class="mensajeWarning" onclick="this.remove()">
            	<div>
            		<h2>Hay advertencias:</h2>
            		<p>$mensaje</p>
            		<p class="mini cursiva">-- Clic para cerrar --</p>
        		</div>
            </div>
EOT: '';}
                
    // muestra mensajes de error flasheados
    public static function getError(){

            return ($mensaje = Session::getFlash('error')) ?
            <<<EOT
            <div class="mensajeError" onclick="this.remove()">
            	<div>
            		<h2>Se ha producido un error</h2>
            		<p>$mensaje</p>
            		<p class="mini cursiva">-- Clic para cerrar --</p>
        		</div>
            </div>
EOT: '';} 
	
    // muestra los mensajes de success, error y warning flasheados
    public static function getFlashes(){
        return self::getSuccess().self::getWarning().self::getError();
    }
        
    
    /*****************************************************************************
     * FILTROS DE BÚSQUEDA
     *****************************************************************************/
    // retorna el formulario para realizar filtros y búsquedas
    public static function filterForm(
        string $action = '/',   // URL donde se enviará el formulario
        array $fields = [],     // lista de campos para el desplegable campo de búsqueda
        array $orders = [],      // lista de campos para el desplegable orden
        string $selectedField = '',
        string $selectedOrder = ''
        
    ){
        $html = "<form method='POST' class='filtro derecha' action='$action'>";
        $html .= "<input type='text' name='texto' placeholder='Buscar...'> ";
        $html .= "<select name='campo'>";
        
        foreach($fields as $nombre=>$valor){
            $html .= "<option value='$valor' ";
            $html .= $selectedField == $nombre ? 'selected' : '';
            $html .= ">$nombre</option>";
        }
        
        $html .= "</select>";
        
        $html .= "<label>Ordenar por:</label>";
        $html .= "<select name='campoOrden'>";
        
        foreach($orders as $nombre=>$valor){
            $html .= "<option value='$valor' ";
            $html .= $selectedOrder == $nombre ? 'selected' : '';
            $html .= ">$nombre</option>";
        }
        
        return $html."</select>
    				<input type='radio' name='sentidoOrden' value='ASC'>
    				<label>Ascendente</label>
    				<input type='radio' name='sentidoOrden' value='DESC' checked>
    				<label>Descendente</label>
    				<input class='button' type='submit' name='filtrar' value='Filtrar'>
    			</form>";
    }
    
    // retorna el formulario de "quitar filtro"
    public static function removeFilterForm(
        Filter $filtro,
        string $action = '/'
    ){
        
        return "<form class='filtro derecha' method='POST' action='$action'>
					<label>$filtro</label>
					<input class='button' style='display:inline' type='submit' 
					       name='quitarFiltro' value='Quitar filtro'>
				</form>";
    }
    
    
    
    /*****************************************************************************
     * FOOTER
     *****************************************************************************/
    // retorna el footer
    public static function getFooter(){
        return <<<EOT
        <footer class='primary'>
            <p>Desarrollado por <a href="https://robertsallent.com">
                Robert Sallent</a> para sus cursos de desarrollo de aplicaciones web (2023).
            </p>
        </footer>
EOT;} 
        
}

