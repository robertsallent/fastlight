<main>

    <h1>Test de la librería CSV</h1>
    
    <section>
        <h2>Probando CSV::encode()</h2>
        
        <h3>Formato genérico</h3>
        <p>Intentando convertir a CSV los usuarios decuperados desde la BDD.
          Para ello podemos hacer <code>CSV::encode(User::all())</code>.</p>
          
        <pre><?= CSV::encode(User::all()) ?></pre>
        
        
        <h3>Formatos personalizados</h3>
        <p>Ahora con puntos y coma y doble salto de línea. Para ello haremos
        <code>CSV::encode(User::all(), ";", "\n\n")</code></p>
        
        <pre><?= CSV::encode(User::all(), ";", "\n\n") ?></pre>
        
    </section>
        
    <section>
        <h2>Probando CSV::decode()</h2>
        
        <p>TODO.</p>   
             
    </section>
        

</main>