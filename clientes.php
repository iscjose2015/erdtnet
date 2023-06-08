<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php

  session_start();
  error_reporting(0);

  include("conecta_facturacion.php");
  //OBTENEMOS LA FECHA ACTUAL DEPENDIENDO DE LA ZONA HORARIA
  date_default_timezone_set('America/Mexico_City');
 // echo $fechaActual= date('Y-m-d H:m:s');

  $usuario =  $_SESSION['user_id'];

  $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
  $re_consulta = mysqli_fetch_array($consulta_acceso);

  if($re_consulta['clientes'] == '0' ) {   header("location: denegado.php");  }

  if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
  header("location: login.php");
  exit;
  }

  //DATOS A MANEJAR
  //$nombre = $_GET['txtnombre'];
  $Idcod          = $_GET['txtid'];
  $nombreClient   = $_GET['txtcliente'];
  $rfc            = $_GET['txtrfc'];
  $correo         = $_GET['txtcorreo'];
  $telefono       = $_GET['txttelefono'];
  $direccion      = $_GET['txtdireccion'];
  $colonia        = $_GET['txtcolonia'];
  $ciudad         = $_GET['txtciudad'];
  $estado         = $_GET['txtestado'];
  $cp             = $_GET['txtcp'];

  //DATOS A MANEJAR

  if($_GET['opc'] == 1){

    $inserta = mysqli_query($cone,"INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `colonia`, `ciudad`, `estado`, `cp`, `status_cliente`, `date_added`, `rfc`) 
    VALUES (NULL, '$nombreClient', '$telefono', '$correo', '$direccion', '$colonia', '$ciudad', '$estado', '$cp', '1', '$fechaActual', '$rfc')");

    header("location: clientes.php");
  }


  if($_GET['opc'] == 3){

    echo "Si entro";

    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `email_cliente` = '$correo' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `telefono_cliente` = '$telefono' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `direccion_cliente` = '$direccion' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `colonia` = '$colonia' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `ciudad` = '$ciudad' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `estado` = '$estado' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `cp` = '$cp' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `nombre_cliente` = '$nombreClient' WHERE `clientes`.`id_cliente` = '$Idcod';");
    $actualiza = mysqli_query($cone,"UPDATE `clientes` SET `rfc` = '$rfc' WHERE `clientes`.`id_cliente` = '$Idcod';");
    //$actualiza = mysqli_query($cone,"UPDATE `clientes` SET `telefono` = '$tel' WHERE `clientes`.`id_cliente` = '$cod';");

    echo "<script>
    Swal.fire({
      icon: 'success',
      title: 'Clientes',
      text: 'Los datos del cliente han sido actualizados correctamente.',  
      })
</script>"; 

   // header("location: clientes.php?banderaBusqueda=$nombreClient");
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
      <!-- Font Awesome -->
      <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
      <!-- Ionicons -->
      <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- DataTables -->
      <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
      <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="dist/css/adminlte.min.css">
      <!--SCRIPT PARA ALERTAS->
      <script src="dist/js/sweetalert2.all.min.js"></script-->

    </head>


     <style>

      .letra{
        font-size: 10px;
      }

      .letra2{
        font-size: 11px;
      }



    </style>
    <body>
      <?php include("navbar.php"); ?>

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Clientes</h1>
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
        <h3 class="card-title">
          Nuevo Cliente
          <a href = "#" data-toggle="modal" data-target="#modal-xl">
            <img src="https://img.icons8.com/windows/32/000000/plus.png"/>
          </a>
        </h3>
      </div>

      <main class="container">

        <div class="card-body">

          <table id="example1" class="table table-bordered table-striped letra">
            <thead>
              <tr>
                <th>RFC</th>
                <th>Clientes</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Direccion</th>
                <th>Colonia</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
                $consulta = mysqli_query($cone, "SELECT * FROM clientes WHERE status_cliente = '1'");
                while($re = mysqli_fetch_array($consulta)){ ?>

                  <tr>
                  <td><?php echo $re['rfc']; ?></td>
                  <td><?php echo utf8_encode($re['nombre_cliente']); ?> </td>
                  <td><?php echo utf8_encode($re['telefono_cliente']); ?> </td>
                  <td class="letra2"><?php echo utf8_encode($re['email_cliente']); ?> </td>
                  <td><?php echo utf8_encode($re['direccion_cliente']); ?></td>
                  <td><?php echo utf8_encode($re['colonia']); ?></td>
                  <!--td>
                    <a href="#" data-toggle="modal" data-target="#modal-edit_<php echo $re['id_cliente']; ?>" class="sub">
                      <img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/>
                    </a>
                  </td-->
                  <td><a class="sub" onclick="modal_edit(<?php echo $re['id_cliente'];?>, 'cliente')"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>

                  </tr>
                <!--AQUI VA EL MODAL DE EDICION-->
                <?php } ?>

            </tbody>
            <tfoot>
              <tr>
                <th>RFC</th>
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
      </main>


        <!-- INICIA MODAL NUEVO REGISTRO/EDITAR -->
  <div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title">Nuevo Registro</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_modal()">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
          <form   id="form2" name="form2" action="clientes.php" method="get" >

            <div class="row g-2"><!-- INICIA SECCION 1--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Id Cliente</label>
                      <div class="col-sm-9">
                      <input type="text" name="txtid" id="txtid" class="form-control" placeholder="Codigo" readonly>
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">RFC</label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" id="txtrfc" placeholder="RFC" name="txtrfc"  >
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 1-->

            <!--div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo"  value= "<php echo $re['id_cliente']; ?>"  readonly="readonly" >
                </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">RFC</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtrfc" placeholder="RFC" name="txtrfc"  value= "<php echo $re['rfc']; ?>"   >
                </div>
            </div-->

            <div class="row g-2"><!-- INICIA SECCION 2--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Cliente</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="txtcliente" id="txtcliente" placeholder="Cliente">
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Correo</label>
                      <div class="col-sm-9">
                        <input type="email" class="form-control" name="txtcorreo" id="txtcorreo" placeholder="Correo" >
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 2-->

            <!--div class="form-group row">
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
            </div-->

            <div class="row g-2"><!-- INICIA SECCION 3--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Direccion</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtdireccion" placeholder="Direccion" name="txtdireccion">
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Telefono</label>
                      <div class="col-sm-9">
                        <input type="number" max="10" class="form-control" id="txttelefono" placeholder="Telefono" name="txttelefono">
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 3-->

            <!--div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Direccion</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtdireccion" placeholder="Direccion" name="txtdireccion"  value= "<php echo $re['direccion_cliente']; ?>"   >
                </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Telefono</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txttelefono" placeholder="Telefono" name="txttelefono"  value= "<php echo $re['telefono']; ?>"   >
                </div>
            </div-->

            <div class="row g-2"><!-- INICIA SECCION 4--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Colonia</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtcolonia" placeholder="Colonia" name="txtcolonia" >
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Ciudad</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtciudad" placeholder="Ciudad" name="txtciudad">
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 4-->

            <!--div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Colonia</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtcolonia" placeholder="Colonia" name="txtcolonia"  >
                </div>
            </div>

            <div class="form-group row">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Ciudad</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="txtciudad" placeholder="Ciudad" name="txtciudad" >
                </div>
            </div-->

            <div class="row g-2"><!-- INICIA SECCION 5--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Estado</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="txtestado" placeholder="Estado" name="txtestado">
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">CP</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="txtcp" placeholder="CP" name="txtcp">
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 5-->

            <!--div class="form-group row">
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
            </div-->

            <!--DATOS OCULTOS-->
            <input type="hidden" name="opc" id="hiddenField" value="1" />
            <!--DATOS OCULTOS-->

            <div class="row"><!-- INICIA SECCION BOTONES GARDAR/CANCELAR-->

              <div class="modal-footer col-md-12 text-right">
                  <button type="button" class="btn btn-secondary"  data-dismiss="modal" onclick="reset_modal()">Cancelar</button>
                  <button type="submit" name="insertar" id="btnguarda" class="btn btn-primary">Guardar</button>
              </div>

            </div><!-- TERMINA SECCION BOTONES GARDAR/CANCELAR -->
          </form>
        </div>
          
          <!--div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div-->

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div> <!-- /.modal fade -->
  <!-- TERMINA MODAL NUEVO REGISTRO/EDITAR -->

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

    </body>
      <script src="assets/dist/js/clientes.js"></script>

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

      <!-- Sweet Alert 2 ->
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script-->
      <!--SCRIPT PARA MODALS-->
      <script src="dist/js/modals.js"></script>
      <?php
        if ($_GET['banderaBusqueda']  <> ''){
          $banderaBusqueda = $_GET['banderaBusqueda'];
        }
      ?>
      <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": false,
                "autoWidth": false,
                "search": {
                    "smart": false
                },
                "search": {
                    "search": "<?php echo $banderaBusqueda ?>"
                }
            });
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": false,
            });
        });
      </script>

  </html>

