<?php

/** 
 * Clase Stat.
 *
 * Modelo responsable de guardar las estadísticas de visitas a las URLs.
 *
 * @author: Robert Sallent <robert@juegayestudia.com>
 * 
 * Última revisión: 03/02/2025
 * 
 * @since v1.4.1
 */


class Stat extends Model{
    
    /** @var string $table nombre de la tabla en la base de datos */ 
    protected static string $table = STATS_TABLE;
    
    
    /**
     * Comprueba si la estadística de visitas existe para la URL indicada
     * 
     * @param string $url la URL a comprobar
     * @return bool true si ya está guardada esa estadística en la tabla
     */
    private static function statExists(string $url):bool{ 
        return count(self::whereExactMatch(['url' => $url])) > 0;       
    }
    
    
    /**
     * Permite crear un nuevo objeto Stat y guardarlo en base de datos.
     * 
     * @param string $url    url de la estadística
     * @return int número de visitas a la URL (1)
     */
    private static function add(string $url):int{
        $stat           = new self();
        $request        = request();
        
        $stat->url      = $url; 
        $stat->ip       = $request->ip;
        $stat->user     = $request->user ? $request->user->email : NULL;
        
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
                
        $stat->count++;     // incrementa el contador
        $stat->update();    // actualiza el dato en la BDD
        
        return $stat->count;
    }
    
    
    /**
     * Guarda una nueva estadística o incrementa el número de visitas en 1.
     * Se usa desde el constructor de Controller y la URL se obtiene mediante
     * el objeto Request.
     * 
     * @param string $url
     * @return int número de visitas de la URL indicada
     */
    public static function saveOrIncrement(string $url):int{
        return self::statExists($url) ? self::increment($url) : self::add($url);
    }
    
}




