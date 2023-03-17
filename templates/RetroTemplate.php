<?php


class RetroTemplate extends Template{
    
    // ficheros CSS para usar con este template
    protected static array $css = ['/css/retro.css'];
    
    // retorna el header
    public static function getHeader(string $titulo=''){ 
        $name = APP_NAME;
        
        return <<<EOT
            <header class='primary flex-container'>
                <hgroup class='flex4'>
            	  <h1>$titulo en $name</h1>
                </hgroup>  
                <figure class='flex1 derecha'>
                    <a href='/'>
                        <img style='width:100%;' src='/images/template/logo.png'>
                    </a>
                </figure>
            </header>
EOT;}
}

