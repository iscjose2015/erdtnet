<?php session_start(); 


$_SESSION['emisor'] = "";
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("libraries/password_compatibility_library.php");
}

// include the configs / constants for the database connection
require_once("config/db.php");

// load the login class
require_once("classes/Login.php");

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

// ... ask if we are logged in here:
if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
   header("location: facturas.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
	$title="CONI | Control de Inventarios";
    ?>

<!doctype html>
<html lang="es">
<head>

	<?php include("head.php");?>
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300i,400,700&display=swap" rel="stylesheet">
   	<link rel="stylesheet" href="assets/dist/css/login.css">
	

</head>

<body>
    <div class="row m-0 h-100">
        <div class="col p-0 text-center d-flex justify-content-center align-items-center display-none">
            <img src="img/logo.png" class="w-100">
        </div>
        <div class="col p-0 bg-custom d-flex justify-content-center align-items-center flex-column w-100">
				<h3>CONI  Sistema de Control de Inventarios</h3>
            <form method="post" accept-charset="utf-8" action="login.php" name="loginform" autocomplete="off" role="form" class="w-75">
			<?php
				// show potential errors / feedback (from login object)
				if (isset($login)) {
					if ($login->errors) {
						?>
						
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
						    <strong>Error!</strong> 
						
						<?php 
						foreach ($login->errors as $error) {
							echo $error;
						}
						?>
						
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>
						<?php
					}
					if ($login->messages) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						    <strong>Aviso!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $message;
						}
						?>
						
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div> 
						<?php 
					}
				}
				?>
				
				
                <div class="mb-3">
                    <label for="user_name" class="form-label">Usuario</label>
                    <input class="form-control" placeholder="Usuario" name="user_name" type="text" value="" autofocus="" required>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="form-label">Contraseña</label>
                    <input class="form-control" placeholder="Contraseña" name="user_password" type="password" value="" autocomplete="off" required>
                </div>
                
                <button type="submit" class="btn btn-custom btn-lg btn-block mt-3" name="login">Iniciar sesión</button>
            </form>
        </div>
    </div>
	<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

	<?php
}
