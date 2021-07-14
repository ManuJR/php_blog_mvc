<nav class="navbar navbar-dark bg-dark">
   <a class="navbar-brand" href="/">Blog MVC en PHP</a>
   <ul class="nav justify-content-end">
		<?php if( !$session->isLogged() ){ ?>
			<li class="nav-item">
				<a href="/login" class=" btn btn-outline-light">Login</a>
			</li>
			<li class="nav-item">
				<a href="/signup" class="btn btn-primary">Registro</a>
			</li>
		<?php }else{ ?>

			<li class="nav-item">
				<span class=" btn btn-outline-light"> <?= $session -> getEmail() ?> </span>
			</li>
			<li class="nav-item">
				<form  action="/logout" method="POST" >
					<input class="btn btn-outline-light" type="submit" value="Logout">
				</form>
			</li>

		<?php } ?>
	</ul>
</nav>