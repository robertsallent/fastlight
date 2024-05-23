<h1>Test de los helpers para trabajar con strings</h1>


<h2>Test del helper <code>arrayToString()</code></h2>
<p>El helper arrayToString() convierte arrays a cadenas de texto.</p>
<?php 
    $lista = ['patata', 'queso', 'pimiento', 'lechuga'];
    
    echo "<p>".arrayToString($lista)."</p>";
    echo "<p>".arrayToString($lista, false)."</p>";
    echo "<p>".arrayToString($lista, true, false)."</p>";
    echo "<p>".arrayToString($lista, false, false)."</p>";
?>

<h2>Helper <code>paragraph()</code></h2>
<p>Convierte un texto con saltos de línea a formato HTML con párrafos.</p>
<?php 
    $texto = "Este es un texto que contiene saltos de línea.   
              Se deben mostrar tres párrafos HTML en el resultado.
              En otro caso no estará funcionando bien.";
    
    echo paragraph($texto);
?>
