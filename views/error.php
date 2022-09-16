<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Error  - <?=APP_TITLE?></title>
		<link rel="stylesheet" type="text/css" href="css/estilo.css">
	</head>
	<body>
		<h1>Error</h1>
		<?php include '../views/components/menu.php';?>
		
		<h2>Error en la operación solicitada</h2>

		<p class='error'><?=$mensaje?></p>
	</body>
</html>

