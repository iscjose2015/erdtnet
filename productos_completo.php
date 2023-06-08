<?php
  error_reporting(0);
	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");

  $usuario =  $_SESSION['user_id'];

  $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
  $re_consulta = mysqli_fetch_array($consulta_acceso);
  //echo "aqui".$re_consulta['empresas'];
  if($re_consulta['clientes'] == '0' ) {   header("location: denegado.php");  }

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		  exit;
  }
        
    /* Connect To Database*/
    require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
    require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
    $active_facturas  ="";
    $active_productos ="";
    $active_clientes  ="active";
    $active_usuarios  ="";	
    $title            ="Clientes ";

    //ACTUALIZACION DE DATOS
     if($_GET['opc'] == 3){
      $id         = $_GET['txtid'];
      $nomProduct = $_GET['nameProduct'];
      $up_product = mysqli_query($cone, "UPDATE products SET nombre_producto = '$nomProduct' WHERE id_producto = '$id'");

      header("location: productos.php?banderaBusqueda=$nomProduct");
     }
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
        <style>
          .dots {
            display: inline-block; 
            width: 100px; 
            float: left; 
            white-space: nowrap; 
            text-overflow: ellipsis; 
            overflow: hidden;
          } 
            .dots:hover{cursor: pointer; }
        </style>

    </head>
    <body>
	    <?php include("navbar.php"); ?>

      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Inventario</h1>
                <?php if($_GET['val'] == 4){ ?>
                  <a href="detalle_invoices.php?idorden=<?php echo $_GET['fac'];  ?>&serie=<?php echo $_GET['fac'];  ?>"> Ir a Factura </a>
                <?php } ?>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"></li>
                <li class="breadcrumb-item active"></li>
              </ol>
            </div><!-- /col-sm-6 -->
          </div><!-- /row mb-2 -->
        </div><!-- /.container-fluid -->
      </section><!-- /section content-header -->

      <div class="card-header">
        <!--<h3 class="card-title">Nuevo Cliente<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3> -->
      </div>
	
	    <main class="container">
        <div class="card-body">
              <!-- CREAR UNA TABLA PARA MOSTRAR LOS DATOS -->
              <table width="100%" class="table table-bordered table-striped" id="example1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Codigo Producto</th>
                    <th>Nombre</th>
                    <th>Id Sat</th>
                    <th>Nombre Sat</th>
                    <th>Unidad Sat</th>
                    <th>Peso</th>
                    <th>IdFamilia</th>
                    <th>Familia</th>
                    <th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  //$data  =  @file_get_contents("http://localhost/elreydeltornillo/FACTURACION/loaddata.php");
                  $data  =  @file_get_contents("https://elreydeltornillo.com/sit/facturacion/loaddata.php");
                  $items = json_decode($data, true);
                  $tot = count($items);

                  for ($k=0; $k <  $tot;  $k++){ ?>
                  <tr>
                    <td><?php echo $items[$k]['idproduct'];?></td>
                    <td><a href="kardex.php?cve=<?php echo  $items[$k]['codproduct']; ?>"><?php echo $items[$k]['codproduct'];?></a></td>
                    <td><?php echo $items[$k]['nomproduc'];?></td>
                    <td><?php echo $items[$k]['idsat'];?></td>
                    <td><?php echo $items[$k]['nombsat'];?></td>
                    <td><?php echo $items[$k]['unidadsat'];?></td>
                    <td><?php echo $items[$k]['peso'];?></td>
                    <td><?php echo $items[$k]['idFamilia'];?></td>
                    <td><?php echo $items[$k]['familia'];?></td>
                    <td>&nbsp;</td>
                  </tr>                 
                  <?php } ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Codigo Producto</th>
                    <th>Nombre</th>
                    <th>Id Sat</th>
                    <th>Nombre Sat</th>
                    <th>Unidad Sat</th>
                    <th>peso</th>
                    <th>IdFamilia</th>
                    <th>Familia</th>
                    <th>&nbsp;</th>
                  </tr>
                </tfoot>
              </table>
              <!-- CREAR UNA TABLA PARA MOSTRAR LOS DATOS -->

        <!-- SCRIPT PARA ACTIVAR EL PLUGIN DATATABLES ->
        <script type="text/javascript" >
          
          $(document).ready(function(){
            $("#mytable").DataTable({
              ajax: "loaddata.php"
            });
          });
        </script-->

        </div><!--card-body-->
      </main>

      <!-- INICIA MODAL NUEVO REGISTRO/EDITAR -->
      <div class="modal fade" id="modal-xl">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="modal-title">Editar Datos</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_modal()">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
              <form   id="form2" name="form2" action="productos.php" method="get" >

                <div class="row g-2"><!-- INICIA SECCION 1--->

                  <div class="col-sm-5 col-md-6">
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Id</label>
                          <div class="col-sm-9">
                          <input type="text" name="txtid" id="txtid" class="form-control" placeholder="Codigo" readonly>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-5 col-md-6">
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Codigo Producto</label>
                          <div class="col-sm-9">
                          <input type="text" class="form-control" id="txtrfc" name="codProduct"   readonly>
                          </div>
                      </div>
                  </div>

                </div><!-- TERMINA SECCION 1-->

                <div class="row g-2"><!-- INICIA SECCION 2--->

                  <div class="col-sm-5 col-md-6">
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Nombre</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="nameProduct" id="txtcliente">
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-5 col-md-6">
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Id Sat</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" name="idSat" id="txtcorreo" readonly >
                          </div>
                      </div>
                  </div>

                </div><!-- TERMINA SECCION 2-->

                <div class="row g-2"><!-- INICIA SECCION 3--->

                  <div class="col-sm-5 col-md-6">
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Nombre Sat</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="nameSat" id="txtdireccion" readonly>
                          </div>
                      </div>
                  </div>

                  <div class="col-sm-5 col-md-6">
                      <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-2 col-form-label">Unidad Sat</label>
                          <div class="col-sm-9">
                            <input type="text" max="10" class="form-control" name="unidadSat" id="txttelefono" readonly >
                          </div>
                      </div>
                  </div>

                </div><!-- TERMINA SECCION 3-->

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
            </div><!-- /.modal-body -->

          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog modal-lg -->
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
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <!--SCRIPT PARA MODALS-->
    <script src="dist/js/modals.js"></script>
    <!-- page script -->
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
