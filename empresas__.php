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

      </head>
      <body>
	      <?php include "navbar.php";?>

        <section class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>Registro de Empresas</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item active"> <a href="https://app.experteasy.mx/test/curso_cfdi/php/csd_procesar/" target="_blank">Procesar Certificado de Sellos Digitales (CSD)</a></li>
                </ol>
              </div>
            </div>
          </div><!-- /.container-fluid -->
        </section>

        <div class="card-header">
          <!--h3 class="card-title">
              Nueva Empresa
              <a href = "#" data-toggle="modal" data-target="#modal-xl">
                  <img src="https://img.icons8.com/windows/32/000000/plus.png"/>
              </a>
          </h3-->
        </div>

	        <main class="container">

            <div class="card-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Empresa</th>
                    <th>Direccion</th>
                    <th>No Certificado</th>
                    <th>Certificado</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
$consulta = mysqli_query($cone, "SELECT * FROM `empresas`");

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
                    <td><?php echo $re['rfc']; ?></td>
                    <td><?php echo utf8_encode($re['empresa']); ?> </td>
                    <td><?php echo utf8_encode($re['direccion']); ?> </td>
                    <td><?php echo utf8_encode($re['no_certificado']); ?> </td>
                    <td> <?php echo limitar_cadena($re['certificado'], 20, "..."); ?></td>
                    <td onclick="showImg()"><a class="sub" onclick="modal_edit(<?php echo $re['id']; ?>, 'empresa')"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>

                    </tr>

                  <?php }?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Id</th>
                    <th>Empresa</th>
                    <th>Direccion</th>
                    <th>No Certificado</th>
                    <th>Certificado</th>
                    <th>&nbsp;</th>
                  </tr>
                </tfoot>
              </table>

            </div>
          </main>

 	        <?php //include("footer.php");     ?>

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
          <form id="newIMG" name="form2" method="POST" enctype="multipart/form-data">

            <div class="row g-2"><!-- INICIA SECCION 1--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Id Empresa</label>
                      <div class="col-sm-9">
                      <input type="text" name="txtid" id="txtid" class="form-control" readonly />
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre</label>
                      <div class="col-sm-9">
                      <input type="text" class="form-control" name="nomEmpresa" id="nomEmpresa" placeholder="RFC" />
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 1-->

            <div class="row g-2"><!-- INICIA SECCION 2--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-4 col-form-label">Subir Logo</label>
                      <div class="col-sm-12">
                        <input type="file" class="form-control" name="archivo[]" id="archivo[]" accept="image/png,image/jpeg/jpg">
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <div class="col-sm-9">
                        <input src="" type="hidden" class="form-control" name="img_name" id="img_name" />
                        <img alt="Logo" name="logo_emp_img" id="logo_emp_img" />
                      </div>
                  </div>
              </div>
            </div><!-- TERMINA SECCION 2-->

            <!--DATOS OCULTOS-->
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
      <!-- Librería general -->
      <script src="dist/js/lib.js"></script>
      <!--SCRIPT PARA MODALS-->
      <script src="dist/js/modals__.js"></script>
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
  function showImg(){
    let image = document.getElementById('logo_emp_img');
    let img   = document.getElementById('img_name').value;
    let emp   = document.getElementById('nomEmpresa').value;
    image.innerHTML = '<img src="dctos_rel/'+emp+'/'+img+'" alt="Logo" name="logo_emp_img" id="logo_emp_img" />';
  }


	$(document).ready(function(){
	    $('#btnguarda').click(function(){
            var form = document.querySelector("#newIMG");
            var formData = new FormData(form);

            $.ajax({
                type:"POST",
                url:"up_docs__.php",
                data: formData,

                contentType: false,
                processData: false,

                success:function(r){
                    if(r == 1){
                        $('#modal-xl').modal('hide');
                        Swal.fire(
                            'Guardado!!',
                            'Se cargo correctamente la Imagen!!',
                            'success'
                        ).then(() => {
                            //location.href = 'index.php';
                            // Aquí la alerta se ha cerrado
                            console.log("Alerta cerrada");
                        });

                    }else{
                        Swal.fire(
                            'Error!!!',
                            'Verifique los datos Ingresados!!',
                            'error'
                        ).then(() => {
                            // Aquí la alerta se ha cerrado
                            console.log("Alerta cerrada");
                        });
                    }
                }	
            });
    
            return false;
		});
	});
</script>