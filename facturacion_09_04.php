<?php

	session_start();

  include("conecta_facturacion.php");
  date_default_timezone_set('America/Mexico_City');


  if ($_GET[f] == 'ant'){

    $_SESSION[tipo] = 'anticipo';

  }


  if ($_GET[f] == 'n'){

    $_SESSION[tipo] = '';


  }

  

	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }




        $usuario =  $_SESSION['user_id'];

        //echo $usuario;
      
        $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
        $re_consulta = mysqli_fetch_array($consulta_acceso);
        //echo "aqui".$re_consulta['empresas'];
        if($re_consulta[facturas] == '0' ) {   header("location: denegado.php");  }
      

        if($_GET[opc] == 1){

     
            $fech = $_GET['txtfecha'];
            $emi = $_GET[lblproveedores];
            $met = $_GET[lblmetodo];
            $us =  $_GET[lbluso];
            $for =  $_GET[lblforma];
            $tip =  $_GET[lbltipo];
            $emisor =   $_SESSION['emisor'];
            $hor = $_GET[txthora];
            $ser = $_GET[lblserie];
            $mon = $_GET[lblmoneda];
            $lug = $_GET[txtlugar];
            $ped = $_GET[txtpedimento];
			      $rel = $_GET[lblrelacionado];
			      $tipor = $_GET[lbltipor];


            
            $sel = $_SESSION['seleccionada'];

          //  echo "Aqui la seleccionada".$sel;
          
            $consulta_emisor = mysqli_query($cone,"SELECT * FROM `empresas` where nombre = '$sel';");
            $re_sel = mysqli_fetch_array($consulta_emisor);

            $emisor = $re_sel[id];
            
           // echo "Emisor".$emisor;

            $inserta = mysqli_query($cone,"INSERT INTO `invoices` (`id`, `fecha_emision`, `csd`, `receptor`, `forma_pago`, `metodo_pago`, 
            `uso`, `estatus`, `tipo_cfdi`, `folio`, `serie`, `hora`, `emisor`, `moneda`, `lugar`, `total`, `pedimento`, `relacionado`, `tiporelacionado`) 
            VALUES (NULL, '$fech', '', '$emi', '$for', '$met', '$us', 'Por Emitir', '$tip', '', '$ser', '$hor','$emisor','$mon','$lug','0','$ped','$rel','$tipor');");
			
			
			
			


            header("location: facturacion.php");

        


        }


        include("funciones_factura.php");


	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	

	$title="Facturacion";
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



<section class="content-header">
      
    </section>


    <div class="card-header">


             
    
                <table width="100%" border="0">
  <tr>
    <td width="24%" align="right">


    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>&nbsp;</h1>
            <p>&nbsp; </p>
            <p>&nbsp;</p>

          </div>
        </div>
      </div><!-- /.container-fluid -->

    </td>
    <td width="76%" valign="top"><p><strong><em><h1>

         <?php

         if ($_GET[f] == 'ant') { echo "Factura de Anticipo"; } else { echo "Facturacion"; }


        ?>

         <?php


           $sel = $_SESSION[seleccionada];

          $consulta_empresa = mysqli_query($con,"select * from empresas where nombre = '$sel'");
          $re_empre = mysqli_fetch_array($consulta_empresa);

          $imagen_empresa = $re_empre[logotipo];

          ?>


            <img src="<?php echo $imagen_empresa; ?>" width="122" height="55" /></h1>

    </em></strong>
      <p>Empresa activa:<?php echo $_SESSION[seleccionada]; ?></p>  
      <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>   <h3 class="card-title">Nueva Factura <?php echo $_SESSION[tipo];?><a href = "#" data-toggle="modal" data-target="#modal-xl"><img src="https://img.icons8.com/windows/32/000000/plus.png" alt=""/></a></h3></td>
  </tr>
</table>
    
    
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <table width="977"  class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="169">Fecha Emision</th>
                    <th width="95">Serie y Folio</th>
                    <th width="138">RFC EMISOR</th>
                    <th width="180">RFC RECEPTOR</th>
                    <th width="62">Receptor</th>
                    <th width="84">Total </th>
                    <th width="117">Tipo de CFDI</th>
                    <th width="17"></th>
                    <th width="75"></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php




                    $consulta = mysqli_query($cone, "SELECT * FROM `invoices` where estatus = 'Por Emitir' order by id desc");


                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                     // https://elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/factura_pdf.php?cve=T_1013

                    ?>
                  
  

                  <tr>
                    <td align="center"><?php 
                    
                    
                    
                    $originalDate =  $re['fecha_emision'];
                    $newDate = date("d-m-Y", strtotime($originalDate));

                    echo $newDate;
                    
                    
                    
                    
                    
                    
                    ?></td>
                    <td>  
					  <a href="detalle_invoices.php?idorden=<?php echo $re[id]; ?>&serie=<?php echo $re[id]; ?>"><?php echo utf8_encode($re['serie'])." ".$re['id']; ?> </a>
					</td>

                    <td><?php 
                    
                    $rece = $re['emisor'];

                    
                    $consulta_emisor = mysqli_query($cone,"select * from empresas where id = '$rece' ");
                    $re_emisor = mysqli_fetch_array($consulta_emisor);
                    echo  $re_emisor['empresa'];

                  
                    
                    ?> </td>
                    <td><?php 
                    
                    $rece = $re['receptor'];

                    $consulta_receptor = mysqli_query($cone,"select * from clientes where id_cliente = '$rece'  ");
                    $re_receptor = mysqli_fetch_array($consulta_receptor);
                     echo  $re_receptor['rfc'];

                  
                    
                    ?> </td>
                    <td> <?php

    

 
                    echo utf8_encode($re_receptor['nombre_cliente']);

                    ?>

                  
                  
                  
                  </td>
                    <td><?php  
                    
                    
                    $tot_fac = saber_total_factura($re[id]) * 1.16; 

                    echo '$'.number_format($tot_fac,2)
                    
                    
                    ?> </td>
                    <td> <?php  
                    
                    $tipo = $re[tipo_cfdi]; 


                    if ($tipo == 'I' ) { echo "Ingreso"; }
                    if ($tipo == 'E' ) { echo "Egreso"; }
                    
                    
                    
                    ?>

                  </a></td>
                    <td><?php
                    
                    
                    if ( utf8_encode($re['estatus'] == 'Timbrada')) { 


                  echo '<img src="https://img.icons8.com/color/48/000000/checked--v1.png"/>';

                    } 


                        
                    if ( utf8_encode($re['estatus'] == 'Cancelada')) { 


                      echo '<img src="https://img.icons8.com/color/48/000000/cancel--v1.png"/>';
    
                        }
                    
                    
                    
                    
                    ?></td>
                    <td><a href="detalle_invoices.php?idorden=<?php echo $re[id]; ?>&serie=<?php echo $re[id]; ?>"> <img src="https://img.icons8.com/ios/50/000000/paid-bill.png"/>Detalle </a></td>
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
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="base.php" method="get" >

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


                      </div>
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
                        <h4 class="modal-title">Baja de Empresa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="empresas.php" method="get" >

                   
                   <p><?php echo "Codigo: ".$re[id]; ?></p>
                   <p><?php echo "Descripcion: ".$re[empresa]; ?></p>
                   

                  <input name="opc" type="hidden" value="2" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />


                      </div>
                      <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Confirmar Baja</button>
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
                    
                  
                  
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th width="169">Fecha Emision</th>
                    <th width="95">Serie y Folio</th>
                    <th width="138">RFC EMISOR</th>
                    <th width="180">RFC RECEPTOR</th>
                    <th width="62">Receptor</th>
                    <th width="84">Total </th>
                    <th width="117">Tipo de CFDI</th>
                    <th width="17"></th>
                    <th width="75"></th>
                  </tr>
                  </tfoot>
                </table>




                 
  

  </div>
</div>

</main>


<!-- Agregar  -->


<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Factura</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="facturacion.php" method="get" >                 
<div class="row">

<div class="col-6">


<?php
$consulta_proveedor = mysqli_query($cone,"SELECT * FROM `clientes` where activo = 1 order by 2");

?>

Lista de Clientes
  <label for="lblproveedores"></label>
  <select name="lblproveedores" id="lblproveedores" class="form-control" required="required">

  <option value=""></option>


  <?php


while($re_pro = mysqli_fetch_array($consulta_proveedor)){
 

  


  ?>
  <option value="<?php  echo $re_pro[id_cliente];?>"><?php  echo utf8_encode($re_pro[nombre_cliente]);?></option>

  <?php
}

?>
  </select>

  </div>


<div class="col-6">
Fecha de Emision
  <input type="date" class="form-control" id="txtfecha" placeholder="Fecha" name="txtfecha" value="<?php echo date("Y-m-d"); ?>" required readonly >
	
</div>

<div class="col-2">
  Serie
<label for="lblserie"></label>
  <select name="lblserie" id="lblserie" class="form-control" required="required">
  <option value="F">F</option>
  <option value="T">T</option>
  <option value="A">A</option>
  <option value="P">P</option>
  <option value="T">T</option>
  </select>
</div>

<div class="col-2">
Hora
  <input type="text" class="form-control" id="txthora" placeholder="hora" name="txthora" value = "<?php 
  
  /*
  $tiempo = date('m/d/Y h:i:s a', time()); 
  $cadena = explode(" ",$tiempo);
  echo $cadena[1];
  */

  echo date('H:i:s');
  
  
  
  ?>"  readonly="readonly" required  >
	
</div>

<div class="col-2">
  Metodo de Pago
<label for="lblserie"></label>
  <select name="lblmetodo" id="lblmetodo" class="form-control" required="required" >
    
  <  <option value="PPD">PPD - PAGO EN PARCIALIDADES O DIFERIDO</option>

  <option value="PUE">PUE - PAGO EN UNA SOLA EXHIBICION</option>
  <option value="PPD">PPD - PAGO EN PARCIALIDADES O DIFERIDO</option>
  </select>
</div>


<div class="col-2">
Tipo Comprobante
<label for="lblserie"></label>
  <select name="lbltipo" id="lbltipo" class="form-control" required="required">
  <option value="I">I - Ingreso</option>
  <option value="E">E - Egreso</option>
  </select>
</div>

<div class="col-2">
 Moneda
<label for="lblserie"></label>
  <select name="lblmoneda" id="lblmoneda" class="form-control">

  <option value="MXN">MNX Peso Mexicano</option>
  </select>
</div>




<?php

if ($_GET[f] == 'ant') {  
?>


<div class="col-2">
Forma de Pago
<label for="lblforma"></label>
  <select name="lblforma" id="lblforma" class="form-control" required="required">
  <option value="03">03 Transferencia electrónica de fondos</option>
  <option value="99">99 Por Definir</option>
  </select>
</div>


<?php
} else { 

?>
  
 
  
<div class="col-2">
Forma de Pago
<label for="lblforma"></label>
  <select name="lblforma" id="lblforma" class="form-control" required="required">
  <option value="99">99 Por Definir</option>
  <option value="01">01 Efectivo</option>
  <option value="02">02 Cheque nominativo</option>
  <option value="03">03 Transferencia electrónica de fondos</option>
  <option value="30">30 Aplicacion de Anticipos</option>
  <option value="99">99 Por Definir</option>
  </select>
</div>



<?php
}


?>






<div class="col-6">
  Uso del CFDI
<label for="lblserie"></label>
  <select name="lbluso" id="lbluso" class="form-control" required="required" >
  <option value="G01">G01 Adquisición de mercancías</option>
  <option value="G01">G01 Adquisición de mercancías</option>
  <option value="G02">G02 Devoluciones, descuentos o bonificaciones</option>
  <option value="G03">G03 Gastos en general</option>
  <option value="P01">P01 Por Definir</option>
  <option value="S01">S01 Sin efectos fiscales</option>
  <option value="CP01">CP01 Pagos</option>
  </select>
</div>


<div class="col-2">
Lugar Expedicion
<label for="lblserie"></label>
<input type="text" class="form-control" id="txtlugar" placeholder="CP" name="txtlugar"  value="44490" required  >
</div>



<div class="col-2">
Pedimento
<label for="lblpedimento"></label>
<input type="text" class="form-control" id="txtpedimento" placeholder="Pedimento" name="txtpedimento"  value=""  >
</div>


<div class="row">
<div class="col-4">
Facturar a Relacionar
<select name="lblrelacionado" id="lblprueba" class="form-control">

<option value=""></option>
  <?php
  
  
  $consulta_uuid = mysqli_query($cone,"SELECT id, uuid, serie FROM `invoices` where uuid <> '' order by 1");
  
  while($re = mysqli_fetch_array($consulta_uuid)){
  
  ?>
  <option value="<?php  echo $re[uuid]?>"><?php  echo $re[serie]. " ",$re[id]?></option>
  <?php
  
  }
  
  ?>
  
  
</select>
</div>

<div class="col-6">
Tipo Relacion
<select name="lbltipor" id="lblprueba" class="form-control">
<option value=""></option>
  <option value="01">01 Nota de crédito de los documentos
relacionados
</option>
  <option value="02">02 Nota de débito de los documentos
relacionados
</option>
  <option value="03">03 Devolución de mercancía sobre facturas o
traslados previos
</option>
  <option value="04">04 Sustitución de los CFDI previos
</option>
</option>
  <option value="07">07 CFDI por aplicación de Anticipo
</option>
</select>
</div>

</div>

<!--

  <div class="col-6">
  Correo <input type="text" class="form-control" id="txtcorreo" placeholder="Correo" name="txtcorreo" required  >
</div>

                  -->
  
<div class="col-sm-12 ">
  <!-- este es un espacio -->  
  </div>
               
        <p></p>         
             
	
               
	<div class="col-sm-3 "> 
    	<input type="hidden" name="opc" id="hiddenField" value="1" />
   </div>
   
   <div class="col-sm-12 ">
  <!-- este es un espacio -->  
  </div>
            

    <div class="col-sm-2 ">
              <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cerrar</button>
    </div>
    <div class="col-sm-8 ">
              
    </div>
    <div class="col-sm-2 ">
              <button type="submit" class="btn btn-primary btn-block">Guardar</button>
    </div>


     <!-- <a href="deposito.php" name="Submit" onclick="javascript:window.print()">
                        <button class="btn btn-success"> Imprimir </button>
                      </a> -->

</div>
</form>
</div>
</div>
</div>
</div>
</div>

    
	
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
