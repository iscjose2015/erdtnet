<?php  session_start();  

      include("clases/main.php");
      include("clases/token.php");
      $to = new Token();
      $to->validaAcceso();

      include("clases/c_empresas.php");
      

     


       $obj = new Empresas();
       $obj->Conecta();


// Insertado de registros
if($_GET[opc] == 1){
  $des = $_GET[txtdescripcion];
  $obj->InsertarEmpresa($des);
}

// Borrado de registros
if($_GET[opc] == 2) {
  $cve = $_GET[txtid];
  $obj->BorraEmpresa($cve);

}


// actualizacion de registros
if($_GET[opc] == 3)
{

  $clave = $_GET[txtid];
  $cod =   $_GET[txtcodigo];
  $des = $_GET[txtdescripcion];

  $obj->ActualizaEmpresa($des,$clave); 
}

?>


<?php include("encabezado.php"); ?>

  
  <!--  
  Aqui se encuentra la parte donde se muestra del departamento y el usuario, y ahi mismo
  se encuentra contenido el acceso a el menu vertical -->

<?php include("side_bar.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Titulo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Titulo</a></li>
              <li class="breadcrumb-item active">Registro - Ver  - Modi </li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
         

            <div class="card">
              <div class="card-header">
                
              </div>
            </div>
        </div>
    </section>

    </div>




<?php include("pie.php");?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
</body>
</html>
