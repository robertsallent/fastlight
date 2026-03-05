<?php

/** NotIdentifiedException
 *
 * Para distinguir las excepciones de usuario no identificado.
 *
 * Útil para derivar al usuario a la vista de login cuando intenta realizar una
 * operación que requiere estar identificado.
 *
 * Última revisión: 19/01/2026
 *
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class NotIdentifiedException extends FastLightException{
    
    /** @var string url para la redirección tras identificación  */
    protected ?string $url;
    
    /**
     * Constructor
     *
     * @param ?string $url url para la redirección tras la identificación (opcional, por defecto la operación que se estaba intentando hacer)
     * @param string $message mensaje del error
     * @param int $code código del error
     * @param Throwable $previous
     * @param string $type tipo original del error producido
     */
    public function __construct(
        ?string $url            = null,
        string $message         = "No identificado",
        int $code               = 0,
        ?Throwable $previous    = null,
        string $type            = null
        ){
            parent::__construct($message, $code, $previous, $type);
            $this->url = $url;
    }
    
    
    /**
     * Getter para la propiedad url
     *
     * @return string|NULL
     */
    public function getUrl(): ?string{
        return $this->url;
    }
}

