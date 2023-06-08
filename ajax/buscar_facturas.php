<?php

	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id']) and $_GET['id']!=0){
		$numero_factura=intval($_GET['id']);
		$del1="delete from facturas where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_factura where numero_factura='".$numero_factura."'";
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible my-2" role="alert">
			
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible my-2" role="alert">
			
			  <strong>Error!</strong> No se puedo eliminar los datos
			  
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<?php
			
		}
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = "facturas, clientes, users";
		 $sWhere = "";
		 $sWhere.=" WHERE facturas.id_cliente=clientes.id_cliente and facturas.id_vendedor=users.user_id";
		if ( $_GET['q'] != "" )
		{
		$sWhere.= " and  (clientes.nombre_cliente like '%$q%' or facturas.numero_factura like '%$q%')";
			
		}
		
		$sWhere.=" order by facturas.id_factura desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturas.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive mt-2">
			  <table class="table">
				<tr  class="table-info">
					<th>#</th>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Vendedor</th>
					<th>Estado</th>
					<th class='text-end'>Total</th>
					<th class='text-end'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_factura=$row['id_factura'];
						$numero_factura=$row['numero_factura'];
						$fecha=date("d/m/Y", strtotime($row['fecha_factura']));
						$nombre_cliente=$row['nombre_cliente'];
						$telefono_cliente=$row['telefono_cliente'];
						$email_cliente=$row['email_cliente'];
						$nombre_vendedor=$row['firstname']." ".$row['lastname'];
						$estado_factura=$row['estado_factura'];
						if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];
					?>
					<tr>
						<td><?php echo $numero_factura; ?></td>
						<td><?php echo $fecha; ?></td>
						<td>
							<a href="#" data-bs-toggle="tooltip" data-bs-html="true" title="" data-bs-original-title="<i class='bi bi-telephone'></i> <?=$telefono_cliente?><br><i class='bi bi-envelope'></i> <?=$email_cliente;?>"><?php echo $nombre_cliente;?></a>
						</td>
						<td><?php echo $nombre_vendedor; ?></td>
						<td><span class="label <?php echo $label_class;?>"><?php echo $text_estado; ?></span></td>
						<td class='text-end'><?php echo number_format ($total_venta,2); ?></td>					
					<td class='text-end'>
								
					
					
						<div class="d-flex justify-content-md-end">
							<div class="btn-group" role="group" aria-label="Basic example">
								<a href="editar_factura.php?id_factura=<?php echo $id_factura;?>" class='btn btn-secondary' title='Editar factura' ><i class="bi bi-pencil"></i></a> 
								<a href="#" class='btn btn-secondary' title='Descargar factura' onclick="imprimir_factura('<?php echo $id_factura;?>');"><i class="bi bi-download"></i></a> 
								<a href="#" class='btn btn-danger' title='Borrar factura' onclick="eliminar('<?php echo $numero_factura; ?>')"><i class="bi bi-trash"></i> </a>
							</div>
						</div>
					
					
					</td>
						
					</tr>
					<?php
				}
				?>
				
			  </table>
			  
			  <div class="d-flex justify-content-md-end">
					
				<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?>
				</div>
			</div>
			<?php
		}
	}
?>