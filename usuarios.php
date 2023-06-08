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


		$usuario =  $_SESSION['user_id'];

        include("conecta_facturacion.php");
    
        //echo $usuario;
        
        $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
        $re_consulta = mysqli_fetch_array($consulta_acceso);
        //echo "aqui".$re_consulta['configuracion'];
        if($re_consulta['usuarios'] == '0' ) {   header("location: denegado.php");  }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="active";	
	$title="Usuarios | Simple Invoice";
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
			include("modal/registro_usuarios.php");
			include("modal/editar_usuarios.php");
			include("modal/cambiar_password.php");
	?>
	
	<main class="container">
  
  
  
  
  <div class="card my-3">
  
  
  
<div class="d-flex card-header">
  <div class="p-0 flex-grow-1 ">
  <h5><i class="bi bi-search"></i> Buscar usuarios</h5>
  </div>
  
  <div class="p-0 "><button type='button' class="btn btn-info"  data-bs-toggle="modal" data-bs-target="#addModal" ><i class="bi bi-plus-circle" ></i> Nuevo Usuario</button></div>
</div>
  
  <div class="card-body">
  
 
  
  <form class="form-horizontal" role="form" id="datos_form" onsubmit="return false">
				
						<div class="form-group row">
							<label for="q" class="col-sm-2 control-label">Nombres</label>
							<div class="col-sm-6">
								<input type="text" class="form-control" id="q" placeholder="Nombres del usuario" onkeyup='load(1);'>
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
	<script src="assets/dist/js/usuarios.js"></script>
  </body>
</html>
