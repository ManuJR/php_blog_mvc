<!DOCTYPE html>
<html>
<head>
	<title> Blog MVC en PHP </title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">

</head>
<body>
    <?php
	    require_once($_SERVER['DOCUMENT_ROOT']."/modules/navigator.php");
	?>
    <div id="main_content">
        Aquí vendrán los artículos de mi BLOG...

    </div>

    <!-- FOOTER -->
    <?php
	    require_once($_SERVER['DOCUMENT_ROOT']."/modules/footer.php");
	?>
</body>

</html>