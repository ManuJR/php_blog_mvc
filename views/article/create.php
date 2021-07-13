<!DOCTYPE html>
<html>
<head>
	<title> Nuevo artículo </title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">

</head>
<body>

<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/modules/navigator.php");

	?>
	<div id="main_content">
	
		<div class="container-fluid page">
			<h1 class="text-center"> Nuevo artículo </h1>
			<div class="row justify-content-center">
				<div class="col-6">
					<form action="/article/create" method="post">
						<div class="form-group">
							<input type="text" class="form-control" id="title" name="title" placeholder="Título del artículo...">
						</div>
						<div class="form-group">				
							<textarea class="form-control" id="text" name="text" rows="6" placeholder="Escribe tu artículo..."></textarea>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Guardar" >
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