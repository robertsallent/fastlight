 
    <h1>Test de la clase Login</h1>
    
    <h2>Haciendo logout</h2>
    
    <p>El método Login::clear() expulsa el usuario identificado y limpia por completo la sesión.</p>
    
    <?php  Login::clear() ?>
    
    <p>Comprobaciones con guest(), check() e isAdmin():</p>
    
    <?php     
        echo Login::guest() ? "Nadie identificado<br>" : "Alguien identificado<br>";  // nadie
        echo Login::check() ? "Alguien identificado<br>" : "Nadie identificado<br>";  // nadie
        echo Login::isAdmin() ? "Administrador<br>" : "No administrador<br>";  // NO
    ?> 
      
       
    <h2>Haciendo login</h2>
    <p> Vamos a loguear el usuario 1 (admin).</p>
    <?php     
        $user = User::find(1);  // encuentra el usuario 1
        dump($user);
        Login::set($user);      // hace Login
    ?>
    
    
    <p>Comprobaciones con guest(), check() e isAdmin():</p>
    <?php 
        echo Login::guest() ? "Nadie identificado<br>" : "Alguien identificado<br>";  // alguien
        echo Login::check() ? "Alguien identificado<br>" : "Nadie identificado<br>";  // alguien
        echo Login::isAdmin() ? "Administrador<br>" : "No administrador<br>";  // Administrador
    ?>   
     
    <br> 
    <p> Vamos a loguear el usuario 2.</p>
    <?php     
        $user = User::find(2);  // encuentra el usuario 2
        dump($user);
        Login::set($user);      // hace Login
    ?>
    
    <p>Comprobaciones con guest(), check() e isAdmin():</p>
    <?php 
        echo Login::guest() ? "Nadie identificado<br>" : "Alguien identificado<br>";  // alguien
        echo Login::check() ? "Alguien identificado<br>" : "Nadie identificado<br>";  // alguien
        echo Login::isAdmin() ? "Administrador<br>" : "No administrador<br>";  // Administrador
     ?> 
     
    <h2>Limpiando...</h2> 
    <p>Finalmente haremos logout con Login::clear().</p>
    <?php  Login::clear() ?> 
    <p class='end'>Fin del test</p>

    
    