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


<!DOCTYPE html>
<html lang="en">
<head>
  <title>CFDI Impreso</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

<div class="container-fluid">
 
 <table width="503" border="0">
  <tr>
    <td><table width="100%" border="0">
        <tr>
          <td width="17%"><img src="logo-erdt.png" width="143" height="76" /></td>
          <td width="83%" align="center" valign="top"><p><strong><em>No de Factura:</em></strong> <?php echo $_GET['idorden'];?></p>
          <p><strong><em>Tipo de Factura:</em></strong> <?php echo $re_orden['tipo_cfdi']; ?> </p>
          <p><strong><em>UUID:   <?php echo "UUID: ".$re_orden[uuid]; ?> </em></strong></p>
          <p><?php


    $archivo = $re_orden['serie']."_".$re_orden['id'];

    $ruta_imagen = 'https://elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/'.$archivo.'_QR.jpg';

	
	?>
          
          </p></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="37%">&nbsp;</td>
        </tr>
      <tr>
        <td>
        
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
        
        </td>
        </tr>
  </table></td>
  </tr>
  <tr>
    <td align="left"><p><strong><em>Datos de la factura</em></strong></p>
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
          <td><em><strong>Fecha de Pedimiento: </strong></em></td>
          <td><?php echo $re_orden[uso]; ?></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="left"><p><strong><em>Detalle de la Factura</em></strong>
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
                    <td><?php echo utf8_encode($red['unidad']); ?> </td>
                    <td><?php echo utf8_encode($red['c_producto']); ?> </td>
                    <td><?php echo utf8_encode($red['descripcion']);  ?> </td>
                    <td>$<?php echo utf8_encode($red['monto']); ?></td>
                    <td>$<?php echo $red['monto'] * $red['cantidad']; ?></td>
                  </tr>
                  
                <?php
				
				   }
				
				
				?>
                
                 
    </tbody>
  </table></td>
  </tr>
  <tr>
    <td align="left"><table border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
      <table width="100%" border="1">
        <tr>
          <td width="19%"><img src="../timbrado/files/cfdi/A_1076_QR.jpg" width="100" height="100" /></td>
          <td width="81%"><p>aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
            <p>sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss</p>
            <p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
    </table>
      <p>&nbsp;</p>
      <p>
        <label for="textarea"></label>
  </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
        <td width="31%" align="center">&nbsp;</td>
    </tr>
    </table></td>
  </tr>
 </table>
 
 
</div>

</body>
</html>