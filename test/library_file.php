<?php
    echo "<h1>Test de File</h1>";

    $fichero = new File('../public/favicon.ico');
    echo "<p>FICHERO: ".$fichero->getPath().".</p>";
    
    
    echo "<h2>Datos del fichero.</h2>";
    echo "<p>Base Name: ".$fichero->getBaseName()."</p>.";
    echo "<p>Name: ".$fichero->getName()."</p>.";
    echo "<p>Extension: ".$fichero->getExtension()."</p>.";
    echo "<p>Directory: ".$fichero->getFolder()."</p>.";
    
    
    
    echo "<h2>Uso de los métodos de objeto para calcular tipos MIME.</h2>";
    
    echo "<h3>Método getMime()</h3>";
    echo "<p>Tipo MIME: ".$fichero->getMime()."</p>.";
    
    echo "<h3>Método is()</h3>";
    echo "<p>Es PDF?: ".($fichero->is('application/pdf') ? 'SI':'NO')."</p>.";
    echo "<p>Es icon?: ".($fichero->is('image/vnd.microsoft.icon') ? 'SI':'NO')."</p>.";
   
    echo "<h3>Método checkMime()</h3>";
    echo "<p>Es PDF, jpg o jpeg?: ".($fichero->checkMime('/\/(pdf|jpe?g)$/i') ? 'SI':'NO')."</p>.";
    echo "<p>Es imagen?: ".($fichero->checkMime('/^image\//i') ? 'SI':'NO')."</p>.";
    
    echo "<h3>Método has()</h3>";
    echo "<p>Es PDF o jpeg?: ".($fichero->has(['application/pdf','image/jpeg']) ? 'SI':'NO')."</p>.";
    echo "<p>Es jpeg o ico?: ".($fichero->has(['image/vnd.microsoft.icon','image/jpeg']) ? 'SI':'NO')."</p>.";
    
    
    
    
    echo "<h2>Uso de los métodos estáticos para calcular tipos MIME.</h2>";
    echo "<h3>Método File::mime()</h3>";
    
    echo "<p>Fichero de tipo php:</p>";
    dump(File::mime('../tests/file.php'));      // php
    
    echo "<p>Fichero de tipo xml:</p>";
    dump(File::mime('../public/sitemap.xml'));  // xml
    
    
    echo "<h3>Método File::isMime()</h3>";
    
    echo "<p>Es txt un fichero de txt?</p>";
    dump(File::isMime('../public/humans.txt', 'text/plain'));  // true
    
    echo "<p>Es imagen un ficheros txt?</p>";
    dump(File::isMime('../public/humans.txt', 'image/png'));   // false
    
    
    echo "<h3>Método File::mimeCheck()</h3>";
    echo "<p>Es imagen un favicon?</p>";
    dump(File::mimeCheck('../public/favicon.ico', '/^image\/*/i'));  // true
    
    echo "<p>Es video un favicon?</p>";
    dump(File::mimeCheck('../public/favicon.ico', '/^video\/*/i'));  // false
    
    
    echo "<h3>Método File::hasMime()</h3>";
    echo "<p>un fichero de texto es text/plain o text/csv?</p>";
    dump(File::hasMime('../public/robots.txt', ['text/plain', 'text/csv']));  // true
    
    echo "<p>un fichero de texto es image/jpeg o text/csv?</p>";
    dump(File::hasMime('../public/robots.txt', ['image/jpeg', 'text/csv']));  // false
    
    
    
    