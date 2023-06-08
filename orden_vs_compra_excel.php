<?php

	session_start();
	
	$hoy = date("d-m-Y_hh_mm_ss");
	
	header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
	header("Content-Disposition: attachment; filename=orden_vs_compra_".$hoy.".xls");  
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: private",false);
	
  	include("conecta_facturacion.php");
  	date_default_timezone_set('America/Mexico_City');



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
    <?php //include("head.php");?>
  </head>
  <body>
	<?php
	//include("navbar.php");
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
            <h1>Orden Vs Compra</h1>
          </div>
          <div class="col-sm-6">Fecha y hora: <?php echo  date("d-m-Y H:m:s"); ?>          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <?php




$clave = $_GET['idorden'];

$consulta_orden= mysqli_query($cone,"SELECT a.id,a.id_proveedor,a.referencia, b.proveedor, b.calle, b.colonia, b.estado, a.fecha, a.fecha_entrega FROM `ordenes` a 
INNER JOIN proveedores b ON a.id_proveedor = b.id where a.id = '$clave'");

$re_orden = mysqli_fetch_array($consulta_orden);

$consulta = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where idorden = '$clave';");


    ?>


    <div class="card-header">
             
                <table width="100%" border="1">
  <tr>
    <td width="15%"><em><strong>Proveedor</strong></em></td>
    <td width="30%"><?php echo $re_orden[proveedor]; ?></td>
    <td width="18%"><em><strong>Referencia </strong></em></td>
    <td width="37%"><?php echo $re_orden[referencia]; $ref =$re_orden[referencia]; ?></td>
  </tr>
  <tr>
    <td><em><strong>Calle</strong></em></td>
    <td><?php echo $re_orden[calle]; ?></td>
    <td><em><strong>Colonia</strong></em></td>
    <td><?php echo $re_orden[colonia]; ?></td>
  </tr>
  <tr>
    <td><em><strong>Fecha Orden</strong></em></td>
    <td><?php echo $re_orden[fecha]; ?></td>
    <td><em><strong>Fecha Entrega</strong></em></td>
    <td><?php echo $re_orden[fecha_entrega]; ?></td>
  </tr>
</table>
            
<p></p>



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


<table width="100%" border="1">
  <tr>
    <td width="81%">&nbsp;</td>
    <td width="19%"><?php 
    
    
    $iva =  $suma - ($suma / 1.16);
    
    echo "Suma: $".number_format($suma,2); 
    echo "<br>";
    
    
    
    ?></td>
  </tr>
</table>

<?php

$consulta2 = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where idorden = '$clave';");

?>



<p>&nbsp;</p>
<table width="100%" border="1">
  <tr>
    <td width="10%" bgcolor="#999999"><em><strong>Clave</strong></em></td>
    <td width="50%" bgcolor="#999999"><em><strong>Descripcion</strong></em></td>
    <td width="15%" bgcolor="#999999"><em><strong>Cantidad inicial</strong></em></td>
    <td width="16%" bgcolor="#999999"><em><strong>Cantidad en Compra</strong></em></td>
    <td width="9%" align="center" bgcolor="#999999"><em><strong>Saldo</strong></em></td>
  </tr>
<?php


        while($re = mysqli_fetch_array($consulta2)){



?>  

  <tr>
    <td><?php echo $re[c_producto];?></td>
    <td><?php echo $re[descripcion];?></td>
    <td><?php echo $re[inicial];  $ini = $re[inicial]; ?></td>
    <td><?php
	
		$cod = $re[c_producto];
		
		$sum =0;
	
		$consulta_compra = mysqli_query($cone,"SELECT * FROM `detalle_fact_provee` WHERE `c_producto` LIKE '$cod'  and referencia = '$ref';");
		$compra = 0;
		
		while($re_compra=mysqli_fetch_array($consulta_compra)){
			
			$compra = $re_compra[cantidad];
			echo $compra;
			
			$sum = $compra + $sum;
			
			echo "/";
			
			
		}
    
	
	?></td>
    <td align="center"> <?php  echo  $sum - $ini; ?></td>
  </tr>
  
<?php

		}
?>
</table>
<p>&nbsp;</p>
<p></p>

<p></p>

<p></p>
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
