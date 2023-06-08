<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php

	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");


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




        if($_GET[opc] == 3){

            $cod =  $_GET[txtid];
            $cost = $_GET[txtcosto];
            $pre =  $_GET[txtprecio];
            $cant =  $_GET[txtcantidad];
 


           // echo $cost.$pre;

            $actualiza = mysqli_query($cone,"UPDATE `products` SET `costo` = '$cost', `precio` = '$pre'
             WHERE `products`.`codigo_producto` = '$cod';");

          //  header("location: productos.php");


           //
        }



        if($_GET['opc'] == 5){

      
           

          $valor = $_GET[txtvalor];
          $busca = mysqli_query($cone,"SELECT * FROM `products` where codigo_producto = '$valor';");

          $tot = mysqli_num_rows($busca);

          if ($tot == 1){
          $re_busca = mysqli_fetch_array($busca);
		  
		  $bandera = 1; 
          }
          else{
			  
			  echo ".";

            echo "<script>
            Swal.fire({
              icon: 'error',
              title: 'Productos Facturacion',
              text: 'No se encontrardo ese producto !',  
              })
        </script>"; 
		
		$bandera = 0;


          }


          $prod =  $re_busca[nombre_producto];
          
        }


        if($_GET['opc'] == 6){
			
			echo ".";
			
			  $val = $_GET[txtvalor];
      		$cant = $_GET[txtcantidad];
	    	$pre = $_GET[txtprecio];
		
		 	$import = $cant * $pre;
			

			
			
			$consulta_producto_venta = mysqli_query($cone,"SELECT * FROM `products` where codigo_producto = '$val';");
            $re_pro = mysqli_fetch_array($consulta_producto_venta);

            $des = $re_pro[nombre_producto];
            $uni = $re_pro[unidad];
            $codi_sat = $re_pro[id_sat];
            $uni_sat = $re_pro[unidad];
            $factu = $_GET[fac];

			echo $uni_sat;
			
			$factu = $_GET[fac];
			
			
			$inserta = mysqli_query($cone,"INSERT INTO `detalle_invoices` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`, `monto`, `unidad`, `idfactura`, `importe`, `unidad_sat`, `codigo_sat`) 
      VALUES (NULL, '0', '$val', '$des', '$cant', '$pre', '$uni', '$factu', '$import', '$uni_sat', '$codi_sat');");


             			echo "Valor: ".$val;

          echo "<script>
          Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'El Producto se ha agregado a la factura',
            showConfirmButton: false,
            timer: 1500
          })
      </script>"; 
	  
	 




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
  
  
  <script>
function setFocusToTextBox(){
    document.getElementById("txtvalor").focus();
}
</script>
  
  <body on>
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
          <div class="col-sm-12">
            <table width="100%" border="0" align="center">
              <tr>
                <td align="left"><h1>&nbsp;</h1>
                  <table width="100%" border="0">
                    <tr>
                      <td width="82%"><strong>
                      <em>
                      <h3>
                      Agregar Producto a la factura </em></strong>                        <h3> </td>
                      <td width="18%"><a href="detalle_invoices.php?idorden=<?php echo $_GET[fac];  ?>&serie=<?php echo $_GET[fac];  ?>"> Regresar a Factura </a></td>
                    </tr>
                  </table>
                 
                  
                <p>&nbsp;</p></td>
              </tr>
            </table>
            <form name="form1" method="get" action="productos.php">
              <label for="txtvalor3"></label>
              Buscar Producto a Agregar
  <input type="text" name="txtvalor" id="txtvalor3">
  <input type="submit" name="button" id="button" value="Buscar">
  <input name="opc" type="hidden" id="opc" value="5">
  <input name="fac" type="hidden" id="fac" value="<?php echo $_GET[fac];?>">
            </form>
            <p>&nbsp;</p>
            
            <?php
			
			
			if ($bandera == 1){
            
            
            ?>
            <table width="100%" border="1">
              <tr>
                <td><form name="form2" method="get" action="productos.php">
                  <p>Codigo :
                    <input name="txtvalor" type="text" id="txtvalor" value="<?php echo $re_busca[codigo_producto]; ?>" size="50" maxlength="50" readonly>
                  </p>
                    <p>Producto:
                      <input name="txtproducto" type="text" id="txtproducto" value="<?php echo $prod; ?>" size="50" maxlength="50" readonly>
                      Precio de Venta
                      <label for="txtprecio"></label>
                      <input name="txtprecio" type="text" required id="txtprecio" maxlength="15">
                      Cantidad
                      <label for="txtprecio"></label>
                      <input name="txtcantidad" type="text" required id="txtcantidad" size="10">
                      <input type="submit" name="agregar" id="agregar" value="Agregar" >
                      <input name="opc" type="hidden" id="opc" value="6">
                        <input name="fac" type="hidden" id="fac" value="<?php echo $_GET[fac];?>">
                  </p>
                </form></td>
              </tr>
            </table>
            <?php
			
			}
			
			?>
            
            
            <p>&nbsp;</p>
          </div>
          <div class="col-sm-6"> </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="card-header">
             <!--   <h3 class="card-title">Nuevo Cliente<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3> -->
              </div>
	
	<main class="container">
	  </div>





  

  
</main>


<!-- Agregar -->

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
