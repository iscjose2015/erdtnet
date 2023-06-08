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
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Nueva Factura | Simple Invoice";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
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
			include("modal/buscar_productos.php");
			include("modal/registro_clientes.php");
			include("modal/registro_productos.php");
		?>
		
		
	<main class="container">
  
  
  
  
  <div class="card my-3">
  
  
  
<div class="d-flex card-header">
  <div class="p-0 flex-grow-1 ">
  <h5><i class="bi bi-plus-circle"></i> Nueva Factura</h5>
  </div>
  
  
</div>
  
  <div class="card-body">
		<form class="form-horizontal" role="form" id="datos_factura">
			<div class="row">
				 <label for="nombre_cliente" class="col-lg-1 control-label">Cliente</label>
				  <div class="col-lg-3">
					  <input type="text" class="form-control input-sm" id="nombre_cliente" placeholder="Selecciona un cliente" required value="">
					  <input id="id_cliente" name="id_cliente" type='hidden' value="">	
				  </div>
				  <label for="tel1" class="col-lg-1 control-label">Teléfono</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" id="tel1" placeholder="Teléfono" value="" readonly>
							</div>
					<label for="mail" class="col-lg-1 control-label">Email</label>
							<div class="col-lg-4">
								<input type="text" class="form-control input-sm" id="mail" placeholder="Email" readonly value="">
							</div>
							
							
											
			</div>
			
			<div class="row my-2">
				<label for="empresa" class="col-lg-1 control-label">Vendedor</label>
							<div class="col-lg-3">
								<select class="form-control input-sm" id="id_vendedor" name="id_vendedor">
									<?php
										$sql_vendedor=mysqli_query($con,"select * from users order by lastname");
										while ($rw=mysqli_fetch_array($sql_vendedor)){
											$id_vendedor=$rw["user_id"];
											$nombre_vendedor=$rw["firstname"]." ".$rw["lastname"];
											
											?>
											<option value="<?php echo $id_vendedor?>"><?php echo $nombre_vendedor?></option>
											<?php
										}
									?>
								</select>
							</div>
							<label for="tel2" class="col-lg-1 control-label">Fecha</label>
							<div class="col-lg-2">
								<input type="text" class="form-control input-sm" id="fecha" value="<?php echo date("d/m/Y");?>" readonly>
							</div>
							<label for="email" class="col-lg-1 control-label">Pago</label>
							<div class="col-lg-2">
								<select class='form-control input-sm ' id="condiciones" name="condiciones">
									<option value="1" >Efectivo</option>
									<option value="2" >Cheque</option>
									<option value="3" >Transferencia bancaria</option>
									<option value="4" >Crédito</option>
								</select>
							</div>
							<div class="col-lg-2">
								<select class='form-control input-sm ' id="estado_factura" name="estado_factura">
									<option value="1" >Pagado</option>
									<option value="2" >Pendiente</option>
								</select>
							</div>
			</div>
			
			
			<div class="col-md-12">
					<div class="d-flex justify-content-md-end">
					
						<div class="btn-group" role="group" aria-label="Basic example">
						  
						  <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addModalProducto"><i class='bi bi-plus-circle-fill'></i> Nuevo producto</button>
						  <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#addModal"><i class='bi bi-person-fill'></i> Nuevo cliente</button>
						  <button type="button" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-outline-secondary"><i class='bi bi-search'></i> Agregar productos</button>
						  <button type="submit" class="btn btn-outline-secondary" ><i class='bi bi-printer-fill'></i> Imprimir</button>
						</div>



						
					</div>	
				</div>
				
				
		</form>
		
		<div class="clearfix"></div>
				<div id="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->	
			
				<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
				
    </div>
</div>


  

  
</main>
    
	
	<?php
	include("footer.php");
	?>
	<script src="assets/dist/js/autocomplete.js"></script>
	<script src="assets/dist/js/nueva_factura.js"></script>
	
	
  </body>
</html>


