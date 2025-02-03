<main>
    <h1>Test del helper <code>old()</code></h1>
    
    <p>
    El helper <code>old()</code> se encarga de rellenar los campos de 
    formulario con los valores de la petición anterior flasheados en sesión.
    </p>
    
    <p>El helper <code>oldSelected()</code> se usa para los desplegables.</p>
    
    <p>El helper <code>oldChecked()</code> se usa para los checkboxes y botones de radio.</p>
    

    <section>
        <h2>Old Inputs en la Request</h2>
        <p>Inputs flasheados en sesión y recuperados en la request actual:</p>
        <?php 
        
            // fuerza una redirección extra tras el envio del formulario,
            // de esta manera puedo comprobar que los helpers funcionan correctamente
            if(request()->has('enviar'))
                redirect(request()->url)->send();
            
            
            // muestra los inputs flasheados en sesión o NULL si no hay
            dump(request()->previousInputs ?? NULL);
        ?>
    </section>
    
    <h2>Formulario que recuerda los valores antiguos.</h2>
    
    <p>
    	Tras enviar el formulario se realizará una redirección, pero 
    	verás que los valores se mantienen.
    </p>
    
    <form method="POST" class="form">
    	<label>Nombre:</label>
    	<input name="nombre" class="long" value="<?= old('nombre') ?>">
    	<br>
    	
    	<label>Apellido:</label>
    	<input name="apellido" class="long" value="<?= old('apellido') ?>">
    	<br>
    	
    	<label>Edad:</label>
    	<input type="number" class="short" name="edad" value="<?= old('edad') ?>">
    	<br>
    	
    	<input type="radio" name="sexo" value='h' <?= oldChecked('sexo', 'h', true) ?>>
    	<label>Hombre</label>
    	<input type="radio" name="sexo" value='m' <?= oldChecked('sexo', 'm') ?>>
    	<label>Mujer</label>
    	<input type="radio" name="sexo" value='n' <?= oldChecked('sexo', 'n') ?>>
    	<label>No binario</label>
    	<br>
    	
    	<label>Idioma:</label>
    	<select name="idioma">
    		<option value="catala" <?= oldSelected('idioma', 'catala') ?>>Català</option>
    		<option value="castellano" <?= oldSelected('idioma', 'castellano') ?>>Castellano</option>
    		<option value="english" <?= oldSelected('idioma', 'english') ?>>English</option>
    	</select>
    	<br>
    	
    	<input type="submit" name="enviar" value="Enviar" class="button">
    </form>
    
    <section>
        <h2>Dump completo de la Request</h2>
        <?php dump(request()); ?>
    </section>
</main>


