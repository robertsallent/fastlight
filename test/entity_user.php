<?php
    echo "<h1>Test del modelo <code>User</code></h1>";

    echo "<h2>Pruebas de los métodos propios de <code>User</code>.</h2>";
        
    echo "<h3>Método <code>getByPhoneAndMail()</code></h3>";
    
    echo "<p>EL método <code>getByPhoneAndMail()</code> nos permite recuperar un usuario a partir
          de su teléfono y correo electrónico. Se usa en la operación de recuperación de 
          password.</p>";
    
    echo "<p>Primero tratamos de recuperar un usuario con los datos correctos  con
          <code>getByPhoneAndMail('666666666','admin@fastlight.com')</code>:</p>";
    echo "<p>".(User::getByPhoneAndMail('666666666','admin@fastlight.com') ?? "ERROR")."</p>";
  
    
    echo "<p>Ahora otro con datos incorrectos:</p>"; 
    echo "<p>".(User::getByPhoneAndMail('123456789','Pepe') ?? "ERROR")."</p>";     
    
   
    
    echo "<h2>Pruebas con los métodos heredados de <code>Model</code>.</h2>";
    
    echo "<h3>Método <code>find()</code></h3>";
    echo "<p>Recuperando el usuario 2:</p>";
    echo "<p>".(User::find(2) ?? "No existe")."</p>";
       
    echo "<p>Recuperando el usuario 1000 (no existe):</p>";
    echo "<p>".(User::find(1000) ?? "No existe")."</p>";
    echo "<br>";
    
    echo "<h3>Usuarios ordenados por nombre descendente:</h3>";
    dump(User::orderBy('displayname','DESC'));
    
    echo "<h3>Filtro where (usuario con displayname admin):</h3>";
    dump(User::where(['displayname' => 'admin']));
    
    echo "<h3>Filtro getFiltered (usuarios con role user ordenados por id DESC):</h3>";
    dump(User::getFiltered('roles','USER','id','DESC'));
    
    echo "<h3>Todos los usuarios:</h3>";
    dump(User::all());