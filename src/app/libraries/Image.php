<?php

/**
 * Clase Image, para realizar operaciones con imágenes mediante la extensión GD
 * 
 * @author Robert Sallent 
 * 
 * @since v2.0.5 nuevo método scaleAndCrop() que escala y recorta una imagen a la resolución deseada, desde el centro y manteniendo la proporción
 *
 */
class Image{

   
/**
 * Escala y recorta una imagen a un tamaño dado
 * 
 * Ejemplo de uso: genera un thumbnail de 300x300 recortado al centro
 * Image::scaleAndCrop("foto.jpg", "thumb.jpg", 300, 300); 
 * 
 * @param string $rutaOrigen rutal del fichero original
 * @param int $anchoFinal ancho final de la imagen
 * @param int $altoFinal alto final de la imagen
 * @param ?string $rutaDestino ruta final del fichero o NULL para sobreescribir el fichero en $rutaOrigen
 *  
 * @return boolean
 */
    public static function scaleAndCrop(
        string $rutaOrigen, 
        int $anchoFinal, 
        int $altoFinal,
        ? string $rutaDestino = null
    ){
        // Obtener dimensiones originales
        $tmp = getimagesize($rutaOrigen);
        
        // por si no se pudieron obtener
        if(!$tmp)
            return false;
        
        list($ancho, $alto, $tipo) = $tmp;
        
        // crea la nueva imagen en función del tipo
        switch ($tipo) {
            case IMAGETYPE_JPEG: $imagenOriginal = imagecreatefromjpeg($rutaOrigen);
                break;
            case IMAGETYPE_PNG:  $imagenOriginal = imagecreatefrompng($rutaOrigen);
                break;
            case IMAGETYPE_GIF:  $imagenOriginal = imagecreatefromgif($rutaOrigen);
                break;
            default:
                return false; // Tipo no soportado
        }
        
        // Calcular proporciones
        $ratioOriginal = $ancho / $alto;
        $ratioFinal = $anchoFinal / $altoFinal;
        
        if ($ratioFinal > $ratioOriginal) {
            // La imagen es más "alta", escalamos por ancho
            $nuevoAncho = $anchoFinal;
            $nuevoAlto = $anchoFinal / $ratioOriginal;
        } else {
            // La imagen es más "ancha", escalamos por alto
            $nuevoAlto = $altoFinal;
            $nuevoAncho = $altoFinal * $ratioOriginal;
        }
        
        settype($nuevoAlto, 'int');
        settype($nuevoAncho, 'int');
        
        // Escalar primero
        $imagenEscalada = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        
        // Mantener transparencia para PNG/GIF
        if ($tipo == IMAGETYPE_PNG || $tipo == IMAGETYPE_GIF) {
            imagecolortransparent($imagenEscalada, imagecolorallocatealpha($imagenEscalada, 0, 0, 0, 127));
            imagealphablending($imagenEscalada, false);
            imagesavealpha($imagenEscalada, true);
        }
        
        imagecopyresampled($imagenEscalada, $imagenOriginal, 0, 0, 0, 0,
            $nuevoAncho, $nuevoAlto, $ancho, $alto);
        
        // Ahora recortamos centrado
        $x = ($nuevoAncho - $anchoFinal) / 2;
        $y = ($nuevoAlto - $altoFinal) / 2;
        
        $imagenFinal = imagecreatetruecolor($anchoFinal, $altoFinal);
        
        if ($tipo == IMAGETYPE_PNG || $tipo == IMAGETYPE_GIF) {
            imagecolortransparent($imagenFinal, imagecolorallocatealpha($imagenFinal, 0, 0, 0, 127));
            imagealphablending($imagenFinal, false);
            imagesavealpha($imagenFinal, true);
        }
        
        imagecopy($imagenFinal, $imagenEscalada, 0, 0, $x, $y, $anchoFinal, $altoFinal);
        
        // Guardar según formato
        switch ($tipo) {
            case IMAGETYPE_JPEG:
                imagejpeg($imagenFinal, $rutaDestino ?? $rutaOrigen, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($imagenFinal, $rutaDestino ?? $rutaOrigen);
                break;
            case IMAGETYPE_GIF:
                imagegif($imagenFinal, $rutaDestino ?? $rutaOrigen);
                break;
        }
        
        // Liberar memoria
        imagedestroy($imagenOriginal);
        imagedestroy($imagenEscalada);
        imagedestroy($imagenFinal);
        
        return true;
    }


}