
<?php
	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");

  date_default_timezone_set('America/Mexico_City');

  
  $idorden = $_GET['idorden'];

        if($_GET['opc'] == 1){

            $u = $_GET['lbluuid'];
            //$fac = $_GET['idorden'];

             $cons_u = mysqli_query($cone,"SELECT * FROM `invoices` WHERE `uuid` = '$u'");
             $reuu = mysqli_fetch_array($cons_u);

            $se = $reuu['serie'];
            $fol = $reuu['id'];
            $mon = $reuu['moneda'];
            $met =$reuu['metodo_pago'];

            $suma = 0;
            $consulta_total = mysqli_query($cone,"SELECT * FROM `detalle_invoices` where idfactura = '$fact'");
            while($re_total=mysqli_fetch_array($consulta_total)){
              $suma = $suma + ($re_total['cantidad'] * $re_total['monto']);
            }
            $sal =  $suma;
            $impo = $suma;

            $cons_t = mysqli_query($cone,"SELECT * FROM `complementos` where id = '$idorden';");
            $ret = mysqli_fetch_array($cons_t);
            $tipoca = $ret['tipo_cambio'];

            $importe_factura = saber_total_factura($fol);
          //  echo $importe_factura;

            $valor_factura_con_iva = number_format($importe_factura * 1.16,2, '.', '');
			
			echo "Valor de U".$u;
          
            $inserta = mysqli_query($cone,"INSERT INTO `detalle_complementos` (`id`, `idfactura`, `uuid`, `serie`, `folio`, `moneda`, `tipocambio`, `metodopago`, `parcialidad`, `saldo`, `importe`, `idorden`, `insoluto`) 
            VALUES (NULL, '$fol', '$u', '$se', '$fol', '$mon', '$tipoca', '$met', '1', '$valor_factura_con_iva', '$valor_factura_con_iva','$idorden','0');");
  
              // Sacar monto anterior

              $monto_anterior = mysqli_query($cone,"SELECT * FROM `complementos` where id = '$idorden';");
              $re_monto_anterior = mysqli_fetch_array($monto_anterior);

              echo "Saldo".$re_monto_anterior[total];
              echo "impo".$valor_factura_con_iva;

            // Actualiza el monto
             $nuevo_monto = $valor_factura_con_iva + $re_monto_anterior[importe]; // Aqui
             $actualiza_monto = mysqli_query($cone,"UPDATE `complementos` SET `total` = '$nuevo_monto' WHERE `complementos`.`id` = '$idorden';");


           //  header("location: detalle_complementos.php?idorden=$idorden");

        }

        if($_GET['opc'] == 2){

          $idDtllComp = $_GET['txtid'];
          $delete = mysqli_query($cone, "DELETE FROM detalle_complementos WHERE id = '$idDtllComp'");
          header("location: detalle_complementos.php?idorden=$idorden");

        }

        if($_GET['opc'] == 3){
              $Id         = $_GET['idComple'];
              $uuid       = $_GET['lbluuid'];
              $seriefolio = $_GET['serieFolio'];
              $parcialid  = $_GET['txtparcial'];
              $saldAnt    = $_GET['txtsaldAnt'];
              $importPago = $_GET['txtimportPgo'];
              $folio      = $_GET['txtfolio'];

			  $up_complemet = mysqli_query($cone, "UPDATE detalle_complementos       SET uuid         = '$uuid'       WHERE id = '$Id'");
              $up_complemet = mysqli_query($cone, "UPDATE detalle_complementos SET serie        = '$seriefolio' WHERE id = '$Id'");
              $up_complemet = mysqli_query($cone, "UPDATE detalle_complementos SET parcialidad  = '$parcialid'  WHERE id = '$Id'");
              $up_complemet = mysqli_query($cone, "UPDATE detalle_complementos SET saldo        = '$saldAnt'    WHERE id = '$Id'");
              $up_complemet = mysqli_query($cone, "UPDATE detalle_complementos SET importe      = '$importPago' WHERE id = '$Id'");
              $up_complemet = mysqli_query($cone, "UPDATE detalle_complementos SET folio        = '$folio'      WHERE id = '$Id'");


             // header("location: detalle_complementos.php?idorden=$idorden");
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
          .div {
                width: 230px;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
                cursor: pointer;
          }
          </style>
    </head>
  <body>
    <?php include("navbar.php"); ?>

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalle Complemento</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
             
            </ol>
          </div>
        </div>
      </div><!--/.container-fluid -->
    </section>

    <?php
      //$clave = $_GET['idorden'];
      //$idorden = $_GET['idorden'];

      $consulta_orden= mysqli_query($cone,"SELECT * FROM `complementos` WHERE `id` = '$idorden'");
      $re_orden = mysqli_fetch_array($consulta_orden);
      $consulta = mysqli_query($cone, "SELECT * FROM `detalle_complementos` where idorden = '$idorden';");

      $emi = $re_orden['emisor'];
      $rece = $re_orden['receptor'];

      $consulta_emisor = mysqli_query($cone,"SELECT * FROM `empresas` where id = '$emi'");
      $consulta_receptor = mysqli_query($cone,"SELECT * FROM `clientes` where id_cliente = '$rece'");

      $re_emisor   = mysqli_fetch_array($consulta_emisor);
      $re_receptor = mysqli_fetch_array($consulta_receptor);
    ?>

    <div class="card-header">

      <table width="100%" border="1"><!--INICIA TABLE1-->
        <tr>
          <td width="50%">DATOS</td>
          <td width="30%" align="center">ACCIONES</td>
          <td width="20%" align="center">Estatus <?php echo $re_orden['estatus'];?></td>
        </tr>
        <tr>
          <td>
            <table width="100%" border="0"><!--INICIA TABLE2-->
              <tr>
                <td width="15%"><em><strong>Emisor</strong></em></td>
                <td width="30%"><?php echo $re_emisor['empresa']; ?></td>
                <td width="18%"><em><strong>Receptor</strong></em></td>
                <td width="37%"><?php echo utf8_encode($re_receptor['nombre_cliente']); ?></td>
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
            </table> <!--TERMINA TABLE2-->
          </td>
          <td align="center">
            <?php
              if($re_orden['estatus'] == 'Por Emitir'  ){
                $ruta_imagen = "https://img.icons8.com/doodle/72/000000/error.png";
                $archivo = $re_orden['serie']."_".$re_orden['id'];
            ?>
              <!-- <a href="../facturacion/timbrado/php/crear_xml_comple.php?cve=<?php//echo $_GET['idorden']; ?>"><img src="https://img.icons8.com/plasticine/50/000000/create-new.png"/> Crear XML</a> -->
            
             <a href="../facturacion/timbrado/php/crear_xml_comple_4.0.php?cve=<?php echo $_GET['idorden']; ?>"><img src="https://img.icons8.com/plasticine/50/000000/create-new.png"/> Crear XML 4.0</a> 
            <?php
              } else{

                echo "Serie y Folio:".$re_orden['serie']." ".$re_orden['id'];
                echo "<br>";
                echo "UUID: ".$re_orden['uuid'];
                echo "<br>";

                $archivo = $re_orden['serie']."_".$re_orden['id'];
                $ruta_imagen = 'https://elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/'.$archivo.'_QR.jpg';
            ?>
              <a href="timbrado/files/cfdi/descarga_xml.php?valor=<?php echo $archivo; ?>">Descargar XML</a>
              <a href="https://elreydeltornillo.com/sit/facturacion/pdfdom/crearPdf_comple.php?idorden=<?php echo $_GET['idorden'];?>" target="_blank">Descargar PDF</a>
            <?php } ?>
          </td>
          <td align="center">
            <img src="<?php  echo $ruta_imagen; ?>" width="100" height="100" />
          </td>
        </tr>
      </table><!--TERMINA TABLE1-->
  
      <p></p>     
      <p></p>   

      <table width="100%" border="0">
        <tr>
          <td><h3 class="card-title"></td>
          <td></td>
          <td></td>
        </tr>
      </table>

      <table width="100%" border="1"><!--INICIA TABLE2-->
        <tr>
          <td width="25%"><em><strong>Fecha de Emision</strong></em></td>
          <td width="26%"><?php echo $re_orden['fecha_emision']; ?></td>
          <td width="16%"><em><strong>Moneda</strong></em></td>
          <td width="33%"><?php echo $re_orden['moneda']; ?></td>
        </tr>
        <tr>
          <td><em><strong>Hora:</strong></em></td>
          <td><?php echo $re_orden['hora']; ?></td>
          <td><em><strong>Fecha de Pago</strong></em></td>
          <td><?php echo $re_orden['fecha_pago']; ?></td>
        </tr>
        <tr>
          <td><em><strong>Serie</strong></em></td>
          <td><?php echo $re_orden['serie']; ?></td>
          <td><em><strong>Lugar de Expedicion</strong></em></td>
          <td><?php echo $re_orden['lugar']; ?></td>
        </tr>
        <tr>
          <td><em><strong>Metodo de Pago</strong></em></td>
          <td>NO APLICA</td>
          <td><em><strong>Forma de Pago</strong></em></td>
          <td>
            <?php 
              echo $re_orden['forma_pago'];
              if ($re_orden['forma_pago'] == '03') { echo "Transferencia electrónica de fondos";}
              if ($re_orden['forma_pago'] == '01') { echo "Efectivo";}
            ?>
          </td>
        </tr>
        <tr>
          <td><em><strong>Tipo de Comprobante</strong></em></td>
          <td>
            <?php 
              echo $re_orden['tipo_cfdi'];
              $tip = $re_orden['tipo_cfdi'];
              if ($tip == 'P') { echo " Complemento para recepción de pagos";}
            ?>
          </td>
          <td><em><strong>Tipo de Cambio</strong></em></td>
          <td>
            <?php 
              echo $re_orden['tipo_cambio'];
            ?>
          </td>
        </tr>
        <tr>
          <td><em><strong>Version </strong></em></td>
          <td>2.0</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><em><strong><!--RFC y Cuenta Ordenante --></strong></em></td>
          <td>
            <?php  
              $ord = $re_orden['ordenante'];
              $consulta_orde = mysqli_query($con,"SELECT * FROM `cuentas_ordenantes` where id = '$ord';");
              $re_o = mysqli_fetch_array($consulta_orde);
           //   echo $re_o['banco']." ".$re_o['cuenta'];
            ?>
          </td>
          <td><em><strong><!--RFC y Cuenta  Beneficiario --></strong></em></td>
          <td>
            <?php  
              $ben = $re_orden['beneficiario'];
              $consulta_ben = mysqli_query($con,"SELECT * FROM `cuentas_bancaras` where id = '$ben';");
              $re_b = mysqli_fetch_array($consulta_ben);
           //   echo $re_b['banco']." ".$re_b['cuenta'];
            ?>
          </td>
        </tr>
      </table><!--TERMINA TABLE2-->
      
    </div><!--card-header-->
	
	  <main class="container">
  
      <div class="card-body">
        <?php
          $consulta2 = mysqli_query($cone, "SELECT * FROM detalle_complementos where idorden = '$idorden';");
          $suma_importe;

          while($re = mysqli_fetch_array($consulta2)){

            $importe = $re['importe'];
            $suma_importe = $importe  +  $suma_importe;


           // echo $importe;

          }


        ?>

        <table width="100%" border="1"><!--INICIA TABLE BOTON AGREGAR-->
          <tr>
            <td width="14%">
              <?php
                if($re_orden['estatus'] == 'Timbrada') { 
              ?>
                <a href="cancelar_comple.php?folio_fiscal=<?php echo $re_orden['uuid']; ?>">
                  <img src="https://img.icons8.com/cotton/64/000000/cancel--v1.png"/> Cancelar Factura
                </a>
              <?php } ?>
            </td>
            <td width="17%">
              <?php
                if($re_orden['estatus'] == 'Por Emitir'){ ?>
                  <h3>
                    <a >

                    <a class="btn btn-primary" href = "#" data-toggle="modal" data-target="#modal" id="btagregar">Agregar Factura</a>
                       <!-- <img src="https://img.icons8.com/windows/32/000000/plus.png"/> -->
                    </a>
                  </h3>
              <?php } ?>
            </td>
            <td width="29%" align="center">
              <?php 
			     $mon =  $suma_importe;
				 $sub = $mon / 1.16;
				 $iv = $mon - $sub;
				 
				 /*
			  
                   echo " <h4> Subtotal: $".number_format($sub,2, '.', '')."</h4>";
				   echo " <h4> IVA: $".number_format($iv,2, '.', '')."</h4>";
				   echo " <h4> Total: $".number_format($mon,2, '.', '')."</h4>";
				   */


           $idc = $_GET['idorden'];

      
           $actualiza = mysqli_query($cone,"UPDATE `complementos` SET `total` = '$mon' WHERE `complementos`.`id` = '$idc';");



				
              ?>
            </td>
            <td width="21%" align="right">Tipo de Cambio 
            <?php 
              echo "<h4>". $re_orden['tipo_cambio']."</h4>";
            ?></td>
            <td width="19%" align="right">En USD: <?php echo "<h4> ".number_format(($re_orden['total'] / $re_orden['tipo_cambio']), 2)."<h4>" ?> </td>
          </tr>
        </table><!--TERMINA TABLE BOTON AGREGAR-->

        <table width="100%" border="1">
          <tr>
            <td width="8%"><strong><em>Cantidad</em></strong></td>
            <td width="6%"> 1</td>
            <td width="7%"><strong><em>Unidad </em></strong></td>
            <td width="10%">ACT</td>
            <td width="11%"><em><strong>Clave Insumo</strong></em></td>
            <td width="9%">84111506</td>
            <td width="19%"><strong><em>Descripcion del pago o Servicio</em></strong></td>
            <td width="6%"> Pago</td>
            <td width="6%"><strong><em>Precio Unitario</em></strong></td>
            <td width="6%">$0</td>
            <td width="6%"><strong><em>Importe</em></strong></td>
            <td width="6%"> $0</td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr>
            <td width="13%"><strong><em>Fecha de Pago</em></strong></td>
            <td width="21%"><?php echo $re_orden['fecha_pago']." 12:00:00"; ?></td>
            <td width="15%"> <em><strong>Monto</strong></em><strong></strong></td>
            <td width="51%">$<?php echo number_format($re_orden['monto'],2);  $mont = $re_orden['monto']; ?></td>
          </tr>
        </table>
        <p></p>
        <p></p>
        <p></p>

        <table id="example1" class="table table-bordered table-striped"><!--INICIA TABLE 3-->
          <thead>
            <tr>
              <th width="2%">#</th>
              <th width="110%">UUID</th>
              <th width="8%">Serie/Folio</th>
              <th width="8%">Parcialidad</th>
              <th width="15%">Saldo Anterior</th>
              <th width="15%">Importe Pago</th>
              <th width="15%">Saldo Insoluto</th>
              <th width="">Saldo del pago</th>
              <th width=""></th>
              <th width=""></th>
            </tr>
          </thead>
            <tbody>
              <?php
                //$fa = $_GET['idorden'];
                //$idorden = $_GET['idorden'];
                $consulta_detalle = mysqli_query($cone,"select * from detalle_complementos where idorden = '$idorden'");


              
                   $suma_total= 0;
				   
				    $nuevo_monto = $mont;

                while($red = mysqli_fetch_array($consulta_detalle)){    $suma_total = $suma_total + $red['saldo']; ?>
                
                  <tr>
                    <td><?php echo $red['id']; ?></td>
                    <td> 
                      <div class="div" title="<?php echo utf8_encode($red['uuid']); ?> ">
                        <?php echo utf8_encode($red['uuid']); ?> 
                      </div>
                    </td>
                    <td><?php echo utf8_encode($red['serie'])."".$red['folio']; ?> </td>
                    <td><?php echo $red['parcialidad']; ?></td>
                    <td><?php echo '$'.number_format($red['saldo'],2); ?></td>
                    <td><?php echo '$'.number_format($red['importe'],2); $nuevo_monto = $nuevo_monto - $red['importe'];  ?></td>
                    <td>$<?php echo number_format($red['saldo'] - $red['importe'],2); ?></td>
                    <td>$<?php echo number_format($nuevo_monto,2); ?></td>
                    <?php
                        if($re_orden['estatus'] == 'Por Emitir') { ?>
                        <td><a class="sub" onclick="modal_edit(<?php echo $red['id'];?>, 'UpComplemet')"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a></td>
                    <?php }  else {echo "<td></td>";}?>

                    <?php 


                    if ($re_orden['estatus'] == 'Por Emitir'){


                     ?>
                    <td><a class="not-active" onclick="modal_delete(<?php echo $red['id'];?>, '<?php echo $red['uuid'];?>')"><img src="https://img.icons8.com/metro/24/A83339/trash.png"/></a></td>
                    <?php

                      }
                     ?>
                 
                 
                  </tr>
                <?php }    
                /*

                     $idc = $_GET['idorden'];

                     echo $idc;
                
                     $actualiza = mysqli_query($cone,"UPDATE `complementos` SET `total` = '$suma_total' WHERE `complementos`.`id` = '$idc';");

                     echo $suma_total

                     */
                
                ?>
            </tbody>
            <tfoot>
              <tr>
                <th width="2%">#</th>
                <th width="110%">UUID</th>
                <th width="8%">Serie/Folio</th>
                <th width="8%">Parcialidad</th>
                <th width="15%">Saldo Anterior</th>
                <th width="15%">Importe Pago</th>
                <th>Saldo Insoluto</th>
                <th>Saldo del pago</th>
                <th width=""></th>
                <th width=""></th>
              </tr>
            </tfoot>
        </table><!--TERMINA TABLE 3-->

      </div><!--card-body--> 

    </main><!--main container--> 

    <!--INICIA MODAL NUEVO REGISTRO-->
    <div class="modal fade" id="modal">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title">Agregar Factura</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btnagregar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div><!--modal-header-->

          <div class="modal-body">
            <div class="card-body">
              <form id="form1" name="form1" action="detalle_complementos.php" method="get" >   
                
              <div class="row g-2"><!-- INICIA SECCION 1--->

                <div class="col-sm-5 col-md-12">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 col-form-label">UUID</label>
                        <div class="col-sm-12">
                          
                        
                          <select name="lbluuid" id="lbluuid" class="form-control">
                           <option value="0">SIAVCOM</option>
                            <?php
                              $consulta_u = mysqli_query($cone,"SELECT a.uuid, a.serie, a.id, b.nombre_cliente 
                              FROM invoices AS a
                              JOIN clientes as b on a.receptor = b.id_cliente
                              WHERE a.uuid <> ''");
                              while($re_u = mysqli_fetch_array($consulta_u)){
                            ?>
                            <option value="<?php  echo $re_u['uuid']?>"><?php  echo $re_u['serie']." ".$re_u['id']." ".$re_u['nombre_cliente']?></option>
                            <?php } ?>
                          </select>
                        </div>
                    </div>
                </div>

              </div><!-- TERMINA SECCION 1-->

                <!--DATOS OCULTOS-->
                <input type="hidden" name="idorden" id="idorden" value="<?php echo $idorden;  ?>" />
                <input type="hidden" name="opc" value="1" />
                <!--DATOS OCULTOS-->

                <div class="row"><!-- INICIA SECCION BOTONES GARDAR/CANCELAR-->

                  <div class="modal-footer col-md-12 text-right">
                      <button type="button" class="btn btn-secondary"  data-dismiss="modal" onclick="reset_modal()">Cancelar</button>
                      <button type="submit" name="insertar" id="btnguarda" class="btn btn-primary">Guardar</button>
                  </div>

                </div><!-- TERMINA SECCION BOTONES GARDAR/CANCELAR -->
              </form>
            </div><!--card-body-->
          </div><!--modal-body-->

        </div><!--modal-content-->
      </div><!--modal-dialog modal-xl-->
    </div><!--modal fade-->
    <!--TERMINA MODAL EDITAR REGISTRO-->


    
  <!-- INICIA MODAL EDITAR -->
  <div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modal-title">Nuevo Registro</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="reset_modal()">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
          <form id="form1" name="form1" action="detalle_complementos.php" method="get" >
            
          <div class="row g-2"><!-- INICIA SECCION 1--->

            <div class="col-sm-5 col-md-6">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Id registro</label>
                    <div class="col-sm-9">
                    <input type="text" name="idComple" id="idComple" class="form-control" readonly >
                    </div>
                </div>
            </div>

            <div class="col-sm-5 col-md-6">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">UUID</label>
                    <div class="col-sm-9">
                      <input type="text" name="lbluuid" id="txtuuid" class="form-control" >
                    </div>
                </div>
              </div>

          </div><!-- TERMINA SECCION 1-->
                  
            <div class="row g-2"><!-- INICIA SECCION 2--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Serie</label>
                      <div class="col-sm-9">
                      <input type="text" name="serieFolio" id="serieFolio" class="form-control" placeholder="SERIE" >
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Parcialidad</label>
                      <div class="col-sm-9">
                      <input type="text" name="txtparcial" id="txtparcial" class="form-control" placeholder="0" >
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 2-->

            <div class="row g-2"><!-- INICIA SECCION 3--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Saldo Anterior</label>
                      <div class="col-sm-9">
                      <input type="text" name="txtsaldAnt" id="txtsaldAnt" class="form-control" placeholder="$ 000.00" >
                      </div>
                  </div>
              </div>

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Importe Pago</label>
                      <div class="col-sm-9">
                      <input type="text" name="txtimportPgo" id="txtimportPgo" class="form-control" placeholder="$ 000.00" >
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 3-->

            <div class="row g-2"><!-- INICIA SECCION 4--->

              <div class="col-sm-5 col-md-6">
                  <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 col-form-label">Folio</label>
                      <div class="col-sm-9">
                      <input type="text" name="txtfolio" id="folio-input" class="form-control" placeholder="Ejemplo 9999" >
                      </div>
                  </div>
              </div>

            </div><!-- TERMINA SECCION 4-->

            <!--DATOS OCULTOS-->
            <input type="hidden" name="opc" id="hiddenField" value="1" />
            <input type="hidden" name="idorden" id="idorden" value="<?php echo $idorden;  ?>" />
            <!--DATOS OCULTOS-->

            <div class="row"><!-- INICIA SECCION BOTONES GARDAR/CANCELAR-->

              <div class="modal-footer col-md-12 text-right">
                  <button type="button" class="btn btn-secondary"  data-dismiss="modal" onclick="reset_modal()">Cancelar</button>
                  <button type="submit" name="insertar" id="btnguarda" class="btn btn-primary">Guardar</button>
              </div>

            </div><!-- TERMINA SECCION BOTONES GARDAR/CANCELAR -->
          </form>
        </div>
          
          <!--div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Actualizar</button>
          </div-->

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div> <!-- /.modal fade -->
  <!-- TERMINA MODAL NUEVO REGISTRO/EDITAR -->

  <!-- MODAL DE BORRADO -->
  <div class="modal fade" id="modal-borrar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Baja de Registro</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <form   id="form2" name="form2" action="detalle_complementos.php" method="get" >
            <p id="borrar_codigo">id</p>
            <p id="borrar_desc">factura</p>
            <!--DATOS OCULTOS-->
            <input type="hidden" name="opc"  value="2"/>
            <input type="hidden" name="txtid" id="txtid"  value=""/>
            <input type="hidden" name="txtfactura" id="txtfact" value =""/>
            <input type="hidden" name="idorden" id="idorden" value="<?php echo $idorden;  ?>" />
            <!--DATOS OCULTOS-->
        </div>
        
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" onclick="">Cerrar</button>
          <button type="submit" class="btn btn-primary">Confirmar Baja</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal BORRADO-->

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
  <!--SCRIPT PARA MODALS-->
  <script src="dist/js/modals.js"></script>
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
