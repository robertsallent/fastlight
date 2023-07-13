 
    <h1>NotIdentifiedException</h1>
    
    <h2>Haciendo logout</h2>
    <p>El método Login::clear() expulsa el usuario identificado y limpia por completo la sesión.</p>
   
    <?php  Login::clear() ?>
    
    <p>Comprobando si el usuario tiene un determinado rol. Esto provocará una
       NotIdentifiedException, puesto que no hay nadie identificado.</p>

    <?php 
        
        Session::warning("Si has sido redirigido a LogIn es porque no estabas identificado, 
                          eso indicaría que NotIdentifiedException funciona correctamente.");
        
        Auth::oneRole(['ROLE_EDITOR', 'ROLE_ADMIN']); 
    ?>
      
    
    
    