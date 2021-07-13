<!DOCTYPE html>
<html>
<head>
	<title> Blog de PHP </title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<meta charset="utf-8">

</head>
<body>
<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/modules/navigator.php");

	?>

	<!-- POST -->
	<div id="post" class="container page">
		<div class="row flex-column justify-content-center">
			<span><?= $article -> created_at ?></span>
			<img src="/assets/imgs/blog_default.png">
		</div>

			<h1><?= $article -> title ?></h1>
			<div class="body_post">
				<p><?= $article -> text ?></p>
			</div>
		<div class="row justify-content-end">
			<div class="col-6">
				Autor: <?= $article -> user_id ?>
			</div>
			
		</div>
	</div>

	<!-- FOOTER -->
	<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/modules/footer.php");

	?>
</body>
</html>