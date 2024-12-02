<main>

    <h1>Responses</h1>
    
    <section>
        <h2>Creando una nueva <code>Response</code></h2>
        
        <p>Creando una nueva respuesta HTML vacía.</p>
        <?php
            $response = new Response();  
            dump($response);
        ?>
        
        <p>Los objetos <code>Response</code> pueden ser enviados mediante el método 
        <code>send()</code>. Sin embargo, en la mayoría de los casos, no será necesario 
        ni crear expresamente el objeto <code>Response</code> ni ivocar al método para
        su envío, puesto que el propio framework construirá las respuestas adecuadas en 
        función del tipo de operación que estemos realizando.</p>
    </section>
       
    
    <section>
        <h2>Pruebas con la clase <code>JsonResponse</code></h2>
        
        <p>Creando una nueva respuesta <b>JSON</b> con un par de objetos genéricos.</p>
        <?php 
            $response = new JsonResponse([new stdclass(), new stdclass()]);
            dump($response);
        ?>
    </section>
    
    
    <section>
        <h2>Pruebas con la clase <code>APIResponse</code></h2>
        
        <p>Creando una nueva respuesta de <b>API Restful</b>.</p>
        <?php 
            $response = new APIResponse(
                [],   // data
                "Test de respuesta de la API",      // message
                "text/plain",                       // content-type
                200,                                // HTTP code
                "OK"                                // HTTP message
            );
            dump($response);
        ?>
    </section>
    
</main>

