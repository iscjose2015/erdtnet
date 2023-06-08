<?php

	session_start();

  include("conecta_facturacion.php");
  date_default_timezone_set('America/Mexico_City');
  
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
  
    function saber_fecha($id){

    include("conecta_facturacion.php");

    $consulta_idf = mysqli_query($cone,"SELECT * FROM `facturas_prov` where id_factura = '$id';");
    $re_idf = mysqli_fetch_array($consulta_idf);
  
    $num = $re_idf['fecha_factura'];

      return  $num;

  }
  
  
    function saber_total($fact){

    include("conecta_facturacion.php");

    $consulta_tot = mysqli_query($cone,"SELECT total_venta FROM `facturas_prov` where numero_factura = '$fact';");
    $re_tot = mysqli_fetch_array($consulta_tot);
  
    $tot = $re_tot['total_venta'];

      return  $tot;

  }



  
        if($_GET[opc] == 1){

            $cant = $_GET[txtcantidad];

        }


        if($_GET[opc] == 2){



        }



        if($_GET[opc] == 3){

          /*

          if(!empty($_GET[txtempresa])){
            $emp = $_GET[txtempresa];
            $cod = $_GET[txtid];

            $inserta = mysqli_query($cone,"UPDATE `empresas` SET `empresa` = '$emp' WHERE `empresas`.`id` = '$cod';");

            header("location: base.php");

            */

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





  <style>

.letrachica{
	font-size:15px;
}

</style>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalle del Saldo por contrato</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <?php





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
	
  
  



  <?php


$consulta2 = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where idorden = '$clave';");


$suma = 0;

while($re = mysqli_fetch_array($consulta2)){

  $importe = $re['monto'] * $re['cantidad']; 
  $suma = $importe  +  $suma;


}






?>




  <table class="" border="1" width="100%">
                  <thead>
                  <tr>
                    <th>Fecha SC</th>
                    <th>Codigo</th>
                    <th>Familia</th>
                    <th>Descripcion</th>
                    <th>usd/mpcs</th>
                    <th>Piezas de SC</th>
                    <th>Valor Solicitado</th>
                    <th>Peso Unitario</th>
                
                    <th>Peso total</th>
                    <th><table width="100%" border="1">
                      <tr>
                        <td align="center" valign="top"><em>No. Compra</em></td>
                        <td align="center" valign="top"><em>Fecha Fact</em></td>
                        <td align="center" valign="top"><em>Canitdad Compra</em></td>
                        <td align="center" valign="top">Saldo Piezas</td>
                        <td align="center" valign="top"><em>Valor Saldo</em></td>
                        <td align="center" valign="top"><em>Peso</em></td>
                        <td align="center" valign="top"><em>Importe Fact</em></td>
                        <td align="center" valign="top"><em>Saldo Ant Fact</em></td>
                        <td align="center" valign="top"><em>Saldo Desp Fact</em></td>
                      </tr>
                    </table></th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php





                  

                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td align="left" valign="top" class="letrachica"><?php echo "fecha sc"; ?></td>
                    <td align="left" valign="top" class="letrachica"><?php echo utf8_encode($re['c_producto']);  $codi =  utf8_encode($re['c_producto']); ?> </td>
                    <td align="left" valign="top" class="letrachica"><?php echo "Familia"; ?> </td>
                    <td align="left" valign="top" class="letrachica"><?php echo  utf8_encode($re['descripcion']);  ?> </td>
                    <td align="center" valign="top" class="letrachica">$<?php echo number_format(utf8_encode($re['monto']),2); ?></td>
                    <td align="center" valign="top" class="letrachica"><?php echo utf8_encode($re['inicial']); ?></td>
                    <td align="center" valign="top" class="letrachica">$<?php echo  $valor_soli = number_format(($re['monto'] * $re['inicial']) / 1000 ,2);
					
					
					 ?></td>
                    <td align="center" valign="top" class="letrachica"><?php echo saber_peso($codi); $peso_uni = saber_peso($codi); ?></td>
                    <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php //echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->
                    <td align="center" valign="top" class="letrachica"><?php echo saber_peso($codi) *  $re['inicial'];?></td>
                    <td  class="letrachica">


                          <table width="100%" border="1">
                            
                            		  <?php

                                $cod = $re['c_producto'];

                                $suma_compras = 0;

                                $consulta_cant = mysqli_query($cone,"SELECT idfactura,cantidad FROM `detalle_fact_provee` WHERE `referencia` LIKE '$ref' and c_producto = '$cod';");
								
								$saldo_piezas = $re['inicial'];
								
								
							
								
                                while($re_cant = mysqli_fetch_array($consulta_cant)){

                      
                                $idf = $re_cant['idfactura'];

                               // echo saber_factura($idf).": ".$re_cant['cantidad'];

                                $suma_compras = $suma_compras + $re_cant['cantidad'];

                               $saldo_anterior = $valor_soli;
								
							
								  ?>
                            
                                  <tr>
                                    <td align="center"><?php  echo saber_factura($idf); $fa = saber_factura($idf);  ?></td>
                                    <td align="center"><?php  echo saber_fecha($idf); ?></td>
                                    <td align="center"><?php   echo $re_cant['cantidad'];?></td>
                                    <td align="center"><?php $saldo_piezas = $saldo_piezas - $re_cant['cantidad'];  echo $saldo_piezas; ?></td>
                                    <td align="center"><?php  $valor_saldo = $re['monto'] * $re_cant['cantidad'];  echo number_format($valor_saldo/1000,2); ?></td>
                                    <td align="center"><?php  echo $peso_uni * $re_cant['cantidad']; ?></td>
                                    <td align="center"><?php echo saber_total($fa); ?></td>
                                    <td align="center"><?php echo $saldo_anterior; ?></td>
                                    <td align="center">
                                    
                                        <?php
										
										   $saldo_despues = $saldo_anterior - ($re_cant['cantidad'] * $re['monto'])/1000;
										   
										   echo number_format(($re_cant['cantidad'] * $re['monto'])/1000,2);
										   
										   $saldo_anterior   = $saldo_despues;
										
										
										?>
                                    
                                    
                                    
                                    
                                    </td>
                            </tr>
                                           
                            <?php
								}
								  
								  ?>

                                    
                      </table>
                           



                    </td>

                    </tr>



               


         
    





                    <?php

                    }

                    ?>
                  <tfoot>
                  </tfoot>
                </table>




                 
  







  

  
</main>
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
