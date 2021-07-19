<!doctype html>
<html lang="en">
  <head>
    <title> Perfil de usuario</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<meta charset="utf-8">
  </head>
  <body>
    <?php
    	require_once($_SERVER['DOCUMENT_ROOT']."/modules/navigator.php");
    ?>
    <div id="main_content" class="d-flex flex-column">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#"><i class="bi bi-person-fill"></i> Tu perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-pencil-fill"></i> Editar Perfil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="bi bi-folder-fill"></i> Tus Artículos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
        </ul>

    </div>



    <?php
	    require_once($_SERVER['DOCUMENT_ROOT']."/modules/footer.php");
	?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b1fb0d435a.js" crossorigin="anonymous"></script>

    

  </body>
</html>