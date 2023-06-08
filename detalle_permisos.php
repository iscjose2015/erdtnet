<?php

	session_start();

  include("conecta_facturacion.php");

  

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

        if($_GET[opc] == 1){

       

        }


        if($_GET[opc] == 3){

        

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
            <h1>Detalle Permisos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Detalle</a></li>
              <li class="breadcrumb-item active">Registro - Ver  - Modi </li>
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


  <?php 


         $clave = $_GET['cve'];
         $consulta_usuarios = mysqli_query($cone,"SELECT * FROM `users` where user_id = '$clave'");
         $re_usuarios = mysqli_fetch_array($consulta_usuarios);
         echo $re_usuarios[user_name];
  
  ?>



  <form id="form1" name="form1" method="get" action="detalle_permisos.php">


  <table width="100%" border="1">
    <tr>
      <td width="12%" height="23">Formulario</td>
      <td width="19%" align="center">Lectura</td>
      <td width="21%" align="center">Agregar</td>
      <td width="23%" align="center">Editar</td>
      <td width="25%" align="center"><p>Borrar</p></td>
    </tr>
    <tr>
      <td>Empresas</td>
      <td align="center"><input type="checkbox" name="101_1" id="101_1" 
      <?php
      $consulta_empresas_lectura = mysqli_query($cone,"SELECT * FROM `permisos` where iduser = '$clave' and tipo = 1;");
      $tot = mysqli_num_rows($consulta_empresas);

        echo "total".$tot;

      if($tot == 1){ ?> checked="checked" <?php } ?>

      />

      <label for="checkbox"></label></td>
      <td align="center"><input type="checkbox" name="checkbox2" id="checkbox2" />
      <label for="checkbox2"></label></td>
      <td align="center"><input type="checkbox" name="checkbox3" id="checkbox3" />
      <label for="checkbox3"></label></td>
      <td align="center"><input type="checkbox" name="checkbox4" id="checkbox4" />
      <label for="checkbox4"></label></td>
    </tr>


  </table>




          <input type="submit" name="btnenviar" id="btnenviar" value="Enviar" />
        </form>      
      
                 
  

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
