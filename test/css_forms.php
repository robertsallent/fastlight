<main>
    <h1>Test de CSS: formularios</h1>
    
    <p>En este ejemplo se prueba el CSS para los formularios, que se encuentra en el fichero
    <a href="/css/base.css">base.css</a>.</p>
    
    
    
    <h2>Ejemplos de formularios</h2>
    
 
    <h3>Formulario de Login</h3>
    
    <p>El formulario de login ya está implementado en el fichero <code>mvc/views/login.php</code>.
    Es similar al que se muestra</p>
    
    <form class="w50 centered-block" method="POST" autocomplete="off" id="login">
    	<h2>Acceso a <?= APP_NAME ?></h2>
    	<p>Introduce tus datos en el formulario para identificarte.</p>
    
    	<div class="m1">
    		<label for="email">email:</label>
    		<input type="email" name="user" id="email" required>
    		<br>
    		<label for="password">Password:</label>
    		<input type="password" name="password" id="password" required>
    	</div>
    	
    	<div class="centered">
    		<input type="submit" class="button" name="login" value="LogIn">
    	</div>
    	<div class="right">
    		<a href="#">Olvidé mi clave</a>
    	</div>
    	
    </form>
    
    <h3>Formulario para filtrar datos</h3>
    
    <p>El formulario de filtrado de datos ya está implementado en el fichero <code>templates/Base.php</code>.
    Es similar al que se muestra:</p>
    
    
    <form method='POST' id="filtro" class='derecha'>
    	<label>Buscar</label>
    	<input type='text' name='texto' placeholder='texto'>
		
		<label>en</label>
		<select name='campo'>
			<option value='titulo' selected>Título</option>
			<option value='editorial' >Editorial</option>
			<option value='autor' >Autor</option>
			<option value='isbn' >ISBN</option>
		</select>
		
		<label>ordenado por</label>
		<select name='campoOrden'>
			<option value='titulo' selected>Título</option>
			<option value='editorial' >Editorial</option>
			<option value='autor' >Autor</option>
			<option value='isbn' >ISBN</option>
			<option value='id' >ID</option>
		</select>
		
		<input type='radio' name='sentidoOrden' value='ASC'>
		<label>ascendente</label>
		<input type='radio' name='sentidoOrden' value='DESC' checked>
		<label>descendente</label>
		<input class='button' type='submit' name='filtrar' value='Filtrar'>
	</form>	
	
	
	<h3>Formulario con elementos de distintos tipos</h3>
    <p>En este ejemplo se muestra un formulario con muchos tipos de elementos distintos.
	En los formularios, podemos usar las clases <code>short</code>,
    <code>medium</code> o <code>large</code> para establecer las longitudes de las etiquetas
    y controles, aunque para las etiquetas no es necesario indicar nada.</p>
    
    <form method="POST" class="w75">
    	<h2>Registro de usuarios</h2>
    	<p>Por favor, rellena el formulario con tus datos.</p>
    	
   		<label>Nombre:</label>
		<input type="text" name="nombre" class="long">
		<br>
					
    	<label>Fecha:</label>
		<input type="date" name="nacimiento" class="short">
		<br>
		
		<label>Hora:</label>
		<input type="time" name="hora" class="short">
		<br>
		
		<label>Sitio web:</label>
		<input type="url" name="web" class="long">
		<br>
					
		<label>E-mail:</label>
		<input type="email" name="email" class="long">
		<br>
					
		<label>Hermanos:</label>
		<input type="number" name="hermanos" min="0" max="10" class="short">
		<br>
						
		<label>Televisores:</label> 
		<input type="range" name="points" min="0" max="10" step="1" value="5"
			   onchange="teles.innerHTML = this.value;" class="short">
		<span id="teles" style="font-weight: bold;">5</span>
		<br>
				
		<label>Foto de perfil:</label>
		<input type="file" class="medium">
		<br>
		
		<div class="centrado">
           <input type="submit" class="button" name="registro" value="Enviar">
           <input type="reset" class="button-light" value="Reset">
        </div>
    </form>
    
    <h3>Formulario con fieldsets en columnas</h3>
    
    
     <form method="POST">
    	<h2>Registro de usuarios</h2>
    	<p>Por favor, rellena el formulario con tus datos. Cada columna es un <code>fieldset</code> 
    	dentro de un contenedor de clase <code>flex-container</code>.</p>
    	
    	<div class="flex-container">
        	<fieldset class="flex1">
        		<legend>Datos de usuario</legend>
        		
           		<label>Nombre:</label>
        		<input type="text" name="nombre" class="long">
        		<br>
        		
        		<label>Sexo</label>
        		<select name="sexo" class="long">
        			<option value="H">Hombre</option>
        			<option value="M">Mujer</option>
        			<option value="N">No binario</option>
        		</select>
        		<br>
        				
            	<label>Fecha:</label>
        		<input type="date" name="nacimiento" class="short">
        		<br>
        		
        		<label>Hora:</label>
        		<input type="time" name="hora" class="short">
        		<br>
        		
        		<label>Sitio web:</label>
        		<input type="url" name="web" class="long">
        		<br>
			</fieldset>
			
			<fieldset class="flex1">
				<legend>Vehículos</legend>
           		
        		<input type="checkbox" name="coche" value="1">
        		<label>Coche</label>
        		<br>
        		<input type="checkbox" name="moto" value="1">
        		<label>Moto</label>
        		<br>
        		<input type="checkbox" name="bici" value="1">
        		<label>Bici</label>
        		<br>
        					       		
        		<label>Carné de conducir</label>
        		<input type="radio" name="carne" value="A">
        		<label>A</label>
        		<input type="radio" name="carne" value="B" checked>
        		<label>B</label>
        		<input type="radio" name="carne" value="C">
        		<label>C</label>
        		<br>
        		
        		<label>Marca:</label>
        		<input type="text" name="marca" class="long">
        		<br>
        		<label>Modelo:</label>
        		<input type="text" name="modelo" class="long">
        		<br>
			</fieldset>
			
		</div>			
		
		
		<div class="centrado">
           <input type="submit" class="button" name="registro" value="Enviar">
           <input type="reset" class="button-light" value="Reset">
        </div>
    </form>
    
    <h3>Formulario con previsualización de imagen</h3>
    <p>TODO.</p>
    
</main>