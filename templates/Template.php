<?php

class Template{
    
    
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
                    <span>Bienvenido <a href='/User/home'>$user->displayname</a> 
                    ($user->email), eres <b>administrador</b>.</span> 
                    <a class='button' href='/Logout'>LogOut</a>
                 </div>
EOT;  
        
        // si el usuario no es administrador...
        if(Login::check())
            return <<<EOT
                 <div class='derecha'>
                    <span>Bienvenido <a href='/User/home'>$user->displayname</a>
                    ($user->email).</span> 
                    <a class='button' href='/Logout'>LogOut</a>
                 </div>
EOT;    
    
    }
        
        
    
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
    
        
        
    // retorna el menú principal
    public static function getMenu(){ 
        return <<<EOT
            <ul class='navBar'>
            	<li><a href="/">Inicio</a></li>
                <li><a href="/">Foo</a></li>
                <li><a href="/">Bar</a></li>
            </ul>
EOT;} 
        
        
        
    // retorna el footer
    public static function getFooter(){
        return <<<EOT
        <footer class='primary'>
            <p>Desarrollado por <a href="https://robertsallent.com">
                Robert Sallent</a> para los cursos de desarrollo de aplicaciones web.
            </p>
        </footer>
EOT;} 
}