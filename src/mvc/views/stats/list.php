<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
            "Número de visitas",
            "Estadísticas de visitas para todas las URLs de la aplicación"
        ) ?>           
        <?= $template->css() ?>    		
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Estadísticas de visitas') ?>
 		
		<?= $template->breadCrumbs([
              "Panel de administrador" => "/Admin",
	          "Visitas" => NULL
	      ]);
	    ?>

		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		
    		<?php if(SAVE_STATS){ ?>
    		
        		<h2>Estadísticas</h2>

    			<?php 
    			
    			// coloca el formulario de filtro
    			echo $template->filter(
        			// opciones para el desplegable "buscar en"
        			[
            			'URL' => 'url',
            			'Último usuario' => 'user',
            			'Última IP' => 'ip',
        			],
        			
        			// opciones para el desplegable "ordenar por"
        			[
            			'URL'    => 'url',
            			'Cuenta' => 'count',
            			'Primera visita'     => 'created_at',
            			'Última visita'  => 'updated_at',
            			'Último usuario' => 'user',
        			],
        			'URL',    // opción seleccionada por defecto en "buscar en"
        			'Cuenta',  // opción seleccionada por defecto en "ordenar por"
        			$filtro  // filtro aplicado (null si no hay) - viene del controlador
    			);

    			     
    			if($stats) { ?> 					
    				<div class="right">
    					<?= $paginator->stats()?>
    				</div>
        		        
        		   <div class="grid-list">
                    		<div class="grid-list-header">
                                <span class="span3">URL</span>
                                <span>Visitas</span>
                                <span class="span2">Primera visita</span>
                                <span class="span2">Última visita</span>
                                <span class="span2">Último Usuario</span>
                              	<span class="span2">Última IP</span>
                    		</div>        		         			
        			
                      		<?php foreach($stats as $stat){ ?>
            				<div class="grid-list-item">
                				<span class="span3" data-label="URL"><?= "<a href='$stat->url'>$stat->url</a>" ?></span>
                				<span data-label="visitas"><?= $stat->count ?></span>
                   				<span class="span2" data-label="Primera visita"><?= $stat->created_at ?></span>
                				<span class="span2" data-label="Última visita"><?= $stat->updated_at ?? 'Sin datos' ?></span>
                				<span class="span2" data-label="Último usuario"><?= $stat->user ? "<a href='mailto:$stat->user'>$stat->user</a>" : 'Sin datos' ?></span>
                				<span class="span2" data-label="Última IP"><?= $stat->ip ?? 'Sin datos' ?></span>
            			   </div>
                		<?php } ?>
            		</div>
            		
            		<?= $paginator->ellipsisLinks() ?>
        		
  					
    				<section class="my2">
 						<h2>Operaciones</h2>
 						<p class="info">Pulsa el botón para vaciar el registro de visitas. 
 						Esta operación no se puede deshacer.</p>
 						<a class="button-danger" href="/Stat/clear">Vaciar lista</a>
    				</section>
    					
					<?= $template->exportForm('/Stat/export') ?>
    				
        				
        		<?php }else{ ?>
        			<div class="warning my2 p3 centrado">
        				<p>No hay estadísticas que mostrar.</p>
        			</div>
        		<?php } ?>            	
        	<?php } ?>
    			
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

