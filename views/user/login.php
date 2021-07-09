<!DOCTYPE html>
<html>
<head>
	<title> Login de Usuario </title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">

</head>
<body>

<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/modules/navigator.php");

	?>
	<div id="main_content">
	
		<div class="container-fluid page">
			<h1 class="text-center"> Entra en el Blog </h1>
			<div class="row justify-content-center">
				<div class="col-6">
					<form action="/login" method="post">
						<div class="form-group">
							<label for="email">Correo</label>
							<input type="email" class="form-control" id="email" name="email" >
						</div>
						<div class="form-group">
							<label for="password">Contraseña</label>
							<input type="password" class="form-control" id="password" name="password" >
						</div>
						<div class="form-group">
							<input type="submit"  id="login" class="btn btn-primary" value="Entra" >
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
	require_once($_SERVER['DOCUMENT_ROOT']."/modules/footer.php");
	?>
</body>
</html>