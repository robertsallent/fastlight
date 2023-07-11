<h1>Test del helper old()</h1>

<p>
El helper old() se encarga de rellenar los campos de 
formulario con los valores de la petición anterior flasheados en sesión.
</p>

<?php 
    $request = Request::take();
?>

<h2>Old Inputs en la Request</h2>
<p>Inputs flasheados en sesión y recuperados en la request actual:</p>
<?php 

    dump($request->previousInputs ?? NULL);
    
    // redireccionando tras el envio del formulario
    if(Request::take()->has('enviar')){
        redirect(Request::take()->url);
    }
?>

<h2>Formulario que recuerda los valores antiguos.</h2>

<p>
	Tras enviar el formulario se realizará una redirección, pero 
	verás que los valores se mantienen.
</p>

<form method="POST">
	<label>Nombre:</label>
	<input name="nombre" value="<?= old('nombre') ?>">
	<br>
	<label>Apellidos:</label>
	<input name="apellidos" value="<?= old('apellidos') ?>">
	<br>
	<label>Edad:</label>
	<input type="number" name="edad" value="<?= old('edad') ?>">
	<br>
	<input type="submit" name="enviar" value="Enviar" class="button">
</form>

<h2>Dump completo de la Request</h2>
<?php dump($request); ?>



