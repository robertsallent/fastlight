<main>
    <h1>Test de los helpers para trabajar con strings</h1>
    
    <section>
        <h2>Test del helper <code>arrayToString()</code></h2>
        <p>El helper arrayToString() convierte arrays a cadenas de texto.</p>
        
        <p>Sus parámetros adicionales permiten indicar si queremos mostrar los corchetes 
        o no y si queremos mostrar las claves o no.</p>
        <?php 
            $lista = ['patata', 'queso', 'pimiento', 'lechuga'];
            
            echo "<p><b>El array pasado a string:</b> " .arrayToString($lista)."</p>";
            echo "<p><b>Sin corchetes:</b> "            .arrayToString($lista, false)."</p>";
            echo "<p><b>Con corchetes sin claves</b> "  .arrayToString($lista, true, false)."</p>";
            echo "<p><b>Sin corchetes ni claves:</b> "  .arrayToString($lista, false, false)."</p>";
        ?>
    </section>
    
    
    <section>
        <h2>Helper <code>paragraph()</code></h2>
        <p>Convierte un texto con saltos de línea a formato HTML en párrafos.</p>
        <?php 
            $texto = "Este es un texto que contiene saltos de línea.   
                      Se deben mostrar tres párrafos HTML en el resultado.
                      En otro caso no estará funcionando bien.";
            
            echo paragraph($texto);
        ?>
    </section>
</main>