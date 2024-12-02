<main>

    <h1>Test de autenticación</h1>
    
    <section>
        <h2>Identificación por email</h2>
        
        <p>Identificación <b>correcta</b> del usuario <i>admin@fastlight.com</i>.</p>
        <?php dump(User::authenticate('admin@fastlight.com', md5('1234'))); ?>    
        
        <p>Identificación <b>incorrecta</b> (usuario inexistente).</p>
        <?php dump(User::authenticate('robert@fastlight.com', md5('1234'))); ?>   
    </section>
    
    
    <section>
        <h2>Identificación por teléfono</h2>
        
        <p>Identificación <b>correcta</b> del usuario admin@fastlight.com mediante el teléfono.</p>
        <?php dump(User::authenticate('666666666', md5('1234'))); ?>
         
        <p>Identificación <b>incorrecta</b> del usuario admin@fastlight.com mediante el teléfono.</p>   
        <?php dump(User::authenticate('111111111', md5('1234'))); ?>
	</section>
</main>
        

    
    