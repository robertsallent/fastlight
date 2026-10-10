<?php

/**
 * Clase UploadedImage, para realizar operaciones con imágenes subidas
 * 
 * Última modificación: 21/09/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.3.1
 * 
 * @since v2.14.0 nuevo método rotate() que permite girar la imagen 90 grados a derecha o izquierda
 *
 */
class UploadedImage extends UploadedFile{

   
    /**
     * Escala la imagen a un tamaño máximo dado.
     *
     * Si el ratio es NULL, mantiene la relación de aspecto original.
     *
     * @param int $maxValue Tamaño máximo del lado más largo.
     * @param ?float $ratio Relación de aspecto deseada (ej: 4/3). NULL para mantener la proporción original.
     * @param bool $respectAspect Si es true, adapta el ratio a la orientación de la imagen.
     *
     * @return UploadedImage
     */
    public function scale(
        int $maxValue           = 1024,
        ?float $ratio           = null,
        bool $respectAspect     = true
    ):UploadedImage{

        // Obtener tamaño de la imagen original.
        [$width, $height] = getimagesize($this->tmp);

        // Si no se indica ratio, utilizar el original.
        if($ratio === null)
            $ratio = $width / $height;

        // Si la imagen es vertical y el ratio es horizontal,
        // invertimos el ratio para adaptarlo a su orientación.
        if($respectAspect && $height > $width && $ratio > 1)
            $ratio = 1 / $ratio;

        // Calcular las dimensiones finales.
        if($ratio >= 1){

            // Imagen horizontal o cuadrada.
            $anchoFinal = $maxValue;
            $altoFinal  = (int) round($maxValue / $ratio);

        }else{

            // Imagen vertical.
            $altoFinal  = $maxValue;
            $anchoFinal = (int) round($maxValue * $ratio);
        }

        // Escalar y recortar.
        Image::scaleAndCrop(
            $this->tmp,
            $anchoFinal,
            $altoFinal
        );

        return $this;
    }
    
    
    /**
     * Rota la imagen 90 grados a izquierda o derecha.
     *
     * @param string $direction Dirección del giro: 'left' o 'right'
     *
     * @return UploadedImage
     */
    public function rotate(string $direction = 'right'): UploadedImage
    {
        $direction = strtolower($direction);
        
        if (!in_array($direction, ['left', 'right'], true))
            throw new InvalidArgumentException("La dirección debe ser 'left' o 'right'.");
            
            $degrees = $direction === 'left' ? 90 : -90;
            
            Image::rotate($this->tmp, $degrees);
            
            return $this;
    }
    
}