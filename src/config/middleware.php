<?php

/** middleware.php
 *
 * Configuración de los middlewares
 * 
 * Última actualización: 28/03/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.6.1
 * /

/* -------------------------------------------------------------
 * LISTADO DE MIDDLEWARES A APLICAR
 * -------------------------------------------------------------*/

// Listado de middlewares a aplicar a la Request y filtros antes de pasar la petición a los controladores.
// Se pueden comentar o descomentar los existentes o añadir nuevos a la carpeta app/middleware
// El orden importa, se ejecutan en orden del primero al último
define('MIDDLEWARES', [
    'Mantenimiento' => Maintenance::class,
]);


/* -------------------------------------------------------------
 * MODO MANTENIMIENTO
 * -------------------------------------------------------------*/

// Activa o desactiva el modo mantenimiento (app/middleware/Maintenance.php)
define('MAINTENANCE_MODE', false);

// Password para saltarse el modo mantenimiento y poder ver el resultado durante la sesión.
// Se usa el parámetro passkey vía GET:
//  EJEMPLO: https://fastlight.org/Example/modal?passkey=1234
define('MAINTENANCE_PASSKEY', '1234');


