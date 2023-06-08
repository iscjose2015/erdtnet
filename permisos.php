<?php

	session_start();

  include("conecta_facturacion.php");

  

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

        $clave = $_GET['cve'];
        $consulta_permisos = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$clave'");
        $re_permisos = mysqli_fetch_array($consulta_permisos);



        if($_GET[opc] == 1){

          $clie = $_GET['chk1'];
          $conf = $_GET['chk2'];
          $emp = $_GET['chk3'];
          $fact = $_GET['chk4'];
          $ord = $_GET['chk5'];
          $pro = $_GET['chk6'];
          $prov = $_GET['chk7'];
          $usu = $_GET['chk8'];

          $id = $_GET['cve'];

       
        

          if($clie == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `clientes` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `clientes` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 


          
          if($conf == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `configuracion` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `configuracion` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 

                
          if($emp == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `empresas` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `empresas` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 

                
          if($fact == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `facturas` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `facturas` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 


          if($ord == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `ordenes` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `ordenes` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 

          if($pro == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `productos` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `productos` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 

          if($prov == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `proveedores` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `proveedores` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 


          if($usu == on) {  
            
            $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `usuarios` = '1' WHERE `permisos`.`idempleado` = '$id';"); }
          else { $actualiza = mysqli_query($cone,"UPDATE `permisos` SET `usuarios` = '0' WHERE `permisos`.`idempleado` = '$id';"); } 

        
          $ruta = "location: permisos.php?cve=".$id;


          header($ruta);
        
        }
        


	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Clientes | Simple Invoice";
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
            <h1>Usuarios y Permisos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="card-header">
                <h3 class="card-title"></h3>
              </div>
	
	<main class="container">
  
  
  <div class="card-body">



  &nbsp;</p>
<form id="form1" name="form1" method="get" action="permisos.php">
  <table width="33%" border="0">
    <tr>
      <td width="38%" align="right">Modulo</td>
      <td width="62%">&nbsp;</td>
    </tr>
    <tr>
      <td align="right">Clientes</td>
      <td><label for="checkbox">

        <input type="checkbox" name="chk1" id="chk1" <?php if($re_permisos['clientes'] == 1) { echo 'checked="checked"'; }  ?> />
      </label></td>
    </tr>
    <tr>
      <td align="right">Configuracion</td>
      <td><input type="checkbox" name="chk2" id="chk2"  <?php if($re_permisos['configuracion'] == 1) { echo 'checked="checked"'; }  ?> /></td>
    </tr>
    <tr>
      <td align="right">Empresas</td>
      <td><input type="checkbox" name="chk3" id="chk3" <?php if($re_permisos['empresas'] == 1) { echo 'checked="checked"'; }  ?> /></td>
    </tr>
    <tr>
      <td align="right">Facturas</td>
      <td><input type="checkbox" name="chk4" id="chk4" <?php if($re_permisos['facturas'] == 1) { echo 'checked="checked"'; }  ?> /></td>
    </tr>
    <tr>
      <td align="right"">Ordenes</td>
      <td><input type="checkbox" name="chk5" id="chk5" <?php if($re_permisos['ordenes'] == 1) { echo 'checked="checked"'; }  ?> /></td>
    </tr>
    <tr>
      <td align="right">Productos</td>
      <td><input type="checkbox" name="chk6" id="chk6" <?php if($re_permisos['productos'] == 1) { echo 'checked="checked"'; }  ?> /></td>
    </tr>
    <tr>
      <td align="right">Proveedores</td>
      <td><input type="checkbox" name="chk7" id="chk17" <?php if($re_permisos['proveedores'] == 1) { echo 'checked="checked"'; }  ?> /></td>
    </tr>
    <tr>
      <td align="right">Usuarios</td>
      <td><input type="checkbox" name="chk8" id="chk18" <?php if($re_permisos['usuarios'] == 1) { echo 'checked="checked"'; }  ?> /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>


  <input type="hidden" name="opc" id="opc" value="1" />
  <input type="hidden" name="cve" id="cve" value="<?php echo $_GET[cve];?>" />
  <p>
    <input type="submit" name="button" id="button" value="Actualizar" />
  </p>
</form>
<p>


              
  

  </div>
</div>





  

  
</main>





<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Nuevo Empresa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="base.php" method="get" >                 
<div class="row">




<div class="col-6">
Empresa
  <input type="text" class="form-control" id="txtempresa" placeholder="Empresa" name="txtempresa" required  >
	
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
	include("footer.php");
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
