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

		include("conecta_facturacion.php");

		$usuario =  $_SESSION['user_id'];

		include("conecta_facturacion.php");

		//echo $usuario;
	  
		$consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
		$re_consulta = mysqli_fetch_array($consulta_acceso);
		//echo "aqui".$re_consulta['configuracion'];
		if($re_consulta['configuracion'] == '0' ) {   header("location: denegado.php");  }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="active";
	$active_clientes="";
	$active_usuarios="";	
	$title="Productos";
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
	<?php
			include("modal/registro_productos.php");
			include("modal/editar_productos.php");
	?>
	
	<main class="container">
  
  
  
  
  <div class="card my-3">
  
  
  
<div class="d-flex card-header">
  <div class="p-0 flex-grow-1 ">
  <h5><i class="bi bi-search"></i> Buscar Productos</h5>
  </div>
  
  <div class="p-0 "></div>
</div>
  
  <div class="card-body">
  
 
  
  <form class="form-horizontal" role="form" id="datos_form" onsubmit="return false">
				
						<div class="form-group row">
							<label for="q" class="col-sm-2 control-label">Código o nombre</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="q" placeholder="Código o nombre del producto" onkeyup='load(1);'>
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

	?>
	<script src="assets/dist/js/productos.js"></script>
  </body>
</html>
