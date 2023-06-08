<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
<title>parrafos</title>
</head>
<style>
p { margin: 0 !important; }

.chica{
	font-size:9px;
}
</style>



<body>

<?php


			include("../conecta_facturacion.php");


			$clave = $_GET['idorden'];
			
			$consulta_orden= mysqli_query($cone,"SELECT * FROM `invoices` WHERE `id` = '$clave'");
			$re_orden = mysqli_fetch_array($consulta_orden);
			
			$emi = $re_orden['emisor'];
			$rece = $re_orden['receptor'];
			
			
			$consulta = mysqli_query($cone, "SELECT * FROM `detalle_invoices` where idorden = '$clave';");
			
			$consulta_emisor = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emi'");
			$consulta_receptor = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente = '$rece'");
			
			$re_emisor   = mysqli_fetch_array($consulta_emisor);
			$re_receptor = mysqli_fetch_array($consulta_receptor);
			
			
		


?>
<table width="100%" border="0">
  <tr>
    <td width="12%"><img src="logo-erdt.png" alt="" width="143" height="76" /></td>
    <td width="71%" align="center" valign="top"><p><strong><em>No de Factura:</em></strong> <?php echo $_GET['idorden'];?></p>
      <p><strong><em>Tipo de Factura:</em></strong> <?php echo $re_orden['tipo_cfdi']; ?></p>
      <p><strong><em>Folio Fiscal del SAT: <?php echo $re_orden[uuid]; ?></em></strong></p>
      <p>
        <?php


    $archivo = $re_orden['serie']."_".$re_orden['id'];

    $ruta_imagen = $archivo.'_QR.jpg';

	
	?>
      </p>
      <p>&nbsp;</p></td>
    <td width="17%" align="left" valign="top">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="555"  border="0" style="table-layout: fixed">
                  <tr>
                    <td width="14%"><em><strong>Emisor</strong></em></td>
                    <td width="28%"><?php echo $re_emisor['empresa']; ?></td>
                    <td width="15%"><em><strong>Receptor</strong></em></td>
                    <td width="43%"><?php echo utf8_encode($re_receptor['nombre_cliente']); ?></td>
  </tr>
                  <tr>
                    <td><em><strong>Direccion</strong></em></td>
                    <td><?php echo $re_emisor['direccion']; ?></td>
                    <td><em><strong>Direccion</strong></em></td>
                    <td><?php echo $re_receptor['direccion_cliente']; ?></td>
                  </tr>
                  <tr>
                    <td><em><strong>Telefono</strong></em></td>
                    <td><?php echo $re_emisor['telefono']; ?></td>
                    <td><em><strong>Telefono</strong></em></td>
                    <td><?php echo $re_emisor['telefono_cliente']; ?></td>
                  </tr>
</table>

<p>&nbsp;</p>
<p><strong><em>Datos de la factura</em></strong></p>
<table width="558"  border="0" style="table-layout: fixed">
  <tr>
    <td width="20%"><em><strong>Fecha de Emision:</strong></em></td>
    <td width="12%"><?php echo $re_orden[fecha_emision]; ?></td>
    <td width="27%"><em><strong>Moneda: </strong></em></td>
    <td width="41%"><?php echo $re_orden[moneda]; ?></td>
  </tr>
  <tr>
    <td><em><strong>Hora:</strong></em></td>
    <td><?php echo $re_orden[hora]; ?></td>
    <td><em><strong>Forma de Pago: </strong></em></td>
    <td><?php echo $re_orden[forma_pago]; ?></td>
  </tr>
  <tr>
    <td><em><strong>Serie:</strong></em></td>
    <td><?php echo $re_orden[serie]; ?></td>
    <td><em><strong>Lugar de Expedicion: </strong></em></td>
    <td><?php echo $re_orden[lugar]; ?></td>
  </tr>
  <tr>
    <td><em><strong>Metodo de Pago:</strong></em></td>
    <td><?php echo $re_orden[metodo_pago]; ?></td>
    <td><em><strong>Pedimento: </strong></em></td>
    <td><?php echo $re_orden[pedimento]; ?></td>
  </tr>
  <tr>
    <td><em><strong>Tipo de Comprobante:</strong></em></td>
    <td><?php echo $re_orden[tipo_cfdi]; ?></td>
    <td><em><strong>Uso del CFDI: </strong></em></td>
    <td><?php echo $re_orden[uso]; ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<p><strong><em>Detalle de la Factura</em></strong>
  <?php
	
	              $fa = $_GET['idorden'];

                  $consulta_detalle = mysqli_query($cone,"select * from detalle_invoices where idfactura = '$fa'");
	
	
	
	?>
</p>
<table  class="table">
  <thead>
    <tr>
      <th width="70"><em><strong>Cantidad</strong></em></th>
      <th width="64"><em><strong>Unidad</strong></em></th>
      <th width="57"><em><strong>Clave</strong></em></th>
      <th width="142">Descripcion</th>
      <th width="72">Monto </th>
      <th width="94">Importe</th>
    </tr>
  </thead>
  <tbody>
    <?php
				
				   while($red = mysqli_fetch_array($consulta_detalle)){

				
				
				?>
    <tr>
      <td><?php echo $red['cantidad']; ?></td>
      <td><?php echo utf8_encode($red['unidad']); ?></td>
      <td><?php echo utf8_encode($red['c_producto']); ?></td>
      <td><?php echo utf8_encode($red['descripcion']);  ?></td>
      <td>$<?php echo utf8_encode($red['monto']); ?></td>
      <td>$<?php echo $red['monto'] * $red['cantidad']; ?></td>
    </tr>
    <?php
				
				   }
				
				
				?>
  </tbody>
</table>
______________________________________________________________________


<p>
  <?php 

$imagen = "../timbrado/files/cfdi/".$ruta_imagen;

?>
  
</p>
<table width="47%" height="31" border="0">
  <tr>
    <td><img src="<?php echo $imagen; ?>" alt="" width="100" height="100" /></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>
  <?php
echo "Sello Digital del CFDI";
?>
<div align="left">
</p>
<p align="justify" class="chica">
  <?php echo substr($re_orden[sello_cfdi],0,140);  ?>
</p>
  <p align="justify" class="chica">
  <?php echo substr($re_orden[sello_cfdi],141,130); ?>
  </p>
  <p align="justify" class="chica">
  <?php echo substr($re_orden[sello_cfdi],271,130); ?>
  </p>
 <?php
echo "<br>";
echo "Sello Digital del SAT";
?>
<div align="left">
  <p align="justify" class="chica">
  <?php echo substr($re_orden[sello_sat],0,140);  ?>
  </p>
  <p align="justify" class="chica">
  <?php echo substr($re_orden[sello_sat],141,130); ?>
  </p>
  <p align="justify" class="chica">
  <?php echo substr($re_orden[sello_sat],271,130); ?>
  </p>
    <p align="justify" class="chica">
  <?php echo substr($re_orden[sello_sat],401,130); ?>
  </p>

 <?php
echo "<br>";
echo "Cadena Original de Complemento de certificacion digital del SAT";
?>
<div align="left">
  <p align="justify" class="chica">
  <?php echo substr($re_orden[cadena],0,140);  ?>
  </p>
  <p align="justify" class="chica">
  <?php echo substr($re_orden[cadena],141,130); ?>
  </p>
  <p align="justify" class="chica">
  <?php echo substr($re_orden[cadena],271,130); ?>
  </p>
  <p align="justify" class="chica">
  <?php echo substr($re_orden[cadena],401,130); ?>
  </p>
  <p>
  <?php
echo "<br>";
echo "<p class='chica'>Fecha y Hora De Certificacion: ".$re_orden[fecha_hora_cer]."</p>";
  ?>
  <?php
echo "<p class='chica'>No de Serie del Certificado del SAT : ".$re_orden[certificado_sat]."</p>";
  ?>
    <?php
echo "<p class='chica'>RfcProvCert : ".$re_orden[rfc_prov]."</p>";;
  ?>
  </p>
  <p>_______________________________________________________________________</p>
</div>
</body>
</html>