<?php


class Retro extends Template{
    
    // ficheros CSS para usar con este template
    protected static array $css = ['/css/retro.css'];
    
    // retorna el header
    public static function getHeader(
        string $titulo = '',
        string $subtitulo = NULL
    ){         
        return "
            <header class='primary flex-container'>
                <hgroup class='flex4'>
            	  <h1>$titulo en ".APP_NAME."</h1>
                </hgroup>  
                <figure class='flex1 derecha'>
                    <a href='/'>
                        <img style='width:100%;' src='/images/template/fastlight_bw.png'>
                    </a>
                </figure>
            </header>";
    }
}

