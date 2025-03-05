<main> 
    <h1>Test de la clase Login</h1>
    
    
    <h2>Recuperando el usuario identificado</h2>
    <section id="user">
    	
        <h3>Login::user()</h3>
        <p>Este método permite <b>recuperar el usuario identificado</b>. Esta operación
         se puede realizar de diversas formas:</p>
        
        <ul>
        	<li>Mediante el método estático: <code>Login::user()</code>.</li>
        	<li>Mediante el método estático: <code>Login::get()</code> (alias de <code>Login::user()</code>)</li>
        	<li>A partir del objeto <i>Request</i> con <code>$request->user</code>.</li>
        	<li>Haciendo uso del helper <code>user()</code>.</li>
        </ul>
        
        <p>El usuario actual es:</p>
        <?php  dump(user()) ?>
    </section> 
    
    
    <h2>Haciendo comprobaciones</h2>
    
    <section id="check">
    	<h3>Login::check()</h3>
    	<p>El método estático <code>Login::check()</code> retorna <b>cierto si hay usuario identificado</b>.</p>
    	<p>Ahora mismo <b><?= Login::check() ? "sí hay alguien" : "no hay nadie" ?></b> identificado.</p> 
    </section>
    
    <section id="guest">
    	<h3>Login::guest()</h3>
    	<p>El método estático <code>Login::guest()</code> retorna <b>cierto si no hay usuario identificado</b>.</p>
    	<p>Ahora mismo <b><?= Login::guest() ? "no hay nadie" : "sí hay alguien" ?></b> identificado.</p> 
    </section>
    
    <section id="isAdmin">
    	<h3>Login::isAdmin()</h3>
    	<p>El método estático <code>Login::isAdmin()</code> retorna <b>cierto si hay usuario identificado 
    	y además tiene el rol <i>ROLE_ADMIN</i></b>.</p>
    	<p>Es administrador? <b><?= Login::isAdmin() ? "SI" : "NO" ?></b>.</p> 
    </section>
    
    
    <h2>Comprobando roles</h2>
    <section id="role"> 
        <h3>Login::role()</h3>
        
        <p>El método <code>Login::role()</code> permite comprobar si el usuario
        <b>tiene el rol indicado por parámetro</b>. Retorna <i>boolean</i>.</p>
        
        <p>Por ejemplo:  <code>Login::role('ROLE_USER')</code>.</p>
        
        <p>El usuario es 'ROLE_USER'? <b><?= Login::role('ROLE_USER') ? 'SI' : 'NO' ?></b>.</p>
        <p>El usuario es 'ROLE_ADMIN'? <b><?= Login::role('ROLE_ADMIN') ? 'SI' : 'NO' ?></b>.</p>
        <p>El usuario es 'ROLE_TEST'? <b><?= Login::role('ROLE_TEST') ? 'SI' : 'NO' ?></b>.</p>
     </section>  
     
     <section id="oneRole"> 
        <h3>Login::oneRole()</h3>
        
        <p>El método <code>Login::oneRole()</code> permite comprobar si el usuario
        <b>tiene uno de los roles indicados en la lista</b> que se le pasa por parámetro. 
        Retorna <i>boolean</i>.</p>
        
        <p>Por ejemplo:  <code>Login::oneRole(['ROLE_ADMIN', 'ROLE_USER'])</code>.</p>
        
        <p>El usuario es 'ROLE_USER' o 'ROLE_ADMIN'? <b>
        <?= Login::oneRole(['ROLE_ADMIN', 'ROLE_USER']) ? 'SI' : 'NO' ?></b>.</p>
        
        <p>El usuario es 'ROLE_ADMIN' o 'ROLE_TEST'? <b>
        <?= Login::oneRole(['ROLE_ADMIN', 'ROLE_TEST']) ? 'SI' : 'NO' ?></b>.</p>
        
        <p>El usuario es 'ROLE_EDITOR' o 'ROLE_SUPERVISOR'? <b>
        <?= Login::oneRole(['ROLE_EDITOR', 'ROLE_SUPERVISOR']) ? 'SI' : 'NO' ?></b>.</p>    
     </section>  
     
     
     
     <section id="allRoles"> 
        <h3>Login::allRoles()</h3>
        
        <p>El método <code>Login::allRoles()</code> permite comprobar si el usuario
        <b>tiene todos los roles indicados en la lista</b> que se le pasa por parámetro. 
        Retorna <i>boolean</i>.</p>
        
        <p>Por ejemplo:  <code>Login::allRoles(['ROLE_ADMIN', 'ROLE_USER'])</code>.</p>
        
        <p>El usuario es 'ROLE_USER' y 'ROLE_ADMIN'? <b>
        <?= Login::allRoles(['ROLE_ADMIN', 'ROLE_USER']) ? 'SI' : 'NO' ?></b>.</p>
        
        <p>El usuario es 'ROLE_USER' y 'ROLE_TEST'? <b>
        <?= Login::allRoles(['ROLE_USER', 'ROLE_TEST']) ? 'SI' : 'NO' ?></b>.</p>
        
        <p>El usuario es 'ROLE_EDITOR' y 'ROLE_SUPERVISOR'? <b>
        <?= Login::allRoles(['ROLE_EDITOR', 'ROLE_SUPERVISOR']) ? 'SI' : 'NO' ?></b>.</p>    
     </section>  
        
        
        
    <h2>Haciendo login</h2>
    <section id="set">   
        <h3>Login::set()</h3>
        <p> El método <code>Login::set()</code> <b>identifica un usuario en la sesión</b>. Sirve tanto
        para hacer <i>login</i> como para cambiar de usuario.</p>
        
        <p><b>No lo usaremos directamente</b> (salvo alguna situación muy especial y controlada),
         es el <i>LoginController</i> el que se encarga de esta operación.</p>
         
         <p>Para probarlo, hagamos <i>login</i> con el usuario "Test".</p>
         
         <pre>
         	<code>
    $usuarioTest = User::where(['displayname' => 'Test'])[0];
    Login::set($usuarioTest);
    dump(Login::user());
         	</code>
         </pre>
        <?php     
            // recupera el usuario con nombre "Test"
            $usuarioTest = User::where(['displayname' => 'Test'])[0];
            
            // hace login con el usuario test
            Login::set($usuarioTest);
            
            // comprobación
            dump(Login::user()); 
        ?>
    </section>  
    
    
    
    <h2>Haciendo logout</h2>
    <section id="clear">
        <h3>Login::clear()</h3>
        
        <p>El método <code>Login::clear()</code> <b>expulsa el usuario identificado y limpia 
        por completo la sesión</b>. Este método no se usa frecuentemente, solamente se usará
         en un par de casos:</p>
        <ul>
        	<li>El usuario hace <i>logout</i> (ya implementado desde <i>LogoutController</i>).</li>
        	<li>El usuario se da de baja, lo que implica además cerrar su sesión.</li>
        </ul>

        <?php  
            Login::clear()            // hago logout
        ?>
        
        <p>Ahora hay alguien identificado? <b><?= Login::check() ? 'SI' : 'NO' ?>.</b></p>
        
        <div class="warning p1">
        	<h3>Advertencia</h3>
            <p>Al volver al listado de test se nos pedirá identificación de nuevo.
            Al hacer <code>Login::clear()</code> se eliminaron todos los datos de la sesión  
            incluida la <i>cookie</i> de sesión.</p>
        </div>
        
    </section> 
</main>    
    
    
    