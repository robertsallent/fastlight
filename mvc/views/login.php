<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>LogIn - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="LogIn en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= (TEMPLATE)::getCss() ?>
	</head>
	<body>
		<?= (TEMPLATE)::getLogin() ?>
		<?= (TEMPLATE)::getHeader('LogIn') ?>
		<?= (TEMPLATE)::getMenu() ?>
		<?= (TEMPLATE)::getBreadCrumbs(["LogIn" => "/Login"]) ?>
		<?= (TEMPLATE)::getFlashes() ?>
		
		
		<main>
	
    		<form class="w50 bloque-centrado" method="POST" autocomplete="off" id="login" action="/Login/enter">
    			
    			<h2>Acceso a la aplicación</h2>
				<p>Introduce tus datos en el formulario para identificarte.</p>
		
				<div style="margin: 10px;">
        			<label for="email">email:</label>
        			<input type="email" name="user" id="email" value="<?= old('user') ?>" required>
        			<br>
        			<label for="password">Password:</label>
        			<input type="password" name="password" id="password" required>
    			</div>
    			
    			<div class="centrado">
    				<input type="submit" class="button" name="login" value="LogIn">
    			</div>
    			<div class="derecha">
    				<a href="/Forgotpassword">Olvidé mi clave</a>
    			</div>
    			
    		</form>

    		
		</main>
		
		<?= (TEMPLATE)::getFooter() ?>
	</body>
</html>

