<?php
// http://localhost/curso_cfdi/cfdi_40/xml_timbrarv4.php
error_reporting(E_ALL); ini_set('display_errors', '1');

echo "<h2> Prueba de Timbrado de CFDI 4.0 </h2>";

$ruta_xml = "files/xml_enviados/";
$ruta_cfdi = "files/cfdi/";
$ruta_cfdi_qr = "files/qr/";

// Archivo XML sin timbrar:
$xml_archivo = $ruta_xml."X25.xml";

// Archivo timbrado:

$xml_archivo2 = $ruta_cfdi."X25_timbrado_".date("YmdHis").".xml";

// PAC: Escenario de pruebas 
$pacurl = "https://pruebas.timbracfdi33.mx/Timbrado.asmx?wsdl"; // URL para timbrar 4.0

$pacusu = "mvpNUXmQfK8=";
echo "<p> PAC URL: $pacurl </p>";
echo "<p> PAC Usuario: $pacusu </p>";

// Contenido del XML encriptado:
$texto = file_get_contents( $xml_archivo );
// echo "<p> <textarea style='width:98%;height:150px;'>".$texto."</textarea></p>";
$base64Comprobante = base64_encode($texto);
// echo "<p> <textarea style='width:98%;height:150px;'>".$base64Comprobante."</textarea></p>";
// exit;

// Webservice:
$response = '';
try{
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
	echo "<p>Error: " . $fault->faultcode . "-" . $fault->faultstring . " </p>";
	exit;
}
if ($response->TimbraCFDIResult->anyType[4] == NULL) {
	// var_dump($response);exit;
	// echo "<br> TimbraCFDIResult: <pre>"; print_r( $response ); echo "</pre>"; // exit;
	// echo "<script>fn_sistemax_mensaje(0, 'Error: " . $response->TimbraCFDIResult->anyType[2] . "',2);</script>";exit;
	echo "
		<h3 align='center'> ERROR: </h3>
		<h3 align='center'>".trim( $response->TimbraCFDIResult->anyType[2] )."</h3>
	";
	echo "
		<br>
		<p align='center'>
			<a href='".$xml_archivo."' target='_blank' class='enlace1' style='color:blue;'> XML enviado </a>
		</p>
	";
	echo "<br><h3 align='left'> TimbraCFDIResult: <pre>"; print_r( $response ); echo "</pre></h3>"; // exit;
}
echo "<hr> RESPUESTA: <br> <pre>"; print_r( $response ); echo "</pre><hr>"; // exit;
// Obtenemos resultado del response
// echo "resultado"; //echo $response;
$tipoExcepcion = $response->TimbraCFDIResult->anyType[0];
$numeroExcepcion = $response->TimbraCFDIResult->anyType[1];
$descripcionResultado = $response->TimbraCFDIResult->anyType[2];
$xmlTimbrado = $response->TimbraCFDIResult->anyType[3];
//$codigoQr = $response->TimbraCFDIResult->anyType[4];
$cadenaOriginal = $response->TimbraCFDIResult->anyType[5];
$errorInterno = $response->TimbraCFDIResult->anyType[6];
$mensajeInterno = $response->TimbraCFDIResult->anyType[7];
$m_uuid = $response->TimbraCFDIResult->anyType[8];
$m_uuid2 = json_decode( $m_uuid );
// echo "<br> <pre>"; print_r( $m_uuid ); echo "</pre>"; // exit;
// echo "<br> <pre>"; print_r( $m_uuid2 ); echo "</pre>"; // exit;

// Guardar la imagen del QR:
$xml_archivo_qr_jpg = $ruta_cfdi_qr."X25_timbrado_QR_".date("YmdHis").".jpg";
file_put_contents( $xml_archivo_qr_jpg, trim( $codigoQr ) );

if($xmlTimbrado != ''){
	// El comprobante fue timbrado correctamente
	if( !file_put_contents( $xml_archivo2, $xmlTimbrado) ){
		echo "<p> Error al crear el archivo: ".$xml_archivo2." </p>";
	}
	echo "
		<p> CFDI creado correctamente: ".$xml_archivo2." </p> 
		<p>
			<a href='".$xml_archivo2."' target='_blank'> Ver XML timbrado </a>
		</p>		
	";	
}else{
	// echo "else";
	echo "<p> Error: [".$tipoExcepcion."  ".$numeroExcepcion." ".$descripcionResultado."  ei=".$errorInterno." mi=".$mensajeInterno."] </p>";
}
?>