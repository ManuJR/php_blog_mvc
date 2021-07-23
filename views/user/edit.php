<!doctype html>
<html lang="en">
  <head>
    <title> Editar de usuario</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="/assets/css/style.css">
	<meta charset="utf-8">
  </head>
  <body>
    <?php
    	require_once($_SERVER['DOCUMENT_ROOT'].BASE_FOLDER."/modules/navigator.php");
    ?>
    <div id="main_content" class="d-flex flex-column">
        <?php
            require_once($_SERVER['DOCUMENT_ROOT'].BASE_FOLDER."/modules/nav_user.php");
        ?>
        <form class="profile_user edit" action="/profile/edit" method="post" enctype="multipart/form-data">

            <div class="column left">
                <div class="input_img_profile">
                    <input type="file" id="profile_img" name="profile_img">
                    <img src=" <?=  BASE_FOLDER.$user->getSrcImg() ?>" alt="" >
                </div>
                <p class="created_date">
                    <b>Fecha de creación:</b>  <?= $user->created_at ?>
                </p>
            </div>
            <div class="column right">
                <h1> <?= $user->getFullName() ?> </h1>

                

                <div class="form-group">
                    <input type="text" class="form-control" id="name" name="name"  value="<?= $user -> name ?>">
                </div>
                <div class="form-group">				
                    <input class="form-control" id="surname" name="surname" value="<?= $user -> surname ?>">
                </div>
                <div class="form-group">
                    
                    <input type="submit" class="btn btn-primary" value="Guardar" >
                </div>
            </div>
        </form>
        <div class="profile_user secondary_actions">
            <div class="column left">
            </div>
            <div class="column right">
                <form class="form-group" action="/profile/changeEmail" method="POST" >
                        <input type="email" class="form-control" id="email" name="email"  value="<?= $user -> email ?>">
                        <input type="submit" class="btn btn-primary" value="Cambiar Email" >
                </form>

                <form class="form-group" action="/profile/changePassword" method="POST">
                        <input type="password" class="form-control" id="password" name="password"  value="">
                        <input type="submit" class="btn btn-primary" value="Cambiar Contraseña" >
                </form>
            </div>
        </div>
    </div>





    <?php
	    require_once($_SERVER['DOCUMENT_ROOT'].BASE_FOLDER."/modules/footer.php");
	?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/b1fb0d435a.js" crossorigin="anonymous"></script>

    

  </body>
</html>