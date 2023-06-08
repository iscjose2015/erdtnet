<?php
// http://localhost/curso_cfdi/php/cfdi_cancelar.php
error_reporting(E_ALL); ini_set('display_errors', '1');

// SAT: Esquema de cancelaciones: http://omawww.sat.gob.mx/factura/Paginas/cancela_procesocancelacion.htm

// PAC:
$pacurl = "https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl";
$pacusu = "mvpNUXmQfK8=";

// Info del CFDI: 
$rfcEmisor = "AAA010101AAA";
$uuid = "35C4CACA-D1CB-425C-B7C5-0AE3085DCB62";

echo "<h3 align='center'> CFDI 3.3 - Cancelar SAT </h3>";
echo "<p align='center'> Emisor: $rfcEmisor  UUID: $uuid </p>";

$response = "";
try{
	$params = [
		"usuarioIntegrador" => $pacusu,
		"rfcEmisor" => $rfcEmisor,
		"folioUUID" => $uuid,
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
	$response = $client->__soapCall('CancelaCFDI', array('parameters' => $params));
}catch (SoapFault $fault){
	echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
	exit;
}
echo "<br> Respuesta: <pre>"; print_r( $response ); echo "</pre><hr>"; exit;	

?>