<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Portada - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>
	</head>
	<body>
		<?= (TEMPLATE)::getLogin() ?>
		<?= (TEMPLATE)::getHeader('Portada') ?>
		<?= (TEMPLATE)::getMenu() ?>
		<?= (TEMPLATE)::getFlashes() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Portada del sitio web</h2>
    		
    		<p><a href="https://github.com/robertsallent/fastlight">FastLight</a> es un framework 
    			rápido y ligero para desarrollar <b>aplicaciones web PHP</b> o <b>APIs RESTFUL</b>.</p>
    		
		   	<p>Está pensado expresamente para docencia, con 
		   	  lo que incorpora las características esenciales, pero no otras 
			  funcionalidades que desarrollamos en clase.</p>
		   	   
            <div class="flex-container">
            	<div class="flex1"> 
            		<h3>Lo que incorpora de serie:</h3>
                    <ul>
                    	<li>Patrón de diseño <b>MVC</b> con controlador frontal.</li>
                    	<li>Autoload mediante mapa de clases</li>
                    	<li>Gestión integrada de errores y herramientas de depuración.</li>
                    	<li>Motor de plantillas.</li>
                    	<li>Sistema para tests unitarios.</li>
                    	<li>Mecanismos de filtrado y paginación.</li>
                    	<li>Autenticación y autorización basada en roles.</li>
                    	<li>Protección CSRF para formularios y APIs.</li>
                    	<li>Herramientas para generación rápida de APIs.</li>
                    	<li>Multitud de librerías para las funcionalidades habituales.</li>
                    	<li>...</li>
                    </ul>
               </div>
               <div class="flex1"> 
               		<h3>Lo que se desarrolla en clase:</h3>
                    <ul>
                    	<li>Formulario de contacto con envío de email.</li>
                    	<li>Espacio personal (home).</li>
                    	<li>Registro y baja de usuario.</li>
                    	<li>...</li>
					</ul>

               		<h3>Lo que incoroprará en futuras versiones:</h3>
                    <ul>
                    	<li>Autoload basado en namespaces (PSR-4)</li>
                    	<li>API Keys</li>
                    	<li>Clase Response.</li>
                    	<li>Middleware.</li>
                    	<li>...</li>
					</ul>
               </div>
           </div>
		   	   
		   
		   	   
		   	<p>Ha sido desarrollado completamente desde cero por 
		   		<a href="https://robertsallent.com">Robert Sallent</a> y no tiene dependencias
		   	   con paquetes externos. Su funcionamiento se explica en detalle en los cursos de PHP y desarrollo web, 
		   	   que imparte desde 2010, en distintos <b>Centros de Innovación y Formación Ocupacional</b> (CIFO) 
		   	   de la província de Barcelona para la Generalitat de Catalunya.</p>
		   	   
	   	   <p>En la carpeta database hay el SQL para una pequeña
    		   base de datos de test. Contiene también el ejemplo de la 
    		   estructura para de tabla users y algunos usuarios de ejemplo.</p>
		   	   
		</main>
		<?= (TEMPLATE)::getFooter() ?>
	</body>
</html>

