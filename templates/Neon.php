<?php

/** NEON TEMPLATE
 *
 * Template que hereda del template base y que modifica solamente los CSS.
 *
 * Última revisión: 25/07/2024
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 *
 */

class Neon extends Base{
    
    // ficheros CSS para usar con este template
    protected array $css = [
        'standard'  => '/css/neon.css',
        'tablet'    => null,
        'phone'     => '/css/phone.css',
        'printer'   => '/css/printer.css'
    ];
    
}

