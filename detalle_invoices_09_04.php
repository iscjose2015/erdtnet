
<?php


	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");
  date_default_timezone_set('America/Mexico_City');
  
        if(isset($_GET['opc']) && $_GET['opc'] == 1){

            $cant = $_GET['txtcantidad'];
            $inserta = mysqli_query($cone,"INSERT INTO `detalle_ordenes` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`, `monto`, `unidad`) 
            VALUES (NULL, '6', '1001', 'tal', '$cant', '100.00', 'PZA');");

        }


        if(isset($_GET['opc']) && $_GET['opc'] == 3){
              $bor = $_GET['txtid'];
             // echo "entro aqui".$bor;

              $inserta = mysqli_query($cone,"DELETE FROM `detalle_invoices` WHERE `detalle_invoices`.`id` = '$bor'");
            //  header('location: detalle_invoices.php?idorden='.$_GET[idorden].'&serie='.$_GET[serie]);

        }
		
		
		
		      if(isset($_GET['opc']) && $_GET['opc'] == 5){
              
			  
			      $val = $_GET['valor'];
            $suc = $_GET['suc'];
				  
				    echo $val;
			  
			  
			    $consulta_cont = mysqli_query($cone, "SELECT * FROM `detalle_fact_provee` WHERE `contenedor` = '$val' AND `sucursal` = '$suc'");


                   //echo "total:".mysqli_num_rows($consulta);

                    while($re_cont = mysqli_fetch_array($consulta_cont)){
						
						$pro = $re_cont['c_producto'];
						$idor = $_GET['idorden'];
						$descrip = $re_cont['descripcion'];
						$cant = $re_cont['cantidad'];
						$impo = $re_cont['factor'];
            $uni = $re_cont['unidad'];
            $mon = $re_cont['monto'];


            $consulta_prod = mysqli_query($cone,"SELECT * FROM `products` WHERE `codigo_producto` = '$pro'");
            $re_pro = mysqli_fetch_array($consulta_prod);


            $idsat = $re_pro[id_sat];
            // Codigo del SAT 123541145

            $unisat = $re_pro[unidad_sat];
            // H87

            $nomsat = $re_pro[nom_sat];
            // Nombre Sat, Tornillos

            $uni = $re_pro[unidad];
            // Pieza
				
						
						$inserta_a_factura = mysqli_query($cone,"INSERT INTO `detalle_invoices` (`id`, `idorden`, `c_producto`,
             `descripcion`, `cantidad`, `monto`, `unidad`, `idfactura`, `importe`, `unidad_sat`, `codigo_sat`) 
						VALUES (NULL, '0', '$pro', '$descrip', '$cant', '$impo', '$uni', '$idor', '$mon', '$uni', '$idsat')");
						
				
            // Actualiza el contenedor

            $fa =   $_GET[idorden];
            $su =     $_GET[suc];
            $conte =  $_GET[valor];

       

            $actuliza = mysqli_query($cone,"UPDATE `invoices` SET `contenedor` = '$conte', `sucursal` = '$su' 
            WHERE `invoices`.`id` = '$fa';");
        
        
        
          }
             
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
  <style type="text/css">
  .chica2 {	font-size:11px; }
  </style>
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
              <li class="breadcrumb-item active"> <?php //echo  //date("d-m-Y H:m:s"); ?></li>
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
    <td width="50%"><strong><em>DATOS</em></strong></td>
    <td width="30%" align="center">ACCIONES</td>
    <td width="20%" align="center">Estatus <?php echo $re_orden['estatus'];?></td>
  </tr>
  <tr>
    <td>


    <table width="100%" border="0">
  <tr>
    <td width="15%"><em><strong>Emisor</strong></em></td>
    <td width="30%"><?php echo $re_emisor['rfc']." - ".$re_emisor['empresa']; ?></td>
    <td width="13%"><em><strong>Receptor</strong></em></td>
    <td width="42%"><?php  echo utf8_encode($re_receptor['rfc']." - ".$re_receptor['nombre_cliente']); ?></td>
  </tr>
  <tr>
    <td><em><strong>Direccion</strong></em></td>
    <td><?php echo $re_emisor['direccion']; ?></td>
    <td><em><strong>Direccion</strong></em></td>
    <td><?php echo $re_receptor['direccion_cliente']." ".$re_receptor['colonia']." ".$re_receptor['ciudad']." ".$re_receptor['ciudad']." ".$re_receptor['estado']." ".$re_receptor['cp']; ?></td>
  </tr>
  <tr>
    <td><em><strong>Telefono</strong></em></td>
    <td><?php echo $re_emisor['telefono']; ?></td>
    <td><em><strong>Telefono</strong></em></td>
    <td><?php echo $re_receptor['telefono_cliente']; ?></td>
  </tr>
</table>



    </td>
    <td align="center">

      <p>
        <?php

      //  echo  $re_orden['estatus'];

    if($re_orden['estatus'] == 'Por Emitir'  )
    {

      $ruta_imagen = "https://img.icons8.com/doodle/72/000000/error.png";

      $archivo = $re_orden['serie']."_".$re_orden['id'];

    ?>
        
        

       <!-- <a href="../facturacion/timbrado/php/crear_xml.php?cve=<?php //echo // $_GET['idorden']; ?>"><img src="https://img.icons8.com/plasticine/50/000000/create-new.png"/> Crear XML 3.3</a>-->
          <?php echo "<br>"; ?>
        <a href="../facturacion/timbrado/php/crear_xml_4.0.php?cve=<?php echo $_GET['idorden']; ?>"><img src="https://img.icons8.com/plasticine/50/000000/create-new.png"/> Crear XML y timbrar factura 4.0</a>
        

        <?php
    }
    else{

    echo "Serie y Folio:".$re_orden['serie']." ".$re_orden['id'];
    echo "<br>";

    echo "UUID: ".$re_orden['uuid'];
    echo "<br>";

    $archivo = $re_orden['serie']."_".$re_orden['id'];

    $ruta_imagen = 'https://elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/'.$archivo.'_QR.jpg';
    ?>
        
        <a href="timbrado/files/cfdi/descarga_xml.php?valor=<?php echo $archivo; ?>">Descargar XML <img src="https://img.icons8.com/external-others-iconmarket/32/000000/external-xml-file-types-others-iconmarket.png"/></a>
        
        <!---->
        
        <!-- timbrado/files/cfdi/factura_pdf.php -->   
        
        <a href="https://elreydeltornillo.com/sit/facturacion/pdfdom/crearPdf.php?idorden=<?php echo $_GET['idorden'];?>" target="_blank">Visualizar  PDF <img src="https://img.icons8.com/dotty/32/000000/export-pdf.png"/></a>
        
        <?php

    }

    ?>
        
        </p>

     
  
 

      
    <td align="center">
      
    <img src="<?php  echo $ruta_imagen; ?>" width="100" height="100" />



      <p><a href="../../envio_correo_con_datos.php?idorden=<?php echo $_GET[idorden]; ?>">Enviar por Correo Electronico <img src="https://img.icons8.com/external-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto/32/000000/external-email-file-and-folder-yogi-aprelliyanto-basic-outline-yogi-aprelliyanto.png"/></a></p></td>


  
  </td>
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
    <td width="13%"><em><strong>Fecha de Emision</strong></em></td>
    <td width="38%"><?php echo $re_orden['fecha_emision']; ?></td>
    <td width="12%"><em><strong>Moneda</strong></em></td>
    <td width="37%"><?php echo $re_orden['moneda']; ?></td>
    </tr>
  <tr>
    <td><em><strong>Hora:</strong></em></td>
    <td><?php echo $re_orden['hora']; ?></td>
    <td><em><strong>Forma de Pago</strong></em></td>
    <td><?php 
    
    $for = $re_orden['forma_pago'];

    if ($for == '99') { echo "99 Por Definir"; }
    if ($for == '01') { echo "01 Efectivo"; }
    if ($for == '02') { echo "02 Cheque nominativo"; }
    if ($for == '03') { echo "03 Transferencia electrónica de fondos"; }
    if ($for == '30') { echo "Aplicacion de Anticipos"; }
    

    
    
    
    ?></td>
    </tr>
  <tr>
    <td><em><strong>Serie</strong></em></td>
    <td><?php echo $re_orden['serie']; ?></td>
    <td><em><strong>Lugar de Expedicion</strong></em></td>
    <td><?php echo $re_orden['lugar']; ?></td>
    </tr>
  <tr>
    <td><em><strong>Metodo de Pago</strong></em></td>
    <td><?php 
    
    $met = $re_orden['metodo_pago'];


    if ($met == 'PPD') { echo 'PPD - PAGO EN PARCIALIDADES O DIFERIDO';}
    if ($met == 'PUE') { echo 'PUE - PAGO EN UNA SOLA EXHIBICION';}
  
    
    
    
    
    ?></td>
    <td><em><strong>Pedimento</strong></em></td>
    <td><?php echo $re_orden['pedimento']; ?></td>
    </tr>
  <tr>
    <td><em><strong>Tipo de Comprobante</strong></em></td>
    <td><?php 
    
    $in = $re_orden['tipo_cfdi']; 
    if ($in == 'I') { echo 'I - Ingreso';}
    
    ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><em><strong>Uso del CFDI</strong></em></td>
    <td><?php 
    
    $us = $re_orden['uso'];

    if ($us == 'G01') {  echo 'G01 Adquisición de mercancías';}
    if ($us == 'G02') {  echo 'G02 Devoluciones, descuentos o bonificaciones';}
    if ($us == 'G03') {  echo 'G03 Gastos en general';}
    if ($us == 'P01') {  echo 'P01 Por Definir';}
    if ($us == 'S01') {  echo 'S01 Sin efectos fiscales';}
    if ($us == 'CP01') {  echo 'Pagos';}


    
    ?></td>
    <td><em><strong>Version </strong></em></td>
    <td><?php echo $re_orden['version']; ?></td>
  </tr>
  <tr>
    <td><span class="chica2">CFDI Relacion</span></td>
    <td><span class="chica2"><?php echo $re_orden['relacionado']; ?></span></td>
    <td><em><strong><span class="chica2">Tipo Relacion</span></strong></em></td>
    <td><span class="chica2">
      <?php  //echo $re_orden['tiporelacionado'];
					
					  $tr = $re_orden['tiporelacionado'];
					  
					  if($tr == 01 ) { echo "01 Nota de crédito de los documentos
              relacionados"; }
					   if($tr == 02 ) { echo "02 Nota de débito de los documentos
              relacionados"; }
					    if($tr == 03 ) { echo "03 Devolución de mercancía sobre facturas o
                traslados previos"; }
						 if($tr == 04 ) { echo "04 Sustitución de los CFDI previos"; }
						  if($tr == 01 ) { echo ""; }
						   if($tr == 01 ) { echo ""; }
						    if($tr == 07 ) { echo "07 CFDI por aplicacion de anticipo"; }
					
					
					 ?>
    </span></td>
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
    <td width="32%" align="center">

    <?php

   // echo "Aqui estatus".$re_orden['estatus'];

   if($re_orden['estatus'] == 'Por Emitir') { echo "No se puede cancelar por que no se ha timbrado";}

    if($re_orden['estatus'] == 'Timbrada')
    {


      if ($re_orden['version'] == '3.3'){
       ?>
      
      <a href="cancelar.php?folio_fiscal=<?php echo $re_orden['uuid']; ?>"><img src="https://img.icons8.com/cotton/64/000000/cancel--v1.png"/> Cancelar directo sin motivo</a>
      <?php
        }

        
      if ($re_orden['version'] == '4.0'){

      ?>

      <a href="cancelar_4.0.php?folio_fiscal=<?php echo $re_orden['uuid']; ?>"><img src="https://img.icons8.com/cotton/64/000000/cancel--v1.png"/> Cancelar directo sin motivo</a>
      
       <?php

      }

    }

  ?>
  
  </td>
    <td width="29%" align="center">
      
      <p>
        
        <!--
    <form name="form3" method="get" action="cancelar_sustitucion.php">
      <p>Cancelar por Sustitución
</p>
      <p>UUID Relacionado
<select name="lblrelacionado" id="lblprueba" class="form-control">
  <?php
  
  
  //$consulta_uuid = mysqli_query($cone,"SELECT id, uuid FROM `invoices` where uuid <> '' order by 2");
  
 // while($re = mysqli_fetch_array($consulta_uuid)){
  
  ?>
  <option value="<?php  //echo $re[uuid]?>"><?php  //echo $re[uuid]?></option>
  <?php
  
  //}
  
  ?>
  
  
</select>
<input type="hidden" name="txtuuid" id="txtuuid" value="<?php //echo $re_orden[uuid]; ?>">
      </p>
      <p>Tipo de Cancelacion 01</p>
      <p>
        <input type="submit" name="Cancelar" id="Cancelar" value="Cancelar por Sustitución">
      </p>
    </form>
  
-->
      
    <?php


 if ($re_orden['estatus'] == 'Por Emitir')
 {

    ?>

<a href="contenedores.php?idorden=<?php echo $_GET['idorden']?>&serie=<?php echo $_GET['serie'];?>&opc=2"><img src="https://img.icons8.com/ios/50/1A1A1A/shipping-container.png"/></a></p>
    <p><a href="contenedores.php?idorden=<?php echo $_GET['idorden']?>&serie=<?php echo $_GET['serie'];?>&opc=5">Agregar Contenedor</a></p></td>

  <?php

 }


?>

    <td width="23%" align="center"><?php

      if($re_orden['estatus'] == 'Por Emitir')
      { ?>
      <p><a href="productos.php?val=4&fac=<?php echo $_GET['serie']; ?>"><img src="https://img.icons8.com/ios/50/000000/add-list.png"/><p>Agregar Productos del Inventario</p></a></p>
      <p><!--<a href="#" data-toggle="modal" data-target="#exampleModal">  Agregar Productos del Inventario -->
        <?php } //productos.php?val=4&fac=<?php echo $_GET['serie']; ?> </a>
      </p>
    </td>
    <td width="16%" align="left"><?php 
    

    $importe_factura = saber_total_factura($re_orden['id']);

    //echo $importe_factura;
    
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


  <table class="table table-bordered table-striped">
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
                    <td>$<?php echo number_format($red['monto'] * $red['cantidad'],2); ?></td>
                    <td> <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php // echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->
                  
                  </td>
                    <td>
                      <?php
                      
                    if ($re_orden['estatus'] == 'Cancelada'){

                    }
                    else { ?>
                     <?php
                     
                     if ($re_orden['estatus'] == 'Por Emitir') {

                     ?>


                    <a href="#" data-toggle="modal" data-target="#modal-borrar_<?php echo $red['id']; ?>"><img src="https://img.icons8.com/metro/24/A83339/trash.png"/></a></td>
                   
                     <?php

                     }


                      ?>
                   
                   <?php
                    }
                    ?>

                  </tr>



<!-- Modal de  edicion ->

  <div class="modal fade" id="modal-edit_<php echo $re['id']; ?>">
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
  <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo" required value= "<php echo $re['id']; ?>"  readonly="readonly" >
  </div>
  </div>

  <div class="form-group row">
  <label for="inputEmail3" class="col-sm-2 col-form-label">Empresa</label>
  <div class="col-sm-10">
  <input type="text" class="form-control" id="txtempresa" placeholder="Codigo" name="txtempresa" required value= "<?php echo $re['empresa']; ?>"   >
  </div>
  </div>

  <input name="opc" type="hidden" value="3" />
  <input name="txtid" type="hidden" value="<php echo $re['id']; ?>" />
  <input name="idorden" type="hidden" value="<php echo $_GET['idorden'] ?>" />


  </div>
  <div class="modal-footer justify-content-between">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="submit" class="btn btn-primary">Actualizar</button>
  </div>

  </form>
  </div>
  </div>
  </div>
<-- /.modal -->


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

                   
                   <p><?php echo "Clave: ".$red['id']; ?></p>
                   <p><?php echo "Cod Prod: ".$red['c_producto']; ?></p>
                   <p><?php echo "Descripcion: ".$red['descripcion']; ?></p>
                   

                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden"   value="<?php echo $red['id']; ?>" />
                  <input name="idorden" type="hidden" value="<?php echo $_GET['idorden']; ?>" />
                  <input name="serie" type="hidden"   value="<?php echo $_GET['serie']; ?>" />
             
              


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
                    <th>Importe</th>
                    <th></th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>

  </div>
</div>

</main>

<!--NUEVO PRODUCTO A LA FACTURA-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Catalogo de Productos</h5>
        <!--button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button-->
      </div>
      <div class="modal-body">

      <table id="example1" class="table table-bordered table-striped text-center">
        <thead>
          <tr>
            <th scope="col">Clave</th>
            <th scope="col">Producto</th>
            <th scope="col">Precio</th>
            <th scope="col">Cantidad</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            $w = 0;
            $productos = mysqli_query($cone, "SELECT * FROM products"); 
            while($product_r = mysqli_fetch_array($productos)){ $w++;?>
            <tr>
              <td><?php echo $product_r['codigo_producto'];?></td>
              <td><div class="divCort"><?php echo $product_r['nombre_producto'];?></div></td>
              <td witdh="35px"><input type="text" name="preciodat" id="preciodata-<?php echo $w;?>" value="<?php echo $product_r['precio'];?>" class = "form-control" ></td>
              <td witdh="35px"><input type="text" name="existenciasdat" id="existenciasdata-<?php echo $w;?>" value = "<?php echo $product_r['existencia'];?>" class = "form-control"></td>
              <td><a class="sub" onclick="newDataFact('<?php echo $product_r['codigo_producto'];?>', 'NewDataFa', '<?php echo $_GET['idorden']; ?>', '<?php echo $w;?>')"><h5><i class="bi bi-plus-circle"></i></h5></a></td>

              <!--td>
                <button type="button" class="btn btn-success" id="newdataFact" name="newdataFact">
                  <i class="bi bi-plus-circle"></i>
                </button>
              </td-->
            </tr>                 
          <?php } ?>
        </tbody>
      </table>
      </div>
      <div class="modal-footer">
        <!--button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button-->
          <a href="detalle_invoices.php?idorden=<?php echo $_GET['idorden']?>&serie=<?php echo $_GET['serie'];?>">
            <button type="button" class="btn btn-primary">Guardar</button>
          </a>
      </div>
    </div>
  </div>
</div><!--TERMINA NUEVO PRODUCTO A LA FACTURA-->
	
	<?php
	//include("footer.php");
	?>
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

<!-- Sweet Alert 2 -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Librería para Popups -->
<script src="dist/js/popups.js"></script>
<!-- Librería para funciones generales -->
<script src="dist/js/lib.js"></script>
<script src="dist/js/modals.js"></script>

<!-- Para el select de checkboxes -->
<link rel="stylesheet" href="docs/css/bootstrap-multiselect.css" type="text/css">
<script type="text/javascript" src="docs/js/bootstrap-multiselect.js"></script>

<div class="modal fade" id="modal-emails">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Enviar Correo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Correos</label>
          <div class="row">
            <select id="example-selectAllJustVisible" multiple="multiple" name="cadena[]">
              <?php
              $query = mysqli_query($con, "SELECT * FROM `cuenta_correos` WHERE `activo` = 1");
              if($query){
                while($arr = mysqli_fetch_array($query)){
                $id     = $arr['id'];
                $correo = $arr['correo'];
                ?>
                <option value="<?php echo $correo;?>"> <?php echo $correo;?> </option>
                <?php
                }
              }
              ?>
            </select>
          </div>
        </div>

        <!-- Campos ocultos -->
        <input type="hidden" name="idorden" id="idorden" value="<?php echo $_GET['idorden']; ?>" />

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" onclick="sendEmails()">Enviar</button>
        </div>
      </div> <!-- /. modal body -->
    </div> <!-- /.modal-content -->
  </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->

<!-- page script -->
<script>
  function showMailModal(){ // Para mostrar el modal y que se cargue correctamente
    $('#example-selectAllJustVisible').multiselect({
      enableFiltering: true,
      includeSelectAllOption: true,
      selectAllJustVisible: false
    });
  }

  function sendEmails(){
    let ord_id = document.getElementById('idorden').value;

    let selected_address = [];
    let addresses = document.getElementById('example-selectAllJustVisible').children;
    for(email in addresses){
      if(addresses[email].selected){
        selected_address.push(addresses[email].value);
      }
    }

    if(selected_address.length != 0){
      /* selected_address */

      $.ajax({
        url: '../../envio_correo_con_datos.php',
        data: {
          to: selected_address,
          idorden: ord_id
        },
        type: 'POST',
        success: (response) => {
          console.log(response);
        },
        error: (jqXHR, textStatus) => {
          markErr(jqXHR, textStatus);
        }
      });
    }else{
      let err = new Popup({generic: {type: 'info', message: 'Por favor seleccione al menos un correo antes de enviar'}});
      err.show();
    }
    
  }

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


  //SCRIPT PARA AGREGAR PRODUCTOS A LA FACTURA
  

</script>


</html>
