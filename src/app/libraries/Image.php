<?php

/**
 * Clase Image, para realizar operaciones con imágenes mediante la extensión GD
 * 
 * @author Robert Sallent 
 * 
 * @since v2.0.5 nuevo método scaleAndCrop() que escala y recorta una imagen a la resolución deseada, desde el centro y manteniendo la proporción
 * @since v2.14.0 nuevo método rotate() que permite rotar una imagen un número determinado de grados.
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
        
        imagecopy($imagenFinal, $imagenEscalada, 0, 0, (int) $x, (int) $y, $anchoFinal, $altoFinal);
        
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
    
    
    /**
     * Rota una imagen el número de grados indicado.
     *
     * Los valores positivos rotan en sentido antihorario
     * y los negativos en sentido horario.
     *
     * @param string $file ruta del fichero
     * @param float $degrees grados de rotación
     *
     * @return void
     */
    public static function rotate(string $file, float $degrees): void{
        
        // recupera el tipo MIME real del fichero
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime  = $finfo->file($file);
        
        // carga la imagen
        $image = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($file),
            'image/png'  => imagecreatefrompng($file),
            'image/gif'  => imagecreatefromgif($file),
            'image/webp' => imagecreatefromwebp($file),
            default => throw new FileException("Formato de imagen '$mime' no soportado.")
        };
        
        // rota la imagen
        $rotated = imagerotate($image, $degrees, 0);
        
        if ($rotated === false) {
            imagedestroy($image);
            throw new FileException("No se pudo rotar la imagen.");
        }
        
        // guarda la imagen
        match ($mime) {
            'image/jpeg' => imagejpeg($rotated, $file, 90),
            'image/png'  => imagepng($rotated, $file),
            'image/gif'  => imagegif($rotated, $file),
            'image/webp' => imagewebp($rotated, $file, 90),
        };
        
        // libera memoria
        imagedestroy($image);
        imagedestroy($rotated);
    }


}