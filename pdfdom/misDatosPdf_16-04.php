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

<?php session_start();


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

      $img = mysqli_query($cone, "SELECT a.*, b.empresa FROM dctos_releciones as a 
      JOIN empresas as b on b.id = a.id_relacion
      WHERE b.id = '$emi'");
      $img_r = mysqli_fetch_array($img);
      $carpeta = $img_r['empresa'];
      $archivo = $img_r['documento'];
      
?>
<table width="98%" border="0">
  <tr>
    <td width="17%"><img src="<?php echo '../dctos_rel/'.$carpeta.'/'.$archivo;?>" width="190" height="102"></td>
    <td width="41%" align="left" valign="bottom"><p class="chica">Lugar de expedicion: <?php  echo $re_emisor[direccion]; ?> CP <?php  echo $re_emisor[cp]; ?><br>
    </p></td>
    <td width="42%" align="left" valign="top"><table width="100%" height="99" border="0">
      <tr>
        <td height="95" align="left"><p><strong class="chica2"><em>Serie y No de Factura:</em></strong> <?php echo $re_orden[serie]; ?><?php echo $_GET['idorden'];?></p>
          <p><strong class="chica2"><em>Tipo de Factura:</em></strong> <?php echo $re_orden['tipo_cfdi'];
		  
		   if ($re_orden['tipo_cfdi'] == 'I') { echo " - INGRESO"; }
		   if ($re_orden['tipo_cfdi'] == 'E') { echo " - EGRESO"; }
		  
		  
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
<table width="505"  border="0" style="table-layout: fixed" class="chica2">
                  <tr class="chica2">
                    <td width="14%" bgcolor="#FFFFFF"><em><strong class="chica">Emisor</strong></em></td>
                    <td width="30%"><?php echo $re_emisor['empresa']; ?></td>
                    <td width="16%"><em><strong>Receptor</strong></em></td>
                    <td width="40%" class="chica2"><?php echo utf8_encode($re_receptor['nombre_cliente']); ?></td>
  </tr>
                  <tr>
                    <td bgcolor="#FFFFFF" class="chica2"><em><strong>Direccion</strong></em></td>
                    <td><?php echo $re_emisor['direccion']; ?></td>
                    <td class="chica2"><em><strong>Direccion'</strong></em></td>
                    <td><?php echo utf8_decode($re_receptor['direccion_cliente'])." ".$re_receptor['colonia']." ".$re_receptor['ciudad']." ".$re_receptor['estado']." ".$re_receptor['cp']; ?></td>
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
                    <td class="chica2"><span class="chica1">Regimen Fiscal: 601Regimen General de Ley de Personas Morales</span></td>
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
<table width="503"  border="0" style="table-layout: fixed" class="chica2">
  <tr>
    <td width="14%"><em><strong>Metodo de Pago:</strong></em></td>
    <td width="21%" align="left"><?php 
    
    
    $mp = $re_orden[metodo_pago]; 
   

    if ($mp == 'PUE') { echo " PUE - PAGO EN UNA SOLA EXHIBICION "; }
    if ($mp == 'PPD') { echo " PPD - PAGO EN PARCIALIDADES O DIFERIDO "; }
    
    ?> </td>
    <td width="19%"><em><strong>Uso del CFDI: </strong></em></td>
    <td width="46%" align="left"><?php echo $re_orden[uso]; ?> 
  
    <?php


    if ($re_orden[uso] ==  "G01" ) { echo "Adquisicion de mercancias";}
    if ($re_orden[uso] ==  "G02" ) { echo "Devoluciones, descuentos o bonificaciones";}
    if ($re_orden[uso] ==  "G03" ) { echo "Gastos en general";}
    if ($re_orden[uso] ==  "P01" ) { echo "Por Definir";}
	if ($re_orden[uso] ==  "S01" ) { echo "Sin Efectos Fiscales";}
    if ($re_orden[uso] ==  "CP01" ) { echo "Pagos";}

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
    <td><strong><em>Contenedor:</em></strong></td>
    <td align="left"><?php echo $re_orden[contenedor]; ?></td>
    <td><strong><em>Sucursal</em></strong></td>
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
<table width="555" class="chica2">
  <thead>
    <tr>
      <th width="48" bgcolor="#CCCCCC"><em><strong>Cantidad</strong></em></th>
      <th width="45" bgcolor="#CCCCCC"><em><strong>Unidad</strong></em></th>
      <th width="46" bgcolor="#CCCCCC"><em><strong>Codigo Sat</strong></em></th>
      <th width="52" bgcolor="#CCCCCC"><em><strong>Clave</strong></em></th>
      <th width="224" bgcolor="#CCCCCC"><em>Descripci&oacute;n</em></th>
      <th width="55" bgcolor="#CCCCCC"><em>Precio</em></th>
      <th width="43" bgcolor="#CCCCCC"><em>Importe</em></th>
    </tr>
  </thead>
  <tbody>
    <?php
	                $contador = 0;
				
				   while($red = mysqli_fetch_array($consulta_detalle)){
					   $contador ++;

				
				
				?>
    <tr class="chica1">
      <td align="center"><?php echo number_format($red['cantidad']); ?></td>
      <td align="left"><?php echo $red['unidad']; ?></td>
      <td align="center"><?php echo utf8_encode($red['codigo_sat']); ?></td>
      <td><?php echo utf8_encode($red['c_producto']); ?></td>
      <td class="chica1"><?php echo utf8_encode($red['descripcion']);  ?></td>
      <td align="right">$<?php echo number_format(utf8_encode($red['monto']),3); ?></td>
      <td align="right">$<?php echo number_format($red['monto'] * $red['cantidad'],2); ?></td>
    </tr>
    <?php
				
				   }
				
				
				?>
  </tbody>
</table>
<p>&nbsp;</p>
<table width="555"   class="chica2">
  <tbody>
    <tr>
      <td width="75">&nbsp;</td>
      <td width="69">&nbsp;</td>
      <td width="63">&nbsp;</td>
      <td width="91">&nbsp;</td>
      <td width="178" align="right"><em><strong>Subtotal:</strong></em></td>
      <td width="51" align="right"><em><strong>$<?php echo number_format(saber_total_factura($clave),2);
	  
	  $factu = saber_total_factura($clave);
	  
	  
	   ?></strong></em></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><em><strong>Iva:</strong></em></td>
      <td align="right"><em><strong>$<?php echo number_format($factu * 0.16,2); ?></strong></em></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><em><strong>
      <?php
	  if ($re_orden[moneda] == 'MXN') { echo "Total:"; }
	  if ($re_orden[moneda] == 'USD') { echo "Total USD:"; }
	  
	  ?>
      
      
      </strong></em></td>
      <td align="right"><em><strong>$<?php echo number_format($factu * 1.16,2); ?></strong></em></td>
    </tr>
  </tbody>
</table>

<?php

if ($re_orden[moneda] == "MXN"){

?>
<table width="489"  class="table">
  <tbody>
    <tr>
      <td width="481" align="center">(-- <?php echo '<strong class="chica2">'.convertir( $factu * 1.16 ).'</strong>'; ?>--)</td>
    </tr>
  </tbody>
</table>
<?php

}
?>

<p>______________________________________________________________________________ </p>
<p>
  <?php 

$imagen = "../timbrado/files/cfdi/".$ruta_imagen;

if ($contador == 12){

echo "<br>";
echo "<br>";
echo "<br>";

	
	
}

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
  <p align="justify" class="chica3">&nbsp;</p>
  <p align="justify" class="chica3">&nbsp;</p>
  <p align="justify" class="chica3">&nbsp;</p>
  <p align="justify" class="chica3">&nbsp;</p>
  <p align="justify" class="chica3">&nbsp;</p>
  <p align="justify" class="chica3">&nbsp;</p>
  <p align="justify" class="chica3">&nbsp;</p>
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
      <p class="chica2">Este documento es un representacion impresa de un CFDI</p>
      <p class="chica2"><strong>Version: <?php echo $re_orden[version] ?></strong></p></td>
    <td width="11%"><img src="<?php echo $imagen; ?>" alt="" width="53" height="53" /></td>
  </tr>
</table>

  <p>________________________________________________________________________________</p>
</div>
</body>
</html>