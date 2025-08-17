<main>
	<h1>Test de la librería <code>Bag</code></h1>


	<section>
		<h2>Creando una bolsa</h2>
		<?php 
		      $bag = new Bag();
		      dump($bag);
		?>
		
		<p>Le añadimos algunas cosas con <code>push()</code>.</p>
		<?php 
    		  $bag->push("patatas");
    		  $bag->push("queso");
    		  $bag->push("tomates");
    		  $bag->push("pan");
    		  
    		  dump($bag);
		?>
		
		<p>Le quitamos la segunda con <code>extract()</code> y la última con <code>pop()</code>.</p>
		<?php 
    		  dump($bag->extract(1));
    		  dump($bag->pop());
        ?>
        
        <p>Añadimos ["lechuga", "atún"] con <code>addAll()</code>.</p>
        <?php 
              $bag->addAll(["lechuga", "atún"]);
        	  dump($bag);
		?>
		
		<p>Pasada a String:</p>
		<?= $bag ?>
		
	</section>
</main>

    
    
    