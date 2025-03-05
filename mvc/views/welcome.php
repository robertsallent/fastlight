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
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Portada') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs() ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>

    		<section>
        		<h2>Bienvenido!</h2>
        		
        		<p><code><a href="https://github.com/robertsallent/fastlight">FastLight</a></code> es un <i>framework PHP</i> 
        			rápido y ligero para desarrollar <b>aplicaciones web</b> o <b>APIs RESTFUL</b>.</p>
        		
        		
    		   	<p>Está <b>pensado para docencia</b>, con lo que incorpora las 
    		   	 características  esenciales para desarrollo de una aplicación web rápida, sólida y fiable, pero no
    			  incluye algunas funcionalidades complejas que desarrollamos en clase (pero que encontraréis en la documentación). </p>
    			  
    			<p>Todas las herramientas que incorpora han sido creadas expresamente para él, aunque 
    		       está basado en <i>frameworks</i> <code>PHP</code> anteriores que he ido implementando desde 2013, 
    		       cogiendo las ideas más interesantes en cada caso.</p>
    		       
    		    <p>Su modo de empleo está inspirado en <code>Laravel</code> (aunque sus ancestros
    		       se inspiraban en <code>CodeIgniter</code>), lo que deriva en una transición muy sencilla
    		       desde <code>FastLight</code> hacia <code>Laravel</code>, <code>Symfony</code> u otros <i>frameworks</i> 
    		       MVC sobre <code>PHP</code>.</p>	    
		    </section>
		    
		    
		    <section>
		    	<h2>Características</h2>
		    	
		    	<p>Como todo framework, dispone de herramientas para facilitar las tareas
		    	   necesarias para llevar a buen término un proyecto web, de forma rápida y 
		    	   organizada.</p>
		          	   
                <div class="flex-container">
                	<div class="flex1"> 
                		<h3>Lo que incorpora de serie:</h3>
                        <ul>
                        	<li>Patrón de diseño <b>MVC</b> con controlador frontal.</li>
                        	<li>Autoload mediante mapa de clases</li>
                        	<li>Gestión integrada de errores y herramientas de depuración.</li>
                        	<li>Motor de plantillas.</li>
                        	<li>Sistema para tests unitarios.</li>
                        	<li>Mecanismos de búsqueda y paginación de resultados.</li>
                        	<li>Autenticación y autorización basada en roles.</li>
                        	<li>Protección CSRF para formularios y APIs.</li>
                        	<li>Herramientas para generación rápida de APIs restful.</li>
                        	<li>Multitud de librerías para las funcionalidades habituales.</li>
                        	<li>...</li>
                        </ul>
                   </div>
                   <div class="flex1"> 
                   		<h3>Lo que se desarrolla en clase:</h3>
                        <ul>
                        	<li>Formulario de contacto con envío de email.</li>
                        	<li>Espacio personal (home).</li>
                        	<li>Operaciones de registro y baja de usuario.</li>
                        	<li>Gestión de usuarios y roles.</li>
                        	<li>Otras operaciones del administrador.</li>
                        	<li>Aplicaciones de gestión completas.</li>
                        	<li>...</li>
    					</ul>
    
                   		<h3>Lo que incoroprará en futuras versiones:</h3>
                        <ul>
                        	<li>API Keys</li>
                        	<li>Configuración de entorno <code>.env</code></li>
                        	<li>Middleware ?</li>
                        	<li>...</li>
    					</ul>
                   </div>
               </div>
           </section>
           
            <section class="warning">
		    	<h2>IMPORTANTE</h2>
		    	<p>En unos meses <b>se hará pública la documentación</b> sobre cómo implementar proyectos
		    	web completos haciendo uso de este framework. Estad atentos a mi 
 				<a href='https://www.linkedin.com/in/robert-sallent-l%C3%B3pez-4187a866'>LinkedIn</a>.</p>
		    </section>
		    
		   <div class="flex-container gap2 space-between"> 
               <section class="flex1">
               		<h2>Requisitos</h2>
               		<p>En docencia, trabajamos cada año	con las últimas versiones de 
               		<code>PHP</code>. En este sentido, el código del <i>framework</i> se va adaptando 
               		para funcionar en versiones nuevas, eliminando el soporte para las antiguas.</p>
               		 
               		<p>Actualmente, <b>la versión <?= APP_VERSION ?> del framework</b> ha sido 
               		testeada en <b>PHP <?= MIN_PHP_VERSION ?></b> con <b>MySQL 8 y MariaDB 10.4</b>.
               		Esto no quiere decir que no funcione en versiones ligeramente anteriores o posteriores,
               		pero no se garantiza que lo haga.</p>
               		
               		<?= "Actualmente este servidor dispone de <b>PHP ".phpversion().".</b>" ?>
               </section>
               
               <section class="flex1 gap2 space-between">
    		   	 	<h2>Consideraciones</h2>
        		   	<p>Ha sido desarrollado completamente desde cero por 
        		   		<a href="https://robertsallent.com">Robert Sallent</a> y no tiene dependencias
        		   	   con paquetes externos. Su funcionamiento se explica en detalle en los cursos de <a href="https://php.net">PHP</a> y desarrollo web, 
        		   	   que imparte desde 2010, en distintos <a href="https://serveiocupacio.gencat.cat/es/soc/com-ens-organitzem/centres-propis-formacio-cifo-cfpa/centres-dinnovacio-i-formacio-ocupacional-cifo/index.html">Centros de Innovación y Formación Ocupacional</a> (CIFO) 
        		   	   de la província de Barcelona para la Generalitat de Catalunya.</p>
        		   	   
        	   	   <p>En la carpeta <code>database_examples</code> se encuentra el SQL para una pequeña
            		   base de datos de test. Contiene también el ejemplo de la 
            		   estructura para de tabla users y algunos usuarios de ejemplo.</p>
        		   
    		   </section>
		   	</div>   
		</main>
		
		<!-- este mapa web solamente se muestra en pantallas grandes -->
		<nav class="web-map pc">  
		<h2>Links</h2>
		
    	<ul class="flex-container">   		
    		<li class="flex1"><a href="#">Recursos</a>
    			<ul>
	    			<li><a href="https://github.com/robertsallent/fastlight">GitHub</a></li>
	    			<li><a href="https://fastlight.org">Docs (TODO)</a></li>
	    			<li><a href="https://api.fastlight.org">API (TODO)</a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="/example">Maquetación</a>
    			<ul>
	    			<li><a href="/example/buttons">Buttons</a></li>
	    			<li><a href="/example/forms">Forms</a></li>
	    			<li><a href="/example/modals">Modals</a></li>
	    			<li><a href="/example">...</a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="#">Ejemplos de clase</a>
    			<ul>
	    			<li><a href="https://larabikes8.robertsallent.com">Larabikes <code>(Laravel)</code></a></li>
	    			<li><a href="https://symfofilms.robertsallent.com">SymfoFilms <code>(Symfony)</code></a></li>
	    			<li><a href="https://biblioteca.fastlight.org">Biblioteca <code>(FastLight)</code></a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="#">Otros proyectos</a>
    			<ul>
	    			<li><a href="https://juegayestudia.com">Juega y Estudia</a></li>
    			</ul>
    		</li>
    		
    		
    	</ul>
    </nav>
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

