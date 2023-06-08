<?php

	session_start();
  error_reporting(0);

  include("conecta_facturacion.php");
  include("funciones_factura.php");


  $usuario =  $_SESSION['user_id'];

  $val =  trim($_GET[valor]);

  $suc = $_GET[suc];
  $va  = $_GET[valor];



  function saber_peso($cod){
    
    include("conecta_facturacion.php");
    $consulta_prod = mysqli_query($cone,"SELECT peso FROM `products` WHERE `codigo_producto` = '$cod'");
    $re_prod = mysqli_fetch_array($consulta_prod);
  
    $we = $re_prod['peso'];
  
    return  $we;
  
    }





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


      

          

            header("location: contendores.php");

          


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
            <p>&nbsp;</p>
          </div>
          <table width="100%" border="0" align="left">
            <tr>
              <td width="50%" align="right"><h1>DETALLE DEL CONTENEDOR</h1></td>
              <td width="50%" align="center"><h1>
                <?php //echo $val." ".$suc; ?>
              </h1>
                <?php
            

              $consulta_contenedor = mysqli_query($cone,"SELECT DISTINCT(contenedor),sucursal, estatus FROM `contenedores` 
              where contenedor = '$val' and sucursal = '$suc';");
              
              $re_cont = mysqli_fetch_array($consulta_contenedor);

              $activo = $re_cont[estatus];

            if ( $_GET[opc] == '5' and activo == 0 ) {

            ?>
                <p><a class="btn btn-primary btn btn-success " href="detalle_invoices.php?idorden=<?php echo $_GET[idorden]; ?>&serie=<?php echo $_GET[serie]?>&opc=5&valor=<?php echo $_GET[valor];?>&suc=<?php echo $_GET[suc];?>" role="button">Agregar a Factura <?php echo $val." ".$suc; ?></a></p>
                <p>
                  <?php

            }

            ?>
              </p></td>
            </tr>
          </table>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="card-header">
                <h3 class="card-title"><a href = "#" data-toggle="modal" data-target="#modal-xl"></a></h3>
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Cod Prod</th>
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
    
                    <th>Importe</th>
                    <th>Factor</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php


               
                    $consulta = mysqli_query($cone, "SELECT * FROM `detalle_fact_provee` WHERE `contenedor` = '$va' and sucursal = '$suc';");


                   //echo "total:".mysqli_num_rows($consulta);

                   
                   $suma_de_pesos = 0;
                     
                      $codp =  $re['c_producto'];

                      while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td><?php echo $re['c_producto']; ?></td>
                    <td><?php echo $re['descripcion']; ?></td>
                    <td><?php echo $re['unidad']; ?></td>
                    <td><?php echo $re['cantidad']; ?></td>
                    <td>$<?php echo number_format($re['importe'],2);; ?></td>
                    <td>$<?php echo  number_format($re['factor'],3); ?></td>
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
            <th>Cod Prod</th>
                    <th>Producto</th>
                    <th>Unidad</th>
                    <th>Cantidad</th>
    
                    <th>Importe</th>
                    <th>Factor</th>
                    </tr>
                  </tfoot>
                </table>
  <p>&nbsp;</p>




                 
  

  </div>
</div>





  

  
</main>


<!-- Agregar -->

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
