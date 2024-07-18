<?php


class Retro extends Base{
    
    // ficheros CSS para usar con este template
    protected array $css = ['/css/retro.css'];
    
    // retorna el header
    public function header(
        ?string $title = NULL,
        ?string $subtitle = NULL
    ){         
        return "
            <header class='primary flex-container'>
                <hgroup class='flex4'>
            	  <h1>$title <span class='small'>en ".APP_NAME."</span></h1>
                  <p>".($subtitle ?? '')."</p>
                </hgroup>  
                <figure class='flex1 derecha'>
                    <a href='/'>
                        <img style='width:100%;' src='/images/template/fastlight_retro.png'>
                    </a>
                </figure>
            </header>";
    }
}

