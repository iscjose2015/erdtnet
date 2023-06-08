<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php

	session_start();

  include("conecta_facturacion.php");

  

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }


        $usuario =  $_SESSION['user_id'];

        include("conecta_facturacion.php");
    
        //echo $usuario;



        if($_GET[opc] == 4){


          $_SESSION['factura_seleccionada'] = $_GET[fac];

        }

        
        $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
        $re_consulta = mysqli_fetch_array($consulta_acceso);
        //echo "aqui".$re_consulta['configuracion'];
        if($re_consulta['ordenes'] == '0' ) {   header("location: denegado.php");  }

        if($_GET[opc] == 1){

          if(!empty($_GET[txtreferencia])){
            
            $ref = $_GET[txtreferencia];
            $fe =  $_GET[txtfecha];
            $fee =  $_GET[txtfecha_entrega];
            $prov = $_GET[lblproveedores];
            $kep = $_GET['txtockepler'];


              $consulta_referencia = mysqli_query($cone,"select * from ordenes where referencia = '$ref'");
			  $tot_ref = mysqli_num_rows($consulta_referencia);
			  
			  
			  if ($tot_ref == 0){

            $inserta = mysqli_query($cone,"INSERT INTO `ordenes` (`id`, `fecha`, `id_proveedor`, `referencia`, `documento`, `fecha_entrega` , `no_orden_kepler`) 
            VALUES (NULL, '$fe', '$prov', '$ref', 'doc', '$fee', '$kep');");
			  }
			  else{
				  
				  echo "Validacion";
				  
				  
				      echo "<script>
					Swal.fire({
					  icon: 'error',
					  title: 'Ordenes',
					  text: 'El Numero de Refeencia ya existe en la base de datos',  
					  })
				</script>";
				  
				  
				  
			  }


          include("log.php");
          agrega_log($use,"Creo una orden de Compra: ".$ref,"Ordenes");



          //  header("location: ordenes.php");

          }


        }


        if($_GET[opc] == 3){

          if(!empty($_GET[txtempresa])){
            $emp = $_GET[txtempresa];
            $cod = $_GET[txtid];

            $inserta = mysqli_query($cone,"UPDATE `empresas` SET `empresa` = '$emp' WHERE `empresas`.`id` = '$cod';");

            header("location: base.php");

          }


        }
        


	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	

	$title="Ordenes";
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
<p>
    
  <!-- Font Awesome -->
  </p>
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">


  <table width="100%" border="0">
  <tr>
    <td width="24%" align="right">


    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>&nbsp;</h1>
            <p>&nbsp; </p>
            <p>&nbsp;</p>

          </div>
        </div>
      </div><!-- /.container-fluid -->

    </td>
    <td width="76%" valign="top"><p><strong><em>
    <h1>Ordenes de Compra
               <?php


           $sel = $_SESSION[seleccionada];

          $consulta_empresa = mysqli_query($con,"select * from empresas where nombre = '$sel'");
          $re_empre = mysqli_fetch_array($consulta_empresa);

          $imagen_empresa = $re_empre[logotipo];

          ?>


            <img src="<?php echo $imagen_empresa; ?>" width="122" height="55" /></h1>
    </em></strong>
      <p>Empresa activa:<?php echo $_SESSION[seleccionada]; ?></p>  
      <p><span class="card-title">Cargar Orden de compra <a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></span></p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>   <h3 class="card-title">&nbsp;</h3></td>
  </tr>
</table>

	
	<main class="container">
  
  
  <div class="card-body">


  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Fecha de la Orden</th>
                    <th>Referencia</th>
                    <th>Proveedor</th>
                    <th>Fecha Entrega</th>
                    <th>OC Kepler</th>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php




                    $consulta = mysqli_query($cone, "SELECT a.id,a.fecha,a.id_proveedor,a.referencia,a.documento,a.fecha_entrega, b.proveedor , a.no_orden_kepler, a.total
                    FROM `ordenes` a INNER JOIN proveedores b ON a.id_proveedor = b.id order by 1 desc");


                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td><?php echo $re['id']; ?></td>
                    <td><?php echo utf8_encode($re['fecha']); ?> </td>
                    <td><?php echo utf8_encode($re['referencia']); ?> </td>
                    <td><?php echo utf8_encode($re['proveedor']); ?> </td>
                    <td><?php echo utf8_encode($re['fecha_entrega']); ?> </td>

                    <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php // echo //$re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->
                    <td><?php echo utf8_encode($re['no_orden_kepler']); ?></td>
                    <td><a href="detalle_orden.php?idorden=<?php echo $re[id]; ?>">Detalle de la Orden</a></td>
                    <td><a href="sube_excel_orden.php?orden=<?php echo $re['id']; ?>&ref=<?php echo $re['referencia']?>"><img src="https://img.icons8.com/fluency/30/000000/microsoft-excel-2019.png"/>Sube Excel</a></td>
                    <td>$<?php echo $re['total']; ?></td>

                  </tr>



                   <!-- Modal de  edicion -->

                  <div class="modal fade" id="modal-edit_<?php echo $re['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Editar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="base.php" method="get" >

                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo" required value= "<?php echo $re['id']; ?>"  readonly="readonly" >
                    </div>
                    </div>



                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Empresa</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtempresa" placeholder="Codigo" name="txtempresa" required value= "<?php echo $re['empresa']; ?>"   >
                    </div>
                  </div>


          
                  
                  


                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />


                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      </div>

                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->


                <!-- Modal de Borrado -->

                <div class="modal fade" id="modal-borrar_<?php echo $re['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Baja de Empresa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="empresas.php" method="get" >

                   
                   <p><?php echo "Codigo: ".$re[id]; ?></p>
                   <p><?php echo "Descripcion: ".$re[empresa]; ?></p>
                   

                  <input name="opc" type="hidden" value="2" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />


                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar Baja</button>
                      </div>

                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->





                    <?php

                    }

                    ?>
                    
                  
                  
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Id</th>
                    <th>Fecha de la Orden</th>
                    <th>Referencia</th>
                    <th>Proveedor</th>
                    <th>Fecha Entrega</th>
                    <th>OC Kepler</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>




                 
  

  </div>
</div>

</main>


<!-- Agregar  -->


<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Nueva Orden</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="ordenes.php" method="get" >                 
<div class="row">

<div class="col-6">


<?php
$consulta_proveedor = mysqli_query($cone,"SELECT * FROM `proveedores` order by 2");

?>

Lista de Proveedores
  <label for="lblproveedores"></label>
  <select name="lblproveedores" id="lblproveedores" class="form-control">


  <?php


while($re_pro = mysqli_fetch_array($consulta_proveedor)){


  ?>
  <option value="<?php  echo $re_pro[id];?>"><?php  echo $re_pro[proveedor];?></option>

  <?php
}

?>
  </select>

  </div>


<div class="col-6">
Fecha
  <input type="date" class="form-control" id="txtfecha" placeholder="Fecha" name="txtfecha" value="<?php echo date("d-m-Y"); ?>"  >
	
</div>


<div class="col-4">
Fecha Entrega
  <input type="date" class="form-control" id="txtfecha_entrega" placeholder="Fecha" name="txtfecha_entrega" required  >
	
</div>


<div class="col-4">
Referencia
  <input type="text" class="form-control" id="txtreferencia" placeholder="Referencia" name="txtreferencia" required  >
	
</div>

<div class="col-4">
Orden de Compra Kepler
  <input type="text" class="form-control" id="txtock" placeholder="Orden De compra Kepler" name="txtockepler" required  >
	
</div>


<!--

  <div class="col-6">
  Correo <input type="text" class="form-control" id="txtcorreo" placeholder="Correo" name="txtcorreo" required  >
</div>


                  -->
  
<div class="col-sm-12 ">
  <!-- este es un espacio -->  
  </div>
               
        <p></p>         
             
	
               
	<div class="col-sm-3 "> 
    	<input type="hidden" name="opc" id="hiddenField" value="1" />
   </div>
   
   <div class="col-sm-12 ">
  <!-- este es un espacio -->  
  </div>
            

    <div class="col-sm-2 ">
              <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cerrar</button>
    </div>
    <div class="col-sm-8 ">
              
    </div>
    <div class="col-sm-2 ">
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
    </div>


     <!-- <a href="deposito.php" name="Submit" onclick="javascript:window.print()">
                        <button class="btn btn-success"> Imprimir </button>
                      </a> -->

</div>
</form>
</div>
</div>
</div>
</div>
</div>

    
	
	<?php
	//include("footer.php");
	?>
	<script src="assets/dist/js/clientes.js"></script>
  </body>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

</html>
