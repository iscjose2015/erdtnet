<?php

	include("conecta_facturacion.php");
	include("log.php");
	date_default_timezone_set('America/Mexico_City');

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
	$title="Facturas ";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php include("navbar2.php"); ?>

	<main class="container">

  		<div class="card my-3">
			<div class="d-flex card-header">
				<div class="p-0 flex-grow-1 ">
					<h5></h5>
				</div>
  				<div class="p-0 ">
  				</div>
			</div>
  
  			<div class="card-body">

				<table width="100%" border="0">
					<tr>
						<td width="2%">&nbsp;</td>
						<td width="98%" align="center">
							<h2>Seleccione la empresa a trabajar:</h2>
								<?php


                                    $use = $_SESSION['user_name'];
									agrega_log($use,"Entro al sistema a elegir empresa","Login-Selecciona Empresa");

									$consulta_modo = mysqli_query($cone,"SELECT * FROM `configuraciones`");
									$re_modo = mysqli_fetch_array($consulta_modo);

									if ($re_modo['modo'] == 'PRODUCTIVO') {

										$consulta_empresas = mysqli_query($cone,"select * from empresas  where id != 0 order by 2");

									}else{
										$consulta_empresas = mysqli_query($cone,"select * from empresas  where id = 0 order by 2");
									}
								?>

								<form id="form1" name="form1" method="post" action="principal.php"><!--https://172.18.10.77/ws/ws_kepler/todos.php-->
									<p>
										<label for="lblempresas"></label>
										<select name="lblempresas" id="lblempresas"  required="required">
											<option value="">--Seleccione una Empresa--</option>
											<?php
											while($re = mysqli_fetch_array($consulta_empresas)) { ?>
											<option value="<?php echo $re['id']; ?>"><?php echo $re['empresa']; ?></option>
											<?php } ?>
										</select>
									</p>
									<p>
										<!--input type="submit" name="button" id="idAcces" value="Entrar" /-->
										<button type="submit" name="insertar" id="newsolict" class="btn btn-primary">Entrar al sistema</button>
									</p>
								</form>
						</td>
  					</tr>
				</table>
			</div><!--card-body-->
		</div><!--card my-3-->
	</main><!--container-->
	<?php
	include("footer.php");
	?>
  </body>
</html>

