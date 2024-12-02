<main> 
    <h1>NotIdentifiedException</h1>
    
    <section>
        <h2>Haciendo logout</h2>
        
        <p>El método <code>Login::clear()</code> expulsa el usuario identificado y limpia 
           por completo la información de la sesión.</p>
       
        <?php  
            Login::clear() // hace logout 
        ?>
        
        <p>Ahora intentamos comprobar si el usuario tiene un determinado rol. Esto provocará una
           <code>NotIdentifiedException</code>, puesto que ya no hay nadie identificado.</p>
           
        <p>El núcleo de la aplicación en <code>App.php</code> tratará esa excepción de manera
           especial, llevando al usuario al formulario de login.</p>
    
        <?php 
            // intenta comprobar el rol
            Auth::oneRole(['ROLE_EDITOR', 'ROLE_ADMIN']); 
        ?>
    </section>
</main>      
    
    
    