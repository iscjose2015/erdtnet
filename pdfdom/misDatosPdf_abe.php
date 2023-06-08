<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
<title>CFDI Impreso</title>
<style type="text/css">
.chica1 {	font-size:9px;
}
.chica1 {	font-size:9px;
}
</style>
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
	font-size:7px;
}

 @page {
            margin: 50px 50px 0px 50px !important;
            padding: 0px 0px 0px 0px !important;
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
    <td width="17%">&nbsp;</td>
    <td width="41%" align="left" valign="bottom"><p class="chica">Lugar de expedicion: Guadalajara Jalisco Mexico CP 44720<br>
    </p></td>
    <td width="42%" align="left" valign="top"><table width="100%" height="99" border="0">
      <tr>
        <td height="95" align="left"><p><strong class="chica2"><em>Serie y No de Factura:</em></strong> J1000<?php  ?><?php ?></p>
          <p><strong class="chica2"><em>Tipo de Factura:</em></strong> <?php echo $re_orden['tipo_cfdi'];
		  
		   if ($re_orden['tipo_cfdi'] == 'I') { echo " - INGRESO"; }
		  
		  
		   ?></p>
          <p>
            <?php


    $archivo = $re_orden['serie']."_".$re_orden['id'];

    $ruta_imagen = $archivo.'_QR.jpg';

	
	?>
          </p>
          <p><strong class="chica2"><em>Fecha y Hora de Emision</em></strong>: <?php echo "<br>"; echo '<strong class="chica2">'. $re_orden[fecha_emision]; ?>/<?php echo '<strong class="chica2">'.$re_orden[hora]; ?></p>
          <p class="chica2"><em><strong>Moneda: </strong></em><?php echo $re_orden[moneda]; ?></p>
          <p></p></td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="103%" border="0" class="chica2">
  <tr>
    <td align="center" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
</table>
<table width="555"  border="0" style="table-layout: fixed" class="chica2">
                  <tr class="chica2">
                    <td width="14%" bgcolor="#FFFFFF"><em><strong class="chica">Emisor</strong></em></td>
                    <td width="30%"><?php echo $re_emisor['empresa']; ?></td>
                    <td width="16%"><em><strong>Receptor</strong></em></td>
                    <td width="40%" class="chica2"><?php echo utf8_encode($re_receptor['nombre_cliente']); ?></td>
  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF" class="chica2"><em><strong>Direccion</strong></em></td>
                    <td><?php echo $re_emisor['direccion']; ?></td>
                    <td class="chica2"><em><strong>Direccion</strong></em></td>
                    <td><?php echo $re_receptor['direccion_cliente']." ".$re_receptor['colonia']." ".$re_receptor['ciudad']." ".$re_receptor['estado']." ".$re_receptor['cp']; ?></td>
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
                    <td bgcolor="#FFFFFF" class="chica2">Regimen Fiscal</td>
                    <td class="chica2"><span class="chica1">Regimen Fiscal: 612 <strong>personas fisicas con actividad empresarial</strong></span></td>
                    <td class="chica2">Regimen Fiscal</td>
                    <td class="chica2"><span class="chica1">Regimen Fiscal: 601Regimen General de Ley de Personas Morales</span></td>
                  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF" class="chica2">CFDI Relacion.</td>
                    <td class="chica2"><?php echo $re_orden['relacionado']; ?></td>
                    <td class="chica2">Tipo Relacion</td>
                    <td class="chica2"><?php  //echo $re_orden['tiporelacionado'];
					
					  $tr = $re_orden['tiporelacionado'];
					  
					  if($tr == 01 ) { echo "01 Nota de credito de los documentos
              relacionados"; }
					   if($tr == 02 ) { echo "02 Nota de debito de los documentos
              relacionados"; }
					    if($tr == 03 ) { echo "03 Devolucion de mercancía sobre facturas o
                traslados previos"; }
						 if($tr == 04 ) { echo "04 Sustitucion de los CFDI previos"; }
						  if($tr == 01 ) { echo ""; }
						   if($tr == 01 ) { echo ""; }
						    if($tr == 07 ) { echo "07 CFDI por aplicacion de anticipo"; }
					
					
					 ?></td>
                  </tr>
</table>
<table width="103%" border="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC" class="chica2"><strong><em>Datos de la Factura</em></strong></td>
  </tr>
</table>
<table width="710"  border="0" style="table-layout: fixed" class="chica2">
  <tr>
    <td width="14%"><em><strong>Metodo de Pago:</strong></em></td>
    <td width="26%" align="left"><?php 
    
    
    $mp = $re_orden[metodo_pago]; 
   

    if ($mp == 'PUE') { echo " PUE - PAGO EN UNA SOLA EXHIBICION "; }
    if ($mp == 'PPD') { echo " PPD - PAGO EN PARCIALIDADES O DIFERIDO "; }
    
    ?> </td>
    <td width="11%"><em><strong>Uso del CFDI: </strong></em></td>
    <td width="49%" align="left"><?php echo $re_orden[uso]; ?> 
  
    <?php


    if ($re_orden[uso] ==  "G01" ) { echo "Adquisicion de mercancias";}
    if ($re_orden[uso] ==  "G02" ) { echo "Devoluciones, descuentos o bonificaciones";}
    if ($re_orden[uso] ==  "G03" ) { echo "Gastos en general";}
    if ($re_orden[uso] ==  "P01" ) { echo "Por Definir";}


  ?>
  
  
  
  </td>
  </tr>
  <tr>
    <td><em><strong>Forma de Pago:</strong></em></td>
    <td align="left"><?php
    

    $for = $re_orden[forma_pago];

    if ($for == '99') { echo "99 Por Definir"; }
    if ($for == '01') { echo "01 Efectivo"; }
    if ($for == '02') { echo "02 Cheque nominativo"; }
    if ($for == '03') { echo "03 Transferencia electronica de fondos"; }
    if ($for == '30') { echo "30 Aplicacion de Anticipos"; }

    
  
    
    ?></td>
    <td><em><strong>Pedimento: </strong></em></td>
    <td align="left"><?php echo $re_orden[pedimento]; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left"><?php echo $re_orden[contenedor]; ?></td>
    <td>&nbsp;</td>
    <td align="left"><?php echo $re_orden[sucursal]; ?></td>
  </tr>
</table>
<table width="103%" border="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC" class="chica2"><strong><em>Detalle de la Factura</em></strong>
    <?php
	
	              $fa = $_GET['idorden'];

                  $consulta_detalle = mysqli_query($cone,"select * from detalle_invoices where idfactura = '$fa'");
	
	
	
	?></td>
  </tr>
</table>
<table width="549" class="chica2">
  <thead>
    <tr>
      <th width="44" bgcolor="#CCCCCC"><em><strong>Cantidad</strong></em></th>
      <th width="43" bgcolor="#CCCCCC"><em><strong>Unidad</strong></em></th>
      <th width="43" bgcolor="#CCCCCC"><em><strong>Codigo Sat</strong></em></th>
      <th width="55" bgcolor="#CCCCCC"><em><strong>Clave</strong></em></th>
      <th width="216" bgcolor="#CCCCCC"><em>Descripci&oacute;nes</em></th>
      <th width="55" bgcolor="#CCCCCC"><em>Precio</em></th>
      <th width="61" bgcolor="#CCCCCC"><em>Importe</em></th>
    </tr>
  </thead>
  <tbody>
    <?php
				
				   while($red = mysqli_fetch_array($consulta_detalle)){

				
				
				?>
    <tr class="chica1">
      <td align="center"><?php echo number_format($red['cantidad'],2); ?></td>
      <td align="center"><?php echo $red['unidad']; ?></td>
      <td align="center"><?php echo utf8_encode($red['codigo_sat']); ?></td>
      <td><?php echo utf8_encode($red['c_producto']); ?></td>
      <td class="chica2"><?php echo utf8_encode($red['descripcion']);  ?></td>
      <td align="center">$<?php echo number_format(utf8_encode($red['monto']),3); ?></td>
      <td align="center">$<?php echo number_format($red['monto'] * $red['cantidad'],2); ?></td>
    </tr>
    <?php
				
				   }
				
				
				?>
  </tbody>
</table>
<p class="chica2">Esta Factura Sustituye a la numero M4566 de Plasencia Autos Japoneses S.A. de C.V.  empresa emitida con fecha 2019-07-10 derivado del siniestro no. GA16647N
</p>
<p>&nbsp;</p>
<table width="551"   class="chica2">
  <tbody>
    <tr>
      <td width="68">&nbsp;</td>
      <td width="62">&nbsp;</td>
      <td width="56">&nbsp;</td>
      <td width="83">&nbsp;</td>
      <td width="158" align="right"><em><strong>Subtotal:</strong></em></td>
      <td width="87" align="right"><em><strong>$390,719.86</strong></em></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><em><strong>Iva:</strong></em></td>
      <td align="right"><em><strong>$0.14</strong></em></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><em><strong>Total:</strong></em></td>
      <td align="right"><em><strong>$390,720.00</strong></em></td>
    </tr>
  </tbody>
</table>
<table width="489"  class="table">
  <tbody>
    <tr>
      <td width="481" align="center">(-- TRES CIENTOS NOVENTA MIL SETECIENTOS VEINTE PESOS MNX--)</td>
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
  <p align="justify" class="chica3">&nbsp;</p>
  <p align="justify" class="chica3">&nbsp;</p>
  <p>
    
  </p>
  <table width="70%" border="0">
  <tr>
    <td width="89%" height="83"><?php

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
      <p class="chica2">Este documento es un previo a una representacion impresa de un CFDI</p>
      <p class="chica2"><strong>Version: 3.3</strong></p></td>
    <td width="11%">&nbsp;</td>
  </tr>
</table>

  <p>________________________________________________________________________________</p>
</div>
</body>
</html>