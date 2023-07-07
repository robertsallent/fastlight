<?php
    echo "<h1>Test de User</h1>";

    echo "<h2>Pruebas de los métodos para el modelo User.</h2>";
        
    echo "<h3>getByPhoneAndMail('666666666','admin@fastlight.com'):</h3>";
    dump(User::getByPhoneAndMail('666666666','admin@fastlight.com'));
    
    echo "<h3>getByPhoneAndMail('wrong','number'):</h3>";
    dump(User::getByPhoneAndMail('wrong','number'));
    
    
    
    echo "<h3>Todos los usuarios:</h3>";
    dump(User::all());
    
    echo "<h3>Usuario 3:</h3>";
    dump(User::find(2));
    
    echo "<h3>Usuario 3000 (no existe):</h3>";
    dump(User::find(3000));
    
    echo "<h3>Usuarios ordenados por nombre descendente:</h3>";
    dump(User::orderBy('displayname','DESC'));
    
    echo "<h3>Filtro where (usuario con displayname admin):</h3>";
    dump(User::where(['displayname' => 'admin']));
    
    echo "<h3>Filtro getFiltered (usuarios con role user ordenados por id DESC):</h3>";
    dump(User::getFiltered('roles','USER','id','DESC'));