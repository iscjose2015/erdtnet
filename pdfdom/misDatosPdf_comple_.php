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
			
			$consulta_orden= mysqli_query($cone,"SELECT * FROM `complementos` WHERE `id` = '$clave'");
			$re_orden = mysqli_fetch_array($consulta_orden);
			
			$emi = $re_orden['emisor'];
			$rece = $re_orden['receptor'];
			$mon = $re_orden[total];
			
			
			$consulta = mysqli_query($cone, "SELECT * FROM `detalle_complementos` where idorden = '$clave';");
			
			$consulta_emisor = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emi'");
			$consulta_receptor = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente = '$rece'");
			
			$re_emisor   = mysqli_fetch_array($consulta_emisor);
			$re_receptor = mysqli_fetch_array($consulta_receptor);
//AQUI OPTENEMOS EL LOGO A MOSTRAR EN EL PDF
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
		   if ($re_orden['tipo_cfdi'] == 'P') { echo " - COMPLEMENTO PAGO"; }
		  
		  
		   ?></p>
          <p>
            <?php


    $archivo = $re_orden['serie']."_".$re_orden['id'];

    $ruta_imagen = $archivo.'_QR.jpg';

	
	?>
          </p>

               <?php



$newDate = date("d-m-Y", strtotime($re_orden[fecha_emision]));

                ?>

          <p><strong class="chica2"><em>Fecha y Hora de Emision</em></strong>: <?php echo "<br>"; echo '<strong class="chica2">'. $newDate; ?>/<?php echo '<strong class="chica2">'.$re_orden[hora]; ?></p>
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
<table width="710"  border="0" style="table-layout: fixed" class="chica2">
  <tr>
    <td width="14%"><em><strong>Metodo de Pago:</strong></em></td>
    <td width="26%" align="left"><?php 
    
    
    $mp = $re_orden[metodo_pago]; 
   

    if ($mp == 'PUE') { echo " PUE - PAGO EN UNA SOLA EXHIBICION "; }
    if ($mp == 'PPD') { echo " PPD - PAGO EN PARCIALIDADES O DIFERIDO "; }
    
    ?> -</td>
    <td width="11%"><em><strong>Uso del CFDI: </strong></em></td>
    <td width="49%" align="left"><?php echo $re_orden[uso]; ?> 
  
    <?php


    if ($re_orden[uso] ==  "G01" ) { echo "Adquisicion de mercancias";}
    if ($re_orden[uso] ==  "G02" ) { echo "Devoluciones, descuentos o bonificaciones";}
    if ($re_orden[uso] ==  "G03" ) { echo "Gastos en general";}
	if ($re_orden[uso] ==  "S01" ) { echo "Sin Efectos Fiscales";}
    if ($re_orden[uso] ==  "CP01" ) { echo "Pagos";}
	if ($re_orden[uso] ==  "P01" ) { echo  "Pagos";}

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
  <tr>
    <td>Tipo de Comprobante</td>
    <td align="left"><?php echo $re_orden[tipo_cfdi];
	
	  $tip = $re_orden[tipo_cfdi];
	  
	  
	  if ($tip == 'P') { echo " Complemento para recepcion de pagos";}
	
	
	 ?></td>
    <td>Tipo de Cambio</td>
    <td align="left"><?php 
    
    
     $tp = $re_orden[tipo_cambio]; 
	 
	 if ($tp == 0 ) {  $tp = 1; }
	 
	 echo $tp;
   


    
    ?></td>
  </tr>
  <tr>
    <td>Version</td>
    <td align="left">2.0</td>
    <td>Moneda</td>
    <td align="left"><?php 
    
    
    echo $mon = $re_orden[moneda]; 
   
         if ( $tp = 1 ) {  echo "MXN"; }

    
    ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
</table>
<table width="103%" border="0">
  <tr>
    <td align="center" bgcolor="#CCCCCC" class="chica2"><strong><em>Detalle de la Factura</em></strong>
    <?php
	
	              $fa = $_GET['idorden'];

                  $consulta_detalle = mysqli_query($cone,"select * from detalle_complementos where idorden = '$fa'");
	
	
	
	?></td>
  </tr>
</table>
<table width="479" class="chica2">
  <thead>
    <tr>
      <th width="30" bgcolor="#CCCCCC"><em><strong>UUID</strong></em></th>
      <th width="25" bgcolor="#CCCCCC"><em><strong>Serie</strong></em></th>
      <th width="27" bgcolor="#CCCCCC"><em><strong>Folio</strong></em></th>
      <th width="43" bgcolor="#CCCCCC"><em>Moneda</em></th>
      <th width="38" bgcolor="#CCCCCC"><em>Tipo cambio</em></th>
      <th width="39" bgcolor="#CCCCCC"><em>Met Pago</em></th>
      <th width="38" bgcolor="#CCCCCC"><em>Saldo</em></th>
      <th width="48" bgcolor="#CCCCCC"><em>Importe</em></th>
      <th width="50" bgcolor="#CCCCCC"><em>Insoluto</em></th>
      <th width="37" bgcolor="#CCCCCC">No Parc.</th>
      <th width="46" bgcolor="#CCCCCC">Objeto Imp DR</th>
      <th width="73" bgcolor="#CCCCCC">Equiv. DR</th>
    </tr>
  </thead>
  <tbody>
    <?php
	                  $contador = 0;
				
				   while($red = mysqli_fetch_array($consulta_detalle)){
					   
					    $contador ++;

				
				
				?>
    <tr class="chica1">
      <td align="center"><?php echo $red['uuid']; ?></td>
      <td align="center"><?php echo $red['serie']; ?></td>
      <td><?php echo $red['folio']; ?></td>
      <td class="chica2"><?php echo $red['moneda'];  ?></td>
      <td align="center"><?php echo "1" ?></td>
      <td align="center"><?php echo $red['metodopago']; ?></td>
      <td align="center">$<?php echo $red['saldo']; ?></td>
      <td align="center">$<?php echo $red['importe']; ?></td>
      <td align="center">$<?php echo $red['insoluto']; ?></td>
      <td align="center"><?php echo $red['parcialidad']; ?></td>
      <td align="center">02</td>
      <td align="center">1</td>
    </tr>
    <?php
				
				   }
				
				
				?>
  </tbody>
</table>
<p>&nbsp;</p>

<?php 


$mon = $re_orden[total];

$sub = number_format($mon / 1.16,2, '.', '');
$iva = number_format($mon - $sub,2, '.', '');;




?>


<table width="551"   class="chica2">
  <tbody>
    <tr>
      <td width="68">&nbsp;</td>
      <td width="62">&nbsp;</td>
      <td width="56">&nbsp;</td>
      <td width="83">&nbsp;</td>
      <td width="158" align="right">Subtotal: </td>
      <td width="87" align="right">$ <?php echo $sub; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right">Iva: $ </td>
      <td align="right">$ <?php echo $iva; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="right"><em><strong>Total: </strong></em></td>
      <td align="right"><em><strong> $ <?php echo  $mon = $re_orden[total];
	  
	  $factu = saber_total_factura($clave);
	  
	  
	   ?></strong></em></td>
    </tr>
  </tbody>
</table>
<table width="489"  class="table">
  <tbody>
    <tr>
      <td width="481" align="center">(-- <?php echo '<strong class="chica2">'.convertir( $mon ).'</strong>'; ?>--)</td>
    </tr>
  </tbody>
</table>

<?php  if ($re_orden[moneda] == 'USD' ) {?>
<p>: </p>
<table width="551"   class="chica2">
  <tbody>
    <tr>
      <td width="68">&nbsp;</td>
      <td width="62">&nbsp;</td>
      <td width="56">&nbsp;</td>
      <td width="83">&nbsp;</td>
      <td width="158" align="right"><em><strong>Monto USD:</strong></em></td>
      <td width="87" align="right"><em><strong>$<?php echo  $usd = number_format($re_orden[total] / $re_orden[tipo_cambio],2);
	  
	
	  
	  
	   ?></strong></em></td>
    </tr>
  </tbody>
</table>

<?php } ?>
<p>&nbsp;</p>
<p>______________________________________________________________________________ </p>
<p>

    <?php 
	
	if ($contador == 6){
		
		echo "<br>";
			echo "<br>";
				echo "<br>";
					echo "<br>";
						echo "<br>";
		
		
	}
	
	
	?>


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
  <?php echo substr($re_orden[sello_sat],271,130); ?><?php echo substr($re_orden[sello_sat],401,130); ?>
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
      <p class="chica2">Este documento es un representacion impresa de un CFDI</p>
      <p class="chica2"><strong>Version: <?php echo "2.0"; ?></strong></p></td>
    <td width="11%"><img src="<?php echo $imagen; ?>" alt="" width="53" height="53" /></td>
  </tr>
</table>

  <p>________________________________________________________________________________</p>
</div>
</body>
</html>