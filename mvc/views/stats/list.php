    <!DOCTYPE html>
    <html lang="es">
    	<head>
    		<meta charset="UTF-8">
			<title>Estadísticas de visitas  - <?= APP_NAME ?></title>
		
    		<!-- META -->
    		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<meta name="description" content="Estadísticas de visitas<?= APP_NAME ?>">
    		<meta name="author" content="Robert Sallent">
    		
    		<!-- FAVICON -->
    		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
    		
    		<!-- CSS -->
    		<?= $template->css() ?>    		
    	</head>
    	<body>
    		<?= $template->login() ?>
    		<?= $template->header('Visitas') ?>
    		<?= $template->menu() ?>
    		<?= $template->breadCrumbs(["Visitas" => NULL]) ?>
    		<?= $template->messages() ?>
    		<?= $template->acceptCookies() ?>
    		
    		<main>
        		<h1><?= APP_NAME ?></h1>
        		
        		<?php if(SAVE_STATS){ ?>
        		
        		
            		<h2>Estadísticas</h2>
        			
        			<p>Utiliza el formulario de búsqueda para filtrar resultados. Las búsquedas 
        			   se mantendrán guardadas aunque cambies de página.</p>
        			   
        			<?php 
        			
        			// coloca el formulario de filtro
        			echo isset($filtro) ?
        			     $template->removeFilterForm($filtro):
        			     
        			     $template->filterForm(
            			     [
            			         'URL' => 'url',
            			         'Último usuario' => 'user',
            			         'Última IP' => 'ip',
            			     ],
            			     [
            			         'URL'    => 'url',
            			         'Cuenta' => 'count',
            			         'Primera visita'     => 'created_at',
            			         'Última visita'  => 'updated_at',
            			         'Último usuario' => 'user',
            			     ], 
            			     'URL',
            			     'Cuenta'
		            );

        			     
        			if($stats) { ?> 					

        				<div class="derecha">
        					<?= $paginator->stats()?>
        				</div>
            		           		         			
            			
            			<table class="table w100 drop-shadow">
                			<tr>
                				<th>URL</th>
                				<th>Visitas</th>
                				<th>Primera visita</th>
                				<th>Última visita</th>
                				<th>Último usuario</th>
                				<th>Última IP</th>
                			</tr>
                    		<?php foreach($stats as $stat){ ?>
                				<tr>
                    				<td class="url"><?= "<a href='$stat->url'>$stat->url</a>" ?></td>
                    				<td class='negrita'><?= $stat->count ?></td>
                    				
                    				<td><?= $stat->created_at ?></td>
                    				<td><?= $stat->updated_at ?? 'Sin datos' ?></td>
                    				<td><?= $stat->user ? "<a href='mailto:$stat->user'>$stat->user</a>" : 'Sin datos' ?></td>
                    				<td><?= $stat->ip ?? 'Sin datos' ?></td>
                			   </tr>
                    		<?php } ?>
                		</table>
                		
                		<?= $paginator->ellipsisLinks() ?>
            		
            			<div class="flex-container">
     						<div class="flex1">
        						<a class="button button-danger" href="/Stat/clear">Vaciar lista</a>
        					</div>
        					
        					<?= $template->exportForm('/Stat/export') ?>
        				</div>
            				
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

