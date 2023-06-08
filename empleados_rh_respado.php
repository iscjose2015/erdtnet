<?php  session_start();  

      include("clases/main.php");
      include("clases/token.php");
      $to = new Token();
      $to->validaAcceso();

      include("clases/c_empresas.php");

      include("conecta_rh.php");


      // Mantenimiento a tabla dbo_personas para no generar errores
      $mtto = mysqli_query($con,"delete from dbo_personas where nombre = ''");

      

       $obj = new Empresas();
       $obj->Conecta();


// Insertado de registros
if($_GET[opc] == 1){

  $nom = $_GET['txtnombre'];
  $num = $_GET['txtnomina'];
  $emp = $_GET['lblempresa'];
  $suc = $_GET['lblsucursales'];
  $h   = $_GET['lblhoras'];
  $tip = $_GET['lbltipo'];
  $me  = $_GET['lblmedias'];
  $hor  = $_GET['lblhorario'];

  function generapassword(){
    $str = "#ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890_$";
    $password = "";
 
    for($i=0;$i<5;$i++) {
       $password .= substr($str,rand(0,62),1);
    }
 
    return $password;
    }
  
	$pass = generapassword();

  $consulta_nomina = mysqli_query($con,"SELECT * FROM `empleados` WHERE `numero_nomina` = '$num'");
  $tot_nom = mysqli_num_rows($consulta_nomina);


  //echo "Esto vale".$nom;
  //echo "Esto vale tot".$tot_num;


 if ($tot_nom == 0){
 
    $inserta_empleado = mysqli_query($con,"insert into empleados(nombre,numero_nomina,password,empresa,estatus,
    sucursal,medias,he,tipo,horario)values('$nom','$num','$pass','$emp','1','$suc','$me','$h','$tip','$hor')");
    }else{
    ?>
     <script>
    alert("El Numero de nomina ya esta registrado: ");
    </script>

    <?php
    }

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
  $cod =   $_GET[txtnombre];
  $des = $_GET[txtnomina];
  $suc = $_GET[lblsucursales];


  $trfc =   $_GET[txtrfc];
  $tnss = $_GET[txtnss];
  $tt = $_GET[txttelemer];
  $tcon = $_GET[txtcontacto];
  $extras = $_GET[lblhoras];
  $per = $_GET[txttel_personal];
  $dire = $_GET[txtdireccion];

  $tip = $_GET[lbltipo];
  $dep = $_GET[lbldepto];
  $pue = $_GET[lblpuesto];  
  $fe = $_GET[txtfecha_ingreso];
  $hor = $_GET[lblhorario];
  $med = $_GET[lblmedias];





  $actualiza = mysqli_query($con,"UPDATE `empleados` 
  SET `nombre` = '$cod' WHERE `empleados`.`id` = '$clave'; ");


$actualiza = mysqli_query($con,"UPDATE `empleados` 
SET `numero_nomina` = '$des' WHERE `empleados`.`id` = '$clave'; ");


$actualiza = mysqli_query($con,"UPDATE `empleados` 
SET `sucursal` = '$suc' WHERE `empleados`.`id` = '$clave'; ");

//UPDATE `dbo_personas` SET `Nombre` = 'Jose Julian R' WHERE `dbo_personas`.`IdPersona` = 44; 

$actualiza = mysqli_query($con,"UPDATE `dbo_personas` SET `Nombre` = '$cod' WHERE `dbo_personas`.`ApPaterno` = '$des';  ");

echo $per;

echo $dire;


$actualiza = mysqli_query($con,"UPDATE `empleados` SET `rfc` = '$trfc' WHERE `empleados`.`numero_nomina` = '$des'; ");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `nss` = '$tnss' WHERE `empleados`.`numero_nomina` = '$des';  ");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `telemer` = '$tt' WHERE `empleados`.`numero_nomina` = '$des'; ");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `contacto` = '$tcon' WHERE `empleados`.`numero_nomina` = '$des';  ");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `he` = '$extras' WHERE `empleados`.`numero_nomina` = '$des';  ");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `tel_personal` = '$per' WHERE `empleados`.`numero_nomina` = '$des';");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `direccion` = '$dire' WHERE `empleados`.`numero_nomina` = '$des';");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `tipo` = '$tip' WHERE `empleados`.`numero_nomina` = '$des';  ");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `departamento` = '$dep' WHERE `empleados`.`numero_nomina` = '$des';");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `puesto` = '$pue' WHERE `empleados`.`numero_nomina` = '$des';");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `fecha_ingreso` = '$fe' WHERE `empleados`.`numero_nomina` = '$des';");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `horario` = '$hor' WHERE `empleados`.`numero_nomina` = '$des';");
$actualiza = mysqli_query($con,"UPDATE `empleados` SET `medias` = '$med' WHERE `empleados`.`numero_nomina` = '$des';");



}


if($_GET[borrado] == 1)
{

 $nomi = $_GET['nom'];

$consulta_personas = mysqli_query($con,"SELECT * FROM `dbo_personas` where ApPaterno = '$nomi'");
$re_personas = mysqli_fetch_array($consulta_personas);

$Id =  $re_personas['IdPersona'];

$borra = mysqli_query($con,"DELETE FROM dbo_huellas WHERE IdPersona = '$Id'");
$borra_personal = mysqli_query($con,"DELETE FROM dbo_personas WHERE IdPersona = '$Id'");

}


if($_GET[borrado] == 2)
{

 $nomi = $_GET['nom'];

$consulta_personas = mysqli_query($con,"SELECT * FROM `dbo_personas` where ApPaterno = '$nomi'");
$re_personas = mysqli_fetch_array($consulta_personas);

$Id =  $re_personas['IdPersona'];

$borra = mysqli_query($con,"DELETE FROM dbo_huellas WHERE IdPersona = '$Id'");
$borra_personal = mysqli_query($con,"DELETE FROM dbo_personas WHERE IdPersona = '$Id'");
$borra_empleados = mysqli_query($con,"DELETE FROM empleados WHERE  numero_nomina = '$nomi'");


}

?>


<?php include("encabezado.php"); ?>

  
  <!--  
  Aqui se encuentra la parte donde se muestra del departamento y el usuario, y ahi mismo
  se encuentra contenido el acceso a el menu vertical -->

<?php include("side_bar_rh.php");?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Empleados </h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              <li class="breadcrumb-item active"> </li>
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
                <h3 class="card-title">Nuevo Empleado<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              <table width="1126" class="table table-bordered">
              <thead>
              <tr>
              <th width="52" style="width: 10px">Nomina</th>
              <th width="576">Nombre del Empleado</th>
              <th width="208">Empresa</th>
              <th width="270" style="width: 40px"></th>
              <th width="270" style="width: 40px"></th>
              <th width="270" style="width: 40px"></th>
              <th width="270" style="width: 40px"></th>
              <th width="270" style="width: 40px"></th>
              <th width="270" style="width: 40px"></th>
              <th width="270" style="width: 40px"></th>
              </tr>
              </thead>
              <script>
                const json = {
                    nombre: [],
                    nomina: []
                };
              </script>
              <tbody>
              

              <?php

              $consulta = mysqli_query($con, "SELECT * FROM empleados ORDER BY nombre");
              while($re = mysqli_fetch_array($consulta)){

              ?>
                <script>
                    json['nombre'].push('<?php echo $re['nombre'];?>');
                    json['nomina'].push(<?php echo $re['numero_nomina'];?>);
                </script>
              <tr>
              <td><?php echo $re['numero_nomina']; ?></td>
              <td><?php echo utf8_encode($re['nombre']); ?></td>
              <td><?php echo utf8_encode($re['sucursal']); ?> </td>
                    <td><?php 
                    
                    
                    $empre = $re['empresa'];


                    if ($empre == 1) { echo "EL REY DEL TORNILLO"; }
                    
                    if ($empre == 2) { echo "FIJACIONES"; }
                    
                    ?></td>
                    <td><a href="elije_consulta.php?cve=<?php echo $re[id]; ?>">Ver Asistencias</a></td>
                    <td><a href="edita_empleado.php?txtnomina=<?php echo $re['numero_nomina']; ?>&opc=1">Editar empleado</a></td>
                   <td><a href="empleados_rh.php?nom=<?php echo $re['numero_nomina']; ?>&borrado=1">Borrar Huellas</a></td>
                   <td><a href="agrega_asistencia2.php?nom=<?php echo $re['numero_nomina']; ?>">Agregar Incidencia</a></td>
                  
                  
                   <td>
                     
                   
                  <?php 	if($_SESSION['usuario'] == "admin"){
                  ?>
                   <a href="empleados_rh.php?nom=<?php echo $re['numero_nomina']; ?>&borrado=2">Borrar Empleado</a></td>
                  <?php
                  }
                  ?>
                  <td>
                    <a href="#" onclick="newBoss(<?php echo $re['numero_nomina'];?>, '<?php echo $re['nombre'];?>')">Asignar/Ver jefe</a>
                  </td>
                   <td>

                      <a href="muestra_autorizaciones.php?nom=<?php echo $re['numero_nomina']; ?>&borrado=2">Ver Autorizaciones</a></td>
            
                  
                  </td>
                   <td>
                   
                          <?php 	if($re['estatus'] == "1"){
                  ?>
                   
                   <a href="inactiva_empleado.php?nom=<?php echo $re['numero_nomina']; ?>"><img src="https://img.icons8.com/external-becris-lineal-becris/28/000000/external-check-mintab-for-ios-becris-lineal-becris.png"/>
                   <?php
                  }else {
                  ?>
                    
                    <a href="activa_empleado.php?nom=<?php echo $re['numero_nomina']; ?>"><img src="https://img.icons8.com/ios/28/000000/delete-forever--v1.png"/></a>
                    
                  <?php
                  }
                  ?>
                   
                   
                   
                   </td>



                    





              <?php



            






              }

              ?>


              </tr>


              </tbody>
              </table>
           
                

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



  <!-- MODALES -->

   <!-- Modal para agregar -->

<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Nuevo Empleado</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="empleados_rh.php" method="get" >                 
<div class="row">




<div class="col-4">
Nombre del Empleado
  <input type="text" class="form-control" id="txtnombre" placeholder="Descripcion" name="txtnombre" required  >
	
</div>

  <div class="col-4">
  Numero de Nomina <input type="text" class="form-control" id="txtnomina" placeholder="Numero de Nomina" name="txtnomina" required  >
</div>


<div class="col-4">
Empresa
<select name="lblempresa" id="lblempresa" class="form-control">

  <option value="1">EL REY DEL TORNILLO</option>
  <option value="2">FIJACIONES</option
></select>

</div>






</div>
</div>


<div class="row">

      <div class="col-3">
      <label for="inputEmail3" class="col col-form-label" >Sucursal</label>
            <select name="lblsucursales" id="lblfsucursales" class="form-control">

            <option value="ALTOS HORNOS">ALTOS HORNOS</option>
            <option value="CALDERA">CALDERA</option>
            <option value="ALAMBIQUES">ALAMBIQUES</option>
            <option value="FIJACIONES">FIJACIONES</option>
            <option value="CHIHUAHUA">CHIHUAHUA</option>
            <option value="QUERETARO">QUERETARO</option>
            <option value="MERIDA">MERIDA</option>
            <option value="VERACRUZ">VERACRUZ</option>

            </select>
      </div>

    <div class="col-1">
        <label for="inputEmail3" class="col-sm-2 col-form-label" >Extras</label>
              <select name="lblhoras" id="lblhoras" class="form-control">
              <option value="NO">NO</option>  
              <option value="SI">SI</option>
              
              </select>
      
    </div>

    <div class="col-3">
        <label for="inputEmail3" class="col col-form-label" >Medias Horas</label>
          <select name="lblmedias" id="lblmedias" class="form-control">
          <option value="NO">NO</option>          
          <option value="SI">SI</option>
                   
          </select>
      </div>


    <div class="col-2">
        <label for="inputEmail3" class="col col-form-label" >Tipo</label>

        <select name="lbltipo" id="lbltipo" class="form-control">
          <option value="Administrativo">Administrativo</option>
          <option value="Operativo">Operativo</option>
        </select>
    </div>
  </div>




<div row">
<div class="col-4">
<label for="inputEmail3" class="col col-form-label" >Horario</label>
        <select name="lblhorario" id="lblhorario" class="form-control">
              <option value="<?php echo $re[horario]; ?>"><?php echo $re[horario]; ?></option>

              <?php
              $consulta_hor =  mysqli_query($con,"SELECT * FROM `horarios` order by 1");

              while($re_hor = mysqli_fetch_array($consulta_hor)){

              ?>
              <option value="<?php echo $re_hor[id]; ?>"><?php echo $re_hor[id]. " - ".$re_hor[horario]; ?></option>

              <?php

              }

              ?>

        </select>
        </div>
</div>



  
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
                
        
    <div class="row">
        <div class="col-sm-2 ">
                  <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cerrar</button>
        </div>
        <div class="col-sm-8 ">
                  
        </div>
        <div class="col-sm-2 ">
                  <button type="submit" class="btn btn-primary btn-block">Guardar</button>
        </div>
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
<!-- Sweet Alert 2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
<script src="dist/js/empleados_rh.js"></script>
</body>
</html>
