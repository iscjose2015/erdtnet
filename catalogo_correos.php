<?php
session_start();

include("conecta_facturacion.php");
$usuario = $_SESSION['user_id'];

$consulta_acceso = mysqli_query($cone, "SELECT * FROM `permisos` WHERE idempleado = '$usuario'");
$re_consulta = mysqli_fetch_array($consulta_acceso);
//echo "aqui".$re_consulta['empresas'];

if ($re_consulta['empresas'] == '0') {header("location: denegado.php");}

if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
    header("location: login.php");
    exit;
}

$deleted = 'false';

//Borrado de correos
if(isset($_GET['delete'])){
  include("conecta_facturacion.php");
  $id = $_GET['delete'];

  $result = mysqli_query($cone, "UPDATE `cuenta_correos` SET `activo` = 0 WHERE `id` = '$id'");
  $deleted = 'true';
}

// Connect To Database
require_once "config/db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "config/conexion.php"; //Contiene funcion que conecta a la base de datos

$active_facturas = "";
$active_productos = "";
$active_clientes = "active";
$active_usuarios = "";
$title = "Clientes ";

?>
  <!DOCTYPE html>
    <html lang="en">
      <head>
        <?php include "head.php";?>

        <!-- Font Awesome -->
        <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/adminlte.min.css">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      </head>
      <body>
	      <?php include "navbar.php";?>

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Registro de Correos</h1>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <div class="card-header">
          <h3 class="card-title">
              Nuevo correo
              <a href = "#" data-toggle="modal" data-target="#modal-xl">
                  <img src="https://img.icons8.com/windows/32/000000/plus.png"/>
              </a>
          </h3>
        </div>

	        <main class="container">

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Correo</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
$consulta = mysqli_query($cone, "SELECT * FROM `cuenta_correos` WHERE activo = 1");

function limitar_cadena($cadena, $limite, $sufijo)
{
    // Si la longitud es mayor que el límite...
    if (strlen($cadena) > $limite) {
        // Entonces corta la cadena y ponle el sufijo
        return substr($cadena, 0, $limite) . $sufijo;
    }

    // Si no, entonces devuelve la cadena normal
    return $cadena;
}

while ($re = mysqli_fetch_array($consulta)) {
    ?>

                    <tr>
                        <td><?php echo $re['id']; ?></td>
                        <td><?php echo utf8_encode($re['correo']); ?> </td>
                        <td><a class="sub" title="Editar" onclick="modal_edit(<?php echo $re['id']; ?>, 'correo')"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>
                        <td><a class="sub" title="Borrar" href="../facturacion/catalogo_correos.php?delete=<?php echo $re['id'];?>"><img src="https://img.icons8.com/metro/24/A83339/trash.png"/></a></td>
                    </tr>

                  <?php }?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Correo</th>
                    <th>&nbsp;</th>
                  </tr>
                </tfoot>
              </table>

            </div>
          </main>

 	        <?php //include("footer.php");     ?>

  <!-- INICIA MODAL NUEVO REGISTRO/EDITAR -->
  <div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-lg" style="width: 50%;">
      <div class="modal-content" style="width: 70%;">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title">Nuevo Registro</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_modal()">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
          <form id="newIMG" name="form2" method="POST">

            <div class="row g-2"><!-- INICIA SECCION 1--->

                <div class="col-sm-5 col-md-6" style="display: none;">
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <input type="hidden" class="form-control" name="txtid" id="txtid" />
                        </div>
                    </div>
                </div>

              <div class="col-sm-5 col-md-12">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Correo</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" name="txtemail" id="txtemail" placeholder="Correo" onKeypress="if(event.keyCode == 13){ document.getElementById('btnguarda').click() }" />
                      </div>
                  </div>
              </div>

            <!--DATOS OCULTOS-->
            <input type="hidden" name="txtid" id="txtid" />
            <input type="hidden" name="opc" id="hiddenField" value="1" />
            <!--DATOS OCULTOS-->

            <div class="row"><!-- INICIA SECCION BOTONES GARDAR/CANCELAR-->
              <div class="modal-footer col-md-12 text-right">
                  <button type="button" class="btn btn-secondary"  data-dismiss="modal" onclick="reset_modal()">Cancelar</button>
                  <button type="button" name="insertar" id="btnguarda" class="btn btn-primary">Guardar</button>
              </div>
            </div><!-- TERMINA SECCION BOTONES GARDAR/CANCELAR -->
          </form>
        </div>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div> <!-- /.modal fade -->
  <!-- TERMINA MODAL NUEVO REGISTRO/EDITAR -->

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
      <!-- Librería general -->
      <script src="dist/js/lib.js"></script>
      <!--SCRIPT PARA MODALS-->
      <script src="dist/js/modals.js"></script>
<!-- AdminLTE for demo purposes ->
<script src="dist/js/demo.js"></script-->
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

<!--SCRIPT PARA GUARDAR LA SOLICITUD-->
<script type="text/javascript">
  if(<?php echo $deleted;?>){
    Swal.fire({
      icon: 'success',
      text: 'Se ha eliminado el correo exitosamente!',
      showConfirmButton: false,
      showCloseButton: true,
      position: 'top',
      allowOutsideClick: false
    }).then(() => {
      location.replace('../facturacion/catalogo_correos.php');
    });
  }

  function updt(dataset){
    $.ajax({
      type:"POST",
      url:"updtEmail.php",
      data: dataset,
      success: (response) => {
        let info_data = {
          success: 'El correo '+dataset['email']+' se ha reactivado nuevamente!',
          error: 'Algo salió mal al tratar de registrar el correo '+dataset['email']
        };

        Swal.fire({
          icon: response,
          text: info_data[response],
          showConfirmButton: false,
          showCloseButton: true,
          position: 'top',
          allowOutsideClick: false
        }).then(() => {
          location.reload();
        });
      },
      error: (jqXHR, textStatus) => {
        markErr(jqXHR, textStatus);
      }
    });
  }


  document.getElementById('btnguarda').addEventListener('click', () => {
          let id     = document.getElementById('txtid').value;
          let correo = document.getElementById('txtemail').value;
          let option = document.getElementById('hiddenField').value;

          if(!isAnEmptyString(correo) && validEmail(correo)){
              $.ajax({
                  type:"POST",
                  url:"updtEmail.php",
                  data: {
                      id: id,
                      email: correo,
                      opc: option
                  },
                  success: (response) => {
                      if(option == 1){
                        action = 'registrado';
                      }else if(option == 3){
                        action = 'actualizado';
                      }
                      let info_data = {
                        success: 'El correo '+correo+' se ha '+action+' exitosamente!',
                        error: 'Algo salió mal al tratar de registrar el correo '+correo
                      };

                      if(response == 'mailExists'){
                          Swal.fire({
                            icon: 'warning',
                            text: 'El correo que intenta registrar ya existe, por favor pruebe con otro',
                            showConfirmButton: false,
                            showCloseButton: true,
                            position: 'top',
                            allowOutsideClick: false
                          });
                      }else if(response.includes('mailInactive')){
                        let arr      = response.split('_');
                        let id_email = arr[1];
                        Swal.fire({
                          icon: 'question',
                          text: 'El correo '+correo+' ya se había registrado, ¿Quiere reactivarlo?',
                          showConfirmButton: true,
                          confirmButtonColor: 'darkblue',
                          confirmButtonText: 'Sí, activar',
                          showCancelButton: true,
                          cancelButtonText: 'No, cerrar',
                          showCloseButton: true,
                          position: 'top',
                          allowOutsideClick: false
                        }).then((result) => {
                          if(result.isConfirmed){
                            updt({
                              id: id_email,
                              email: correo,
                              opc: 3
                            });
                          }
                        });
                      }else{
                        Swal.fire({
                          icon: response,
                          text: info_data[response],
                          showConfirmButton: false,
                          showCloseButton: true,
                          position: 'top',
                          allowOutsideClick: false
                        }).then(() => {
                          location.reload();
                        });
                      }
                      
                      console.log(response);
                  },
                  error: (jqXHR, textStatus) => {
                    markErr(jqXHR, textStatus);
                  }
              });
          }else{
              Swal.fire({
                  icon: 'warning',
                  text: 'Por favor ponga un correo válido',
                  showConfirmButton: false,
                  showCloseButton: true,
                  position: 'top',
                  allowOutsideClick: false 
              });
              
          }
  
          return false;
  });
</script>