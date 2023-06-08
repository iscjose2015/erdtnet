<?php

	session_start();

  include("conecta_facturacion.php");

  $usuario =  $_SESSION['user_id'];

  //echo $usuario;



  $consulta_acceso = mysqli_query($cone,"SELECT * FROM `permisos` where idempleado = '$usuario'");
  $re_consulta = mysqli_fetch_array($consulta_acceso);
  //echo "aqui".$re_consulta['empresas'];
  if($re_consulta[empresas] == '0' ) {   header("location: denegado.php");  }





	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Clientes ";
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
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


   


    <div class="card-header">
                <h3></h3>
              </div>
	
	<main class="container">
  
  
  <div class="card-body">

  <?php

  // http://localhost/curso_cfdi/php/cfdi_cancelar.php
error_reporting(E_ALL); ini_set('display_errors', '0');

// SAT: Esquema de cancelaciones: http://omawww.sat.gob.mx/factura/Paginas/cancela_procesocancelacion.htm

// PAC:
$pacurl = "https://timbracfdi33.mx:1443/Timbrado.asmx?wsdl";
$pacusu = "Jjtm6Lfes+mmNO/ic5P3DQ==";

// Info del CFDI: 



$rfcEmisor = $_SESSION[seleccionada];


$uuid = $_GET[folio_fiscal];

$consulta_emisor = mysqli_query($con,"SELECT emisor,b.empresa, b.rfc FROM `complementos` a 
INNER JOIN empresas b ON a.emisor = b.id where uuid = '$uuid';");

$re_emi = mysqli_fetch_array($consulta_emisor);

echo "RFC". $re_emi[rfc];

echo "<h3 align='center'> CFDI 4.0 Cancelar SAT </h3>";
echo "<p align='center'> Emisor: $rfcEmisor  UUID: $uuid </p>";

$response = "";
try{
	$params = [
		"usuarioIntegrador" => $pacusu,
		"rfcEmisor" => $re_emi[rfc],
		"folioUUID" => $uuid,
    "motivoCancelacion" => "03"
	];
	$context = stream_context_create(
		array(
			'ssl' => array(
				// set some SSL/TLS specific options
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true  //--> solamente true en ambiente de pruebas
			),
			'http' => array(
				'user_agent' => 'PHPSoapClient'
			)
		) 
	);
	$options =array();
	$options['stream_context'] = $context;
	$options['trace']= true;	
	$client = new SoapClient($pacurl,$options);
	$response = $client->__soapCall('CancelaCFDI40', array('parameters' => $params));
}catch (SoapFault $fault){
	echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
	exit;
}
echo "<br> Respuesta: <pre>"; print_r( $response ); echo "</pre><hr>";

$respuesta = $response->CancelaCFDIResult->anyType[7];

echo $respuesta;



if($respuesta == 'UUID Previamente cancelado.')
{

echo "<p align='center'>Resultado de la cancelacion: ".$respuesta."</p>";

echo '<p align="center"><img src="https://img.icons8.com/doodle/48/000000/delete-sign.png"/></p>';

}
else{

    $respuesta = $response->CancelaCFDIResult->anyType[2];


    if($respuesta == 'El comprobante será cancelado')
        {

            echo "<p align='center'>Resultado de la cancelacion: ".$respuesta."</p>";

            echo '<p align="center"><img src="https://img.icons8.com/ios/50/000000/cancel-subscription.png"/></p>';


            include("conecta_facturacion.php");
            $actualiza = mysqli_query($cone,"update invoices set estatus = 'Cancelada' where uuid = '$uuid';");


        }


}

exit;	



//$cadenaOriginal = $response->TimbraCFDIResult->anyType[5];





 

?>


                 
  

  </div>
</div>





  

  
</main>





<div class="modal fade" id="modal-xl">
<div class="modal-dialog modal-xl">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title">Nuevo Empresa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
<div class="modal-body">
<div class="card-body">
<form   id="form1" name="form1" action="base.php" method="get" >                 
<div class="row">




<div class="col-6">
Empresa
  <input type="text" class="form-control" id="txtempresa" placeholder="Empresa" name="txtempresa" required  >
	
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
	include("footer.php");
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
