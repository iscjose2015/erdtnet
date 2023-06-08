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
	include("navbar2.php");
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
    <td width="47%" align="center">Seleecione la empresa a uitlizar:

		<?php


$consulta_empresas = mysqli_query($cone,"select * from empresas order by 2");



		?>


	<form id="form1" name="form1" method="post" action="principal.php">
        <p>
          <label for="lblempresas"></label>
          <select name="lblempresas" id="lblempresas"  required="required">
		    <option value=""></option>
			<?php
			while($re = mysqli_fetch_array($consulta_empresas))
			{

			?>
            <option value="<?php echo $re['id']; ?>"><?php echo $re['empresa']; ?></option>
			<?php
			}
			

			?>
          </select>
        </p>
        <p>
          <input type="submit" name="button" id="button" value="Entrar" />
        </p>
      </form>


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
