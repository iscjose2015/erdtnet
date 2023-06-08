<?php session_start();

    header('Access-Control-Allow-Origin: *');
    //header('Content-Type: application/json; charset=utf-8');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");

  include("conecta_facturacion.php");

      $usuario =  $_SESSION['user_id'];



      $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
      $re_consulta = mysqli_fetch_array($consulta_acceso);
      //echo "aqui".$re_consulta['empresas'];
      if($re_consulta[clientes] == '0' ) {   header("location: denegado.php");  }

      

      if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
            header("location: login.php");
        exit;
            }


        /* Connect To Database*/
        require_once ("config/db.php");         //Contiene las variables de configuracion para conectar a la base de datos
        require_once ("config/conexion.php"); //Contiene funcion que conecta a la base de datos
        
        $active_facturas="";
        $active_productos="";
        $active_clientes="active";
        $active_usuarios="";	
        $title="Kardex Individual";
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
            <h1>Kardex Individual</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <p><!--  <li class="breadcrumb-item"></li> -->
                <!--  <li class="breadcrumb-item active"></li> -->
              </p>
              <p>&nbsp;</p>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="card-header">
              
    </div>
	
	  <main class="container">
  
          
          <div class="card-body">
          
          
          <table width="100%" border="1">
	      <tr>
	        <td width="46%" valign="top"><p><strong>DATOS DEL PRODUCTO
            </strong></p>
	          <table width="90%" border="1">
              <tr>
                <td width="35%">Codigo del Producto</td>
                <td width="65%"><em><strong><?php echo $idprod = $_GET['cve'];?>
                <?php
				
				$query = mysqli_query($cone,"SELECT * FROM `products` WHERE `codigo_producto` LIKE '$idprod'");	
				$re = mysqli_fetch_array($query);		
				
				?>
                
                </strong></em></td>
              </tr>
              <tr>
                <td>Descripcion</td>
                <td><?php echo $re['nombre_producto']; ?></td>
              </tr>
              <tr>
                <td>Id familia</td>
                <td><?php echo $re['idfamilia']; ?></td>
              </tr>
              <tr>
                <td>Familia</td>
                <td><?php echo $re['familia']; ?></td>
              </tr>
              <tr>
                <td>Peso</td>
                <td><?php echo $re['peso']; ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
              
                       <?php    
					   
				/*
					   
					   
					   $url= "http://172.18.10.77/ws/ws_kepler/productos.php?codigo=1010003020";

$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  

$data = file_get_contents($url, false, stream_context_create($arrContextOptions));
					   
					   
					   
					   
					      
   
                                  $items = json_decode($data, true);
                                  $tot = count($items);
								  
								  echo "total".$tot;
                
                for ($k=0; $k <  $tot;  $k++){ 
                
                echo  $items[$k]['codproduct'];
				
				}
				
				
				*/
				
				?>
                
         


              
              
            <p>&nbsp;</p></td>
	        <td width="54%" align="center" valign="top"><p><strong>MOVIMIENTOS</strong></p>
	          <table width="100%" border="1">
              <tr>
                  <td width="33%"><em><strong>Ordenes de Compra</strong></em></td>
                  <td width="52%"><em><strong>Factura de Ingreso</strong></em><strong> / Facturacion</strong></td>
                  <td width="15%" align="center"><strong><em>Monto</em></strong></td>
                </tr>
                <tr>
                  <td><?php
			 
			 $consulta_ordenes = mysqli_query($cone,"SELECT * FROM `detalle_ordenes` WHERE `c_producto` LIKE '$idprod'");
			 
			 while($re_ord = mysqli_fetch_array($consulta_ordenes)){
				 
				 echo number_format($re_ord[inicial],2)." ".$re_ord[referencia];
				 echo "<br>";
				 
				 
				 
			 }
			 
			 
			 ?></td>
                  <td><?php
			 
			 $consulta_ingreso = mysqli_query($cone,"SELECT * FROM `detalle_fact_provee` WHERE `c_producto` LIKE '$idprod' ");
			 
			 
		
			 
			 while($re_pro = mysqli_fetch_array($consulta_ingreso)){
				 
				 echo number_format($re_pro[cantidad],2)." ".$re_pro[contenedor]." ".$re_pro[sucursal];
				 echo "<br>";
				 
				 
				 
			 }
			 
			 
			 ?></td>
                  <td align="right"><?php
			 
			 $consulta_ingreso = mysqli_query($cone,"SELECT * FROM `detalle_fact_provee` WHERE `c_producto` LIKE '$idprod' ");
			 
			 	 $contador = 0;
				 $suma = 0;
			 
			 while($re_pro = mysqli_fetch_array($consulta_ingreso)){
				 
				 echo number_format($re_pro[monto],3);
				 echo "<br>";
				 
				 $suma = $suma + $re_pro[monto];
				 
				 $contador ++;
				 
			 }
			 
			 
			 
			  $costo_promedio = $suma / $contador; 
			 
			 ?></td>
                </tr>
              </table>
              <p>&nbsp; </p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>&nbsp;</p>
              <p>COSTO PROMEDIO <?php echo $costo_promedio;  ?></p>
            
            
            </td>
	        </tr>
      </table>

          </div>



    </div>

  
    </main>


    <ol class="breadcrumb float-sm-right">
	    
  </ol>
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
