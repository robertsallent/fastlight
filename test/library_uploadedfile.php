
<h1>Test de UploadedFile</h1>

<form method="POST" enctype="multipart/form-data">
	<input type="file" name="fichero">
	<input type="submit" value="enviar">
</form>
<br>

<?php

$request = Request::create();

if($file = $request->file('fichero')){
    
    echo "<h2>Comprobando lo que llega</h2>";
    echo "<p>Ha llegado:</p>";
    dump($file);
    
    echo "<h2>Validando el fichero subido</h2>";
    echo "<p>Mostrando errores si no es texto menor de 10Kb:</p>";
    echo arrayToString($file->errors(10000, 'text/plain'));
    
    echo "<h2>Moviendo el fichero.</h2>";
    
    if(!$file->errors(50000, 'image/*')){
        /*
        echo "<p>Moviendo a /tmp con el nombre original.</p>";
        echo $file->storeAs('../tmp', NULL, true);
       
        echo "<p>Moviendo a /tmp con el nombre 'patata.png'.</p>";
        echo $file->storeAs('../tmp', 'patata.png', true);
        */
        
        echo "<p>Moviendo a /tmp con un nombre generado.</p>";
        echo $file->store('../tmp', 'img_', true);
        
        
        echo "<p>Tras guardarlo queda como:</p>";
        dump($file);
    }
    
}else{
    echo "<p>Por favor adjunta un fichero.</p>";
}
    