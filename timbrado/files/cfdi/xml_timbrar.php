<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<?php
// http://localhost/curso_cfdi/php/xml_timbrar.php
error_reporting(0); ini_set('display_errors', '1');

echo "<h2></h2>";

// Archivo XML sin timbrar:

$archi_xml = $_GET[xml];

$xml_archivo = "../files/xml/".$archi_xml;
$ruta_cfdi = "../files/cfdi/";



// Crear la carpeta donde se almacenan los XML timbrados:
if( !file_exists( $ruta_cfdi ) ){
	if( !mkdir( $ruta_cfdi, 0777, true ) ){ 
		die('<br>Error al crear: '. $ruta_cfdi );
	}else{ 
		// echo "<br>Se crea la carpeta: $ruta_cfdi";			
	}	
}
// Archivo timbrado:

$cad = explode(".",$archi_xml);

$xml_archivo2 = $ruta_cfdi.$cad[0]."_timbrado.xml";

// PAC: Escenario de pruebas 
$pacnomcor = "PRUEBAS";
$pacurl = "https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl";
$pacusu = "mvpNUXmQfK8=";
//echo "<p> PAC Nombre: $pacnomcor </p>";
//echo "<p> PAC URL: $pacurl </p>";
//echo "<p> PAC Usuario: $pacusu </p>";

// Contenido del XML encriptado:
$texto = file_get_contents( $xml_archivo );
//echo "<p> <textarea style='width:98%;height:150px;'>".$texto."</textarea></p>";
$base64Comprobante = base64_encode($texto);
//echo "<p> <textarea style='width:98%;height:150px;'>".$base64Comprobante."</textarea></p>";
//exit;

// Webservice:
$response = '';
try {
	$params = array();
	$params['xmlComprobanteBase64'] = $base64Comprobante;
	$params['usuarioIntegrador'] = 'mvpNUXmQfK8=';
	$params['idComprobante'] = rand(5, 999999);
	$context = stream_context_create(array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		),
		'http' => array(
			'user_agent' => 'PHPSoapClient'
		)
	));
	$options = array();
	$options['stream_context'] = $context;
	$options['cache_wsdl'] = WSDL_CACHE_MEMORY;
	$options['trace'] = true;
	libxml_disable_entity_loader(false);
	$client = new \SoapClient($pacurl, $options);
	$response = $client->__soapCall('TimbraCFDI', array('parameters' => $params));
}catch (SoapFault $fault) {
	// var_dump($response);exit;
	// echo "<br> <pre>"; print_r( $response ); echo "</pre>"; exit;
	// echo "<br> <pre>"; print_r( $fault ); echo "</pre>"; exit;
	echo "<p>Error: " . $fault->faultcode . "-" . $fault->faultstring . " </p>";exit;
	exit;
}
if ($response->TimbraCFDIResult->anyType[4] == NULL) {
	// var_dump($response);exit;
	// echo "<br> TimbraCFDIResult: <pre>"; print_r( $response ); echo "</pre>"; // exit;
	// echo "<script>fn_sistemax_mensaje(0, 'Error: " . $response->TimbraCFDIResult->anyType[2] . "',2);</script>";exit;


	echo '<table width="100%" border="0">
	<tr>
	  <td align="center"><img src="error.jpg" alt="" width="267" height="177" /></td>
	</tr>
  </table>';

	echo "
		<p align='center' class='etiqueta2c'> ERROR: </p>
		<p align='center' class='campo_requerido'>".trim( $response->TimbraCFDIResult->anyType[2] )."</p>
	";
	echo "
		<br>
		<p align='center'>
			<a href='".$xml_archivo."' target='_blank' class='enlace1' style='color:blue;'> XML enviado </a>
		</p>
	";

//	Resultado del Timbrado
//	echo "<br><div align='left'> TimbraCFDIResult: <pre>"; print_r( $response ); echo "</pre></div>"; // exit;
}
//echo "<hr><br> <pre>"; print_r( $response ); echo "</pre><hr>"; // exit;
// Obtenemos resultado del response
// echo "resultado"; //echo $response;
$tipoExcepcion = $response->TimbraCFDIResult->anyType[0];
$numeroExcepcion = $response->TimbraCFDIResult->anyType[1];
$descripcionResultado = $response->TimbraCFDIResult->anyType[2];
$xmlTimbrado = $response->TimbraCFDIResult->anyType[3];
$codigoQr = $response->TimbraCFDIResult->anyType[4];
$cadenaOriginal = $response->TimbraCFDIResult->anyType[5];
$errorInterno = $response->TimbraCFDIResult->anyType[6];
$mensajeInterno = $response->TimbraCFDIResult->anyType[7];
$m_uuid = $response->TimbraCFDIResult->anyType[8];
$m_uuid2 = json_decode( $m_uuid );
// echo "<br> <pre>"; print_r( $m_uuid ); echo "</pre>"; // exit;
// echo "<br> <pre>"; print_r( $m_uuid2 ); echo "</pre>"; // exit;

$xml_archivo_qr_jpg = $ruta_cfdi.$cad[0]."_QR.jpg";
file_put_contents( $xml_archivo_qr_jpg, trim( $codigoQr ) );


if($xmlTimbrado != ''){
	// El comprobante fue timbrado correctamente
	if( !file_put_contents( $xml_archivo2, $xmlTimbrado) ){

		echo "<p> Error al crear el archivo: ".$xml_archivo2." </p>";
	}


    ?>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>


<table width="100%" border="0">
  <tr>
  <td align="center">&nbsp;</td>
    <td align="center">

	<?php


echo '<img src="https://img.icons8.com/doodle/48/000000/checkmark.png"/>';


         //T_1034.xml Asi llega
		 
		$archi = explode(".",$archi_xml);

	echo "
		<p> CFDI creado correctamente: ".$archi_xml."  </p> 
			
		
		";

		$ar = explode("_",$archi_xml);

		?>


<a href="../../detalle_invoices.php?idorden=<?php echo $ar[1]; ?>">Ir a Factura</a>


		<?php


		
		//	<a href='lee.php?xml=".$cad[0]."' target='_blank'>Leer</a>
	
		


     ?>

	</td>
  </tr>
</table>



<?php








}else{
	// echo "else";
	//echo "<p> Error: [".$tipoExcepcion."  ".$numeroExcepcion." ".$descripcionResultado."  ei=".$errorInterno." mi=".$mensajeInterno."] </p>";
}


?>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>



<table width="100%" border="0">
      <tr>
        <td align="center"><a href="../../facturacion.php"><img src="https://img.icons8.com/flat-round/64/000000/thick-long-right-arrow--v1.png"/> Volver a Facturas</a></td>
      </tr>
    </table>




<?php


// Lee el xml para UUID


include("../../conecta_facturacion.php");

$archi_xml = $_GET[xml];
$cad = explode(".",$archi_xml);
$ruta_cfdi = "../files/cfdi/".$cad[0]."_timbrado.xml";

//echo "aqui la ruta".$ruta_cfdi;

$xml = simplexml_load_file($ruta_cfdi); 

$xml = simplexml_load_file( $ruta_cfdi, 'SimpleXMLElement', 0, 'cfdi', true );
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('c', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);
 

foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
 //  echo $tfd['SelloCFD']; 
   echo "<br />"; 
 //  echo $tfd['FechaTimbrado']; 
   echo "<br />"; 
   $uuid =  $tfd['UUID']; 
   echo "<br />"; 
//   echo $tfd['noCertificadoSAT']; 
   echo "<br />"; 
//   echo $tfd['RfcProvCertif']; 
   echo "<br />"; 
//   echo $tfd['Version']; 
   echo "<br />"; 
 //  echo $tfd['SelloSAT']; 
   
} 




$cad2 = explode("_",$cad[0]);

//echo "a".$cad2[1];

$cve= $cad2[1];


$actualiza = mysqli_query($cone,"UPDATE `invoices` SET `uuid` = '$uuid' WHERE `invoices`.`id` = '$cve';");
$actualiza = mysqli_query($cone,"UPDATE `invoices` SET `estatus` = 'Timbrada' WHERE `invoices`.`id` = '$cve';")




?>



