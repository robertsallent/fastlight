<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
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
		<?= $template->header(null, 'Desarrollo rápido de aplicaciones web y APIs RESTFUL') ?>
		<?= $template->menu() ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1>Bienvenido</h1>

    		<section>
        		<h2>¿Qué es FastLight?</h2>
        		
        		<p><code><a href="https://github.com/robertsallent/fastlight">FastLight</a></code> es un <i>framework PHP</i> 
        			rápido y ligero para desarrollar <b>aplicaciones web</b> o <b>APIs RESTFUL</b>.</p>
        		
        		
    		   	<p>Está <b>pensado para docencia</b>, con lo que incorpora las 
    		   	 características  esenciales para desarrollo de una aplicación web rápida, sólida y fiable, pero no
    			  incluye algunas funcionalidades complejas que desarrollamos en clase (pero que encontraréis en la documentación). </p>
    			      		       
    		    <p>Su modo de empleo está inspirado en <code>Laravel</code> (aunque sus ancestros
    		       se inspiraban en <code>CodeIgniter</code>), lo que deriva en una transición muy sencilla
    		       desde <code>FastLight</code> hacia <code>Laravel</code>, <code>Symfony</code> u otros <i>frameworks</i> 
    		       MVC sobre <code>PHP</code>.</p>	 
    		       
    		    <p>Encontrarás más información en la documentación oficial y en los manuales, en 
    		    <a href="https://fastlight.org" target="_blank">https://fastlight.org</a>.</p>    
		    </section>
		    
		               
            <section class="warning">
		    	<h2>IMPORTANTE</h2>
		    	<p>En unos meses <b>se hará pública la documentación</b> sobre cómo implementar proyectos
		    	web completos haciendo uso de este framework. Estad atentos a mi 
 				<a href='https://www.linkedin.com/in/robert-sallent-l%C3%B3pez-4187a866'>LinkedIn</a>.</p>
		    </section>
		    
           <section class="flex1">
           		<h2>Requisitos</h2>
           		 
           		<p>Actualmente, <b>la versión <?= APP_VERSION ?> del framework</b> ha sido 
           		testeada en <b>PHP <?= MIN_PHP_VERSION ?></b> con <b>MySQL 8</b>.
           		Esto no quiere decir que no funcione en versiones ligeramente anteriores o posteriores,
           		pero no se garantiza que lo haga.</p>
           		
           		<?= "Actualmente este servidor dispone de <b>PHP ".phpversion().".</b>" ?>
           </section>

		</main>
		
		<!-- este mapa web solamente se muestra en pantallas grandes -->
		<nav class="web-map pc">  
		<h2>Links</h2>
		
    	<ul class="flex-container">   		
    		<li class="flex1"><a href="#">Recursos</a>
    			<ul>
	    			<li><a target="_blank" href="https://github.com/robertsallent/fastlight">GitHub</a></li>
	    			<li><a target="_blank" href="https://fastlight.org">Documentación oficial</a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="https://fastlight.org/Example#list">Maquetación</a>
    			<ul>
	    			<li><a target="_blank" href="https://fastlight.org/Example/botones">Buttons</a></li>
	    			<li><a target="_blank" href="https://fastlight.org/Example/formularios">Forms</a></li>
	    			<li><a target="_blank" href="https://fastlight.org/Example/modal">Modals</a></li>
	    			<li><a target="_blank" href="https://fastlight.org/Example/sliders">Sliders</a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="#">Ejemplos de clase</a>
    			<ul>
	    			<li><a target="_blank" href="https://larabikes.robertsallent.com">Larabikes <code>(Laravel)</code></a></li>
	    			<li><a target="_blank" href="https://symfofilms.robertsallent.com">SymfoFilms <code>(Symfony)</code></a></li>
	    			<li><a target="_blank" href="https://biblioteca.fastlight.org">Biblioteca <code>(FastLight)</code></a></li>
    			</ul>
    		</li>
    		
    		<li class="flex1"><a href="#">Otros proyectos</a>
    			<ul>
	    			<li><a target="_blank" href="https://juegayestudia.com">Juega y Estudia</a></li>
    			</ul>
    		</li>
    		
    		
    	</ul>
    </nav>
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

