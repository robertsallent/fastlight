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
		   	   lo que no incorpora de serie las cosas que desarrollamos en clase como:</p>
		   	   <ul>
		   	   		<li>Autoload basado en namespaces (PSR-4)</li>
		   	   		<li>Formulario de contacto con envío de email.</li>
		   	   		<li>Espacio personal (home).</li>
		   	   		<li>Registro de usuarios.</li>
		   	   		<li>Baja de usuario.</li>
		   	   		<li>...</li>
		   	   </ul>
		   	   
		   	<p>Sí implementa los mecanismos necesarios para autenticación y autorización, además
		   	   de multitud de librerías útiles, templates, un estilo básico...</p>
		   	   
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

