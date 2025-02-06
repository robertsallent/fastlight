<main>
	<h1>Test del modelo User</h1>
	
	<p>La clase <i>User</i> del modelo <b>implementa el CRUD y las operaciones
	con usuarios</b>.</p>
	
	<section>
		<h2>getByPhoneAndMail()</h2>
		
		<p>El método <code>getByPhoneAndMail()</code> recupera un usuario a partir de su email y su 
		teléfono. Se usa desde el controlador de recuperación de password
		 <span class="bold italic">ForgotPasswordController</span>, donde se le solicita al usuario
		 que indique estos datos para enviarle un email con la nueva clave.</p>
		
		<p>Estas son algunas pruebas:</p>
		
		<p>Primero tratamos de recuperar un usuario con los datos correctos  con
          <code>getByPhoneAndMail('666666666','admin@fastlight.com')</code>:</p>
		
		<pre>
		<?php dump(User::getByPhoneAndMail('666666666','admin@fastlight.com')) ?>
		</pre>
		
		<p>Ahora otro con datos incorrectos con
		<code>User::getByPhoneAndMail('123456789','Pepe')</code>:</p>
		
		<pre>
		<?php dump(User::getByPhoneAndMail('123456789','Pepe')) ?>
		</pre>
	</section>

	
  	<h2>Métodos heredados</h2>
  	
  	<p>Al tratarse de una clase del modelo, podemos usar cualquiera de los métodos
  		heredados de la clase <i>Model</i>.</p>
  		
  	<section>
  		<h3>find()</h3>
  		
  		<p>Recuperando el usuario 2 con <code>User::find(2)</code>:</p>
  		<pre>
  		<?php dump(User::find(2)) ?>
  		</pre>
  		
  		<p>Recuperando el usuario 1000 (no existe) con <code>User::find(1000)</code>:</p>
  		<pre>
  		<?php dump(User::find(1000)) ?>
  		</pre>
  	</section>
  	
  	
  	<section>
  		<h3>where()</h3>
  		
  		<p>Usuario con <i>displayname = test</i>  
  		<code>User::where(['displayname' => 'test'])</code>:</p>
  		<pre>
  		<?php dump(User::where(['displayname' => 'test'])) ?>
  		</pre>
  		
  		<p>Usuarios con <i>role admin</i> ordenados por <i>displayname DESC</i>:
  		<code>User::getFiltered('roles','ADMIN','displayname','DESC')</code></p>
  		<pre>
  		<?php dump(User::getFiltered('roles','ADMIN','displayname','DESC')) ?>
  		</pre>
  	</section>
</main>
<?php

    
   