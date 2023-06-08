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

    <script>
      function updatos(w,h,url)
      { 
      window.open(url,"popup","width="+w+",height="+h+",left=20,top=20"); 
      }
      </script> 
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
    <td width="98%" align="center"><?php


if( $_SESSION['emisor'] == ''){

 $_SESSION['emisor'] = $_POST['lblempresas'];

}


$cve =   $_SESSION['emisor'];


$consulta_empresas = mysqli_query($cone,"select * from empresas where id = '$cve'");
$re = mysqli_fetch_array($consulta_empresas);

echo "Empresa Seleccionada: ".$re['empresa'];


$_SESSION['seleccionada'] = $re['empresa'];

?>      <p>&nbsp;</p>
    <p><img src="<?php echo $re[logotipo]; ?>" /></p></td>
    <td width="2%" align="center">

       

    </td>
  </tr>
</table>

<table width="100%" border="1">
	  <tr>
	    <td width="9%" align="left"><p>&nbsp;</p></td>
	    <td width="86%" align="center"><p>Los Siguientes registros en Ordenes de compra estan incompletos:</p>
          <p>
            <?php
	
	$consulta_faltantes = mysqli_query($cone,"SELECT * FROM `detalle_ordenes` where descripcion = '' or unidad = '';");

	
	?>
        </p>
          <table width="64%" height="69" border="1">
            <tr>
              <td width="36%">Codigo de Producto</td>
              <td width="17%">No de Orden</td>
              <td width="47%">&nbsp;</td>
            </tr>
            
            <?php
			
             	while( $re_faltantes = mysqli_fetch_array($consulta_faltantes)){
		
		 		$ido =  $re_faltantes['idorden'];
		
	
		
	
	
              ?>
            
            <tr>
              <td align="left"><img src="https://img.icons8.com/color/48/null/toxic-material.png"/><?php  echo $re_faltantes['c_producto']; ?></td>
              <td align="center"><a href="https://www.elreydeltornillo.com/sit/facturacion/detalle_orden.php?idorden=<?php echo $ido; ?>"><?php  echo $re_faltantes['idorden'];?></a></td>
              <td align="center"><p><a href="http://172.18.10.77:8080/ws/ws_kepler/actualiza_uno.php?codigo=<?php echo $re_faltantes['c_producto']; ?>"><img src="https://img.icons8.com/external-outline-juicy-fish/24/null/external-update-arrows-outline-outline-juicy-fish.png" alt=""/>  </a><a href="http://172.18.10.77:8080/ws/ws_kepler/actualiza_uno.php?codigo=<?php echo $re_faltantes['c_producto']; ?>">Acualizar Producto </a></p></td>
            </tr>
            
            <?php
			
				}
			
			?>
            
            
          </table>
        <p>&nbsp;</p></td>
	    <td width="5%">&nbsp;</td>
      </tr>
  </table>





</main>
	
  <p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	
	<p>&nbsp;</p>
	<p>
	  <?php
  
	include("footer.php");
	?>
  </p>
	<!--script src="assets/dist/js/facturas.js"></script-->
  </body>
</html>

<script>

  /*function updatos(){//GENERAR FILAS CON DATOS DE BD
    $.ajax({
        url: 'http://172.18.10.77:80/ws/ws_kepler/todos.php',
        type: 'POST',
        //cache: false,
        //fileasync: true,
        crossDomain: true,
        success: (r) => {
          if (r == 1){
            ///////////
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: 'Base datos Actualizada Correctamente!!',
                  showConfirmButton: false,
                  timer: 1500
                })
                .then(() => {
                    console.log("Alerta cerrada");
                });
            //////////
          }
        }, error:(r,txt) => {
            ///////////
            markErr(r,txt);
            //////////
        }
      });
    }*/
    

    updatos('350', '150', 'http://172.18.10.77:8080/ws/ws_kepler/todos.php');
  </script>