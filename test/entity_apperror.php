<main>

	<h1>Test de la clase AppError</h1>
	
	<p>La clase <i>AppError</i> del modelo <b>implementa el CRUD de los errores que 
	se producen
	durante la ejecución de la aplicación</b>. Gracias a esta clase, se guardan
	los erres en BDD y se pueden listar o eliminar.</p>
	
	
	<section id="create">
		<h2>AppError::new()</h2>
		
		<p>El método estático <code>new()</code> de <i>AppError</i> crea el error y lo guarda en BDD. 
		<b>No lo invocaremos directamente</b>, ya lo hace automáticamente la gestión de errores y excepciones
		del propio framework.</p>
		
		<p>Para la prueba, guardaremos tres errores:</p>
		
		<pre>
			<code>
    AppError::new('NOTICE', 'Esto es un test');
    AppError::new('DEPRECATED', 'El penúltimo test');
    AppError::new('WARNING', "Esto '<b>es</b>\'texto\n&nbsp;&gt;&lt;especial.");
			</code>
		</pre>
		<?php
            AppError::new('NOTICE', 'Esto es un test');
            AppError::new('DEPRECATED', 'El penúltimo test');
            AppError::new('WARNING', "Esto '<b>es</b>\'texto\n&nbsp;&gt;&lt;especial.");
        ?>  
	</section>
  
  
  	<h2>Métodos heredados</h2>
  	
  	<p>Al tratarse de una clase del modelo, podemos usar cualquiera de los métodos
  		heredados de la clase <i>Model</i>.</p>
  		
  	<section>
  		<h3>Recuperando errores</h3>
  		
  		<p>Para recuperar los cuatro últimos errores:
  		<code>$lista = AppError::orderBy('date','DESC', 4)</code></p>
  		
  		<?php dump(AppError::orderBy('id','DESC', 4)) ?>
  		
  	</section>
  	
  	<section id="clearLast">
  		<h3>Borrando el último error</h3>
  		
  		<p>Elimina el último error de la 
  		base de datos usando el método heredado de <i>Model</i>: 
  		<code>AppError::clear(1)</code></p>
  		
  		<?= "<p>Se han borrado ".AppError::clear(1)." errores.</p>" ?>
  		
  		<p>Demostración mostrando los 4 últimos errores:</p>
  		
  		<?php dump(AppError::orderBy('id','DESC', 4)) ?>
  		
  	
  	</section>
  	
  	
  	<section id="clear">
  		<h2>Borrando todo</h2>
  		
  		<p>El método estático <code>clear()</code>, heredado de <i>Model</i>,
  		 elimina todos los registros de la BDD si no le pasamos el número
  		 de registros a borrar: <code>AppError::clear()</code></p>
  		
  		
  		<?= "<p>Se han borrado ".AppError::clear()." errores.</p>" ?>
  		
  		<p>Demostración mostrando los 4 últimos errores:</p>
  		
  		<?php dump(AppError::orderBy('id','DESC', 4)) ?>
  			
  	</section>

</main>
      
