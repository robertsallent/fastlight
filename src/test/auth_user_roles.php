<main>
    <h1>Test de gestión de roles (clase User)</h1>
    
    <h2>Recuperar roles</h2>
    
    <section id="getRoles">
        <h3>getRoles()</h3>
        <p>El método de objeto <code>getRoles()</code> <b>recupera la lista de roles de un usuario</b>.</p>
        
        <p>Por ejemplo, para mostrar los roles del usuario actual (<b><?= user()->displayname ?></b>):</p>
        
        <pre>
        	<code>
    $roles = user()->getRoles();
    echo arrayToString($roles);
        	</code>
        </pre>
        
        
        <?php
            $roles = user()->getRoles();
            echo "<p>Los roles del usuario actual son: <b>".arrayToString($roles, false, false)."</b><p>";
        ?>
    </section>
    
        
    <h2>Añadiendo roles</h2>
    
    <section id="addRole">
        <h2>addRole()</h2>
        <p>El método <code>addRole()</code> permite <b>añadir nuevos roles a un usuario</b>, pero no
        aplica los cambios en la base de datos. Para aplicar los cambios en la BDD habrá que usar
        el método <code>update()</code> del modelo.</p>
         
        <p>Por ejemplo, añadiremos los roles <i>ROLE_STUDENT</i> y <i>ROLE_FREAK</i> al usuario 
        <b><?= user()->displayname ?></b> con el que estás identificado ahora mismo,
         aplicando los cambios en la base de datos.</p>
         
         <pre>
         	<code>
    user()->addRole('ROLE_STUDENT', 'ROLE_FREAK');
    user()->update();
         	</code>
         </pre>
        <?php     
            user()->addRole('ROLE_STUDENT', 'ROLE_FREAK');
            user()->update();             
        ?>
        
        <p>Si recuperamos el usuario desde la BDD, veremos que se guardaron los cambios.</p>
        <?php dump(User::find(user()->id)->getRoles()); ?>
        
        <p>Si añadimos roles que ya tiene el usuario, no se duplican.</p>
    </section>
    
    
    
    <h2>Comprobando roles</h2>
    
     <section id="isAdmin">
    	<h3>isAdmin()</h3>
    	<p>El método <code>isAdmin()</code> permite <b>comprobar si un usuario tiene el rol de administrador</b>,
    	es decir <i>ROLE_ADMIN</i>.</p>
    	
    	<p>Por ejemplo: <code>user()->isAdmin();</code>.</p>
    	
    	<p>¿El usuario actual es administrador? <b><?= user()->isAdmin() ? 'SI' : 'NO' ?></b>.</p>
    </section>
    
    
    <section id="hasRole">
    	<h3>hasRole()</h3>
    	
    	<p>El método <code>hasRole()</code> sirve para <b>comprobar si un usuario tiene un rol
    	concreto</b>. Le pasamos el nombre del rol por parámetro y retorna boolean.</p>
    	
    	<?php  $roles = user()->getRoles() ?>
    	
        <p>Los roles del usuario actual son: <b><?= arrayToString($roles, false, false) ?></b><p>
        
        <p>Hagamos algunas comprobaciones, por ejemplo: <code>user()->hasRole('ROLE_TEST')</code>.</p>
        
        <?php 
        	echo "<p><i>ROLE_TEST:</i> <b>".(user()->hasRole('ROLE_TEST') ? 'SI' : 'NO')."</b><br>";                                  // SI
        	echo "<i>ROLE_DEVELOPER:</i> <b>".(user()->hasRole('ROLE_DEVELOPER') ? 'SI' : 'NO')."</b><br>";
        	echo "<i>ROLE_USER:</i> <b>".(user()->hasRole('ROLE_USER') ? 'SI' : 'NO')."</b><br>";
        	echo "<i>ROLE_FREAK:</i> <b>".(user()->hasRole('ROLE_FREAK') ? 'SI' : 'NO')."</b></p>";
    	?>
    </section>
    
    <section id="allRoles">
        <h3>allRoles()</h3>
        
        <p>El método <code>allRoles()</code> sirve para <b>comprobar si un usuario tiene todos
    	los roles indicados en una lista</b>. Le pasamos la lista de roles y retorna boolean.</p>
    	
    	<?php
            $roles = user()->getRoles();
            echo "<p>Los roles del usuario actual son: <b>".arrayToString($roles, false, false)."</b><p>";
        ?>    
            
    	<p>Hagamos algunas comprobaciones, por ejemplo: <code>user()->allRoles(['ROLE_TEST','ROLE_DEVELOPER'])</code>.</p>
        
        <?php 
            echo "<p><i>ROLE_TEST y ROLE_DEVELOPER:</i> <b>".(user()->allRoles(['ROLE_TEST','ROLE_DEVELOPER']) ? 'SI' : 'NO')."</b><br>"; 
            echo "<i>ROLE_USER y ROLE_ADMIN:</i> <b>".(user()->allRoles(['ROLE_USER','ROLE_ADMIN']) ? 'SI' : 'NO')."</b><br>";
            echo "<i>ROLE_STUDENT y ROLE_FREAK:</i> <b>".(user()->allRoles(['ROLE_STUDENT','ROLE_FREAK']) ? 'SI' : 'NO')."</b><br>";
            echo "<i>ROLE_STUDENT y ROLE_EDITOR:</i> <b>".(user()->allRoles(['ROLE_STUDENT','ROLE_EDITOR']) ? 'SI' : 'NO')."</b></p>";
         ?>    
    </section>
    
    
    <section id="oneRole">
        <h3>oneRole()</h3>
        
        <p>El método <code>oneRole()</code> sirve para <b>comprobar si un usuario tiene alguno de 
    	los roles indicados en una lista</b>. Le pasamos la lista de roles y retorna boolean.</p>
    	
         <?php
            $roles = user()->getRoles();
            echo "<p>Los roles del usuario actual son: <b>".arrayToString($roles, false, false)."</b><p>";
         ?>
         
         <p>Hagamos algunas comprobaciones, por ejemplo: <code>user()->oneRole(['ROLE_TEST','ROLE_DEVELOPER'])</code>.</p>
        
        
         <?php   
            echo "<p><i>ROLE_USER o ROLE_DEVELOPER:</i> <b>".(user()->oneRole(['ROLE_USER','ROLE_DEVELOPER']) ? 'SI' : 'NO')."</b><br>"; 
            echo "<i>ROLE_CRACK o ROLE_MACHINE:</i> <b>".(user()->oneRole(['ROLE_CRACK','ROLE_MACHINE']) ? 'SI' : 'NO')."</b><br>";
            echo "<i>ROLE_STUDENT o ROLE_FREAK:</i> <b>".(user()->oneRole(['ROLE_STUDENT','ROLE_FREAK']) ? 'SI' : 'NO')."</b><br>";
            echo "<i>ROLE_STUDENT o ROLE_EDITOR:</i> <b>".(user()->oneRole(['ROLE_STUDENT','ROLE_EDITOR']) ? 'SI' : 'NO')."</b></p>";
         ?>    
    </section>
    
    
    
    <h2>Eliminando roles</h2>
    
    <section id="removeRole">
        <h3>Eliminando roles</h3>    
        
        <p>El método <code>removeRole()</code> se utiliza para <b>eliminar roles de un usuario</b>.
        No guarda los cambios en la base de datos, para hacerlo habrá que llamar al método 
        <code>update()</code> del modelo.</p>
        
         <pre>
         	<code>
    user()->removeRole('ROLE_STUDENT', 'ROLE_FREAK');
    user()->update();
         	</code>
         </pre>
        <?php     
            user()->removeRole('ROLE_STUDENT', 'ROLE_FREAK');
            user()->update();             
        ?>
        
        <p>Si recuperamos el usuario desde la BDD, veremos que se guardaron los cambios.</p>
        <?php dump(User::find(user()->id)->getRoles()); ?>
    </section>
</main>
