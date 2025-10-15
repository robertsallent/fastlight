<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "Política de cookies",
                "Política de cookies e información sobre la privacidad"
        ) ?>           
        <?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/TextReader.js"></script>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Política de cookies') ?>
		<?= $template->breadCrumbs() ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1>Declaración de responsabilidad y política de cookies</h1>
    		
    		<section id="cookies" class="readable" data-event="dblclick">
    			<h2>Política de cookies</h2>

                <h3>¿Qué son las cookies?</h3>
                <p>
                    Las cookies son pequeños archivos de datos que se descargan en el dispositivo del usuario 
                    cuando visita una página web. Sirven para que el sitio web pueda funcionar correctamente o 
                    para recordar información sobre la navegación.
                </p>
                
                <h3>Tipos de cookies utilizadas en este sitio</h3>
                <p>
                    En esta web <strong>solo utilizamos cookies técnicas</strong> imprescindibles para 
                    el funcionamiento de la página. Estas cookies no requieren el consentimiento expreso del 
                    usuario según la normativa vigente (art. 22.2 LSSI-CE).
                </p>
                
                <div class="grid-list">
                    <div class="grid-list-header">
                        <span>Nombre</span>
                        <span class="span3">Finalidad</span>
                        <span>Tipo</span>
                        <span>Duración</span>
                        <span>Propietario</span>							
                    </div>
                
                    <div class="grid-list-item">
                        <span data-label="Nombre"><?= SESSION_NAME ?></span>
                        <span data-label="Finalidad" class="span3">Mantener la sesión del usuario activa durante la navegación en la web.</span>
                        <span data-label="Tipo">Técnica, de sesión</span>
                        <span data-label="Duración">Se elimina al cerrar el navegador</span>
                        <span data-label="Propietario">Propia</span>
                    </div>
                    
                    <?php if(ACCEPT_COOKIES){ ?>
                    <div class="grid-list-item">
                        <span data-label="Nombre">accept-cokies</span>
                        <span data-label="Finalidad" class="span3">Necesaria para saber que el usuario aceptó las cookies y 
                        	no volver a mostrar el cuadro de diálogo de aceptación.</span>
                        <span data-label="Tipo">Técnica, persistente</span>
                        <span data-label="Duración">Por defecto, una semana</span>
                        <span data-label="Propietario">Propia</span>
                    </div>
                    <?php }?>
                </div>
                
                <h3>Gestión de cookies</h3>
                <p>
                    El usuario puede configurar su navegador para bloquear o eliminar las cookies, 
                    aunque hacerlo puede afectar al correcto funcionamiento de la página.
                </p>
    			<ul>
					<li><a href="https://support.google.com/chrome/answer/95647?hl=ca" target="_blank">Google Chrome</a></li>
					<li><a href="https://support.mozilla.org/ca/kb/habilitar-i-deshabilitar-les-galetes-als-llocs-web" target="_blank">Mozilla Firefox</a></li>
					<li><a href="https://support.apple.com/ca-es/guide/safari/sfri11471/mac" target="_blank">Safari</a></li>
					<li><a href="https://support.microsoft.com/ca-es/help/4027947/microsoft-edge-delete-cookies" target="_blank">Microsoft Edge</a></li>
				</ul>
			</section>


			<div class="centrado my2">
    			<a class="button" onclick="history.back()">Volver</a>  
    		</div>
		    
		</main>    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

