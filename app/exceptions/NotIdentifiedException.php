<?php

/** NotIdentifiedException 
 *
 * Para distinguir las excepciones de usuario no identificado. 
 * 
 * Útil para derivar al usuario a la vista de login cuando intenta realizar una 
 * operación que requiere estar identificado.
 *
 * Última revisión: 23/03/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class NotIdentifiedException extends FastLightException{}
    
    