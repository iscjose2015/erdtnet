

<?php

	session_start();

  include("conecta_facturacion.php");
  include("funciones_factura.php");
  date_default_timezone_set('America/Mexico_City');

  

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
            $prov = $_GET[lblproveedores];
            $n_fact = $_GET['txtno_factura'];
            $ref = $_GET['txtreferencia'];
            $mon = $_GET['txtmonto'];
      

           $consulta_existe = mysqli_query($cone,"select * from facturas_prov  where numero_factura = '$n_fact'");
           $existe = mysqli_num_rows($consulta_existe);


            if ($existe == 0){

              $hoy = date("Y-m-d");

            $inserta = mysqli_query($cone,"INSERT INTO `facturas_prov` (`id_factura`, `numero_factura`, `fecha_factura`, `id_provee`, `total_venta`, `estado_factura`, `referencia`) 
            VALUES (NULL, '$n_fact', '$hoy', '$prov', '$mon', '1', '$ref');");

            }
            else{


              echo "** ESTA FACTURA YA EXISTE **";
            }

           // header("location: registra_factura.php");

        


        }


        
        if($_GET[opc] == 3){

     
            echo "Entro aqui";

            $idf = $_GET[cve];

            $inserta = mysqli_query($cone,"delete from detalle_fact_provee where idfactura = '$idf'");



           echo '<script>alert("Se ha  borrado el folio: '.$idf.'")</script>;';

            ?>



         <?php
 

           ?>

       

          <?php
          //  header("location: registra_factura.php");

        


        }


  


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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.26.10/dist/sweetalert2.all.min.js"></script>


  
  <style>
      .chica{
		  font-size:12px;  
	  }  </style>



<script>
$(document).ready(function(){
  $("borra").click(function(){
    $(this).hide();


    Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'El correo ha sido enviado con exito',
            showConfirmButton: false,
            timer: 1500
        })



  });

});
</script>


<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Facturas Salda</h1>
            <p>Empresa activa: <?php echo $_SESSION[seleccionada]; ?></p>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#"></a></li>
              <li class="breadcrumb-item active"></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>








    <div class="card-header">
                <h3 class="card-title"></h3>
              

                
              
              
              
              </div>
	
	<main class="container">
  
  
  <div class="card-body">


  <table id="example1" class="table table-bordered table-striped chica">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Numero Factura</th>
                    <th>Fecha Factura</th>
                    <th>Proveedor</th>
        
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                 
        
                  </tr>
                  </thead>
                  <tbody>

                    <?php



                      $consulta_sal = mysqli_query($cone,"SELECT * FROM `facturas_prov` WHERE `numero_factura` LIKE '%SALD%'");
                      while($re_sal = mysqli_fetch_array($consulta_sal)){

                       $ids = $re_sal[id_factura];
                       // echo $re_sal[numero_factura];

                         $actualiza = mysqli_query($cone,"UPDATE `facturas_prov` SET `id_provee` = '140' WHERE `facturas_prov`.`id_factura` = '$ids';");

                      }




                    $consulta = mysqli_query($cone, "SELECT * FROM `facturas_prov` a INNER JOIN proveedores b ON a.id_provee = b.id WHERE `numero_factura` LIKE '%SALD%' order by id_factura desc");


                   //echo "total:".mysqli_num_rows($consulta);

                    while($re = mysqli_fetch_array($consulta)){

                     // https://elreydeltornillo.com/sit/facturacion/timbrado/files/cfdi/factura_pdf.php?cve=T_1013

                    ?>
                  
  

                  <tr class="chica">
                    <td><?php echo $re['id_factura']; ?></td>
                    <td><?php echo $re['numero_factura']; ?></td>
                    <td><?php echo $re['fecha_factura']; ?></td>
                    <td><?php 
                    
                      echo $re['proveedor']; ?>
                    
                   </td>
            
        
             
                 
                    <td><a href="detalle_fact_reg.php?idorden=<?php echo $re[id_factura]; ?>&serie=<?php echo $re[id]; ?>">Ver Detalle </a></td>
                    <td>
                    <?php   if($_SESSION['user_name'] == 'admin' or $_SESSION['user_name'] == 'luz' ) { ?>  
                    </td>
                    <td></td>
                     <?php } ?>
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
                  <th>Id</th>
                  <th>Numero Factura</th>
                    <th>Fecha Factura</th>
                    <th>Proveedor</th>
                  
                               <th></th>
                    <th></th>
                    <th></th>
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
<form   id="form1" name="form1" action="registra_factura.php" method="get" >                 
<div class="row">

<div class="col-6">


<?php
$consulta_proveedor = mysqli_query($cone,"SELECT * FROM `proveedores` order by 2");

?>

Lista de Proveedores
  <label for="lblproveedores"></label>
  <select name="lblproveedores" id="lblproveedores" class="form-control" required="required">

  <option value=""></option>


  <?php


while($re_pro = mysqli_fetch_array($consulta_proveedor)){
 

  


  ?>
  <option value="<?php  echo $re_pro[id];?>"><?php  echo utf8_encode($re_pro[proveedor]);?></option>

  <?php
}

?>
  </select>

  </div>


<div class="col-6">
Fecha de Factura
  <input type="date" class="form-control" id="txtfecha" placeholder="Fecha" name="txtfecha" required value="<?php  echo date("Y-m-d");?>" readonly  >
	
</div>


<div class="col-6">
 No Factura
<label for="lblserie"></label>
<input type="text" name="txtno_factura" id="txtno_factura" class="form-control" />
  
  </select>
</div>

<div class="col-6">

  
  </select>
</div>
<div class="col-6">
 Total de Factura
<label for="lblserie"></label>

<input name="txtmonto" type="text" class="form-control" id="txtmonto" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
  
  </select>
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
      "pageLength": 100,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
      "pageLength": 100,

    });
  });
</script>

</html>
