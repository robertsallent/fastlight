<?php

    // si queremos que el resultado se vea "bonito"
    echo TestTemplate::start($method); 

    echo "<h1>Test del Test Template</h1>";

    echo "<p>Este test no hace nada especial, solo muestra cómo visualizar el resultado
             con un aspecto un poco mejor.</p>";
     
    dump(User::getById(1)); // por mostrar algo...
    
    // si queremos que el resultado se vea "bonito"
    echo TestTemplate::end(); 
    
    