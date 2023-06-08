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
		if($re_consulta['configuracion'] == '0' ) {   header("location: denegado.php");  }
	  


	

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$active_perfil="active";	
	$title="Configuración | Simple Invoice";
	$query_empresa=mysqli_query($con,"select * from perfil where id_perfil=1");
	$row=mysqli_fetch_array($query_empresa);
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
  <h5><i class="bi bi-badge"></i> Configuración</h5>
  </div>
  
  
</div>
  
  <div class="card-body">
   <form method="post" id="actualizarDatos">
		<div class="row">
			  
                <div class="col-md-3 col-lg-3 " align="center"> 
				<div id="load_img">
					<img class="img-fluid" src="<?php echo $row['logo_url'];?>" alt="Logo">
					
				</div>
				<br>				
					<div class="row">
  						
						
						
						<div class="mb-3">
						  <label for="imagefile" class="form-label">Seleccionar logo</label>
						  <input class="form-control"  type="file"  name="imagefile" id="imagefile" onchange="upload_image();">
						</div>

						
					</div>
				</div>
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-condensed">
                    <tbody>
                      <tr>
                        <td class='col-md-3'>Nombre de la empresa:</td>
                        <td><input type="text" class="form-control input-sm" name="nombre_empresa" value="<?php echo $row['nombre_empresa']?>" required></td>
                      </tr>
                      <tr>
                        <td>Teléfono:</td>
                        <td><input type="text" class="form-control input-sm" name="telefono" value="<?php echo $row['telefono']?>" required></td>
                      </tr>
                      <tr>
                        <td>Correo electrónico:</td>
                        <td><input type="email" class="form-control input-sm" name="email" value="<?php echo $row['email']?>" ></td>
                      </tr>
					  <tr>
                        <td>IVA (%):</td>
                        <td><input type="text" class="form-control input-sm" required name="impuesto" value="<?php echo $row['impuesto']?>"></td>
                      </tr>
					  <tr>
                        <td>Simbolo de moneda:</td>
                        <td>
							<select class='form-control input-sm' name="moneda" required>
										<?php 
											$sql="select name, symbol from  currencies group by symbol order by name ";
											$query=mysqli_query($con,$sql);
											while($rw=mysqli_fetch_array($query)){
												$simbolo=$rw['symbol'];
												$moneda=$rw['name'];
												if ($row['moneda']==$simbolo){
													$selected="selected";
												} else {
													$selected="";
												}
												?>
												<option value="<?php echo $simbolo;?>" <?php echo $selected;?>><?php echo ($simbolo);?></option>
												<?php
											}
										?>
							</select>
						</td>
                      </tr>
					  <tr>
                        <td>Dirección:</td>
                        <td><input type="text" class="form-control input-sm" name="direccion" value="<?php echo $row["direccion"];?>" required></td>
                      </tr>
					  <tr>
                        <td>Ciudad:</td>
                        <td><input type="text" class="form-control input-sm" name="ciudad" value="<?php echo $row["ciudad"];?>" required></td>
                      </tr>
					  <tr>
                        <td>Región/Provincia:</td>
                        <td><input type="text" class="form-control input-sm" name="estado" value="<?php echo $row["estado"];?>"></td>
                      </tr>
					  <tr>
                        <td>Código postal:</td>
                        <td><input type="text" class="form-control input-sm" name="codigo_postal" value="<?php echo $row["codigo_postal"];?>"></td>
                      </tr>
                   
                        
                     
                    </tbody>
                  </table>
                  
                  
                </div>
				<div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->
              </div>
			  
			  
			 <div class="d-flex justify-content-center">
			 
				<button type="submit" class="btn btn-primary">Actualizar datos</button>
			 </div>
			  
				
			  
			 
  </form>
  
  </div>
  
  
					
</div>


  

  
</main>
    
	
	<?php
	//include("footer.php");
	?>
	<script>
		function actualizar_datos(event) {
			const data = new FormData(document.getElementById('actualizarDatos'));
			fetch('ajax/editar_perfil.php', {
			   method: 'POST',
			   body: data
			})
			.then(function(response) {
			   if(response.ok) {
				   return response.text()
			   } else {
				   throw "Error en la llamada Ajax";
			   }

			})
			.then(function(texto) {
			   document.getElementById("resultados_ajax").innerHTML = texto;
			   
			   
			})
			.catch(function(err) {
			   alert(err);
			});


		   event.preventDefault();
		}

		const formEdit = document.getElementById('actualizarDatos');
		formEdit.addEventListener('submit', actualizar_datos);
		
		
		function upload_image(){
				
				var inputFileImage = document.getElementById("imagefile");
				var file = inputFileImage.files[0];
				if( (typeof file === "object") && (file !== null) )
				{
					//$("#load_img").text('Cargando...');	
					var data = new FormData();
					data.append('imagefile',file);
					
					
					console.log(file);	
					
					fetch('ajax/imagen_ajax.php', {
					   method: 'POST',
					   body: data
					})
					.then(function(response) {
					   if(response.ok) {
						   return response.text()
					   } else {
						   throw "Error en la llamada Ajax";
					   }

					})
					.then(function(texto) {
					   document.getElementById("load_img").innerHTML = texto;
					   
					   
					})
					.catch(function(err) {
					   alert(err);
					});
			
			
				}
				
				
			}
			
		
	</script>
  </body>
</html>
