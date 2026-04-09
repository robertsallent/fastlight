<?php

/** middleware.php
 *
 * Configuración de los middlewares
 *
 * Última actualización: 31/03/2026
 *
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.6.1
 * /
 
 /* -------------------------------------------------------------
 * LISTADO DE MIDDLEWARES A APLICAR
 * -------------------------------------------------------------*/

/**
 * Listado de middlewares a aplicar a la Request  antes de pasar la petición a los controladores.
 * Se pueden comentar o descomentar las líneas para activar o desactivar middlewares.
 * Podemos añadir nuevos middlewares personalizados a la carpeta app/middleware
 *
 * El orden importa, se ejecutan en orden del primero al último
 */
define('MIDDLEWARES', [
    'Mantenimiento'             => Maintenance::class,
    'Usuarios bloqueados'       => BlockedUser::class,
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


/* -------------------------------------------------------------
 * USUARIOS BLOQUEADOS
 * -------------------------------------------------------------*/

// nombre del rol para el usuario bloqueado
define('ROLE_BLOCKED', 'ROLE_BLOCKED');

// redirección para los usuarios bloqueados
// debería ser a '/Contacto' una vez implementado el formulario de contacto (lo haremos en clase)
define('BLOCKED_REDIRECT', '/');

// mensaje que se mostrará al usuario bloqueado cuando intenta hacer Login
define('BLOCKED_MESSAGE', "Has sido bloqueado por un administrador,
                           si consideras que es un error puedes contactar
                           mediante el formulario de contacto.");






