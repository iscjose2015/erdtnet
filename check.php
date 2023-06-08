<?php

	session_start();

  include("conecta_facturacion.php");
  date_default_timezone_set('America/Mexico_City');


  
  function buscaProducto($cod,$ref){

    include("conecta_facturacion.php");

 
     $consulta = mysqli_query($cone,"SELECT cantidad FROM `detalle_fact_provee` WHERE `c_producto` LIKE '$cod' and referencia = '$ref'");
     $re = mysqli_fetch_array($consulta);


     $comprada = $re[cantidad];

    return $comprada;
  }




  
        if($_GET[opc] == 1){

            $cant = $_GET[txtcantidad];


  

      

        }


        if($_GET[opc] == 2){
			
			
			    $ref = $_GET['txtreferencia'];
          $id = $_GET['idorden'];

          $actualiza = mysqli_query($cone,"UPDATE `ordenes` SET `referencia` = '$ref' WHERE `ordenes`.`id` = '$id';");

          header("location: detalle_orden.php?idorden=".$id);

        }



        if($_GET[opc] == 3){

          /*

          if(!empty($_GET[txtempresa])){
            $emp = $_GET[txtempresa];
            $cod = $_GET[txtid];

            $inserta = mysqli_query($cone,"UPDATE `empresas` SET `empresa` = '$emp' WHERE `empresas`.`id` = '$cod';");

            header("location: base.php");

            */

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
  
  
  <style>
      .chica{
		  font-size:10px;  
	  }  </style>



<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Check Express</h1>
          </div>
          <div class="col-sm-6"> </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <?php




$clave = $_GET['idorden'];

$consulta_orden= mysqli_query($cone,"SELECT a.id,a.id_proveedor,a.referencia, b.proveedor, b.calle, b.colonia, b.estado, a.fecha, a.fecha_entrega, a.no_orden_kepler, a.documento FROM `ordenes` a 
INNER JOIN proveedores b ON a.id_proveedor = b.id where a.id = '$clave'");

$re_orden = mysqli_fetch_array($consulta_orden);

$consulta = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where idorden = '$clave';");


    ?>


    <div class="card-header">
      <form name="form3" method="get" action="detalle_orden.php">
      <table width="100%" border="1">
    <tr>
      <td width="15%">Proveedor</td>
      <td width="30%"><?php echo $re_orden[proveedor]; ?></td>
      <td width="18%">Referencia </td>
      <td width="37%"><label for="txtreferencia"></label>
        <input name="txtreferencia" type="text" id="txtreferencia" value="<?php echo $re_orden[referencia]; $refe =  $re_orden[referencia];  ?>" readonly></td>
    </tr>
    <tr>
      <td>Calle</td>
      <td><?php echo $re_orden[calle]; ?></td>
      <td>Colonia</td>
      <td><?php echo $re_orden[colonia]; ?></td>
    </tr>
    <tr>
      <td>Fecha Orden</td>
      <td><?php echo $re_orden[fecha]; ?></td>
      <td>Fecha Entrega</td>
      <td><?php echo $re_orden[fecha_entrega]; ?></td>
    </tr>
      </table>
  <p>
    <input type="hidden" name="opc" id="opc"  value="2">
        <input type="hidden" name="idorden" id="idorden" value="<?php echo $_GET[idorden]; ?>">
  </p>
  <p>Orden De Compra en Kepler: <?php echo $re_orden['no_orden_kepler']; ?></p>
      </form>
      <h3 class="card-title"></h3>

<!-- Agregar Producto<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a> -->
            
            
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <?php


$consulta2 = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where idorden = '$clave';");


$suma = 0;

while($re = mysqli_fetch_array($consulta2)){

  $importe = $re['monto'] * $re['cantidad']; 
  $suma = $importe  +  $suma;


}






?>


  <table width="100%" class="table table-bordered table-striped" id="example1">
                  <thead>
                  <tr>
                    <th>Cantidad Inicial</th>
                    <th>Unidad</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Cantidad Comprada</th>
                    <th>Saldo</th>
                    <th>&nbsp;</th>
                
                    <th>10 %</th>
                    <th>Salda</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php





                  

                   //echo "total:".mysqli_num_rows($consulta);


                   $suma = 0;

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td><?php echo number_format($re['inicial'],2); ?></td>
                    <td><?php echo utf8_encode($re['unidad']); ?> </td>
                    <td><?php echo utf8_encode($re['c_producto']); ?> </td>
                    <td><?php echo utf8_encode($re['descripcion']); ?> </td>
                    <td align="center"><?php  $compra = buscaProducto($re['c_producto'],$refe);  echo number_format($compra,2); ?></td>
                    <td align="center"><?php  $saldo = $re['inicial'] - $compra; echo number_format(abs($saldo),2); ?></td>
                    <td align="center">
                     <?php
					 
					  if ($saldo == 0 ){ echo "Completada"; }
					  if ($saldo > 0 ){ echo "Pendiente"; }
					  if ($saldo < 0 ){ echo "Excedida"; }

                $saca_10 = ($re['inicial'] * 0.1);

					 
					 ?>
                    
                    </td>

                   

                    <td align="center"><?php echo number_format($saca_10,2); ?></td>
                    <td>
                    
                    <?php
					
					  if ( $saldo <= $saca  and $saldo > 0) { echo "Aplica para salda"; }					
					?>
                    </td>
                   
                  </tr>



                 


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
                    <th>Cantidad Comprada</th>
                    <th>Saldo</th>
                    <th></th>
                    <th>10 %</th>
                    <th>Salda</th>
                    </tr>
                  </tfoot>
                </table>


                      <?php  echo "Suma de Importes: ".number_format($suma,2);
                      

                      $sum = number_format($suma,2);
                      
                      $actualiza = mysqli_query($cone,"UPDATE `ordenes` SET `total` = '$sum' WHERE `ordenes`.`id` = '$clave';")
                      
                      
                      ?>

                 
  

  </div>
</div>





  

  
</main>
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
