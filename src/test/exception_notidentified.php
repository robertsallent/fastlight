<main> 
    <h1>NotIdentifiedException</h1>
    
    <section>
        <h2>Login::clear()</h2>
        
        <p>El método <code>Login::clear()</code> <b>expulsa el usuario identificado y limpia 
           por completo la información de la sesión</b>.</p>
       
        <?php Login::clear() // hace logout ?>

        <p>Se ha hecho <b class="upper maxi">logout</b> usando <code>Login::clear()</code>,
        así que ahora mismo dejas de estar identificado en el sistema.</p>
        
        <p>Se va a hacer una redirección <b>en diez segundos</b> al listado de test en la ruta
        <i>/test</i>. Esto provocará una <code>NotIdentifiedException</code>, puesto que ya no 
        hay nadie identificado.</p>
           
        <p>El núcleo de la aplicación en <i>App.php</i> tratará esa excepción de manera
           especial, llevando al usuario al formulario de login.</p>
           
    	<div class="warning p1">
        	<h2>Importante</h2>
        	
        	<p>Se ha hecho logout y en diez segundos serás redireccionado, 
        	tendrás que hacer login de nuevo para ir a la lista de test.</p>
        </div>
        
        <?php 
            // redirección en diez segundos
            redirect('/test', 10)->send();
        ?>
    </section>
</main>      
    
    
    