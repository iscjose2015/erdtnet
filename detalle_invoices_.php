
<?php


	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");
  date_default_timezone_set('America/Mexico_City');

  
        if($_GET[opc] == 1){

            $cant = $_GET[txtcantidad];
            $inserta = mysqli_query($cone,"INSERT INTO `detalle_ordenes` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`, `monto`, `unidad`) 
            VALUES (NULL, '6', '1001', 'tal', '$cant', '100.00', 'PZA');");

        }


        if($_GET[opc] == 3){
              $bor = $_GET[txtid];
              echo "entro aqui".$bor;

              $inserta = mysqli_query($cone,"DELETE FROM `detalle_invoices` WHERE `detalle_invoices`.`id` = '$bor'");
            //  header('location: detalle_invoices.php?idorden='.$_GET[idorden].'&serie='.$_GET[serie]);

        }
        


	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Detalle de Orden de Compra";
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
            <h1>Detalle de la Factura</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              <li class="breadcrumb-item active">Fecha y hora: <?php echo  date("d-m-Y H:m:s"); ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <?php




$clave = $_GET['idorden'];

$consulta_orden= mysqli_query($cone,"SELECT * FROM `invoices` WHERE `id` = '$clave'");
$re_orden = mysqli_fetch_array($consulta_orden);
$consulta = mysqli_query($cone, "SELECT * FROM `detalle_invoices` where idorden = '$clave';");

$emi = $re_orden['emisor'];
$rece = $re_orden['receptor'];


$consulta_emisor = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emi'");
$consulta_receptor = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente = '$rece'");

$re_emisor   = mysqli_fetch_array($consulta_emisor);
$re_receptor = mysqli_fetch_array($consulta_receptor);

    ?>


    <div class="card-header">


    <table width="100%" border="1">
  <tr>
    <td width="50%">DATOS</td>
    <td width="30%" align="center">ACCIONES</td>
    <td width="20%" align="center">Estatus <?php echo $re_orden[estatus];?></td>
  </tr>
  <tr>
    <td>


    <table width="100%" border="0">
  <tr>
    <td width="15%">Emisor</td>
    <td width="30%"><?php echo $re_emisor['empresa']; ?></td>
    <td width="18%">Receptor</td>
    <td width="37%"><?php echo utf8_encode($re_receptor['nombre_cliente']); ?></td>
  </tr>
  <tr>
    <td>Direccion</td>
    <td><?php echo $re_emisor['direccion']; ?></td>
    <td>Direccion</td>
    <td><?php echo $re_receptor['direccion_cliente']; ?></td>
  </tr>
  <tr>
    <td>Telefono</td>
    <td><?php echo $re_emisor['telefono']; ?></td>
    <td>Telefono</td>
    <td><?php echo $re_emisor['telefono_cliente']; ?></td>
  </tr>
</table>



    </td>
    <td align="center">

    <?php

    if($re_orden[estatus] == 'Por Emitir'  )
    {

      $ruta_imagen = "https://img.icons8.com/doodle/72/000000/error.png";

      $archivo = $re_orden['serie']."_".$re_orden['id'];

    ?>

    <a href="../facturacion/timbrado/php/crear_xml.php?cve=<?php echo $_GET['idorden']; ?>"><img src="https://img.icons8.com/plasticine/50/000000/create-new.png"/> Crear XML</a>

    <?php
    }
    else{

    echo "Serie y Folio:".$re_orden[serie]." ".$re_orden[id];
    echo "<br>";

    echo "UUID: ".$re_orden[uuid];
    echo "<br>";

    $archivo = $re_orden['serie']."_".$re_orden['id'];

    $ruta_imagen = 'https://elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/'.$archivo.'_QR.jpg';
    ?>

    <a href="timbrado/files/cfdi/descarga_xml.php?valor=<?php echo $archivo; ?>">Descargar XML</a>

    <!---->

      -->


  <!-- timbrado/files/cfdi/factura_pdf.php -->   

    <a href="https://elreydeltornillo.com/sit/facturacion/pdfdom/crearPdf.php?idorden=<?php echo $_GET[idorden];?>" target="_blank">Descargar PDF</a>

    <?php

    }

    ?>

    </td>
    <td align="center"><img src="<?php  echo $ruta_imagen; ?>" width="100" height="100" /></td>
  </tr>
</table>
    
             

            
<p></p>     
<p></p>   

<table width="100%" border="0">
  <tr>
    <td><h3 class="card-title"><!--Agregar Producto<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a>--></h3></td>
    <td></td>
    <td>
      
    
 
  
  </td>
  </tr>
</table>




<table width="100%" border="1">
  <tr>
    <td width="25%">Fecha de Emision</td>
    <td width="26%"><?php echo $re_orden[fecha_emision]; ?></td>
    <td width="16%">Moneda</td>
    <td width="33%"><?php echo $re_orden[moneda]; ?></td>
  </tr>
  <tr>
    <td>Hora:</td>
    <td><?php echo $re_orden[hora]; ?></td>
    <td>Forma de Pago</td>
    <td><?php echo $re_orden[forma_pago]; ?></td>
  </tr>
  <tr>
    <td>Serie</td>
    <td><?php echo $re_orden[serie]; ?></td>
    <td>Lugar de Expedicion</td>
    <td><?php echo $re_orden[lugar]; ?></td>
  </tr>
  <tr>
    <td>Metodo de Pago</td>
    <td><?php echo $re_orden[metodo_pago]; ?></td>
    <td>Pedimento</td>
    <td><?php echo $re_orden[pedimento]; ?></td>
  </tr>
  <tr>
    <td>Tipo de Comprobante</td>
    <td><?php echo $re_orden[tipo_cfdi]; ?></td>
    <td>Fecha de Pedimiento</td>
    <td><?php echo $re_orden[uso]; ?></td>
  </tr>
</table>



            
            
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <?php


$consulta2 = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where idorden = '$clave';");


$suma = 0;

while($re = mysqli_fetch_array($consulta2)){

  $importe = $re['monto'] * $re['cantidad']; 
  $suma = $importe  +  $suma;


}






?>


<table width="100%" border="1">
  <tr>
    <td width="31%">

    <?php

    if($re_orden[estatus] == 'Timbrada')
    {

    ?>
      
    <a href="cancelar.php?folio_fiscal=<?php echo $re_orden[uuid]; ?>"><img src="https://img.icons8.com/cotton/64/000000/cancel--v1.png"/> Cancelar Factura</a>
  <?php

    }

  ?>
  
  </td>
    <td width="52%">
      <?php


    if($re_orden[estatus] == 'Por Emitir')
    {

    ?>
      
      <a href="productos.php?val=4&fac=<?php echo $_GET[serie] ?>"><img src="https://img.icons8.com/ios/50/000000/add-list.png"/> Agregar Productos del Inventario
  <?php

    }

  ?>
      
    
    
  
  
  
  
  </td>
    <td width="17%"><?php 
    

    $importe_factura = saber_total_factura($re_orden[id]);
    
    echo "Subtotal: $".number_format($importe_factura,2);
    echo "<br>";
    echo "Iva: $" .number_format($importe_factura * 0.16,2);
    echo "<br>";
    echo "Total: $".number_format($importe_factura * 1.16,2);
    echo "<br>";
    
    
    
    ?></td>
  </tr>
</table>

<p></p>

<p></p>

<p></p>


  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Monto</th>
                    <th>Importe</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php


                    $fa = $_GET['serie'];

                  $consulta_detalle = mysqli_query($cone,"select * from detalle_invoices where idfactura = '$fa'");
                  

                   //echo "total:".mysqli_num_rows($consulta);

                    while($red = mysqli_fetch_array($consulta_detalle)){

                    ?>
                  
                  <tr>
                    <td><?php echo $red['cantidad']; ?></td>
                    <td><?php echo utf8_encode($red['unidad']); ?> </td>
                    <td><?php echo utf8_encode($red['c_producto']); ?> </td>
                    <td><?php echo utf8_encode($red['descripcion']); ?> </td>
                    <td>$<?php echo utf8_encode($red['monto']); ?></td>
                    <td>$<?php echo $red['monto'] * $red['cantidad']; ?></td>
                    <td> <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php // echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->
                  
                  
                  
                  </td>


                    
                  
                    <td>
                      <?php
                      
                    if ($re_orden[estatus] == 'Cancelada'){

                    }
                    else {
                      
                    

                    ?>
                    
                    <a href="#" data-toggle="modal" data-target="#modal-borrar_<?php echo $red['id']; ?>"><img src="https://img.icons8.com/metro/24/A83339/trash.png"/></a></td>
                   <?php
                    }
                    ?>

                  </tr>



                   <!-- Modal de  edicion -->

                  <div class="modal fade" id="modal-edit_<?php echo $re['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Editar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="detalle_orden.php" method="get" >

                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo" required value= "<?php echo $re['id']; ?>"  readonly="readonly" >
                    </div>
                    </div>



                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Empresa</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtempresa" placeholder="Codigo" name="txtempresa" required value= "<?php echo $re['empresa']; ?>"   >
                    </div>
                  </div>


          
                  
                  


                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />
                  <input name="idorden" type="hidden" value="<?php echo $_GET[idorden] ?>" />


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

                <div class="modal fade" id="modal-borrar_<?php echo $red['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Borrar Producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="detalle_invoices.php" method="get" >

                   
                   <p><?php echo "Clave: ".$red[id]; ?></p>
                   <p><?php echo "Cod Prod: ".$red[c_producto]; ?></p>
                   <p><?php echo "Descripcion: ".$red[descripcion]; ?></p>
                   

                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden"   value="<?php echo $red[id]; ?>" />
                  <input name="idorden" type="hidden" value="<?php echo $_GET[idorden]; ?>" />
                  <input name="serie" type="hidden"   value="<?php echo $_GET[serie]; ?>" />
             
              


                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar Borrado</button>
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
                  <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Monto</th>
                    <th></th>
                    <th>Importe</th>
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
        <h4 class="modal-title">Agregar Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="detalle_orden.php" method="get" >                 
<div class="row">




<div class="col-6">
Cantidad
  <input type="text" class="form-control" id="txtcantidad" placeholder="Cantidad" name="txtcantidad" required  >
	
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

   <div class="col-sm-3 "> 
    	<input type="hidden" name="idorden" id="hiddenField" value="<?php echo $clave;  ?>" />
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
	//include("footer.php");




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
