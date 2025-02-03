<main>

    <h1>Test de autenticación</h1>

    <section>
    
    	<h2>User::authenticate()</h2>
    	
        <p>El método <code>User::authenticate()</code> sirve para autenticar usuarios y darles 
        acceso a la aplicación o a distintos recursos. Es usado desde el mecanismo de <i>Login</i> 
        de <i>FastLight</i>.</p>
        
        <p>Recibe por parámetro email/teléfono y password (encriptado) y retorna el usuario
        que tiene esos datos o <i>NULL</i> si no existe.</p>
     
     </section>
     
     
     <section id="email">   
        <h3>Autenticación por email</h3>
        
        <p>Ejemplo de identificación <b>correcta</b> del usuario <i>test@fastlight.com</i>:<br> 
        <code>User::authenticate('test@fastlight.com', md5('1234'))</code>.</p>
    
        <?php dump(User::authenticate('test@fastlight.com', md5('1234'))); ?>    
        
        
        <p>Ejemplo de identificación <b>incorrecta</b> del usuario <i>test@fastlight.com</i> (password incorrecto):<br> 
        <code>User::authenticate('test@fastlight.com', md5('5678'))</code>.</p>
    
        <?php dump(User::authenticate('test@fastlight.com', md5('5678'))); ?>  
        
        
        <p>Ejemplo de identificación <b>incorrecta</b> del usuario <i>robert@fastlight.com</i> (no existe): <br>
        <code>User::authenticate('robert@fastlight.com', md5('1234'))</code>.</p>  
        
        <?php dump(User::authenticate('robert@fastlight.com', md5('1234'))); ?>

     </section>   
     
     
     <section id="phone">   
        <h3>Autenticación por teléfono</h3>
         
        
        <p>Identificación <b>correcta</b> del usuario mediante el teléfono 666666663:<br>
        <code>User::authenticate('666666663', md5('1234'))</code>.</p>  
        
        <?php dump(User::authenticate('666666663', md5('1234'))); ?>
        
         
        <p>Identificación <b>incorrecta</b> del usuario mediante el teléfono 666666663 (password incorrecto):<br>
        <code>User::authenticate('666666663', md5('5678'))</code>.</p> 
        
        <?php dump(User::authenticate('666666663', md5('5678'))); ?>
        
        
        <p>Identificación <b>incorrecta</b> del usuario mediante el teléfono 666666660 (no existe):<br>
        <code>User::authenticate('666666660', md5('1234'))</code>.</p>  
        
        <?php dump(User::authenticate('666666660', md5('1234'))); ?> 
	</section>
</main>
        

    
    