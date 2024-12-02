<main> 
    <h1>Test de la clase Login</h1>
    
    
    <section>
        <h2>Haciendo logout</h2>
        <p>El método Login::clear() expulsa el usuario identificado y limpia por completo la sesión.</p>
        <?php  Login::clear() ?>
        
        <p>Comprobaciones con guest(), check() e isAdmin():</p>
        <?php     
            echo Login::guest() ? "Nadie<br>" : "Alguien<br>";  // nadie           
            echo Login::check() ? "Alguien<br>" : "Nadie<br>";  // nadie
            echo Login::isAdmin() ? "Administrador<br>" : "No administrador<br>";  // NO
        ?> 
    </section> 
    
    
    <section>   
        <h2>Haciendo login</h2>
        <p> Vamos a loguear el usuario 1 (admin).</p>
        <?php     
            Login::set(User::find(1));      // hace Login con el usuario 1
            dump(Login::user());            // datos del administrador        
        ?>
    </section>
    
    
    <section>
        <h2>Comprobando si hay alguien identificado (lo está el admin)</h2>
        <p>Comprobaciones con guest(), check() e isAdmin():</p>
        <?php 
            echo Login::guest() ? "Nadie<br>" : "Alguien<br>";  // alguien
            echo Login::check() ? "Alguien<br>" : "Nadie<br>";  // alguien
            echo Login::isAdmin() ? "Administrador<br>" : "No administrador<br>";  // Administrador
        ?>   
    </section>
    
    
    <section> 
        <h2>Comprobando sus roles</h2>
        <p> Vamos a comprobar ahora sus roles (es user y admin).</p>
        <?php     
            echo (Login::isAdmin() ? "Si " : "No ")."es ADMIN<br>"; // SI           
            echo (Login::role("ROLE_USER") ? "Si " : "No ")."es USER<br>"; // SI           
            echo (Login::role("ROLE_TEST") ? "Si " : "No ")."es TEST<br>"; // NO           
            echo (Login::oneRole(["ROLE_TEST","ROLE_LIBRARIAN"]) ? "Si " : "No ")."es TEST ni LIBRARIAN<br>"; // NO            
            echo (Login::allRoles(["ROLE_USER","ROLE_ADMIN"]) ? "Si " : "No ")."es USER y ADMIN<br>"; // SI       
        ?>
    </section> 
     
     
    <section> 
        <h2>Limpiando...</h2> 
        <p>Finalmente haremos logout con Login::clear().</p>
        
        <?php  
            Login::clear();      // elimina el usuario de la sesión 
            dump(Login::user()); // NULL
        ?>
    </section> 
</main>    
    
    
    