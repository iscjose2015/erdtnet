<?php

	session_start();

  include("conecta_facturacion.php");



  

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

        $usuario =  $_SESSION['user_id'];


    
        //echo $usuario;
        
        $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
        $re_consulta = mysqli_fetch_array($consulta_acceso);
        //echo "aqui".$re_consulta['configuracion'];
        if($re_consulta['proveedores'] == '0' ) {   header("location: denegado.php");  }

        if($_GET[opc] == 1){

        //    echo "entro aqui";
            $emp = $_GET[txtproveedor];

            $inserta = mysqli_query($cone,"INSERT INTO `proveedores` (`id`, `proveedor`, `calle`, `colonia`, `estado`, `cp`, `telefonos`, `email`) 
            VALUES ('', '$emp', NULL, NULL, NULL, NULL, NULL, '');");
          //  header("location: proveedores.php");

        }


        if($_GET[opc] == 3){
          

          echo "entro a 3";

            $corr = $_GET[txtcorreo];
            $cod = $_GET[txtid];
            $nom = $_GET[txtnombre];

            $cal = $_GET[txtcalle];
            $col = $_GET[txtcolonia];
            $est = $_GET[txtestado];

            $codp = $_GET[txtcp];

          //  echo $corr;
         //   echo $cod;

            $inserta = mysqli_query($cone,"UPDATE `proveedores` SET `calle` = '$cal' WHERE `proveedores`.`id` = '$cod';");

            $inserta = mysqli_query($cone,"UPDATE `proveedores` SET `colonia` = '$col' WHERE `proveedores`.`id` = '$cod';");

            $inserta = mysqli_query($cone,"UPDATE `proveedores` SET `estado` = '$est' WHERE `proveedores`.`id` = '$cod';");

            $inserta = mysqli_query($cone,"UPDATE `proveedores` SET `email` = '$corr' WHERE `proveedores`.`id` = '$cod';");

            $inserta = mysqli_query($cone,"UPDATE `proveedores` SET `cp` = '$codp' WHERE `proveedores`.`id` = '$corr';");


          header("location: proveedores.php");

          


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
            <h1>Registro de Proveedores</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Proveedores</a></li>
              <li class="breadcrumb-item active">Registro - Ver  - Modi </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="card-header">
                <h3 class="card-title">Nuevo Proveedor<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3>
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Proveedor</th>
                    <th>Direccion</th>
                    <th>Email</th>
          
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php




                    $consulta = mysqli_query($cone, "SELECT * FROM `proveedores`");


                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td><?php echo $re['id']; ?></td>
                    <td><?php echo utf8_encode($re['proveedor']); ?> </td>
                    <td><?php echo "Calle: ".utf8_encode($re['calle'])." Colonia: ".utf8_encode($re['colonia'])." Estado: ".utf8_encode($re['estado']);  ?> </td>
                    <td><?php echo utf8_encode($re['email']); ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#modal-edit_<?php echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>
                  </tr>



                   <!-- Modal de  edicion -->

                  <div class="modal fade" id="modal-edit_<?php echo $re['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Editar Proveedor</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="proveedores.php" method="get" >

                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo"  value= "<?php echo $re['id']; ?>"  readonly="readonly" >
                    </div>
                    </div>



                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Proveedor</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtproveedor" placeholder="Codigo" name="txtproveedor"  value= "<?php echo $re['proveedor']; ?>"   >
                    </div>
                  </div>


                  
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Calle</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcalle" placeholder="Calle" name="txtcalle"  value= "<?php echo $re['calle']; ?>"   >
                    </div>
                  </div>


                              
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Colonia</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcolonia" placeholder="Calle" name="txtcolonia"  value= "<?php echo $re['colonia']; ?>"   >
                    </div>
                  </div>



          
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Estado</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtestado" placeholder="Estado" name="txtestado"  value= "<?php echo $re['estado']; ?>"   >
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">CP</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcp" placeholder="CP" name="txtcp"  value= "<?php echo $re['cp']; ?>"   >
                    </div>
                  </div>




          
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="txtcorreo" placeholder="Correo" name="txtcorreo"  value= "<?php echo $re['email']; ?>"   >
                    </div>
                  </div>

                  
                  


                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />


                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      </div>

                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->


                <!-- Modal de Borrado -->

                <div class="modal fade" id="modal-borrar_<?php echo $re['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Baja de Empresa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="proveedores.php" method="get" >

                   
                   <p><?php echo "Codigo: ".$re[id]; ?></p>
                   <p><?php echo "Descripcion: ".$re[empresa]; ?></p>
                   

                  <input name="opc" type="hidden" value="2" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />


                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar Baja</button>
                      </div>

                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->





                    <?php

                    }

                    ?>
                    
                  
                  
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Id</th>
                    <th>Proveedor</th>
                    <th>Direccion</th>
                    <th>Email</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>




                 
  

  </div>
</div>





  

  
</main>





<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Nuevo Proveedor</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="proveedores.php" method="get" >                 
<div class="row">




<div class="col-6">
Proveedor
  <input type="text" class="form-control" id="txtproveeedor" placeholder="Proveedor" name="txtproveedor" required  >
	
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
