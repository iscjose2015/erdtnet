<?php

	session_start();

  include("conecta_facturacion.php");
  date_default_timezone_set('America/Mexico_City');


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
  <head>
    <?php include("head.php");?>
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



  <style>

.letrachica{
	font-size:15px;
}

</style>

<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalle del Saldo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              <li class="breadcrumb-item active">Fecha y hora: <?php echo  date("d-m-Y H:m:s"); ?></li>
            </ol>
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
<p>No de Folio en CONI: <?php  echo $re_orden[id];?></p>   

<p><a href="detalle_orden_saldos_excel.php?refe=<?php echo $_GET[refe];?>">Descargar Excel <img src="https://img.icons8.com/color/48/null/ms-excel.png"/></a></p>   


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


<style>

.tabla {
   width: 100%;
   border: 1px solid #000;
}
th, td {


   border: 1px solid #000;



}

</style>




  <table class="tabla" border="1" width="100%">
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
                    <th><table width="660" border="1" class="letrachica">
                      <tr>
                        <td width="17%" align="center" valign="top" bgcolor="#CCCCFF"><em><strong class="letrachica">Factura de Importacion</strong></em></td>
                        <td width="12%" align="center" valign="top" bgcolor="#CCCCFF"><em><strong>Fecha Ingreso</strong></em></td>
                        <td width="12%" align="center" valign="top" bgcolor="#CCCCFF"><em><strong>Pzas Ingresads</strong></em></td>
                        <td width="12%" align="center" valign="top" bgcolor="#CCCCFF"><em><strong>Valor Usd Pzas Ingresada</strong></em></td>
                        <td width="8%" align="center" valign="top" bgcolor="#FFFFCC"><em><strong>Saldo Piezas</strong></em></td>
                        <td width="9%" align="center" valign="top" bgcolor="#FFFFCC"><em><strong>Valor Usd Saldo</strong></em></td>
                        <td width="10%" align="center" valign="top" bgcolor="#FFFFCC"><em><strong>Peso Pend.</strong></em></td>
                        <td width="9%" align="center" valign="top" bgcolor="#CCFFFF"><em><strong>Saldo Ant Fact</strong></em></td>
                        <td width="11%" align="center" valign="top" bgcolor="#CCFFFF"><strong><em>Saldo Desp Fact</em></strong></td>
                      </tr>
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
                      <?php
								}
								  
								  ?>
                    </table></th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php





                  

                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td height="32" align="left" valign="top" class="letrachica"><?php echo $re_orden[fecha]; ?></td>
                    <td align="left" valign="top" class="letrachica"><?php echo utf8_encode($re['c_producto']);  $codi =  utf8_encode($re['c_producto']); ?> </td>
                    <td align="left" valign="top" class="letrachica"><?php echo "Familia"; ?> </td>
                    <td align="left" valign="top" class="letrachica"><?php echo  utf8_encode($re['descripcion']);  ?> </td>
                    <td align="center" valign="top" class="letrachica">$<?php echo number_format(utf8_encode($re['monto']),2); $pre_u = $re['monto']; ?></td>
                    <td align="center" valign="top" class="letrachica"><?php echo number_format($re['inicial']); ?></td>
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
								
								
								$encontradas = 0;
								
								$consulta_encontradas = mysqli_num_rows($consulta_cant); // echo $consulta_encontradas;	
								
								
								if ($consulta_encontradas == 0){
									
							    ?>
                                
                                
                                     <tr>
                                    <td width="17%" align="center"></td>
                                    <td width="12%" align="center"></td>
                                    <td width="12%" align="center">&nbsp;</td>
                                    <td width="12%" align="center">&nbsp;</td>
                                    <td width="8%" align="center"><?php  echo number_format($saldo_piezas,2);  ?></td>
                                    <td width="9%" align="center">$<?php  echo number_format( ($saldo_piezas * $re[monto])/1000,2);  ?></td>
                                    <td width="10%" align="center"><?php  echo $peso_uni * $saldo_piezas; ?></td>
                                    <td width="9%" align="center"><?php  echo number_format( ($saldo_piezas * $re[monto])/1000,2);  ?></td>
                                    <td width="11%" align="center"><?php  echo number_format( ($saldo_piezas * $re[monto])/1000,2);  ?></td>
                            </tr>
                                
                                
									
									
							    <?php		
								}
									
								
								
								
								$saldo_anterior =  number_format( ($saldo_piezas * $re[monto])/1000,2);
								
											
								
							  
							   // ----------------------------------------------------------------------------------------------------------
								
                                while($re_cant = mysqli_fetch_array($consulta_cant)){

                      
                                $idf = $re_cant['idfactura'];

                               // echo saber_factura($idf).": ".$re_cant['cantidad'];

                                $suma_compras = $suma_compras + $re_cant['cantidad'];

								
							
								  ?>
                            
                                  <tr>
                                    <td width="17%" align="center"><?php  echo saber_factura($idf); $fa = saber_factura($idf);  ?></td>
                                    <td width="12%" align="center"><?php  echo saber_fecha($idf); ?></td>
                                    <td width="12%" align="center"><?php   echo $re_cant['cantidad'];?></td>
                                    <td width="12%" align="center">$<?php  echo number_format(($re['monto'] * $re_cant['cantidad']) / 1000 ,2);
?></td>
                                    <td width="8%" align="center"  <?php $saldo_piezas = $saldo_piezas - $re_cant['cantidad']; ?> <?php if ($saldo_piezas < 0 ) {?>bgcolor="#CCCCCC" <?php } ?>><?php    $saldo_piezas = abs($saldo_piezas);  echo $saldo_piezas; ?></td>
                                    <td width="9%" align="center">$<?php  $valor_saldo = $re['monto'] * $saldo_piezas;  echo number_format($valor_saldo/1000,2); ?></td>
                                    <td width="10%" align="center"><?php  echo $peso_uni * $saldo_piezas; ?></td>
                                    <td width="9%" align="center"><?php echo number_format($saldo_anterior,2); ?></td>
                                    <td width="11%" align="center">
                                    
                                        <?php
										
									
										
										    
										   $saldo_despues = $saldo_anterior - ($re_cant['cantidad'] * $re['monto'])/1000;
										   
										   echo abs( number_format($saldo_despues,2));
										   
										  $saldo_anterior   = number_format($saldo_despues,2);; 
										   
										
										
										
										?>
                                    
                                    
                                    
                                    
                                    </td>
                            </tr>
                                           
                            <?php
								}
								  
								  ?>

                                    
                      </table>
                           



                    </td>

                    </tr>



                   <!-- Modal de  edicion -->

                  <div class="modal fade" id="modal-edit_<?php echo $re['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Editar Cliente</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    
         


                  <form   id="form2" name="form2" action="detalle_orden.php" method="get" >

                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Id</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtcodigo" placeholder="Codigo" name="txtcodigo" required value= "<?php echo $re['id']; ?>"  readonly="readonly" >
                    </div>
                    </div>



                    <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Empresa</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="txtempresa" placeholder="Codigo" name="txtempresa" required value= "<?php echo $re['empresa']; ?>"   >
                    </div>
                  </div>


          
                  
                  


                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />
                  <input name="idorden" type="hidden" value="<?php echo $_GET[idorden] ?>" />
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      </div>

                      </form>
                    </div>
                    <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->


                <!-- Modal de Borrado -->

                <div class="modal fade" id="modal-borrar_<?php echo $re['id']; ?>">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Borrar Producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    
         


                  <form   id="form2" name="form2" action="detalle_orden.php" method="get" >

                   
                   <p><?php echo "Clave: ".$re[id]; ?></p>
                   <p><?php echo "Descripcion: ".$re[descripcion]; ?></p>
                   

                  <input name="opc" type="hidden" value="2" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />
                  <input name="idorden" type="hidden" value="<?php echo $_GET[idorden]; ?>" />
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
