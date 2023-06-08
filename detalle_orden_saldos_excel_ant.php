<?php

	session_start();

  include("conecta_facturacion.php");
  date_default_timezone_set('America/Mexico_City');

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=detalle_orden_saldos.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);


  function saber_peso($cod){
    
  include("conecta_facturacion.php");
  $consulta_prod = mysqli_query($cone,"SELECT peso FROM `products` WHERE `codigo_producto` = '$cod'");
  $re_prod = mysqli_fetch_array($consulta_prod);

  $we = $re_prod['peso'];

  return  $we;

  }


  function saber_factura($id){

    include("conecta_facturacion.php");

    $consulta_idf = mysqli_query($cone,"SELECT * FROM `facturas_prov` where id_factura = '$id';");
    $re_idf = mysqli_fetch_array($consulta_idf);
  
    $num = $re_idf['numero_factura'];

      return  $num;

  }






  $ref = $_GET['refe'];
  
  $consulta_orden= mysqli_query($cone,"SELECT a.id,a.id_proveedor,a.referencia, b.proveedor, b.calle, b.colonia, b.estado, a.fecha, a.fecha_entrega, a.no_orden_kepler FROM `ordenes` a 
  INNER JOIN proveedores b ON a.id_proveedor = b.id where a.referencia = '$ref'");
  
  $re_orden = mysqli_fetch_array($consulta_orden);
  
  $consulta = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where referencia = '$ref';");
  
  
      ?>
  
  
      <div class="card-header">
               
                  <table width="100%" border="1">
    <tr>
      <td width="15%">Proveedor</td>
      <td width="30%"><?php echo $re_orden[proveedor]; ?></td>
      <td width="18%">Referencia </td>
      <td width="37%"><?php echo $re_orden[referencia];  $ref = $re_orden[referencia]; ?></td>
    </tr>
    <tr>
      <td>Calle</td>
      <td><?php echo $re_orden[calle]; ?></td>
      <td>Colonia</td>
      <td><?php echo $re_orden[colonia]; ?></td>
    </tr>
    <tr>
      <td>Fecha Orden</td>
      <td><?php echo $re_orden[fecha]; ?></td>
      <td>Fecha Entrega</td>
      <td><?php echo $re_orden[fecha_entrega]; ?></td>
    </tr>
  </table>
              
  <p></p>     
  <p>Orden De Compra en Kepler: <?php echo $re_orden['no_orden_kepler']; ?></p>   
 
  
  
  <h3 class="card-title"></h3>
  
  <!-- Agregar Producto<a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png"/></a> -->
              
              
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
  

  <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th align="left">Fecha SC</th>
                    <th align="left">Codigo</th>
                    <th align="left">Familia</th>
                    <th align="left">Descripcion</th>
                    <th align="left">usd/mpcs</th>
                    <th align="left">Piezas de SC</th>
                    <th align="left">Valor Solicitado</th>
                    <th align="left">Peso Unitario</th>
                
                    <th align="left">Peso total</th>
                    <th  align="left">Cantidad en Compra</th>
                    <th align="left">Saldo</th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php





                  

                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td class="letrachica" align="left"><?php echo "fecha sc"; ?></td>
                    <td class="letrachica" align="left"><?php echo utf8_encode($re['c_producto']);  $codi =  utf8_encode($re['c_producto']); ?> </td>
                    <td class="letrachica" align="left"><?php echo "Familia"; ?> </td>
                    <td class="letrachica" align="left"><?php echo  utf8_encode($re['descripcion']);  ?> </td>
                    <td class="letrachica" align="left">$<?php echo number_format(utf8_encode($re['monto']),2); ?></td>
                    <td class="letrachica" align="left"><?php echo utf8_encode($re['inicial']); ?></td>
                    <td class="letrachica" align="left">$<?php echo ($re['monto'] / 1000) * $re['cantidad']; ?></td>
                    <td class="letrachica" align="left"><?php echo saber_peso($codi);?></td>
                    <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php //echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->
                    <td class="letrachica"align="left" ><?php echo saber_peso($codi) *  $re['inicial'];?></td>
                    <td  class="letrachica">


                          <?php

                                $cod = $re['c_producto'];

                                $suma_compras = 0;

                                $consulta_cant = mysqli_query($cone,"SELECT idfactura,cantidad FROM `detalle_fact_provee` WHERE `referencia` LIKE '$ref' and c_producto = '$cod';");
                                while($re_cant = mysqli_fetch_array($consulta_cant)){

                      
                                $idf = $re_cant['idfactura'];

                                echo saber_factura($idf).": ".$re_cant['cantidad'];

                                $suma_compras = $suma_compras + $re_cant['cantidad'];

                                echo "<br>";
                                }

                          ?>



                    </td>

                    <td class="letrachica" align="left" >


                  <?php

                           $saldo = $re['inicial'] - $suma_compras;

                           echo $saldo;

                  ?>



                  </td>
                   
                  </tr>



               
          





                    <?php

                    }

                    ?>
                    
                  
                  
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                
                    <th></th>
                  </tr>
                  </tfoot>
                </table>

  
  
  
  ?>