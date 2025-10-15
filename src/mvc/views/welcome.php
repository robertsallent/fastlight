<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Portada del sitio",
                "Página de inicio del framework PHP FastLight"
        ) ?>           
        <?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/TextReader.js"></script>
		<script src="/js/Modal.js"></script>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Para desarrollo web y APIs RESTFUL') ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1>Bienvenido</h1>

    		<section id="queesfastlight"  class="flex-container gap2">
				<div class="flex2 readable" data-event="dblclick">
            		<h2>¿Qué es FastLight?</h2>
            		
            		<p>
            			<a href="https://github.com/robertsallent/fastlight">FastLight</a>
            			es un <b>framework PHP</b> rápido y ligero para desarrollar 
            			<b>aplicaciones web</b> y <b>APIs RESTFUL</b>.
            		</p>
            		
            		<p>Está <b>pensado para docencia</b>, con lo que incorpora las 
        		   	 características  esenciales para desarrollo de una aplicación web rápida, sólida y fiable, pero no
        			  incluye algunas funcionalidades complejas que desarrollamos en clase (pero que encontraréis en la documentación). </p>
        			      		       
        		    <p>Su modo de empleo está inspirado en <code>Laravel</code> (aunque sus ancestros
        		       se inspiraban en <code>CodeIgniter</code>), lo que deriva en una transición muy sencilla
        		       desde <code>FastLight</code> hacia <code>Laravel</code>, <code>Symfony</code> u otros <i>frameworks</i> 
        		       MVC sobre <code>PHP</code>.</p>	 
        		       
        		    <p>La documentación oficial y los manuales están disponibles en 
    		    </div>   
    		    
    		    <figure class="flex1 medium centered centered-block">
    		    	<img class="square fit with-modal" src="/images/template/phpmysql.png" 
    		    		 alt="FastLight recomienda PHP8.2 y MySQL8"
    		    		 title="FastLight recomienda PHP8.2 y MySQL8"
    		    		 data-caption="La combinación perfecta"
    		    		 data-description="Se recomienda PHP8.2 y MySQL8"
    		    	>
    		    </figure>
		    </section>
		    
		               
            <section class="warning">
		    	<h2>IMPORTANTE</h2>
		    	<p>Se está elaborando la <a href="https://fastlight.org/Backend">documentación Backend</a> (esto me llevará un tiempo) y en
		    	breve también se comenzarán a publicar los manuales en PDF con ejemplos prácticos.
		    	Lo encontraréis todo en <a href="https://fastlight.org">la documentación oficial de FastLight</a>. 
		    	</p>
		    	<p>Estad también atentos a mi 
 				<a href='https://www.linkedin.com/in/robert-sallent-l%C3%B3pez-4187a866'>LinkedIn</a> personal.</p>
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
		<nav class="web-map">  
			<h2>Links</h2>
			
			<ul class="flex-container">   		
				<li class="flex1"><a href="#">Recursos</a>
					<ul>
						<li><a target="_blank" href="https://github.com/robertsallent/fastlight">GitHub</a></li>
						<li><a target="_blank" href="https://fastlight.org">Documentación oficial</a></li>
					</ul>
				</li>
				
				<li class="flex1"><a href="https://fastlight.org/Example#list">Documentación</a>
					<ul>
						<li><a target="_blank" href="https://fastlight.org/Example">Frontend</a></li>
						<li><a target="_blank" href="https://fastlight.org/Backend">Backend</a></li>
						<li><a target="_blank" href="#">Manuales PDF (TODO)</a></li>
					</ul>
				</li>
				
				<li class="flex1"><a href="#">Ejemplos de clase</a>
					<ul>
						<li><a target="_blank" href="https://larabikes.robertsallent.com">Larabikes (Laravel)</a></li>
						<li><a target="_blank" href="https://symfofilms.robertsallent.com">SymfoFilms (Symfony)</a></li>
						<li><a target="_blank" href="https://biblioteca.fastlight.org">Biblioteca (FastLight)</a></li>
					</ul>
				</li>
				
				<li class="flex1"><a href="#">Otros proyectos</a>
					<ul>
						<li><a target="_blank" href="https://juegayestudia.com">Juega y Estudia</a></li>
						<li><a target="_blank" href="https://veinspercubelles.org">Veïns per Cubelles</a></li>
					</ul>
				</li>
			</ul>
		</nav>
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

