<?php
    echo "<h1>Test de File</h1>";

    echo "<h2>Comprobando tipos de fichero</h2>";
    echo "<p>Fichero de tipo php:</p>";
    dump(File::mime('../tests/file.php')); 
    
    echo "<p>Fichero de tipo xml:</p>";
    dump(File::mime('../public/sitemap.xml')); 
    
   