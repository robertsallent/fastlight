<?php
    echo "<h1>Test de relaciones N a N</h1>";
    echo "<h2>Ejemplo biblioteca</h2>";
    echo "<p>Las siguientes pruebas han sido realizadas sobre el ejemplo de la biblioteca,
             desarrollado en clase en CIFO Sabadell.</p>";
      
    echo "<h2>Pruebas de <code>belongsToMany()</code>.</h2>";
    echo "<h3>Buscando temas del libro 1</h3>";
    
    $libro = Libro::find(1);
    echo "<p>El libro 1 es: $libro.</p>";
    
    $temas = $libro->belongsToMany('Tema', 'temas_libros');
    dump($temas);
    
    
    
    echo "<h3>Buscando libros del tema 8</h3>";
    
    $tema = Tema::find(8);
    echo "<p>El tema 8 es: $tema.</p>";
    
    $libros = $tema->belongsToMany('Libro', 'temas_libros');
    dump($libros);
    
    