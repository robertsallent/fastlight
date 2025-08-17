<?php

/** DARK TEMPLATE
 *
 * Template que hereda del template base y que modifica solamente los CSS.
 *
 * Última revisión: 25/07/2024
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 *
 */

class Dark extends Base{
    
    // ficheros CSS para usar con este template
    protected array $css = [
        'standard'  => '/css/dark.css',
        'tablet'    => '/css/base_tablet.css',
        'phone'     => '/css/base_phone.css',
        'printer'   => '/css/base_printer.css'
    ];
    
}

