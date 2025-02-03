<main>
    <h1>Test de los helpers para trabajar con strings</h1>
    
    <section id="arrayToString">
        <h2>arrayToString()</h2>
        <p>El helper arrayToString() convierte arrays a cadenas de texto.</p>
        
        <p>Recibe hasta cinco parámetros, solamente el primero es obligatorio:</p>
        <ul>
        	<li><i>array <b>list</b></i>: el array a convertir.</li>
        	<li><i>bool <b>brackets</b></i>: true si queremos que aparezcan corchetes en los extremos del string resultante.</li>
        	<li><i>bool <b>associative</b></i>: true si queremos mostrar los pares de clave => valor, false para mostrar solamente los valores.</li>
        	<li><i>string <b>separator</b></i>: separador entre valores.</li>
        	<li><i>string <b>keyValueSeparator</b></i>: separador en los pares de clave => valor.</li>
        </ul>
        
        <h3>Con un array indexado</h3>
        
        <code>$lista = ['patata', 'queso', 'pimiento', 'lechuga'];</code>
        <?php 
            $lista = ['patata', 'queso', 'pimiento', 'lechuga'];
            
            echo "<p>El array pasado a string:<b> " .arrayToString($lista)."</b></p>";
            echo "<p>Separadores cambiados:<b> "    .arrayToString($lista, true, true, ' | ',':')."</b></p>";
            echo "<p>Sin corchetes:<b> "            .arrayToString($lista, false)."</b></p>";
            echo "<p>Con corchetes sin claves<b> "  .arrayToString($lista, true, false)."</b></p>";
            echo "<p>Sin corchetes ni claves:<b> "  .arrayToString($lista, false, false)."</b></p>";
        ?>
        
        <h3>Con un array asociativo</h3>
        <p>Funciona también con arrays asociativos:</p>
        
        <code>$lista = ['dia'=>'lunes', 'plato'=>'lechuga'];</code>
        <?php 
            $lista = ['dia'=>'lunes', 'plato'=>'lechuga'];
            
            echo "<p>El array pasado a string:<b> " .arrayToString($lista)."</b></p>";
            echo "<p>Separadores cambiados:<b> "    .arrayToString($lista, true, true, ' | ',':')."</b></p>";
            echo "<p>Sin corchetes:<b> "            .arrayToString($lista, false)."</b></p>";
            echo "<p>Con corchetes sin claves<b> "  .arrayToString($lista, true, false)."</b></p>";
            echo "<p>Sin corchetes ni claves:<b> "  .arrayToString($lista, false, false)."</b></p>";
        ?>
        
        
        <h3>Arrays anidados</h3>
        
        <p>Si un array contiene otros arrays, también pasa a string los arrays internos:</p>
        
        <code>$lista = ['dias'=>['lunes','martes'], 'plato'=>['primero'=>'lechuga', 'segundo'=>'lomo']];</code>
        
         <?php 
         $lista = ['dias'=>['lunes','martes'], 'plato'=>['primero'=>'lechuga', 'segundo'=>'lomo']];
            
            echo "<p>El array pasado a string:<b> " .arrayToString($lista)."</b></p>";
            echo "<p>Separadores cambiados:<b> "    .arrayToString($lista, true, true, ' | ',':')."</b></p>";
            echo "<p>Sin corchetes (no muy útil):<b> "            .arrayToString($lista, false)."</b></p>";
            echo "<p>Con corchetes sin claves<b> "  .arrayToString($lista, true, false)."</b></p>";
            echo "<p>Sin corchetes ni claves (no muy útil):<b> "  .arrayToString($lista, false, false)."</b></p>";
        ?>
        
    </section>
    
    
    <section id="paragraph()">
        <h2>paragraph()</h2>
        <p>Convierte un texto con saltos de línea a formato HTML en párrafos.
        Para la siguiente prueba se usa un texto con tres saltos de línea 
        (ver el código fuente).</p>
        
        <div class="p1 border">
        <?php 
            $texto = "Este es un texto que contiene saltos de línea.   
                      Se deben mostrar tres párrafos HTML en el resultado.
                      En otro caso no estará funcionando bien.";
            
            echo paragraph($texto);
        ?>
        </div>
    </section>
</main>