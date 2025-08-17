<main>
	<h1>Test del modelo User</h1>
	
	<p>La clase <i>User</i> del modelo <b>implementa el CRUD y las operaciones
	con usuarios</b>.</p>
	
	<section id="getByPhoneAndMail">
		<h2>getByPhoneAndMail()</h2>
		
		<p>El método <code>getByPhoneAndMail()</code> recupera un usuario a partir de su email y su 
		teléfono. Se usa desde el controlador de recuperación de password
		 <span class="bold italic">ForgotPasswordController</span>, donde se le solicita al usuario
		 que indique estos datos para enviarle un <i>email</i> con la nueva clave.</p>
		
		<p>Hagamos unas pruebas. Primero tratamos de recuperar un usuario con los datos correctos  con:
        <code>$user = getByPhoneAndMail('666666661','admin@fastlight.org')</code>:</p>
		<?php dump(User::getByPhoneAndMail('666666661','admin@fastlight.org')) ?>
		
		
		<p>Ahora otro con datos incorrectos con
		<code>$user = User::getByPhoneAndMail('123456789','Pepe')</code>:</p>
		<?php dump(User::getByPhoneAndMail('123456789','Pepe')) ?>
	</section>

	
  	<h2>Métodos heredados de Model</h2>
  	
  	<p>Al tratarse de una clase del modelo, podemos usar cualquiera de los métodos
  		heredados de la clase <i>Model</i>.</p>
  		
  	<section id="find">
  		<h3>find()</h3>
  		
  		<p>Recuperando el usuario 2 con <code>$user = User::find(2)</code>:</p>
  		<?php dump(User::find(2)) ?>
  		
  		<p>Recuperando el usuario 1000 (no existe) con <code>$user = User::find(1000)</code>:</p>
  		<?php dump(User::find(1000)) ?>
  	</section>
  	
  	
  	<section id="where">
  		<h3>where()</h3>
  		
  		<p>Usuario con <i>displayname = test</i>  
  		<code>$user = User::where(['displayname' => 'test'])</code>:</p>
  		<?php dump(User::where(['displayname' => 'test'])) ?>
  		
  		<p>Usuarios con <i>role admin</i> ordenados por <i>displayname DESC</i>:
  		<code>$user = User::getFiltered('roles','ADMIN','displayname','DESC')</code></p>
  		<?php dump(User::getFiltered('roles','ADMIN','displayname','DESC')) ?>
  	</section>
</main>
<?php

    
   