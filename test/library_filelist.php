<?php
    echo "<h1>Test de FileList</h1>";

    echo "<h2>Pruebas básicas</h2>";
    echo "<p>Contenido de la carpeta actual:</p>";
    dump(FileList::get()); 
    
    echo "<p>Contenido de la carpeta public:</p>";
    dump(FileList::get('../public')); 
    
    echo "<p>Ficheros php, ini o xml de la carpeta public:</p>";
    dump(FileList::get('../public', ['xml','php','ini'])); 
    
    echo "<p>Ficheros php o txt de la carpeta public:</p>";
    dump(FileList::get('../public', '/\.(php|txt)$/i')); 

    echo "<h2>Pruebas delicadas</h2>";
    
    echo "<p>Si le pasamos un array vacío:</p>";
    dump(FileList::get('../public', [])); 
    
    echo "<p>Si le pasamos un string vacío:</p>";
    dump(FileList::get('../public', '')); 