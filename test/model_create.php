<h1>Test del método create() de Model.</h1>

<h2>Creando un nuevo usuario.</h2>
<p>Esta prueba crea un nuevo usuario haciendo uso del método estático create() definido
en la clase Model.</p>

<?php 
    $id = User::create([
        'displayname' => 'Pepe',
        'email'       => 'pepelu@fastlight.com',
        'phone'       => '654987320',
        'password'    =>  md5('Hola'),
        'roles'       =>  json_encode(['ROLE_USER', 'ROLE_EDITOR'])
    ]);
?>

<p>Una vez creado el usuario <?= $id ?>, lo recuperamos para comprobar que ha funcionado.</p>

<?php dump(User::find($id)); ?>



<p>Finalmente lo borramos para evitar problemas al repetir esta prueba.</p>

<?php 
    User::delete($id);
    dump(User::find($id)); 
?>

