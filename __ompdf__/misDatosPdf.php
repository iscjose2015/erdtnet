<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
<title>CFDI Impreso</title>
</head>
<style>
p { margin: 0 !important; }

.chica{
	font-size:9px;
}

.chica2{
	font-size:11px;
}

.chica3{
	font-size:6px;
}
</style>

</style>

<body>

<?php


			include("../conecta_facturacion.php");
			include("../funciones_factura.php");


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
<table width="98%" border="0">
  <tr>
    <td width="18%"><img src="logo_fijaciones.png" width="190" height="102"></td>
    <td width="33%" align="center" valign="middle"><p>&nbsp;</p></td>
    <td width="49%" align="left" valign="top"><table width="100%" height="99" border="0">
      <tr>
        <td height="95"><p><strong class="chica2"><em>Serie y No de Factura:</em></strong> <?php echo $re_orden[serie]; ?><?php echo $_GET['idorden'];?></p>
          <p><strong class="chica2"><em>Tipo de Factura:</em></strong> <?php echo $re_orden['tipo_cfdi'];
		  
		   if ($re_orden['tipo_cfdi'] == 'I') { echo " - INGRESO"; }
		  
		  
		   ?></p>
          <p>
            <?php


    $archivo = $re_orden['serie']."_".$re_orden['id'];

    $ruta_imagen = $archivo.'_QR.jpg';

	
	?>
          </p>
          <p><strong class="chica2"><em>Fecha y Hora de Emision</em></strong>: <?php echo $re_orden[fecha_emision]; ?>-<?php echo $re_orden[hora]; ?></p>
          <p class="chica2"><em><strong>Moneda: </strong></em><?php echo $re_orden[moneda]; ?></p>
          <p></p></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="96%" border="0" class="chica2">
  <tr>
    <td align="center" bgcolor="#CCCCCC"><strong><em>Emisor / Receptor</em></strong></td>
  </tr>
</table>
<table width="555"  border="0" style="table-layout: fixed" class="chica2">
                  <tr class="chica2">
                    <td width="14%" bgcolor="#FFFFFF"><em><strong class="chica">Emisor</strong></em></td>
                    <td width="30%"><?php echo $re_emisor['empresa']; ?></td>
                    <td width="13%"><em><strong>Receptor</strong></em></td>
                    <td width="43%" class="chica2"><?php echo utf8_encode($re_receptor['nombre_cliente']); ?></td>
  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF" class="chica2"><em><strong>Direccion</strong></em></td>
                    <td><?php echo $re_emisor['direccion']; ?></td>
                    <td class="chica2"><em><strong>Direccion</strong></em></td>
                    <td><?php echo $re_receptor['direccion_cliente']; ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF" class="chica2"><em><strong>Telefono</strong></em></td>
                    <td class="chica2"><?php echo $re_emisor['telefono']; ?></td>
                    <td class="chica2"><em><strong>Telefono</strong></em></td>
                    <td class="chica2"><?php echo $re_receptor['telefono_cliente']; ?></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF" class="chica2"><em>RFC Emisor</em></td>
                    <td class="chica2"><span class="chica21"><?php echo $re_emisor['rfc']; ?></span></td>
                    <td class="chica2"><em>RFC Receptor</em></td>
                    <td class="chica2"><span class="chica21"><?php echo $re_receptor['rfc']; ?></span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF" class="chica2">&nbsp;</td>
                    <td class="chica2">&nbsp;</td>
                    <td class="chica2">&nbsp;</td>
                    <td class="chica2">&nbsp;</td>
                  </tr>
</table>
<table width="96%" border="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC" class="chica2"><strong><em>Datos de la Factura</em></strong></td>
  </tr>
</table>
<table width="710"  border="0" style="table-layout: fixed" class="chica2">
  <tr>
    <td width="14%"><em><strong>Metodo de Pago:</strong></em></td>
    <td width="26%" align="left"><?php echo $re_orden[metodo_pago]; ?></td>
    <td width="11%"><em><strong>Uso del CFDI: </strong></em></td>
    <td width="49%" align="left"><?php echo $re_orden[uso]; ?></td>
  </tr>
  <tr>
    <td><em><strong>Forma de Pago:</strong></em></td>
    <td align="left"><?php echo $re_orden[forma_pago]; ?></td>
    <td><em><strong>Pedimento: </strong></em></td>
    <td align="left"><?php echo $re_orden[pedimento]; ?></td>
  </tr>
</table>
<table width="95%" border="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC" class="chica2"><strong><em>Detalle de la Factura</em></strong>
    <?php
	
	              $fa = $_GET['idorden'];

                  $consulta_detalle = mysqli_query($cone,"select * from detalle_invoices where idfactura = '$fa'");
	
	
	
	?></td>
  </tr>
</table>
<table width="489" class="chica2">
  <thead>
    <tr>
      <th width="43" bgcolor="#CCCCCC"><em><strong>Cantidad</strong></em></th>
      <th width="43" bgcolor="#CCCCCC"><em><strong>Unidad</strong></em></th>
      <th width="59" bgcolor="#CCCCCC"><em><strong>Clave</strong></em></th>
      <th width="206" bgcolor="#CCCCCC"><em>Descripci&oacute;nes</em></th>
      <th width="55" bgcolor="#CCCCCC"><em>Precio</em></th>
      <th width="88" bgcolor="#CCCCCC"><em>Importe</em></th>
    </tr>
  </thead>
  <tbody>
    <?php
				
				   while($red = mysqli_fetch_array($consulta_detalle)){

				
				
				?>
    <tr>
      <td align="center"><?php echo $red['cantidad']; ?></td>
      <td align="center"><?php echo utf8_encode($red['unidad']); ?></td>
      <td><?php echo utf8_encode($red['c_producto']); ?></td>
      <td class="chica2"><?php echo utf8_encode($red['descripcion']);  ?></td>
      <td align="center">$<?php echo number_format(utf8_encode($red['monto']),2); ?></td>
      <td align="center">$<?php echo number_format($red['monto'] * $red['cantidad'],2); ?></td>
    </tr>
    <?php
				
				   }
				
				
				?>
  </tbody>
</table>
<table width="565"   class="chica2">
  <tbody>
    <tr>
      <td width="75">&nbsp;</td>
      <td width="68">&nbsp;</td>
      <td width="61">&nbsp;</td>
      <td width="148">&nbsp;</td>
      <td width="77" align="right"><em><strong>Subtotal:</strong></em></td>
      <td width="108"><em><strong>$<?php echo number_format(saber_total_factura($clave),2);
	  
	  $factu = saber_total_factura($clave);
	  
	  
	   ?></strong></em></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><em><strong>Iva:</strong></em></td>
      <td><em><strong>$<?php echo number_format($factu * 0.16,2); ?></strong></em></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><em><strong>Total:</strong></em></td>
      <td><em><strong>$<?php echo number_format($factu * 1.16,2); ?></strong></em></td>
    </tr>
  </tbody>
</table>
<table width="489"  class="table">
  <tbody>
    <tr>
      <td width="481" align="center">(-- <?php echo '<strong class="chica2">'.convertir( $factu * 1.16 ).'</strong>'; ?>--)</td>
    </tr>
  </tbody>
</table>
<p>______________________________________________________________________________ </p>
<p>
  <?php 

$imagen = "../timbrado/files/cfdi/".$ruta_imagen;

?>
  
</p>
<p>&nbsp;</p>
<p>
  <?php
echo "<span class='chica3'>Sello Digital del CFDI<span>";
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
echo "<span class='chica3'>Sello Digital del SAT</span>";
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
echo "<span class='chica3'>Cadena Original de Complemento de certificacion digital del SAT</span>";
?>
<div align="left">
  <p align="justify" class="chica3">
  <?php echo substr($re_orden[cadena],0,140);  ?>
  </p>
  <p align="justify" class="chica3">
  <?php echo substr($re_orden[cadena],141,130); ?>
  </p>
  <p align="justify" class="chica3">
  <?php echo substr($re_orden[cadena],271,130); ?>
  </p>
  <p align="justify" class="chica3">
  <?php echo substr($re_orden[cadena],401,130); ?>
  </p>
  <p>
  
  </p>
  <table width="100%" border="0">
  <tr>
    <td width="70%"><?php

echo "<p class='chica3'>Fecha y Hora De Certificacion: ".$re_orden[fecha_hora_cer]."</p>";
  ?>
      <p>
        <?php
echo "<p class='chica3'>No de Serie del Certificado del SAT : ".$re_orden[certificado_sat]."</p>";
  ?>
        <?php
echo "<p class='chica3'>RfcProvCert : ".$re_orden[rfc_prov]."</p>";;
  ?>
      </p>
      <p class="chica2"><strong><em>Folio Fiscal del SAT: <?php echo $re_orden[uuid]; ?></em></strong> </p>
      <p class="chica2">Este documento es un representacion impresa de un CFDI</p>
      <p class="chica2"><strong>Version: 3.3</strong></p></td>
    <td width="30%"><img src="<?php echo $imagen; ?>" alt="" width="100" height="100" /></td>
  </tr>
</table>

  <p>________________________________________________________________________________</p>
</div>
</body>
</html>