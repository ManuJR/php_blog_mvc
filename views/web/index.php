<!DOCTYPE html>
<html>
<head>
	<title> Blog MVC en PHP </title>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<script src="/assets/js/functions.js"></script>
</head>
<body>
    <?php
	    require_once($_SERVER['DOCUMENT_ROOT']."/modules/navigator.php");
	?>
    <div id="main_content" class="d-flex flex-column">
		<?php if( $session -> isLogged() ){ ?>
			<div id="header_actions">
				<a href="/article/new" class="btn btn-success"> Nuevo artículo </a>
			</div>
		<?php } ?>
		<div id="articles_content" class="d-flex align-items-start">

			<?php
				// Articulos de la bbdd
				foreach ($articles as $article) {
					require($_SERVER['DOCUMENT_ROOT']."/modules/article/thumb.php");
				}
			?>
			
		</div>

	    <?=  $paginator -> element; ?>
    </div>

    <!-- FOOTER -->
    <?php
	    require_once($_SERVER['DOCUMENT_ROOT']."/modules/footer.php");
	?>
</body>

</html>