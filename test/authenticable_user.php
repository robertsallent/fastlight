<h1>Test de autenticación</h1>

<h2>Identificación por email</h2>

<p>Identificación correcta del usuario admin@fastlight.com.</p>
<?php dump(User::authenticate('admin@fastlight.com', md5('1234'))); ?>    

<p>Identificación incorrecta de un usuario inexistente.</p>
<?php dump(User::authenticate('robert@fastlight.com', md5('1234'))); ?>   


<h2>Identificación por teléfono</h2>

<p>Identificación correcta del usuario admin@fastlight.com mediante el teléfono.</p>
<?php dump(User::authenticate('666666666', md5('1234'))); ?>
 
 <p>Identificación incorrecta del usuario admin@fastlight.com mediante el teléfono.</p>   
<?php dump(User::authenticate('111111111', md5('1234'))); ?>
        

    
    