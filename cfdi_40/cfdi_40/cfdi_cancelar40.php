<?php
// http://localhost/curso_cfdi/cfdi_40/cfdi_cancelar40.php

error_reporting(E_ALL); ini_set('display_errors', '1');

echo "<h2> Cancelar CFDI 4.0 </h2>";

$usuarioIntegrador = "mvpNUXmQfK8=";
$rfcEmisor = "EKU9003173C9";
$folioUUID = "4108c168-ffad-4a22-8409-f258750186f8";
$motivoCancelacion = "03";
$folioUUIDSustitucion = "";

$pacurl = "https://pruebas.timbracfdi33.mx/Timbrado.asmx?wsdl"; // URL para timbrar y cancelar CFDI 4.0

$response = "";
try{
	$params = [
		"usuarioIntegrador" => $usuarioIntegrador,
		"rfcEmisor" => $rfcEmisor,
		"folioUUID" => $folioUUID,
		"motivoCancelacion" => $motivoCancelacion,
		"folioUUIDSustitucion" => $folioUUIDSustitucion,
	];
	$context = stream_context_create(
		array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
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
	// $response = $client->__soapCall('CancelaCFDI', array('parameters' => $params));
	$response = $client->__soapCall('CancelaCFDI40', array('parameters' => $params));
}catch (SoapFault $fault){
	echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
	exit;
}
echo "<br> Respuesta: <pre>"; print_r( $response ); echo "</pre><hr>"; exit;

?>