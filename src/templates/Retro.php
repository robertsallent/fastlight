<?php

/** RETRO TEMPLATE
 *
 * Template que hereda del template base y que modifica los CSS y alguno
 * de los métodos existentes en la clase padre.
 *
 * Última revisión: 25/07/2024
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 *
 */


class Retro extends Base{
    
    // ficheros CSS para usar con este template
    protected array $css = [
        'standard'  => '/css/retro.css',
        'tablet'    => '/css/base_tablet.css',
        'phone'     => '/css/base_phone.css',
        'printer'   => '/css/base_printer.css'
    ];
    
    
    // retorna el header
    public function header(
        ?string $title = NULL,
        ?string $subtitle = NULL
    ){         
        return "
            <header class='primary flex-container gap2'>
                <hgroup class='flex6'>
            	  <h1>$title <span class='small'>en ".APP_NAME."</span></h1>
                  <p>".($subtitle ?? '')."</p>
                </hgroup>  
                <figure class='flex1 derecha p2'>
                    <a href='/'>
                        <img style='width:100%;' src='/images/template/fastlight_retro.png'>
                    </a>
                </figure>
            </header>";
    }
}

