<?php

/**
 * LoginAttempt
 *
 * Representa los intentos fallidos de identificación.
 *
 * @author Robert Sallent <robert@fastlight.org>
 * @since v2.15.0
 * 
 * Última revisión: 10/10/2026
 */

class LoginAttempt extends Model{

    // tabla de la base de datos asociada a este modelo
    protected static string $table = 'login_attempts';


    /**
     * Recupera el registro de intentos correspondiente a un usuario y una IP concretos.
     *
     * @param string $user
     * @param string $ip
     *
     * @return LoginAttempt|null
     */
    public static function attemptsByUserAndIp(
        string $user,
        string $ip
    ):?LoginAttempt{

        // retorna el usuario que coincide con ese usuario e IP, o null si no existe
        return QueryBuilder::select(self::$table, DB::get())
            ->where('user = ?', $user)
            ->where('ip = ?', $ip)
            ->getAndFetch(self::class);
    }



    /**
     * Devuelve el número total de intentos fallidos para una IP (sin tener en cuenta el usuario).
     *
     * Solamente se tienen en cuenta los intentos realizados dentro del
     * intervalo definido por LOGIN_IP_BLOCK_SECONDS.
     *
     * @param string $ip
     *
     * @return int
     */
    public static function attemptsByIp(string $ip): int{

        // calcula la fecha límite para contar los intentos
        $limit = date(
            'Y-m-d H:i:s',
            time() - LOGIN_IP_BLOCK_SECONDS
        );

    
        // realiza la consulta para contar los intentos fallidos desde esa IP en el 
        // intervalo de tiempo definido
        $result = QueryBuilder::select(self::$table, DB::get())
            ->field('SUM(attempts) AS total')
            ->where('ip = ?', $ip)
            ->where('last_attempt >= ?', $limit)
            ->getAndFetch();

        // devuelve el número total de intentos, o 0 si no hay registros
        return (int)($result->total ?? 0);
    }



   /** 
    * Incrementa el número de intentos fallidos y actualiza la fecha del último intento.
    * Si se alcanza el número máximo de intentos, bloquea el registro durante un tiempo
    * determinado.
    *
    * @return void
    */
    public function failed(): void{

        // incrementa el contador de intentos y actualiza la fecha del último intento
        $this->attempts = ($this->attempts ?? 0) + 1;
        $this->last_attempt = date('Y-m-d H:i:s');

        // si se alcanza el número máximo de intentos, bloquea el registro
        if($this->attempts >= LOGIN_MAX_ATTEMPTS)
            $this->blocked_until = date(
                'Y-m-d H:i:s',
                time() + LOGIN_BLOCK_SECONDS
            );

        // guarda los cambios en la base de datos
        $this->update();
    }



    /**
     * Indica si el intento está actualmente bloqueado.
     *
     * @return bool
     */
    public function isBlocked(): bool{

        // está bloqueado si la fecha de bloqueo es posterior a la fecha actual
        return $this->blocked_until && strtotime($this->blocked_until) > time();
    }



    /**
     * Devuelve los segundos restantes de bloqueo por IP y usuario.
     *
     * @return int
     */
    public function remainingBlockTime(): int{

        // si no hay bloqueo, devuelve 0; si lo hay, calcula los segundos restantes
        return !$this->blocked_until ? 0 : max(0, strtotime($this->blocked_until) - time());
    }



    /**
     * Devuelve los segundos restantes del bloqueo global por IP.
     *
     * Se calcula tomando como referencia el último intento realizado
     * desde esa IP y el intervalo LOGIN_IP_BLOCK_SECONDS.
     *
     * @param string $ip
     *
     * @return int
     */
    public static function remainingIpBlockTime(string $ip): int{

        // realiza la consulta para obtener la fecha del último intento desde esa IP
        $result = QueryBuilder::select(self::$table, DB::get())
            ->field('MAX(last_attempt) AS last_attempt')
            ->where('ip = ?', $ip)
            ->getAndFetch();

        // si no hay intentos registrados, devuelve 0
        if(!$result || !$result->last_attempt)
            return 0;

        // calcula los segundos restantes de bloqueo
        $remaining = strtotime($result->last_attempt) + LOGIN_IP_BLOCK_SECONDS - time();

        // devuelve el tiempo restante, o 0 si ya ha pasado
        return max(0, $remaining);
    }



    /**
     * Reinicia el contador de intentos y elimina el bloqueo.
     *
     * @return void
     */
    public function reset(): void{

        // reinicia los intentos y elimina el bloqueo
        $this->attempts = 0;
        $this->blocked_until = null;

        // actualiza el registro en la base de datos
        $this->update();
    }
}