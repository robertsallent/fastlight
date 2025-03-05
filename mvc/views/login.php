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
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('LogIn') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
                "LogIn" => null
    	    ]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<form class="w50 centered-block" method="POST" autocomplete="off" id="login" action="/Login/enter">
    			
    			<?= csrf() ?>
    			
    			<h2>Acceso a <?= APP_NAME ?></h2>
				<p>Introduce tus datos en el formulario para identificarte.</p>
		
				<div class="m1">
        			<label for="email">Email:</label>
        			<input type="email" name="user" id="email" value="<?= old('user') ?>" required>
        			<br>
        			<label for="password">Password:</label>
        			<input type="password" name="password" id="password" required>
    			</div>
    			
    			<div class="centered m2">
    				<input type="submit" class="button" name="login" value="LogIn">
    			</div>
    			<div class="right">
    				<a href="/Forgotpassword">Olvidé mi clave</a>
    			</div>
    			
    		</form>

    		
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

