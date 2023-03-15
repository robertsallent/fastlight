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
		<link rel="shortcut icon" href="/images/template/smallLogo.png" type="image/png">	
		
		<!-- CSS -->
		<link rel="stylesheet" type="text/css" href="/css/estilo.css">
	</head>
	<body>
		<?= Template::getLogin() ?>
		<?= Template::getHeader('LogIn') ?>
		<?= Template::getMenu() ?>
		<?= Template::getMigas(["LogIn" => "/Login"]) ?>
		<?= Template::getSuccess() ?>
		<?= Template::getWarning() ?>
		<?= Template::getError() ?>
		
		<main>
			<section class="flex-container">
    			<div class="flex1"> </div>
        		<form class="flex2" method="POST" autocomplete="off" id="loginForm" action="/Login/enter">
        			
        			<h2>Acceso a la aplicación</h2>
    				<p>Introduce tus datos en el formulario para identificarte.</p>
    		
    				<div style="margin: 10px;">
            			<label for="email">email:</label>
            			<input type="email" name="user" id="email" required>
            			<br>
            			<label for="password">Password:</label>
            			<input type="password" name="password" id="password" required>
        			</div>
        			<div class="centrado">
        				<input type="submit" class="button" name="login" value="LogIn">
        			</div>
        		</form>
        		<div class="flex1"> </div>
    		</section>
    		
		</main>
		
		<?= Template::getFooter() ?>
	</body>
</html>

