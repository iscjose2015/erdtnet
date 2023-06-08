<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Facturas | Simple Invoice";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>

	<main class="container">
  
  
  
  
  <div class="card my-3">
  
  
  
<div class="d-flex card-header">
  <div class="p-0 flex-grow-1 ">
  <h5><i class="bi bi-search"></i> Buscar facturas</h5>
  </div>
  
  <div class="p-0 "><a href ="nueva_factura.php" class="btn btn-info"   ><i class="bi bi-plus-circle" ></i> Nueva Factura</a></div>
</div>
  
  <div class="card-body">
  
 
  
  <form class="form-horizontal" role="form" id="datos_form" onsubmit="return false">
				
						<div class="form-group row">
							<label for="q" class="col-sm-2 control-label">Cliente o # de factura</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="q" placeholder="Nombre del cliente o # de factura" onkeyup='load(1);'>
							</div>
							<div class="col-sm-4">
								<button type="button" class="btn btn-info" onclick='load(1);'>
									<i class="bi bi-search"></i>  Buscar</button>
								<span id="loader">
									<img src="img/ajax-loader.gif" id="cargador">
								</span>
							</div>
							
						</div>
				
				
				
			</form>
			
			
    <div id="resultados"></div><!-- Carga los datos ajax -->
	<div class='outer_div'></div><!-- Carga los datos ajax -->
  </div>
</div>


  

  
</main>
    
	
	<?php
	include("footer.php");
	?>
	<script src="assets/dist/js/facturas.js"></script>
  </body>
</html>
