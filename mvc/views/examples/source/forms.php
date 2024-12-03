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
    		<label for="email">Email:</label>
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
    	<h2 class="centrado">Registro de usuario</h2>

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
				
		<label>Imagen:</label>
		<input type="file" class="medium">
		<br>
		
		<label>Color favorito:</label>
		<input type="color" class="short" value="#ffffff">
		<br>
		
		<div class="centrado">
           <input type="submit" class="button" name="registro" value="Enviar">
           <input type="reset" class="button-light" value="Reset">
        </div>
    </form>
    
    <h3>Formulario con fieldsets en columnas</h3>
    
    <p>El formulario tiene en su interior un contenedor de clase <code>flex-container</code>
     y cada columna es un <code>fieldset</code> de clase
     <code>flex1</code> o <code>flex2</code>... según el ancho deseado.</p>
    
     <form method="POST">
    	<h2 class="centrado">Registro de usuario</h2>
    	<p>Por favor, rellena el formulario con tus datos.</p>
    	
    	<div class="flex-container">
        	<fieldset class="flex1">
        		<legend>Datos de usuario</legend>
        		
           		<label>Nombre:</label>
        		<input type="text" name="nombre" class="long">
        		<br>
        		
        		<label>Sexo:</label>
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
			</fieldset>
			
			<fieldset class="flex1">
				<legend>Vehículos</legend>
				
				<label class="short">Carné de conducir</label>
        		<input type="radio" name="carne" value="A">
        		<label>A</label>
        		<input type="radio" name="carne" value="B" checked>
        		<label>B</label>
        		<input type="radio" name="carne" value="C">
        		<label>C</label>
        		<br>
           		
        		<input type="checkbox" name="coche" value="1">
        		<label>Coche</label>
        		<br>
        		<input type="checkbox" name="moto" value="1">
        		<label>Moto</label>
        		<br>
        		<input type="checkbox" name="bici" value="1">
        		<label>Bici</label>
        		<br>
        					       		      			
        		<label>Marca:</label>
        		<input type="text" name="marca" class="long">
        		<br>
        		<label>Modelo:</label>
        		<input type="text" name="modelo" class="long">
			</fieldset>
			
		</div>			
		
		
		<div class="centrado">
           <input type="submit" class="button" name="registro" value="Enviar">
           <input type="reset" class="button-light" value="Reset">
        </div>
    </form>
    
    <h3>Formulario con previsualización de imagen</h3>
    <p>FastLight incorpora un pequeño script que nos permite realizar previsualizaciones
       de los ficheros de imagen que seleccionamos en los <code>inputs</code> de tipo <code>file</code>.
       Para usarlo, tan solo hay que añadir el fichero con 
       <code>&lt;script src="/js/preview.js"&gt;&lt;/script&gt;</code> y añadir las clases:</p>
       <ul>
       		<li><code>file-with-preview</code> al input de formulario.</li>
       		<li><code>preview-image</code> a la imagen.</li>
       </ul>
    
    
    <script src="/js/preview.js"></script>
    
    <form method="POST" enctype="multipart/form-data" class="w75">
    	<h2 class="centrado">Registro de usuario</h2>
    	<p>Por favor, rellena el formulario con tus datos. Observa que en la imagen
    	de la derecha se mostrará una previsualización del fichero elegido como foto de perfil.</p>
    	
    	<div class="flex-container">
        	<fieldset class="flex2">
        		<legend>Datos de usuario</legend>
        		
           		<label>Nombre:</label>
        		<input type="text" name="nombre" class="long">
        		<br>
        		
        		<label>Sexo:</label>
        		<select name="sexo" class="long">
        			<option value="H">Hombre</option>
        			<option value="M">Mujer</option>
        			<option value="N">No binario</option>
        		</select>
        		<br>
        				
            	<label>Fecha:</label>
        		<input type="date" name="nacimiento" class="short">
        		<br>
        		
        		<label>Imagen:</label>
        		<input type="file" accept="image/*" id="file-with-preview">
			</fieldset>
			
			<figure class="flex1 centrado">
    			<img src="/images/template/logo.png" id="preview-image" 
				     alt="Previsualización de la imagen de perfil">
			     <figcaption>Previsualización de la imagen de perfil</figcaption>
			</figure>    
			
		</div>			
		
		
		<div class="centrado">
           <input type="submit" class="button" name="registro" value="Enviar">
           <input type="reset" class="button-light" value="Reset">
        </div>
    </form>
    
    
    
</main>