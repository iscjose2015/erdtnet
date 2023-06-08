
<?php


	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");
  
  date_default_timezone_set('America/Mexico_City');


  $_SESSION[idfactura] = $_GET[idorden];

//  $_SESSION[idfactura];


  
  


        if($_GET[opc] == 3){
              $bor = $_GET[txtid];
             // echo "entro aqui".$bor;

              $borra = mysqli_query($cone,"DELETE FROM detalle_fact_provee WHERE `detalle_fact_provee`.`id` = '$bor'");
            //  header('location: detalle_fact_reg.php?idorden='.$_GET[idorden]);
          ?>
              <script>
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Your work has been saved',
              showConfirmButton: false,
              timer: 1500
            })

            </script>


<?php




        }


        
        


	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Detalle de Orden de Compra";
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


  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">



<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalle de la Factura de Compra</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              <li class="breadcrumb-item active"></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <?php




$clave = $_GET['idorden'];

$consulta_orden= mysqli_query($cone,"SELECT * FROM `facturas_prov` a INNER JOIN proveedores b 
ON a.id_provee = b.id where `id_factura` = '$clave'");
$re_orden = mysqli_fetch_array($consulta_orden);

$consulta = mysqli_query($cone, "SELECT * FROM `detalle_invoices` where idorden = '$clave';");


$emi = $re_orden['emisor'];
$rece = $re_orden['receptor'];


$consulta_emisor = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emi'");
$consulta_receptor = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente = '$rece'");

$re_emisor   = mysqli_fetch_array($consulta_emisor);
$re_receptor = mysqli_fetch_array($consulta_receptor);

    ?>


    <div class="card-header">




<table width="100%" border="1">
  <tr>
    <td width="25%">Fecha de Factura</td>
    <td width="26%"><?php echo $re_orden[fecha_factura]; ?></td>
    <td width="16%"></td>
    <td width="33%"></td>
  </tr>
  <tr>
    <td>Proveedor</td>
    <td><?php echo $re_orden[proveedor]; ?></td>
    <td></td>
    <td></td>
  </tr>
 
  <tr>
    <td>No Factura</td>
    <td><?php echo $re_orden[numero_factura];  $_SESSION[facturaCompra] = $re_orden[numero_factura]; ?></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td><</td>
  </tr>
</table>



            
            
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <?php









?>


      <a href="sube_excel_compra.php"> Subir Excel <img src="https://img.icons8.com/fluency/48/null/microsoft-excel-2019.png"/> </a>
     <!-- <a href="ordenes.php?opc=4&fac=<?php //echo $_GET[idorden] ?>"><img src="https://img.icons8.com/ios/50/000000/add-list.png"/> Extraer datos de orden de compra -->




  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Referencia</th>
                    <th>Cantidad</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Precio Compra </th>
                    <th>Precio Factura</th>
                    <th>Contenedor </th>
                    <th>Sucursal</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php


                    $fa = $re_orden[referencia]; 

                    $cve = $_GET['idorden'];

                  $consulta_detalle = mysqli_query($cone,"SELECT * FROM `detalle_fact_provee` WHERE `idfactura` = '$cve'");
                  

                   //echo "total:".mysqli_num_rows($consulta);


                   $total = 0;

                    while($red = mysqli_fetch_array($consulta_detalle)){

                    ?>
                  
                  <tr>
                    <td><a href="check.php?idorden=<?php 
					
					 $ref = $red['referencia'];
					 
					 $consulta_orden = mysqli_query($cone,"SELECT * FROM `ordenes` where referencia = '$ref';");
					 $re_orden = mysqli_fetch_array($consulta_orden);
					 
					 echo $re_orden[id];
					
					
					
					?>"><?php echo $red['referencia']; ?></a></td>
                    <td><?php echo utf8_encode($red['cantidad']); ?> </td>
                    <td><?php echo utf8_encode($red['c_producto']); ?> </td>
                    <td><?php echo utf8_encode($red['descripcion']); ?> </td>
                    <td>$<?php echo number_format($red['monto'],3, ".", ""); ?></td>
                    <td>$<?php echo number_format($red['factor'],3, ".", ""); ?></td>
                    <td><?php echo $red[contenedor]; ?></td>
                    <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php // echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->
                    <td><?php echo $red[sucursal]; ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#modal-borrar_<?php echo $red['id']; ?>"><img src="https://img.icons8.com/metro/24/A83339/trash.png"/></a></td>
                   
                       <?php  $total = $total + ($red[cantidad] * $red[factor]); ?>


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
                    
         


                  <form   id="form2" name="form2" action="detalle_orden.php" method="get" >

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
                  <input name="idorden" type="hidden" value="<?php echo $_GET[idorden] ?>" />


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

                <div class="modal fade" id="modal-borrar_<?php echo $red['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Borrar Productos</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="detalle_fact_reg.php" method="get" >

                   
                   <p><?php echo "Clave: ".$red[id]; ?></p>
                   <p><?php echo "Cod Prod: ".$red[c_producto]; ?></p>
                   <p><?php echo "Descripcion: ".$red[descripcion]; ?></p>
                   

                  <input name="opc" type="hidden" value="3" />
                  <input name="idorden" type="hidden" value="<?php echo $_GET[idorden]; ?>" />
                  <input name="txtid" type="hidden"   value="<?php echo $red[id];; ?>" />
              


                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar Borrado</button>
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
                  <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Monto</th>
                    <th>Precio Factura</th>
                    <th>Contenedor</th>
                    <th>Sucursal</th>
                  </tr>
                  </tfoot>
                </table>




                 
  

  </div>
</div>





  

  
</main>
	<table width="634" border="1" align="center">
	  <tr>
	    <td width="374">&nbsp;</td>
	    <td width="117">Total de Factura: </td>
	    <td width="121"><?php  echo number_format($total,3); ?></td>
                  </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
      </tr>
  </table>
	<p>
	  <?php
	//include("footer.php");




	?>
	  
	  
	  
	  
	  <script src="assets/dist/js/clientes.js"></script>
  </p>
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
