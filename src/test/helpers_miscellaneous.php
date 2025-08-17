<main>
    <h1>Test de varios helpers</h1>
    
    <section id="dump">
        <h2>dump()</h2>
        <p>La función helper <code>dump()</code> <b>muestra la estructura y el contenido de una
        o más variables</b>. Es útil para depurar, por ejemplo si queremos mostrar
        los datos que llegan por <i>COOKIE</i>, podemos hacer: 
        <code>dump(request()->cookies());</code></p>
        
        <?php dump(request()->cookies()) ?>
    </section>
    
    <section id="dd">
        <h2>dd()</h2>
        <p>La función helper <code>dd()</code> <b>muestra la estructura y el contenido de una
        variable y finaliza la ejecución</b>. 
        Es útil para depurar, por ejemplo si queremos mostrar
        los datos que llegan por GET y finalizar la ejecución, podemos hacer: 
        <code>dd(request()->gets(), 'Se detuvo la ejecución');</code></p>
        
        <?php //dd(request()->gets(), 'Se detuvo la ejecución') ?>
    </section>
    
    
    <section id="request">
        <h2>request()</h2>
        <p>Retorna el objeto <b>Request para la petición actual</b>, que llegó desde el cliente.</p>
        
        <?php dump(request()) ?>
    </section>
    
    
    <section id="user">
        <h2>user()</h2>
        <p>Retorna el <b>usuario identificado</b>.</p>
        <?php dump(user()) ?>
    </section>
</main>