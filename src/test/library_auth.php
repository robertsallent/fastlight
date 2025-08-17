<main>
	<h1>Test de la clase <code>Auth</code></h1>
	
	
	<section>
		<h2>Recuperando un usuario y haciendo login</h2>
		<?php      
            $id = 1; // id del usuario con el que haremos la prueba (configurable)

            echo "<p>Recupera el usuario $id y hace login:</p>";
            
            $usuario = User::getById($id);  // recupera el usuario
            Login::set($usuario);           // hace login
                   
            echo "<p>El usuario $id ($usuario->displayname) tiene los roles: ";
            echo "<b>".arrayToString(Login::user()->getRoles(), false, false)."</b></p>";
        ?>
	</section>
	
	
	<section>
		<h2>Comprobaciones de Auth</h2>
		
		<p>Hay que comentar y descomentar las comprobaciones
              que se encuentran en el código <code>PHP</code> a continuación, puesto que 
              lanzan excepciones.
              Si se produce un error de autorización, aparecerá un <b>mensaje en rojo</b>
              justo debajo de este párrafo. La descripción del mensaje tiene 
              que ser coherente con la prueba que estamos haciendo.</p>
              
        <?php 
            try{
                // Auth::guest();  // usuario no identificado
                Auth::check();  // usuario identificado
                Auth::admin();  // usuario admin
            
                // pruebas con roles
                Auth::role('ROLE_ADMIN');
                // Auth::role('ROLE_TEST');
                Auth::allRoles(['ROLE_USER','ROLE_ADMIN']);
                // Auth::allRoles(['ROLE_USER','ROLE_TEST']);
                Auth::oneRole(['ROLE_USER','ROLE_ADMIN']);
                Auth::oneRole(['ROLE_USER','ROLE_TEST']);
                Auth::oneRole(['ROLE_EDITOR','ROLE_TEST']);
            
                echo "<p>No se detectaron problemas de autorización.</p>";
                               
            }catch(AuthException $exception){
                
                $mensaje  = "<h2 style='color:red'>Detectado problema de autorización</h2>";
                $mensaje .= "<p><b>".$exception->getMessage()."</b>.</p>";
                $mensaje .= "<p>Se detuvo la ejecución en la línea <b>".$exception->getTrace()[0]['line']."</b>";
                $mensaje .= " del fichero <b>".File::name($exception->getTrace()[0]['file'])."</b>.</p>";
                
                echo $mensaje;
            }
            
        ?>
		
	</section>
    

</main>
 