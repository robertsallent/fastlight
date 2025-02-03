<main> 
    <h1>NotIdentifiedException</h1>
    
    <section>
        <h2>Haciendo logout</h2>
        
        <p>El método <code>Login::clear()</code> expulsa el usuario identificado y limpia 
           por completo la información de la sesión.</p>
       
        <?php  
            Login::clear() // hace logout 
        ?>
        
        <p>Ahora haremos una redirección <b>tras cinco segundos</b> al listado de test. Esto provocará una
           <code>NotIdentifiedException</code>, puesto que ya no hay nadie identificado.</p>
           
        <p>El núcleo de la aplicación en <i>App.php</i> tratará esa excepción de manera
           especial, llevando al usuario al formulario de login.</p>
    
        <?php 
            // redirección en cinco segundos
            redirect('/test', 5)->send();
        ?>
    </section>
</main>      
    
    
    