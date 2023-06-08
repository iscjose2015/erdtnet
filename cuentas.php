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

        if($_GET[opc] == 1){

            $nomb = $_GET[txtnombre];

            $r = $_GET[txtrfc];


            echo "entro a 1";

            $inserta = mysqli_query($cone,"INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `colonia`, `ciudad`, `estado`, `cp`, `status_cliente`, `date_added`, `rfc`) 
            VALUES (NULL, '$nomb', '', '', '', '', '', '', '', '', '2021-10-06 17:19:47.000000', '$r');");

            header("location: clientes.php");

          


        }


        if($_GET[opc] == 3){

     
            $corr = $_GET[txtcorreo];
            $cod = $_GET[txtid];
            $tel = $_GET[txttelefono];
            $dir = $_GET[txtdireccion];
            $col = $_GET[txtcolonia];
            $ciu = $_GET[txtciudad];
            $est = $_GET[txtestado];
            $cp = $_GET[txtcp];
            $nom = $_GET[txtcliente];
            $rf = $_GET[txtrfc];
			$tel = $_GET[txttelefono];


            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `email_cliente` = '$corr' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `telefono_cliente` = '$tel' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `direccion_cliente` = '$dir' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `colonia` = '$col' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `ciudad` = '$ciu' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `estado` = '$est' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `cp` = '$cp' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `nombre_cliente` = '$nom' WHERE `clientes`.`id_cliente` = '$cod';");
            $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `rfc` = '$rf' WHERE `clientes`.`id_cliente` = '$cod';");
			$actualiza = mysqli_query($cone,"UPDATE `clientes` SET `telefono` = '$tel' WHERE `clientes`.`id_cliente` = '$cod';");

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



<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Cuentas</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"></li>
              <li class="breadcrumb-item active"></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="card-header">
                <h3 class="card-title">Nuevo Cuenta<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3>
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>RFC</th>
                    <th>Cuenta</th>
                    <th>Tipo</th>
                    <th>Banco</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php




                    $consulta = mysqli_query($cone, "SELECT * FROM `cuentas`");


                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td><?php echo $re['id']; ?></td>
                    <td><?php echo utf8_encode($re['rfc']); ?> </td>
                    <td><?php echo utf8_encode($re['cuenta']); ?> </td>
                    <td><?php echo utf8_encode($re['tipo']); ?> </td>
                    <td><?php echo utf8_encode($re['banco']); ?></td>
                    <td><?php echo utf8_encode($re['colonia']); ?></td>
                    <td><a href="#" data-toggle="modal" data-target="#modal-edit_<?php echo $re['id_cliente']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>
                  </tr>



                   <!-- Modal de  edicion -->

                  <div class="modal fade" id="modal-edit_<?php echo $re['id_cliente']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Editar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="clientes.php" method="get" >

                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo"  value= "<?php echo $re['id_cliente']; ?>"  readonly="readonly" >
                    </div>
                    </div>


                    
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">RFC</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtrfc" placeholder="RFC" name="txtrfc"  value= "<?php echo $re['rfc']; ?>"   >
                    </div>
                  </div>



                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Clientes</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcliente" placeholder="Cliente" name="txtcliente"  value= "<?php echo $re['nombre_cliente']; ?>"   >
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Correo</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="txtcorreo" placeholder="Correo" name="txtcorreo"  value= "<?php echo $re['email_cliente']; ?>"   >
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Direccion</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtdireccion" placeholder="Direccion" name="txtdireccion"  value= "<?php echo $re['direccion_cliente']; ?>"   >
                    </div>
                  </div>



					          <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Telefono</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txttelefono" placeholder="Telefono" name="txttelefono"  value= "<?php echo $re['telefono']; ?>"   >
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Colonia</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcolonia" placeholder="Colonia" name="txtcolonia"  value= "<?php echo $re['colonia']; ?>"   >
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Ciudad</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtciudad" placeholder="Ciudad" name="txtciudad"  value= "<?php echo $re['ciudad']; ?>"   >
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Estado</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtestado" placeholder="Estado" name="txtestado" value= "<?php echo $re['estado']; ?>"   >
                    </div>
                  </div>
                  

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">CP</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcp" placeholder="CP" name="txtcp"  value= "<?php echo $re['cp']; ?>"   >
                    </div>
                  </div>
                  
                  
                  
                  


                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id_cliente]; ?>" />


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
                    
         


                  <form   id="form2" name="form2" action="clientes.php" method="get" >

                   
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
                    <th>Clientes</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Direccion</th>
                    <th>Colonia</th>
					<th></th>
                  </tr>
                  </tfoot>
                </table>




                 
  

  </div>
</div>





  

  
</main>


<!-- Agregar -->

<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Registro de Cuenta Nueva </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="cuentas.php" method="get" >                 
<div class="row">




<div class="col-4">
RFC
  <input type="text" class="form-control" id="txtrfc" placeholder="RFC" name="txtrfc" required  >
	
</div>

<div class="col-4">
Cuenta
  <input type="text" class="form-control" id="txtcuenta" placeholder="Cuenta" name="txtcuenta" required  >
	
</div>
<div class="col-4">
Tipo
  <label for="lbltipo"></label>
<select name="lbltipo" id="lbltipo" class="form-control" required >
  <option value="BENEFICIARIO">BENEFICIARIO</option>
  <option value="ORDENANTE">ORDENANTE</option>
</select>
	
</div>
<div class="col-4">
<label for="lblbanco"></label>
<select name="lblbanco" id="lblbanco" class="form-control" required >
  <option value="BBVA">BBVA</option>
  <option value="SANTANDER">SANTANDER</option>
</select>
	
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
