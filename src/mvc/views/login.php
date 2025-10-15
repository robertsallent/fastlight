<!DOCTYPE html>
<html lang="<?= LANGUAGE_CODE ?>">
	<head>
		<?= $template->metaData(
                "LogIn",
                "Acceso a la apliación"
        ) ?>           
        <?= $template->css() ?>
	</head>
	
	<body>
		<?= $template->login() ?>
		<?= $template->menu() ?>
		<?= $template->header(null, 'Acceso a la aplicación') ?>
		<?= $template->breadCrumbs([
                "LogIn" => null
    	    ]) ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<form class="w50 centered-block my2" method="POST" autocomplete="off" id="login" action="/Login/enter">
    			
    			<?= csrf() ?>
    			
    			<h2 class="centered">Acceso a <?= APP_NAME ?></h2>
				<p class="info">Introduce tus datos para identificarte.</p>
		
				<div class="m1">
        			<label for="email">Email:</label>
        			<input class="long" type="email" name="user" id="email" value="<?= old('user') ?>" required>
        			<br>

					<script>
        				function showPassword(input){
        					input.type = input.type == 'password' ? 'text' : 'password';
        				}
        			</script>

        			<label for="password">Password:</label>
        			<div class="password-wrapper long">
        				<input class="long" type="password" name="password" id="password" required>
        				<a class="button" onclick="showPassword(this.previousElementSibling)">
            				<img src="/images/icons/view.png" alt="Mostrar password">
            			</a>
        			</div>
    			</div>
    			
    			<div class="centered m3">
    				<input type="submit" class="button" name="login" value="LogIn">
    			</div>
    			<div class="centered">
    				<a class="button-light" href="/Forgotpassword">Olvidé mi clave</a>
    			</div>
    			
    		</form>

	

    		
		</main>
		
		<?= $template->footer() ?>
		<?= $template->version() ?>
	</body>
</html>

