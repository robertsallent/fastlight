<?php

/**
 * Clase UploadedImage, para realizar operaciones con imágenes subidas
 * 
 * Última modificación: 25/03/2026
 * 
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.3.1
 *
 */
class UploadedImage extends UploadedFile{

   
    /**
     * Escala la imagen a un tamaño máximo dado, manteniendo la proporción original 
     * 
     * @param int $maxValue tamaño máximo del lado más largo de la imagen (ancho o alto)
     * @param float $ratio relación de aspecto deseada (ej: 4/3)
     * @param bool $respectAspect si es true, se ajustará el ratio para que se adapte mejor a la orientación de la imagen (horizontal o vertical)
     * 
     * @return UploadedImage 
     */
    public function scale(        
        int $maxValue           = 1024,
        float $ratio            = 4/3,
        bool $respectAspect     = true
    ):UploadedImage{

        // Obtener tamaño de la imagen original
        [$width, $height] = getimagesize($this->tmp);

        
        if ($respectAspect && $height > $width && $ratio > 1)
            // Si la imagen es vertical y el ratio es horizontal, invertimos el ratio para que se ajuste mejor  
            $ratio = 1 / $ratio;
        

        if ($ratio >= 1) {
            // Imagen horizontal (ej: 4:3, 16:9)
            $anchoFinal = $maxValue;
            $altoFinal  = (int) round($maxValue / $ratio);
        } else {
            // Imagen vertical (ej: 3:4)
            $altoFinal  = $maxValue;
            $anchoFinal = (int) round($maxValue * $ratio);
        }

        Image::scaleAndCrop($this->tmp, $anchoFinal, $altoFinal);
        
        return $this;
    }
}