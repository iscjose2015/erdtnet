<?php



	include("conecta_facturacion.php");
	date_default_timezone_set('America/Mexico_City');


	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Facturas ";
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
  <h5></h5>
  </div>
  
  <div class="p-0 ">

 


  </div>
</div>
  
  <div class="card-body">
  

  <table width="100%" border="0">
  <tr>
    <td width="53%"><img src="logo.fw.png" width="557" height="351" /></td>
    <td width="53%" align="center">

        <?php


       if( $_SESSION['emisor'] == ''){

        $_SESSION['emisor'] = $_POST[lblempresas];

       }

       
      $cve =   $_GET['lblempresas'];


      $consulta_empresas = mysqli_query($cone,"select * from empresas where id = '$cve'");
      $re = mysqli_fetch_array($consulta_empresas);

      echo "Empresa Seleccionada: ".$re[empresa];


       $_SESSION['seleccionada'] = $re[empresa];

?>

    </td>
  </tr>
</table>
 






  

  
</main>
    
	
	<?php
	include("footer.php");
	?>
	<script src="assets/dist/js/facturas.js"></script>
  </body>
</html>
