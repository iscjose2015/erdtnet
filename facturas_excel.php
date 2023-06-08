


<?php

include("conecta_facturacion.php");
include("funciones_factura.php");


header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=facturas".$esta."_".$hoy.".xls");  
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);


$ini = $_GET[txtinicio];
$fin = $_GET[txtfin];

$consulta = mysqli_query($cone,"SELECT * FROM `invoices` where fecha_emision >= '$ini' and fecha_emision <= '$fin' order by 1 desc;");

?>

<body>
<p>&nbsp;</p>
<h3>Reporte de Facturas de Fijaciones</h3>
<p>Periodo del <?php  echo $ini; ?> al <?php echo $fin; ?>   <a href="facturas_excel.php"><img src="https://img.icons8.com/color/48/000000/export-excel.png"/></a> </p>
<table width="100%" border="1">
<tr>
  <td width="9%" bgcolor="#CCCCCC"><em><strong>No de Folio</strong></em></td>
  <td width="10%" bgcolor="#CCCCCC"><em><strong>Estatus</strong></em></td>
  <td width="28%" bgcolor="#CCCCCC"><em><strong>UUID</strong></em></td>
  <td width="10%" bgcolor="#CCCCCC"><em><strong>Fecha de Emision</strong></em></td>
  <td width="10%" bgcolor="#CCCCCC"><em><strong>Tipo de CFDI</strong></em></td>
  <td width="13%" bgcolor="#CCCCCC"><em><strong>Emisor</strong></em></td>
  <td width="12%" bgcolor="#CCCCCC"><em><strong>Receptor</strong></em></td>
  <td width="8%" bgcolor="#CCCCCC"><em><strong>Total</strong></em></td>
    <td width="12%" bgcolor="#CCCCCC"><em><strong>Pedimento</strong></em></td>
  <td width="8%" bgcolor="#CCCCCC"><em><strong>CFDI Relacionado</strong></em></td>
</tr>


  <?php
  
  
  
  while($re = mysqli_fetch_array($consulta)){
  
  
  ?>
<tr>
  <td><?php echo $re[id];?></td>
  <td><?php echo $re[estatus];?></td>
  <td><?php echo $re[uuid];?></td>
  <td><?php echo $re[fecha_emision];?></td>
  <td>
          <?php  
                  
                  $tipo = $re[tipo_cfdi]; 


                  if ($tipo == 'I' ) { echo "Ingreso"; }
                  if ($tipo == 'E' ) { echo "Egreso"; }
                  
                  
                  
                  ?>
  
  
  </td>
  <td><?php
                     $rece = $re['emisor'];

                  
                  $consulta_emisor = mysqli_query($cone,"select * from empresas where id = '$rece' ");
                  $re_emisor = mysqli_fetch_array($consulta_emisor);
                  echo  $re_emisor['empresa'];
                  
                  ?></td>
  <td><?php
  
     $rece = $re['receptor'];

                  $consulta_receptor = mysqli_query($cone,"select * from clientes where id_cliente = '$rece' ");
                  $re_receptor = mysqli_fetch_array($consulta_receptor);
                   echo  $re_receptor['rfc']." ". $re_receptor['nombre_cliente'];
                   
                   
                   ?>
  
  
  </td>
  <td>
  
  <?php  
                  
                  
                  $tot_fac = saber_total_factura($re[id]) * 1.16; 

                  echo '$'.number_format($tot_fac,2)
                  
                  
                  ?>
  
  </td>
  
    <td><?php echo $re[pedimento];?></td>
  <td><?php echo $re[relacionado];?></td>
</tr>

<?php

  }

?>

</table>