<?php

	session_start();

  include("conecta_facturacion.php");


  $usuario =  $_SESSION['user_id'];

  //echo $usuario;

  $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
  $re_consulta = mysqli_fetch_array($consulta_acceso);
  //echo "aqui".$re_consulta['empresas'];
  if($re_consulta[clientes] == '0' ) {   header("location: denegado.php");  }

  

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

 



	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Clientes ";
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






    <div class="card-header">
              
              </div>
	
	<main class="container">
  
  
  <div class="card-body">
  <?php

include("conecta_facturacion.php");
include("funciones_factura.php");


$ini = $_GET[txtinicio];
$fin = $_GET[txtfin];

$consulta = mysqli_query($cone,"SELECT * FROM `invoices` where fecha_emision >= '$ini' and fecha_emision <= '$fin' order by 1 desc;");

?>

<body>
<p>&nbsp;</p>
<h3>Reporte de Facturas de Fijaciones</h3>
<p>Periodo del <?php  echo $ini; ?> al <?php echo $fin; ?>   <a href="facturas_excel.php?txtinicio=<?php echo $ini; ?>&txtfin=<?php echo $fin; ?>"><img src="https://img.icons8.com/color/48/000000/export-excel.png"/></a> </p>
<table width="100%" border="1">
<tr>
  <td width="9%" bgcolor="#CCCCCC"><em><strong>No de Folio</strong></em></td>
  <td width="10%" bgcolor="#CCCCCC"><em><strong>Estatus</strong></em></td>
  <td width="28%" bgcolor="#CCCCCC"><em><strong>UUID</strong></em></td>
  <td width="10%" bgcolor="#CCCCCC"><em><strong>Fecha de Emision</strong></em></td>
  <td width="10%" bgcolor="#CCCCCC"><em><strong>Tipo de CFDI</strong></em></td>
  <td width="13%" bgcolor="#CCCCCC"><em><strong>Emisor</strong></em></td>
  <td width="12%" bgcolor="#CCCCCC"><em><strong>Receptor</strong></em></td>
  <td width="8%" bgcolor="#CCCCCC"><em><strong>Total</strong></em></td>
  <td width="8%" bgcolor="#CCCCCC"><em><strong>Pedimento</strong></em></td>
  <td width="8%" bgcolor="#CCCCCC"><em><strong>CFDI Relacionado</strong></em></td>
</tr>


  <?php
  
  
  
  while($re = mysqli_fetch_array($consulta)){
  
  
  ?>
<tr>
  <td><?php echo $re[id];?></td>
  <td><?php echo $re[estatus];?></td>
  <td><?php echo $re[uuid];?></td>
  <td><?php echo $re[fecha_emision];?></td>
  <td>
          <?php  
                  
                  $tipo = $re[tipo_cfdi]; 


                  if ($tipo == 'I' ) { echo "Ingreso"; }
                  if ($tipo == 'E' ) { echo "Egreso"; }
                  
                  
                  
                  ?>
  
  
  </td>
  <td><?php
                     $rece = $re['emisor'];

                  
                  $consulta_emisor = mysqli_query($cone,"select * from empresas where id = '$rece' ");
                  $re_emisor = mysqli_fetch_array($consulta_emisor);
                  echo  $re_emisor['empresa'];
                  
                  ?></td>
  <td><?php
  
     $rece = $re['receptor'];

                  $consulta_receptor = mysqli_query($cone,"select * from clientes where id_cliente = '$rece' ");
                  $re_receptor = mysqli_fetch_array($consulta_receptor);
                //   echo  $re_receptor['rfc']." ". $re_receptor['nombre_cliente'];
                  echo  $re_receptor['rfc'];
                   ?>
  
  
  </td>
  <td>
  
  <?php  
                  
                  
                  $tot_fac = saber_total_factura($re[id]) * 1.16; 

                  echo '$'.number_format($tot_fac,2)
                  
                  
                  ?>
  
  </td>
  <td><?php echo $re[pedimento];?></td>
  <td><?php echo $re[relacionado];?></td>
</tr>

<?php

  }

?>

</table>
     



  </div>
</div>





  

  
</main>


<!-- Agregar -->

<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Registro de Cliente Nuevo </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="clientes.php" method="get" >                 
<div class="row">




<div class="col-6">
RFC
  <input type="text" class="form-control" id="txtrfc" placeholder="RFC" name="txtrfc" required  >
	
</div>

<div class="col-6">
Nombre del Cliente
  
	
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
