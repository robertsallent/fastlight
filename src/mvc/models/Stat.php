<?php

/** 
 * Clase Stat.
 *
 * Modelo responsable de guardar las estadísticas de visitas a las URLs.
 *
 * @author: Robert Sallent <robert@juegayestudia.com>
 * 
 * Última revisión: 15/09/2025
 * 
 * @since v1.4.1
 * @since v2.0.5 el método saveOrIncrement() puede recibir el parámetro adicional $queryString
 */


class Stat extends Model{
    
    /** @var string $table nombre de la tabla en la base de datos */ 
    protected static string $table = STATS_TABLE;
    
    /**
     * Comprueba si la estadística de visitas existe para la URL indicada
     * 
     * @param string $url la URL a comprobar
     * @param bool $queryString false para no distinguir URLs a un mismo sitio pero con parámetros adicionales distintos
     * @return bool true si ya está guardada esa estadística en la tabla
     */
    private static function statExists(
        string $url
    ):bool{ 
        // retorna true si la URL ya está en la BDD
        return count(self::whereExactMatch(['url' => $url])) > 0;       
    }
    
    
    /**
     * Permite crear un nuevo objeto Stat y guardarlo en base de datos.
     * 
     * @param string $url    url de la estadística
     * @param bool $queryString false para no distinguir URLs a un mismo sitio pero con parámetros adicionales distintos
     * @return int número de visitas a la URL (1)
     */
    private static function add(
        string $url
    ):int{
        // crea una nueva estadística
        $stat           = new self();
        
        // toma los datos
        $stat->url      = $url; 
        $stat->ip       = request()->ip;
        $stat->user     = user() ? user()->email : NULL;
                
        // guarda los datos en la bdd
        return $stat->save() ? 1 : 0;
    }    
    
    
    /**
     * Incrementa el contador de visitas para una determinada URL
     * 
     * @param string $url URL cuyo contador hay que incrementar
     * @return int número de visitas de la URL indicada
     */
    private static function increment(string $url):int{
        // recupera la estadística para esa URL
        $stat = self::whereExactMatch(['url' => $url])[0];
                
        // modifica los datos de visitas y el último usuario
        $stat->count++; 
        $stat->user = user() ? user()->email : NULL;
        
        $stat->update();    // actualiza el dato en la BDD
        
        return $stat->count;
    }
    
    
    /**
     * Guarda una nueva estadística o incrementa el número de visitas en 1.
     * Se usa desde el constructor de Controller y la URL se obtiene mediante
     * el objeto Request.
     * 
     * @param string $url
     * @param bool $queryString false para no distinguir URLs a un mismo sitio pero con parámetros adicionales distintos
     * @param bool $index false para no distinguir las URLs que acaben en index.php de las que acaben en / (las que acaban en index.php darán un error, excepto en la raíz /index.php)
     * @param bool $finalBar false para quitar la / al final de la URL
     * @return int número de visitas de la URL indicada
     */
    public static function saveOrIncrement(
        string $url,
        bool $queryString   = false,   // tener en cuenta o no los parámetros adicionales
        bool $index         = false,   // tener en cuenta o no las URLs que acaben en index.php
        bool $finalBar      = false    // quita la / del final
    ):int{
              
        if(!$queryString && str_contains($url, '?')) 
            $url = substr($url, 0, strpos($url, '?'));
        
        if(!$index && str_contains($url, 'index.php'))
            $url = substr($url, 0, strpos($url, 'index.php'));
        
        if(!$finalBar && $url != '/')
            $url = rtrim($url, '/');
               
        return self::statExists($url) ? self::increment($url) : self::add($url);
    }
    
}




