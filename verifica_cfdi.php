<?php
/* 
KIT DE INTEGRACION PHP para CFID 4.0
versi�n 1.0
Integraci�n de Consulta de estatus de un CFDI en el SAT
Licencia: MIT - https://opensource.org/licenses/MIT
Profact - La forma m�s simple de facturar
*/
/* Ruta del servicio de integracion*/

$ws = "https://timbracfdi33.mx:1443/Timbrado.asmx?wsdl";/*<- Esta ruta es para el servicio de pruebas, para pasar a productivo cambiar por https://timbracfdi33.mx:1443/Timbrado.asmx?wsdl*/
$response = '';

/* La funci�n para consultar el estatus de un CFDI recibe 2 par�metros*/

/*Nombre del usuario integrador asignado, para efecto de pruebas utilizaremos 'mvpNUXmQfK8=' <- Este usuario es para el servicio de pruebas, para pasar a productivo cambiar por el que le asignar�n posteriormente*/
$usuarioIntegrador = 'jtm6Lfes+mmNO/ic5P3DQ==';

/*Folio fiscal(UUID) del comprobante a consultar, deber� ser uno v�lido de los que hayamos timbrado previamente en pruebas*/
$folioUUID = strtoupper('2c098303-ae24-4ba4-b588-393099fc41bb');

try
{
$params = array();
/*Nombre del usuario integrador asignado, para efecto de pruebas utilizaremos 'mvpNUXmQfK8='*/
$params['usuarioIntegrador'] = $usuarioIntegrador;
/*Folio fiscal del comprobante a obtener*/
$params['folioUUID'] = $folioUUID;


$context = stream_context_create(array(
    'ssl' => array(
        // set some SSL/TLS specific options
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true  //--> solamente true en ambiente de pruebas
    ),
	'http' => array(
            'user_agent' => 'PHPSoapClient'
            )
 ) );
$options =array();
$options['stream_context'] = $context;
$options['cache_wsdl']= WSDL_CACHE_MEMORY;
$options['trace']= true;

$client = new SoapClient($ws,$options);
$response = $client->__soapCall('ConsultaEstatusSat', array('parameters' => $params));
}
catch (SoapFault $fault)
{
	echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
}
/*Obtenemos resultado del response*/
$tipoExcepcion = $response->ObtieneCFDIResult->anyType[0];
$numeroExcepcion = $response->ObtieneCFDIResult->anyType[1];
$descripcionResultado = $response->ObtieneCFDIResult->anyType[2];
$xmlResult = $response->ObtieneCFDIResult->anyType[3];
$codigoQr = $response->ObtieneCFDIResult->anyType[4];
$cadenaOriginal = $response->ObtieneCFDIResult->anyType[5];
/*Los siguientes par�metros sirve en caso de error*/
 $errorInterno = $response->TimbraCFDIResult->anyType[6];
 $mensajeInterno = $response->TimbraCFDIResult->anyType[7];
 $detalleError = $response->TimbraCFDIResult->anyType[8];

print_r($descripcionResultado." xmlr=".$descripcionResultado." ei=".$errorInterno." mi=".$mensajeInterno);
?>