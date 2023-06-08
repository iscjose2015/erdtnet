<?php

	session_start();

  include("conecta_facturacion.php");
  date_default_timezone_set('America/Mexico_City');

  
        if($_GET[opc] == 1){

            $cant = $_GET[txtcantidad];


  

      

        }


        if($_GET[opc] == 2){
			
			
			    $ref = $_GET['txtreferencia'];
          $id = $_GET['idorden'];
		      $id_pro = $_GET['lblproveedores'];
			  $ke = $_GET['txtorden'];

            $actualiza = mysqli_query($cone,"UPDATE `ordenes` SET `referencia` = '$ref' WHERE `ordenes`.`id` = '$id';");
		        $actualiza = mysqli_query($cone,"UPDATE `ordenes` SET `id_proveedor` = '$id_pro' WHERE `ordenes`.`id` = '$id';");
            $actualiza = mysqli_query($cone," UPDATE `detalle_ordenes`set referencia = '$ref' wHERE `idorden` = '$id';");
			  $actualiza = mysqli_query($cone," UPDATE `ordenes`set no_orden_kepler = '$ke' wHERE `id` = '$id';");

          header("location: detalle_orden.php?idorden=".$id);

        }



        if($_GET[opc] == 3){
			
            $cod = $_GET[txtid];

            $inserta = mysqli_query($cone,"DELETE FROM detalle_ordenes WHERE `detalle_ordenes`.`id` = '$cod'");

                  //  header("location: detalle_orden.php?idorden=".$cod);

		}



        if($_GET[opc] == 5){
			
            $cod = $_GET[idorden];
            echo $cod;
			

            $inserta = mysqli_query($cone,"DELETE  FROM `detalle_ordenes` WHERE `idorden` = '$cod'");
            header("location: detalle_orden.php?idorden=".$cod);

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
      .chica{
		  font-size:10px;  
	  }  </style>



<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Detalle de Orden de Compra</h1>
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




$clave = $_GET['idorden'];

$consulta_orden= mysqli_query($cone,"SELECT a.id,a.id_proveedor,a.referencia, b.proveedor, b.calle, b.colonia, b.estado, a.fecha, a.fecha_entrega, a.no_orden_kepler, a.documento FROM `ordenes` a 
INNER JOIN proveedores b ON a.id_proveedor = b.id where a.id = '$clave'");

$re_orden = mysqli_fetch_array($consulta_orden);

$consulta = mysqli_query($cone, "SELECT * FROM `detalle_ordenes` where idorden = '$clave';");


    ?>


    <div class="card-header">
      <form name="form3" method="get" action="detalle_orden.php">
      <table width="100%" border="1">
    <tr>
      <td width="15%">Proveedor</td>
      <td width="30%">
        
        
<?php
$consulta_proveedor = mysqli_query($cone,"SELECT * FROM `proveedores` order by 2");

?>
<label for="lblproveedores"></label>
  <select name="lblproveedores" id="lblproveedores" class="form-control">
  
 
 
 
   <option value="<?php  echo $re_orden[id_proveedor];?>"><?php  echo $re_orden[proveedor];?></option>


  <?php


while($re_pro = mysqli_fetch_array($consulta_proveedor)){


  ?>
  <option value="<?php  echo $re_pro[id];?>"><?php  echo $re_pro[proveedor];?></option>

  <?php
}

?>
  </select>

	        
        </td>
      <td width="18%">Referencia </td>
      <td width="37%"><label for="txtreferencia"></label>
        <input type="text" name="txtreferencia" id="txtreferencia" value="<?php echo $re_orden[referencia]; ?>"></td>
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
    <tr>
      <td>&nbsp;</td>
      <td><a href="check.php?idorden=<?php echo $_GET[idorden]; ?>">Ver Match</a></td>
      <td>Ultimo Excel Cargado</td>
      <td><a href="phpexcel/<?php echo $re_orden[documento]; ?>"><?php echo $re_orden[documento]; ?></a></td>
    </tr>
      </table>
  <p>&nbsp;    </p>
  
    <p>Orden De Compra en Kepler: 
    <label for="txtorden"></label>
    <input type="text" name="txtorden" id="txtorden" value="<?php echo $re_orden['no_orden_kepler']; ?> "
  </p>
  
  
  <p>
    <input type="submit" name="txtactualizar" id="txtactualizar" value="Actualizar datos">
    <input type="hidden" name="opc" id="opc"  value="2">
    <input type="hidden" name="idorden" id="idorden" value="<?php echo $_GET[idorden]; ?>">
  </p>

   
   
   <?php if ($_SESSION['user_name'] == 'admin' or $_SESSION['user_name'] == 'luz' or $_SESSION['user_name'] == 'martha'  ){ ?>
  <p><a href="detalle_orden.php?idorden=<?php echo $_GET['idorden'];?>&opc=5"> <img src="https://img.icons8.com/color/48/null/delete-forever.png"/>Borrar Detalle de Orden</a></p>
  <p>&nbsp;</p>
  <?php
  
   }
  ?>
  
  
  
      </form>
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
                    <th>Cantidad Inicial</th>
                    <th>Unidad</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Precio x Millar</th>
                    <th>Precio Unitario</th>
                    <th>Importe / 1000</th>
                
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php





                  

                   //echo "total:".mysqli_num_rows($consulta);


                   $suma = 0;

                    while($re = mysqli_fetch_array($consulta)){

                    ?>
                  
                  <tr>
                    <td><?php echo number_format($re['inicial'],2); ?></td>
                    <td><?php echo utf8_encode($re['unidad']); ?> </td>
                    <td><?php echo utf8_encode($re['c_producto']); ?> </td>
                    <td><?php echo utf8_encode($re['descripcion']); ?> </td>
                    <td>$<?php echo number_format(utf8_encode($re['monto']),2); ?></td>
                    <td>$<?php echo number_format(utf8_encode($re['monto']) / 1000,2); ?></td>
                    <td>$<?php  $impo = ($re['monto'] / 1000) * $re['inicial'];   echo number_format($impo,2);
                     $suma  = $suma + $impo;  //echo "eso es la suma".$suma; ?>
                    </td>

                    <!-- <a href="#" data-toggle="modal" data-target="#modal-edit_<?php //echo $re['id']; ?>" class="sub"><img src="https://img.icons8.com/material-sharp/24/A83339/pencil--v2.png"/></a> -->

                    <td><a href="#" data-toggle="modal" data-target="#modal-borrar_<?php echo $re['id']; ?>"><img src="https://img.icons8.com/metro/24/A83339/trash.png"/></a></td>
                   
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
                        <h4 class="modal-title">Borrar Producto</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                    
         


                  <form   id="form2" name="form2" action="detalle_orden.php" method="get" >

                   
                   <p><?php echo "Clave: ".$re[id]; ?></p>
                   <p><?php echo "Descripcion: ".$re[descripcion]; ?></p>
                   

                  <input name="opc" type="hidden" value="3" />
                  <input name="txtid" type="hidden" value="<?php echo $re[id]; ?>" />
                  <input name="idorden" type="hidden" value="<?php echo $_GET[idorden]; ?>" />


                      </div>
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
                    
                  
                  
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th>Cantidad</th>
                    <th>Unidad</th>
                    <th>Clave</th>
                    <th>Descripcion</th>
                    <th>Precio por Millar</th>
                    <th>Precio Unitario</th>
                    <th></th>
                    <th>Importe</th>
                    <th></th>
                  </tr>
                  </tfoot>
                </table>


                      <?php  echo "Suma de Importes: ".number_format($suma,2);
                      

                      $sum = number_format($suma,2);
                      
                      $actualiza = mysqli_query($cone,"UPDATE `ordenes` SET `total` = '$sum' WHERE `ordenes`.`id` = '$clave';")
                      
                      
                      ?>

                 
  

  </div>
</div>





  

  
</main>





<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Agregar Producto</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="detalle_orden.php" method="get" >                 
<div class="row">




<div class="col-6">
Cantidad
  <input type="text" class="form-control" id="txtcantidad" placeholder="Cantidad" name="txtcantidad" required  >
	
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

   <div class="col-sm-3 "> 
    	<input type="hidden" name="idorden" id="hiddenField" value="<?php echo $clave;  ?>" />
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
