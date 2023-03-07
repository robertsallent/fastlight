<?php

class Template{
    
    
    // retorna los enlaces a login/logout
    public static function getLogin(){
        
        if(Login::guest())
            return <<<EOT
               <div class='derecha'>
                    <a class='button' href='/Login'>LogIn</a>
               </div>
EOT;
        
        $user = Login::user();
            
        if(Login::isAdmin())
            return <<<EOT
                 <div class='derecha'>
                    <span>Bienvenido <a href='/User/home'>$user->displayname</a> 
                    ($user->email), eres <b>administrador</b>.</span> 
                    <a class='button' href='/Logout'>LogOut</a>
                 </div>
EOT;  
            
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
            <header>
            	<h1>$titulo en $name</h1>
            </header>
EOT;}
    
        
        
    // retorna el menú principal
    public static function getMenu(){ 
        return <<<EOT
            <ul>
            	<li><a href="/">Inicio</a></li>
            </ul>
EOT;} 
        
        
        
    // retorna el footer
    public static function getFooter(){
        return <<<EOT
        <p>Desarrollado por <a href="https://robertsallent.com">
            Robert Sallent</a> para los cursos de desarrollo de aplicaciones web.
        </p>
EOT;} 
}