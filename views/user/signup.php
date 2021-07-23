<!DOCTYPE html>
<html>
<head>
	<title> Blog MVC en PHP </title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">

</head>
<body>


	<?php
	require_once($_SERVER['DOCUMENT_ROOT'].BASE_FOLDER."/modules/navigator.php");

	?>
	<div id="main_content">
		<div class="container-fluid page">
			<h1 class="text-center"> Regístrate en el Blog </h1>
			<div class="row justify-content-center">
				<div class="col-6">
					<form action="/signup" method="post">
						<div class="form-group">
							<label for="name">Nombre</label>
							<input type="text" class="form-control" id="name" name="name"> 
						</div>
						<div class="form-group">
							<label for="surname">Apellido</label>
							<input type="text" class="form-control" id="surname" name="surname"> 
						</div>
						<div class="form-group">
							<label for="email">Correo</label>
							<input type="email" class="form-control" id="email" name="email" >
							<small id="correoHelp" class="form-text text-muted">Debe introducir un correo con el formato nombre@algo.com</small>
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input type="password" class="form-control" id="password" name="password">
							<small id="correoHelp" class="form-text text-muted">La contraseña debe ser al menos de 6 caracteres</small>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary">
						</div>
					</form>
					<?php
						if( isset($error) && !empty($error) ){
							echo "<div class='alert alert-danger'> $error </div>";
						}
					?>
				</div>
			</div>
		</div>
	</div>
  		<!-- FOOTER -->
  	<?php
	require_once($_SERVER['DOCUMENT_ROOT'].BASE_FOLDER."/modules/footer.php");

	?>


</body>
</html>