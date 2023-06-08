
<?php


	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");

  date_default_timezone_set('America/Mexico_City');

        if($_GET[opc] == 1){

          

            $u = $_GET[lbluuid];
            $fac = $_GET[idorden];


             $cons_u = mysqli_query($cone,"SELECT * FROM `invoices` WHERE `uuid` = '$u'");
             $reuu = mysqli_fetch_array($cons_u);


          

            $se = $reuu[serie];

            echo "Esta es la serie".$se;

            $fol = $reuu[id];
            $mon = $reuu[moneda];
            $met =$reuu[metodo_pago];



            $suma = 0;

            $consulta_total = mysqli_query($cone,"SELECT * FROM `detalle_invoices` where idfactura = '$fact'");

            while($re_total=mysqli_fetch_array($consulta_total)){

              $suma = $suma + ($re_total[cantidad] * $re_total[monto]);

            }

            
      

            $sal =  $suma;
            $impo = $suma;

			

            
            $cons_t = mysqli_query($cone,"SELECT * FROM `complementos` where id = '$fac';");
            $ret = mysqli_fetch_array($cons_t);

            $tipoca = $ret[tipo_cambio];



            $importe_factura = saber_total_factura($fol);


            echo $importe_factura;
        
            $valor_factura_con_iva = number_format($importe_factura * 1.16,2);
          
            
            $inserta = mysqli_query($cone,"INSERT INTO `detalle_complementos` (`id`, `idfactura`, `uuid`, `serie`, `folio`, `moneda`, `tipocambio`, `metodopago`, `parcialidad`, `saldo`, `importe`, `idorden`, `insoluto`) 
            VALUES (NULL, '$fol', '$u', '$se', '$fol', '$mon', '$tipoca', '$met', '1', '$valor_factura_con_iva', '$valor_factura_con_iva','$fac','0');");

            

        }


        if($_GET[opc] == 3){
              $bor = $_GET[txtid];
              echo "entro aqui".$bor;

            //  $inserta = mysqli_query($cone,"DELETE FROM `detalle_invoices` WHERE `detalle_invoices`.`id` = '$bor'");
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
            <h1>Detalle Complemento</h1>
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

$consulta_orden= mysqli_query($cone,"SELECT * FROM `complementos` WHERE `id` = '$clave'");
$re_orden = mysqli_fetch_array($consulta_orden);
$consulta = mysqli_query($cone, "SELECT * FROM `detalle_complementos` where idorden = '$clave';");

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

    <a href="../facturacion/timbrado/php/crear_xml_comple.php?cve=<?php echo $_GET['idorden']; ?>"><img src="https://img.icons8.com/plasticine/50/000000/create-new.png"/> Crear XML</a>

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

    <a href="https://elreydeltornillo.com/sit/facturacion/pdfdom/crearPdf_comple.php?idorden=<?php echo $_GET[idorden];?>" target="_blank">Descargar PDF</a>

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
    <td><h3 class="card-title">></td>
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
    <td>Fecha de Pago</td>
    <td><?php echo $re_orden[fecha_pago]; ?></td>
    </tr>
  <tr>
    <td>Serie</td>
    <td><?php echo $re_orden[serie]; ?></td>
    <td>Lugar de Expedicion</td>
    <td><?php echo $re_orden[lugar]; ?></td>
    </tr>
  <tr>
    <td>Metodo de Pago</td>
    <td>NO APLICA</td>
    <td>Forma de Pago</td>
    <td><?php echo $re_orden[forma_pago];
	
	  if ($re_orden[forma_pago] == '03') { echo "Transferencia electrónica de fondos";}
	  if ($re_orden[forma_pago] == '01') { echo "Efectivo";}
	  
	  /*
	  
	    <option value="99">99 Por Definir</option>
		  <option value="01">01 Efectivo</option>
		  <option value="02">02 Cheque nominativo</option>
		  <option value="03">03 Transferencia electrónica de fondos</option>
		  <option value="30">30 Aplicacion de Anticipos</option>
		  <option value="99">99 Por Definir</option>
	  
	  */
	
	
	 ?></td>
    </tr>
  <tr>
    <td>Tipo de Comprobante</td>
    <td><?php echo $re_orden[tipo_cfdi];
	
	  $tip = $re_orden[tipo_cfdi];
	  
	  
	  if ($tip == 'P') { echo " Complemento para recepción de pagos";}
	
	
	 ?></td>
    <td>Tipo de Cambio</td>
    <td><?php echo $re_orden[tipo_cambio];
	  
	
	
	 ?></td>
    </tr>
  <tr>
    <td>Version </td>
    <td>3.3</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>RFC y Cuenta Ordenante</td>
    <td><?php  
	
	  $ord = $re_orden[ordenante];
	  
	  
	  $consulta_orde = mysqli_query($con,"SELECT * FROM `cuentas_ordenantes` where id = '$ord';");
	  $re_o = mysqli_fetch_array($consulta_orde);
	  
	  echo $re_o[banco]." ".$re_o[cuenta];
	  

	
	
	 ?></td>
    <td>RFC y Cuenta  Beneficiario</td>
    <td><?php  
	
	  $ben = $re_orden[beneficiario];
	  
	  
	  $consulta_ben = mysqli_query($con,"SELECT * FROM `cuentas_bancaras` where id = '$ben';");
	  $re_b = mysqli_fetch_array($consulta_ben);
	  
	  echo $re_b[banco]." ".$re_b[cuenta];
	  

	
	
	 ?></td>
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


<h3>Agregar Factura<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a></h3
      
    ><?php

    }

  ?>
      
    
    
  
  
  
  
  </td>
    <td width="17%"><?php 
    
    
    
    echo "Total: $".$re_orden[total] 

    
    
    ?></td>
  </tr>
</table>

<p></p>

<p></p>

<p></p>


  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="67">Id Interno</th>
                    <th width="40">UUID</th>
                    <th width="84">Serie y Folio</th>
                    <th width="161">No de Parcialidad</th>
                    <th width="97">Saldo Anterior</th>
                    <th width="114">Importe del Pago</th>
                    <th width="98">Saldo del Pago</th>
                    <th width="17"></th>
                    <th width="54"></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php


                    $fa = $_GET['idorden'];

                  $consulta_detalle = mysqli_query($cone,"select * from detalle_complementos where idorden = '$fa'");
                  

                   //echo "total:".mysqli_num_rows($consulta);

                    while($red = mysqli_fetch_array($consulta_detalle)){

                    ?>
                  
                  <tr>
                    <td><?php echo $red['id']; ?></td>
                    <td><?php echo utf8_encode($red['uuid']); ?> </td>
                    <td><?php echo utf8_encode($red['serie']); ?> </td>
                    <td>   <?php echo $red['parcialidad']; ?></td>
                    <td>   <?php echo $red['saldo']; ?></td>
                    <td>   <?php echo $red['saldo']; ?></td>
                    <td>   <?php echo "0"; ?></td>
                    <td>   <?php echo "0"; ?></td>
      
                    <td> 
                     <?php
                     

                     if($re_orden[estatus] == 'Por Emitir')
                     {
                     
                     ?>
                    
                    
                    <a href="#" data-toggle="modal" data-target="#modal-edit_<?php  echo $red['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>
                   
                      <?php

                     }

                      ?>

                  </tr>



                   <!-- Modal de  edicion -->

                  <div class="modal fade" id="modal-edit_<?php  echo $red['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Editar Complemento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="detalle_complemento.php" method="get" >

                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo" required value= "<?php echo $red['id']; ?>"  readonly="readonly" >
                    </div>
                    </div>



                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">UUID</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtuuid" placeholder="UUID" name="txtuuid" required value= "<?php echo $red['uuid']; ?>" readonly  >
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
                <th width="67">Id Interno</th>
                    <th width="40">UUID</th>
                    <th width="84">Serie y Folio</th>
                    <th width="161">No de Parcialidad</th>
                    <th width="97">Saldo Anterior</th>
                    <th width="114">Importe del Pago</th>
                    <th width="98">Saldo del Pago</th>
                    <th width="17"></th>
                    <th width="54"></th>
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
        <h4 class="modal-title">Agregar Factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="detalle_complementos.php" method="get" >                 
<div class="row">




<div class="col-6">
UUID 
<select name="lbluuid" id="lbluuid" class="form-control">
  <?php
  
  
  $consulta_u = mysqli_query($cone,"SELECT * FROM `invoices` where uuid <> '';");
  
  while($re_u = mysqli_fetch_array($consulta_u)){
  
  ?>
  <option value="<?php  echo $re_u[uuid]?>"><?php  echo $re_u[serie]." ".$re_u[id]." ".$re_u[uuid]?></option>
  <?php
  
  }
  
  ?>
  
  
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
