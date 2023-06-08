<?php

	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");


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




        if($_GET[opc] == 3){

            $cod =  $_GET[txtid];
            $cost = $_GET[txtcosto];
            $pre =  $_GET[txtprecio];
            $cant =  $_GET[txtcantidad];
 


           // echo $cost.$pre;

            $actualiza = mysqli_query($cone,"UPDATE `products` SET `costo` = '$cost', `precio` = '$pre'
             WHERE `products`.`codigo_producto` = '$cod';");

          //  header("location: productos.php");


           //
        }


        if($_GET[val] == 4){


          //echo "Entro Aqui a 4";


          if ($_GET[txtid] != ''){


            $import = $cant * $pre;
            $consulta_producto_venta = mysqli_query($cone,"SELECT * FROM `products` where codigo_producto = '$cod';");
            $re_pro = mysqli_fetch_array($consulta_producto_venta);

            $des = $re_pro[nombre_producto];
            $uni = $re_pro[unidad];
            $codi_sat = $re_pro[id_sat];
            $uni_sat = $re_pro[unidad];
            $factu = $_GET[fac];



            $import =  $cost * $pre;


            $consulta_invoice = mysqli_query($cone,"SELECT * FROM `invoices` where id = '$factu';");
            $re_invo = mysqli_fetch_array($consulta_invoice);


           if($re_invo[tiporelacionado] == '01' and $re_invo[tipo_cfdi]  == 'E' ) {

          

            $des = "BONIFICACION DE SERVICIOS";

            echo "Si entro";



           }

           // echo "Descr".$des;

            $inserta = mysqli_query($cone,"INSERT INTO `detalle_invoices` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`, `monto`, `unidad`, `idfactura`, `importe`, `unidad_sat`, `codigo_sat`) 
                                                                          VALUES (NULL, '0', '$cod', '$des', '$cant', '$pre', '$uni', '$factu', '$import', '$uni_sat', '$codi_sat');");

          }


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
            <h1>&nbsp;</h1>
            <table width="100%" border="0" align="center">
              <tr>
                <td align="center"><h1>Productos</h1>
                  <p>&nbsp;</p>
                  <p>
                    <?php

            if($_GET[val] == 4){

            ?>
                    <a href="detalle_invoices.php?idorden=<?php echo $_GET[fac];  ?>&serie=<?php echo $_GET[fac];  ?>"> Ir a Factura </a>
                    <?php

            }

            ?>
                </p></td>
              </tr>
            </table>
            <p>&nbsp;</p>
          </div>
          <div class="col-sm-6"> </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="card-header">
             <!--   <h3 class="card-title">Nuevo Cliente<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3> -->
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Codigo Producto</th>
                    <th>Nombre</th>
                    <th>Existencia</th>
                    <th>Id Sat</th>
                    <th>Nombre Sat</th>
                    <th>Unidad Sat</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php


                    if ($_GET[tipo] == 's' or $_SESSION[tipo] == 'anticipo' ){

                      echo "Entro aqui";

                    $consulta = mysqli_query($cone, "SELECT * FROM `products` where tipo = 'S';");

                    }
                    else {

                      $consulta = mysqli_query($cone, "SELECT * FROM `products` where existencia > 0 and existencia != '' ");

                 
                    }

                   

                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td><?php echo $re['codigo_producto']; ?></td>
                    <td><?php echo utf8_encode($re['nombre_producto']); ?> </td>
                    <td><?php echo utf8_encode($re['existencia']); ?> </td>
                    <td><?php echo utf8_encode($re['id_sat']); ?> </td>
                    <td><?php echo utf8_encode($re['nom_sat']); ?></td>
                    <td><?php echo utf8_encode($re['unidad_sat']); ?></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><a href="#" data-toggle="modal" data-target="#modal-edit_<?php echo $re['codigo_producto']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>
                  </tr>



                   <!-- Modal de  edicion -->

                  <div class="modal fade" id="modal-edit_<?php echo $re['codigo_producto']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Actualizar </h4>

                   

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="productos.php" method="get" >

                 
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Clave de Producto</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo"  value= "<?php echo $re['codigo_producto']; ?>"  readonly="readonly" >
                    </div>
                    </div>


                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Nombre del Producto</label>
                    <div class="col-sm-10">
                      <p><?php echo $re[nombre_producto]; ?></p>
                    </div>
                    </div>


                    
                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Precio</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcosto" placeholder="Costo" name="txtcosto"  value= "<?php echo saber_costo(number_format($re['codigo_producto'],3));  ?>"  readonly  >
                    </div>
                  </div>


                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Precio con Ultilidad</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtprecio" placeholder="Precio Venta" name="txtprecio"  value= "<?php echo number_format($re['precio'],3); ?>"   required="required" >
                    </div>
                  </div>


                  <?php if ($_GET[val] == 4) {?>
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Cantidad</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="txtcantidad" placeholder="Cantidad" name="txtcantidad"  value= "<?php echo $re['existencia']; ?>"  required="required" max="<?php echo $re['existencia']; ?>"  >
                    </div>
                  </div>


                  <input name="fac" type="hidden" value="<?php echo $_GET['fac']; ?>" />

                  <?php

                  

                  }

                  ?>

          

                  <input name="opc" type="hidden" value="3" />
                  <input name="val" type="hidden" value="<?php echo $_GET['val']; ?>" />
                  <input name="txtid" type="hidden" value="<?php echo $re[codigo_producto]; ?>" />


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
                  <th>Codigo Producto</th>
                    <th>Nombre</th>
                    <th>Existencia</th>
                    <th>Id Sat</th>
                    <th>Nombre Sat</th>
                    <th>Unidad Sat</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th></th>
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
        <h4 class="modal-title">Registro de Cliente Nuevo </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="clientes.php" method="get" >                 
<div class="row">




<div class="col-6">
RFC
  <input type="text" class="form-control" id="txtrfc" placeholder="RFC" name="txtrfc" required  >
	
</div>

<div class="col-6">
Nombre del Cliente
  <input type="text" class="form-control" id="txtnombre" placeholder="Nombre" name="txtnombre" required  >
	
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
