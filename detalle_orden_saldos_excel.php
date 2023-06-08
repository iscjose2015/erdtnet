<?php

	session_start();

  include("conecta_facturacion.php");
  date_default_timezone_set('America/Mexico_City');
  

  
    header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=detalle_orden_saldos.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
  

  
  
  
  if ($_GET[opc] == 3){
	  
	//  echo "Entro a salda";
	  
	  
	  $ref = $_GET[refe];
	  $id =  $_GET[id];
	  $pzas =$_GET[piezas];
	  $factu_ = $_GET[fact];
	  
	  //echo $ref.$id.$pzas;
	  
	  
	  $crea_factura = 'SALD-'.$factu_;
  
      $existe_factura = mysqli_query($cone,"SELECT * FROM `facturas_prov` WHERE `numero_factura` LIKE '$crea_factura'");
	  
	  $tot = mysqli_num_rows($existe_factura);
	  
	//  echo "Esto vale".$tot;
	  
	  if ($tot == 1){
		  
		  
	  }else
	  {
		  
		  // Aqui se inserta en facturas
		  $hoy = date("Y-m-d");
		  echo "Inserto Factura";
		  
		  $inserta = mysqli_query($cone,"INSERT INTO `facturas_prov` (`id_factura`, `numero_factura`, `fecha_factura`, `id_provee`, `total_venta`, `estado_factura`, `referencia`) VALUES (NULL, '$crea_factura', '$hoy', '0', '0', '0', '0');");
		    
		  
	  }
	  
	//  echo $crea_factura;
	  
      $query_saber_factura = mysqli_query($cone,"SELECT * FROM `facturas_prov` WHERE `numero_factura` LIKE '$crea_factura'");
	  $re_saber = mysqli_fetch_array($query_saber_factura);
	  
	  $idfacturaprov =$re_saber[id_factura];
	


	  
	  $cons = mysqli_query($cone,"SELECT * FROM `detalle_fact_provee` WHERE `id` = '$id'");
	  $datos_pre = mysqli_fetch_array($cons);
	  
	  //echo "prod".$datos_pre['c_producto'];
	  
	  
	  $prod = $datos_pre['c_producto'];
	  $desc = $datos_pre['descripcion'];;

	  
	  
	  
	  //echo $prod.$desc;
	  
	  
	//  $pzas = $pzas * -1;
	  
	 $inserta = mysqli_query($cone,"INSERT INTO `detalle_fact_provee` (`id`, `idorden`, `c_producto`, `descripcion`, `cantidad`, `monto`, `unidad`, `idfactura`, `importe`, `unidad_sat`, `codigo_sat`, `factor`, `pedimento`, `contenedor`, `referencia`, `sucursal`) VALUES (NULL, '0', '$prod', '$desc', '$pzas', '0', 'Pieza', '$idfacturaprov', '0', '', '', '', '', '', '$ref', '');");
	  
	  
	  
  }


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
  
  
  
   function saber_estatus($fct){

    include("conecta_aduana.php");

    $consulta_est = mysqli_query($cone,"SELECT b.factura_final, b.monto, a.fsc, c.estatus 
FROM bitacora_oc as a
JOIN pago_final as b on b.n_contrato = a.numcontrato
JOIN trafico as c on c.factura = b.factura_final
WHERE b.factura_final = '$fct'");
    
	$re_idf = mysqli_fetch_array($consulta_est);
  
    $num = $re_idf['estatus'];

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


  function saber_familia($cod){

    include("conecta_facturacion.php");

    $consulta_fam = mysqli_query($cone,"SELECT * FROM `products` WHERE `codigo_producto` LIKE '$cod'");
    $re_fam = mysqli_fetch_array($consulta_fam);
  
    $num = $re_fam['familia'];

    return  $num;

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
  
  






<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalle del Saldo</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
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







  <table width="2296" border="1" align="center">
                  <thead>
                  <tr>
                    <th width="50">Fecha SC</th>
                    <th width="47">Codigo</th>
                    <th width="49">Familia</th>
                    <th width="79">Descripcion</th>
                    <th width="61">usd/mpcs</th>
                    <th width="58">Piezas de SC</th>
                    <th width="77">Valor Solicitado</th>
                    <th width="64">Peso Unitario</th>
                
                    <th width="45">Peso total</th>
                    <th width="1702"><table width="1701" border="0" class="letrachica">
                      <tr>
                        <td width="114" align="center" valign="middle" bgcolor="#CCCCFF"><em><strong class="letrachica">Factura de Importacion</strong></em></td>
                         <td width="76" align="center" valign="middle" bgcolor="#CCCCFF"><em><strong>Estatus</strong></em></td>
                        <td width="100" align="center" valign="middle" bgcolor="#CCCCFF"><em><strong>Fecha Ingreso</strong></em></td>
                        <td width="112" align="center" valign="middle" bgcolor="#CCCCFF"><em><strong>Pzas Ingresads</strong></em></td>
                        <td width="124" align="center" valign="middle" bgcolor="#CCCCFF"><em><strong>Valor Usd Pzas Ingresada</strong></em></td>
                        <td width="75" align="center" valign="middle" bgcolor="#FFFFCC"><em><strong>Saldo Piezas</strong></em></td>
                        <td width="75" align="center" valign="middle" bgcolor="#FFFFCC"><em><strong>Valor Usd Saldo</strong></em></td>
                        <td width="63" align="center" valign="middle" bgcolor="#FFFFCC"><em><strong>Peso Pend.</strong></em></td>
                        <td width="92" align="center" valign="middle" bgcolor="#CCFFFF"><em><strong>Saldo Ant Fact</strong></em></td>
                        <td width="108" align="center" valign="middle" bgcolor="#CCFFFF"><strong><em>Saldo Desp Fact</em></strong></td>
                        <td width="100" align="center" valign="middle" bgcolor="#CCFFFF"><p>% Completado</p></td>
                        <td width="104" align="center" valign="middle" bgcolor="#CCFFFF">Acción</td>
                        <td width="104" align="center" valign="middle" bgcolor="#CCFFFF">Suma de Saldo Discontinuo</td>
                      </tr>
                      <?php

                                $cod = $re['c_producto'];

                                $suma_compras = 0;

                                $consulta_cant = mysqli_query($cone,"SELECT idfactura,cantidad FROM `detalle_fact_provee` WHERE `referencia` LIKE '$ref' and c_producto = '$cod';");
								
								//$saldo_piezas = number_format( $re['inicial'], 2, '.', '' );
								
								 $saldo_piezas = $re['inicial'];
								
								$suma_total = 0;							
								
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
                    <td align="left" valign="top" class="letrachica"><?php echo $re_orden[fecha]; ?></td>
                    <td align="left" valign="top" class="letrachica"><?php echo utf8_encode($re['c_producto']);  $codi =  utf8_encode($re['c_producto']); ?> </td>
                    <td align="left" valign="top" class="letrachica"><?php echo saber_familia($re['c_producto']); ?> </td>
                    <td align="left" valign="top" class="letrachica"><?php echo  utf8_encode($re['descripcion']);  ?> </td>
                    <td align="center" valign="top" class="letrachica">$<?php echo number_format(utf8_encode($re['monto']),2); $pre_u = $re['monto']; ?></td>
                    <td align="center" valign="top" class="letrachica"><?php echo number_format($re['inicial']); ?></td>
                    <td align="center" valign="top" class="letrachica">$<?php echo  $valor_soli = number_format(($re['monto'] * $re['inicial']) / 1000 ,2);
					
					
					 ?></td>
                    <td align="center" valign="top" class="letrachica"><?php echo saber_peso($codi); $peso_uni = saber_peso($codi); ?></td>
                    <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php //echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->
                    <td align="center" valign="top" class="letrachica"><?php echo saber_peso($codi) *  $re['inicial'];?></td>
                    <td  class="letrachica">


                          <table width="1701" border="0" class="letrachica">
                            
                            		  <?php

                                $cod = $re['c_producto'];

                                $suma_compras = 0;
								
								$suma_saldos = 0;
								
								$suma_piezas_ingre = 0;
								

                                $consulta_cant = mysqli_query($cone,"SELECT idfactura,cantidad,id FROM `detalle_fact_provee` WHERE `referencia` LIKE '$ref' and c_producto = '$cod';");
								
								$saldo_piezas = $re['inicial'];
								
								
								$encontradas = 0;
								
								$consulta_encontradas = mysqli_num_rows($consulta_cant); // echo $consulta_encontradas;	
								
								
							
								
								
								if ($consulta_encontradas == 0){
									
							    ?>
                                
                                
                                     <tr>
                                    <td width="150" align="center"></td>
                                    <td width="100" align="center"></td>
                                     <td width="131" align="center"></td>
                                    <td width="137" align="center">&nbsp;</td>
                                    <td width="163" align="center">&nbsp;</td>
                                    <td width="106" align="center"><?php  echo number_format($saldo_piezas,2);  ?></td>
                                    <td width="90" align="center">$<?php  echo ($saldo_piezas * $re[monto])/1000;  ?></td>
                                    <td width="82" align="center"><?php  echo $peso_uni * $saldo_piezas; ?></td>
                                    <td width="123" align="center">$<?php  echo  ($saldo_piezas * $re[monto])/1000;  ?></td>
                                    <td width="149" align="center">$<?php  echo  ($saldo_piezas * $re[monto])/1000;  
									$suma_total = $suma_total + ( ($saldo_piezas * $re[monto])/1000 ); //  echo "St".$suma_total; ?></td>
                                    <td width="129" align="center">&nbsp;</td>
                                    <td width="144" align="center">&nbsp;</td>
                                    <td width="141" align="center"><?php echo number_format($suma_total,2); ?></td>
                            </tr>
                                
                                      
									
									
							    <?php
								
								$suma_saldos = $suma_saldos + (	$saldo_piezas * $re[monto] );
								}
									
								
								
								
								$saldo_anterior =  number_format( ($saldo_piezas * $re[monto])/1000,2);
								
							
											
								$suma_saldos = 0;
								$contador_vueltas = 0;
							  
							   // ----------------------------------------------------------------------------------------------------------
								
                                while($re_cant = mysqli_fetch_array($consulta_cant)){
									
								 // echo "cE".$consulta_encontradas;
								 
								 $contador_vueltas ++;
									
									
									$color = '#FFFFFF';
									
								$identificador = $re_cant['id'];

                      
                                $idf = $re_cant['idfactura'];

                               // echo saber_factura($idf).": ".$re_cant['cantidad'];

                                $suma_compras = $suma_compras + $re_cant['cantidad'];

								
							
								  ?>
                            
                                  <tr>
                                    <td width="150" align="center"><?php  echo saber_factura($idf); $fa = saber_factura($idf);  ?></td>
                                        <td align="center" width="100">&nbsp;</td>
                                    <td width="131" align="center"><?php  echo saber_fecha($idf); ?></td>
                                    <td width="137" align="center"><?php   echo abs($re_cant['cantidad']);
									
									 $mas_diez =  $re['inicial'] * 0.10; 
									 
									 
									  $suma_piezas_ingre = $suma_piezas_ingre +  abs($re_cant['cantidad']);
									 
									 
									
									?></td>
                                    <td width="163" align="center">$<?php  echo number_format(($re['monto'] * abs($re_cant['cantidad'])) / 1000 ,2);
?></td>

										 <?php 
										 
									
										 
										// $saldo_piezas = number_format( $saldo_piezas, 2, '.', '' ) - $re_cant['cantidad'];
										
										
										 
										 
										//  echo $saldo_piezas." / ".$re_cant['cantidad'];
										  
								
										  
										  
										  
										  if($saldo_piezas < 0) { 
										  //echo "aqui entro"; 
										  
										   $saldo_piezas = $saldo_piezas * -1; //echo "Sa".$saldo_piezas; 					
										  
										   $saldo_piezas =   $saldo_piezas - $re_cant['cantidad'];
										  
										  }
										  else
										  {
											  
										    $saldo_piezas =    $re_cant['cantidad'] - $saldo_piezas ;
											  
										  }
										  
										  
										 
										 
										
										 
										 
										  
										  
									
										 
										 if ($saldo_piezas < 0 ) { //$color = "#CCCCCC";
										   $negativo = 0; } ?>
								

                                    <td width="106" align="center" bgcolor="<?php echo $color; ?>" >	<?php 
									
									
									
									 
									 if ($saldo_piezas > -5 and $saldo_piezas <= 2) {  $saldo_piezas = 0;  }
									 
									  echo abs($saldo_piezas);
									  
									  
									     $completado = ($suma_piezas_ingre * 100) / $re['inicial']; 
									 
									  ?></td>
                                    <td width="90" align="center">$
                                      <?php  
									
									$valor_saldo = $re['monto'] * abs($saldo_piezas);  
									
									 if ($completado > 100 ) { $valor_saldo = 0; }
									 
									echo $valor_saldo/1000;
									if ($negativo == 0) { $valor_saldo = 0; }
									
									 ?></td>
                                    <td width="82" align="center"><?php  echo $peso_uni * abs($saldo_piezas); ?></td>
                                    <td width="125" align="center">$<?php echo $saldo_anterior; ?></td>
                                    <td width="149" align="center">$<?php
									
								   $saldo_despues =  (abs($saldo_piezas) * $re[monto])/1000;  
								   
								    if ($completado > 100 ) { $saldo_despues = 0; }
								   
								   echo $saldo_despues;
								   
								   $cad = explode("-",$fa);
								   
								   if ( $cad[0] == 'SALD' ) { $saldo_despues = 0;}
								   
								   
								   
								   if ($contador_vueltas == $consulta_encontradas){
								   $suma_total = $suma_total + $saldo_despues;
								   
								   
								    if ($suma_total == 0) {}
								  // echo"<br>";
								  // echo "St**".$suma_total;
								  // echo"<br>";
								   }
								   
								    $suma_saldos = $suma_saldos + $saldo_despues;
								   
								   $saldo_anterior   = $saldo_despues;
								   
								   
										
								   
										
										
										?></td>
                                        
                                      
                                    <td width="129" align="center">
                                    
                                    <?php   
									
									
									
									
									    
											
											 echo number_format($completado,2)."%"; //echo $suma_piezas_ingre;
											 echo "<br>";
											 
								
									?> 
                                    
                                    </td>
                                    <td width="144" align="center"><?php   
									
									
									
									
									    
											
											// echo number_format($completado,2)."%"; //echo $suma_piezas_ingre;
											// echo "<br>";
											 
											 
											 
											 if ($completado > 100){
												 
												    echo "Salda Excedido";
												 
											 }
											 
										
											 
											 
											  if ($completado >= 90 and $completado <= 99.99 ){
												  
												  
												  	 echo '<a href="detalle_orden_saldos.php?refe='.$ref.'&id='.$identificador.'&opc=3&piezas='.abs($saldo_piezas).'&fact='.$fa.'"; >Aplicar Salda</a>';
													 
													    
												  
											  }
											 
											 
											
											
											 /*
											 if ($completado >= 90 and $saldo_despues > 0 ){
												 
												 if ($completado == 100.00){}else{
													 
													 
													  if ($completado  > 100){
														  
													  }else{
														  
														  echo "Salda Excedido";
													  }
													 
													 echo '<a href="detalle_orden_saldos.php?refe='.$ref.'&id='.$identificador.'&opc=3&piezas='.abs($saldo_piezas).'&fact='.$fa.'"; >Aplicar Salda</a>';
													 
												 }
												 
												 
											 }  */
											
										/*	if (abs($saldo_piezas) <= $mas_diez  and $saldo_despues <> 0 ) { echo '<a href="detalle_orden_saldos.php?refe='.$ref.'&id='.$identificador.'&opc=3&piezas='.abs($saldo_piezas).'&fact='.$fa.'"; >Aplicar Salda</a>'; }
									           
										
									*/
									?></td>
                                    <td width="141" align="center"><?php echo number_format($suma_total,2); ?></td>
                            </tr>
                                           
                            <?php
							
							              // $suma_saldos = $suma_saldos + $saldo_despues;
							 
								}
								
							//	echo "Hola";
								  
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
<table width="2296" border="0">
  <tr>
    <td width="54">&nbsp;</td>
    <td width="48">&nbsp;</td>
    <td width="52">&nbsp;</td>
    <td width="85">&nbsp;</td>
    <td width="68">&nbsp;</td>
    <td width="62">&nbsp;</td>
    <td width="68">&nbsp;</td>
    <td width="67">&nbsp;</td>
    <td width="48">&nbsp;</td>
    <td width="154">&nbsp;</td>
    <td width="99">&nbsp;</td>
    <td width="130">&nbsp;</td>
    <td width="142">&nbsp;</td>
    <td width="162">&nbsp;</td>
    <td width="103">&nbsp;</td>
    <td width="88">&nbsp;</td>
    <td width="84">&nbsp;</td>
    <td width="123" align="right"><em><strong>Saldo Total: $</strong></em></td>
    <td width="149" align="center" valign="top" bgcolor="#999999"><em><strong>&nbsp;
      <?php  echo "<h3>". $suma_total."</h3>"; ?>
    </strong></em></td>
    <td width="129">&nbsp;</td>
    <td width="144">&nbsp;</td>
    <td width="141">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>
  <?php
	//include("footer.php");




	?>
  
  
  
  
  <script src="assets/dist/js/clientes.js"></script>
</p>
<p>&nbsp;</p>
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
